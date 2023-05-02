<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Models\Product;
use App\Core\Validation\Validation;

class ProductController extends Controller
{
    public function show()
    {
        $products = new Product();
        $this->render('Product/index', $products->all());
    }

    public function add()
    {
        $this->render('Product/add');
    }
    public function validateProductRequest($request, $isUpdate = false)
{
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

    $validationRules = [
        'productType' => [$productType, 'required'],
        'name' => [$name, 'required'],
        'price' => [$price, 'required|numeric'],
    ];

    if ($isUpdate) {
        $model = 'App\\Models\\' . ucfirst($productType);
        $instance = new $model();
        $result = $instance->select("sku")->where("id", $id)->get();
        if ($result) {
            if ($result[0]['sku'] != $sku) {
                $validationRules['sku'] = [$sku, 'required|unique:Product'];
            }
        } else {
            $validationRules["id"] = [$id, "required|numeric|unique:Product"];
            $validationRules['sku'] = [$sku, 'required|unique:Product'];
        }
    } else {
        $validationRules['sku'] = [$sku, 'required|unique:Product'];
    }

    if ($productType == 'furniture') {
        $validationRules += [
            'height' => [$height, 'required'],
            'width' => [$width, 'required'],
            'length' => [$length, 'required'],
        ];
    } elseif ($productType == 'dvd') {
        $validationRules += [
            'size' => [$dvdSize, 'required'],
        ];
    } elseif ($productType == 'book') {
        $validationRules += [
            'weight' => [$weight, 'required'],
        ];
    }

    Validation::validate($validationRules);

    if (!empty($_SESSION['errors'])) {
        header('Content-type: application/json');
        $_SESSION['errors'][0]['status'] = 'error';
        echo json_encode($_SESSION['errors'][0]);
        exit;
    }

    return true;
}

    
    public function create()
    {
        // Initialize errors array
        $_SESSION['errors'] = [];
        // Get request variables
        $request =  Validation::filter($_REQUEST);
        $productType = $request['productType'];
        // Validate request
        if($this->validateProductRequest($request)) {
            // Add product
            $product = $this->model(ucfirst($productType));
            $product->add($request);
            // Set success message and redirect to homepage
            $_SESSION['success'] = 'Product added successfully';
            header('Content-type: application/json');
            echo json_encode(['status' => 'success']);
        }

    }
    
    public function edit($id)
    {
        // print_r($id);
        // die;
        $id = Validation::filter($id);
        $product = new Product();
        $product = $product->find($id["id"]);
        if (!$product) {
            $_SESSION['errors'] = 'Product not found';
            $this->redirect('/');
        }
        if ($product["type"] == "furniture") {
            $product["height"] = (int)filter_var(trim(explode(":", explode("x", $product["property"])[0])[1]), FILTER_SANITIZE_NUMBER_INT);
            $product["width"] = (int)filter_var(explode("x", $product["property"])[1], FILTER_SANITIZE_NUMBER_INT);
            $product["length"] = (int)filter_var(explode("x", $product["property"])[2], FILTER_SANITIZE_NUMBER_INT);
        } elseif ($product["type"] == "dvd") {
            $product["size"] = (int)filter_var($product["property"], FILTER_SANITIZE_NUMBER_INT);
        } elseif ($product["type"] == "book") {
            $product["weight"] = (int)filter_var($product["property"], FILTER_SANITIZE_NUMBER_INT);
        }
        $this->render('Product/edit', $product);
    }
    public function update()
    {
        // Initialize errors array
        $_SESSION['errors'] = [];
        // Get request variables
        $_REQUEST['id'] = (int)filter_var($_REQUEST['id']["id"], FILTER_SANITIZE_NUMBER_INT);
        $request = Validation::filter($_REQUEST);
        $productType = $request['productType'];
        // Validate request
        if($this->validateProductRequest($request,true)) {
            // Add product
            $product = $this->model(ucfirst($productType));
            $product->updateRow($request);
            // Set success message and redirect to homepage
            $_SESSION['success'] = 'Product updated successfully';
            header('Content-type: application/json');
            echo json_encode(['status' => 'success']);
        }
    }
    public function delete()
    {
        $request = Validation::filter($_REQUEST);
        $product = new Product();
        $product->delete($request);
        $_SESSION['success'] = 'Product deleted successfully';
        $this->redirect('/');
    }
}
