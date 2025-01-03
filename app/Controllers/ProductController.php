<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Models\Product;
use App\Core\Validation\Validation;
use App\Core\Interfaces\ProductInterface;

// We Will Document all project starting from here

/**
 * ProductController class is responsible for handling all product related requests and responses
 */
class ProductController extends Controller implements ProductInterface
{
    /**
     * Show method is responsible for rendering homepage
     *
     * @return void
     */
    public function show(): void
    {
        $products = new Product();
        $this->render('Product/index', $products->all());
    }
    /**
     * Add product method is responsible for rendering add product page
     *
     * @return void
     */
    public function add(): void
    {
        $this->render('Product/add');
    }
    /**
     * ValidateProductRequest method is responsible for validating product request data
     *
     * @param array $request
     * @param bool $isUpdate
     * @return true or json with errors
     */
    public function validateProductRequest($request, $isUpdate = false): bool
{
    // Initialize variables
    $id = $request['id'] ?? null;
    $sku = $request['sku'] ?? null;
    $price = $request['price'] ?? null;
    $productType = $request['productType'] ?? "";
    $name = $request['name'] ?? null;
    $height = $request['height'] ?? null;
    $width = $request['width'] ?? null;
    $length = $request['length'] ?? null;
    $dvdSize = $request['size'] ?? null;
    $weight = $request['weight'] ?? null;

    // Define validation rules lookup table
    $validationRulesLookup = [
        'furniture' => [
            'height' => [$height, 'required|nonNegative'],
            'width' => [$width, 'required|nonNegative'],
            'length' => [$length, 'required|nonNegative'],
        ],
        'dvd' => [
            'size' => [$dvdSize, 'required|nonNegative'],
        ],
        'book' => [
            'weight' => [$weight, 'required|nonNegative'],
        ],
    ];

    // Initialize validation rules array
    $validationRules = [
        'productType' => [$productType, 'required'],
        'name' => [$name, 'required'],
        'price' => [$price, 'required|numeric|nonNegative'],
        'sku' => [$sku, 'required'],
    ];

    // Add specific validation rules based on product type from the lookup table
    if (array_key_exists($productType, $validationRulesLookup)) {
        $validationRules += $validationRulesLookup[$productType];
    }

    // Add additional rules for update request
    if ($isUpdate) {
        $model = 'App\\Models\\' . ucfirst($productType);
        $instance = new $model();
        $result = $instance->select("sku")->where("id", $id)->get();
        if ($result) {
            if ($result[0]['sku'] != $sku) {
                $validationRules['sku'][] = 'unique:Product';
            }
        } else {
            $validationRules["id"] = [$id, "required|numeric|unique:Product|nonNegative"];
            $validationRules['sku'][] = 'unique:Product';
        }
    } else {
        $validationRules['sku'][] = 'unique:Product';
    }

    // Validate request data and set errors if they exist with Validation class
    Validation::validate($validationRules);

    // Check if there are errors and return JSON response with errors if they exist
    if (!empty($_SESSION['errors'])) {
        header('Content-type: application/json');
        $_SESSION['errors'][0]['status'] = 'error';
        echo json_encode($_SESSION['errors'][0]);
        unset($_SESSION['errors']);
        exit;
    }

    // Return true if there are no errors
    return true;
}

    /**
     * Create method is responsible for handling requests to create a new product.
     *
     * @return void This function does not return a value.
     *
     * @throws \Error If there was an error adding the product to the database.
     */

    public function create(): void
    {
        // Initialize errors array
        $_SESSION['errors'] = [];
        // Get request variables
        try {
            $request =  Validation::filter($_REQUEST);
            $productType = $request['productType'];
            // Validate request
            if($this->validateProductRequest($request)) {
                // Add product
                $product = $this->model(ucfirst($productType));
                $product->add($request);
                // Set success message and return json response with success status
                header('Content-type: application/json');
                echo json_encode(['status' => 'success', 'message' => "Product added successfully"]);
            }
        }catch(\Exception $e){
            // Set error message and return json response with error status
            header('Content-type: application/json');
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }
    /**
     * Edit method is responsible for handling requests to edit an existing product.
     *
     * @param int $id The ID of the product to edit.
     *
     * @return void This function does not return a value.
     *
     * @throws \Error If there was an error finding the product in the database.
     */

     public function edit($id = null): void
     {
         // Get product by id
         $id = Validation::filter([$id]);
         $product = new Product();
         $product = $product->find($id[0]);
         // Check if product exists or not and redirect to homepage if not exists
         $productExists = (!($product == null));
         if (!$productExists) {
            $_SESSION['errors'] = ['Product not found'];
             $this->redirect('/');
         }
         $product = array_filter($product, function ($key) {
             return !is_int($key);
         }, ARRAY_FILTER_USE_KEY);

         // Check product type and set product properties to render it in edit page
         $productType = $productExists ? $product["type"] : null;
         $productProperties = $productExists ? $product["property"] : null;
         // Mapping product types to corresponding property handlers
         $propertyHandlers = [
             "furniture" => function () use (&$product, $productProperties) {
                 $product["height"] = (int)filter_var(trim(explode(":", explode("x", $productProperties)[0])[1]), FILTER_SANITIZE_NUMBER_INT);
                 $product["width"] = (int)filter_var(explode("x", $productProperties)[1], FILTER_SANITIZE_NUMBER_INT);
                 $product["length"] = (int)filter_var(explode("x", $productProperties)[2], FILTER_SANITIZE_NUMBER_INT);
             },
             "dvd" => function () use (&$product, $productProperties) {
                 $product["size"] = (int)filter_var($productProperties, FILTER_SANITIZE_NUMBER_INT);
             },
             "book" => function () use (&$product, $productProperties) {
                 $product["weight"] = (int)filter_var($productProperties, FILTER_SANITIZE_NUMBER_INT);
             }
         ];

         // Execute the corresponding property handler based on the product type
         if (array_key_exists($productType, $propertyHandlers)) {
             $propertyHandlers[$productType]();
         }
         // Render edit page
         $this->render('Product/edit', $product);
     }

    /**
     * Update method is responsible for handling requests to update an existing product.
     *
     * @return void This function does not return a value.
     *
     * @throws \Error If there was an error updating the product in the database.
     */

    public function update(): void
    {
        // Initialize errors array
        $_SESSION['errors'] = [];
        // Get request variables
        $_REQUEST['id'] = (int)filter_var($_REQUEST['id']["id"], FILTER_SANITIZE_NUMBER_INT);
        $request = Validation::filter($_REQUEST);
        $productType = $request['productType'];
        // Validate request
        if($this->validateProductRequest($request, true)) {
            // Add product
            $product = $this->model(ucfirst($productType));
            $product->updateRow($request);
            // Set success message and redirect to homepage
            header('Content-type: application/json');
            $_SESSION['success'] = 'Product updated successfully';
            echo json_encode(['status' => 'success', 'message' => "Product updated successfully"]);
        }
    }
    /**
     * Delete method is responsible for handling requests to delete a product.
     *
     * @return void This function does not return a value.
     *
     * @throws \Error If there was an error deleting the product from the database.
     */

    public function delete(): void
    {
        $request = Validation::filter($_REQUEST);
        $product = new Product();
        // Validate request data
        foreach ($request as $id) {
            Validation::validate([
                'id' => [$id, 'required|numeric|exists:Product'],
            ]);
        }
        // Check if there is errors and redirect to homepage if exists
        if (!empty($_SESSION['errors'])) {
            $this->redirect('/');
        }
        // Delete product if there is no errors
        $product->delete($request);
        // Set success message and redirect to homepage
        $_SESSION['success'] = 'Product deleted successfully';
        $this->redirect('/');
    }
}
