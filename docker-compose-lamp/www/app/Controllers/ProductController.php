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
        $this->render('Product_List', $products->all());
    }

    public function add()
    {
        $this->render('Product_Add');
    }

    public function create()
    {
        // Initialize errors array
        $_SESSION['errors'] = [];
        // print_r($_REQUEST);
        
        // Get request variables
        $request =  Validation::filter($_REQUEST);
        $sku = $request['sku'] ?? null;
        $price = $request['price'] ?? null;
        $productType = $request['productType'] ?? "";
        $name = $request['name'] ?? null;
        $height = $request['height'] ?? null;
        $width = $request['width'] ?? null;
        $length = $request['length'] ?? null;
        $dvdSize = $request['size'] ?? null;
        $weight = $request['weight'] ?? null;
        // Define validation rules
        $validationRules = [
            'productType' => [$productType, 'required'],
            'sku' => [$sku, 'required|unique:Product'],
            'name' => [$name, 'required'],
            'price' => [$price, 'required|numeric'],
        ];
        
        // Add additional validation rules for each product type
        if ($productType != null && $productType == 'furniture') {
            $validationRules += [
                'height' => [$height, 'required'],
                'width' => [$width, 'required'],
                'length' => [$length, 'required'],
            ];
        } elseif ($productType != null && $productType == 'dvd') {
            $validationRules += [
                'size' => [$dvdSize, 'required'],
            ];
        } elseif ($productType != null && $productType == 'book') {
            $validationRules += [
                'weight' => [$weight, 'required'],
            ];
        }
        
        // Perform validation
        Validation::validate($validationRules);
         // Redirect if there are validation errors
        if (!empty($_SESSION['errors'])) {
            header('Content-type: application/json');
            $_SESSION['errors'][0]['status'] = 'error';
            echo json_encode($_SESSION['errors'][0]);
            exit;
        }
        
        // Add product
        $product = $this->model(ucfirst($productType));
        $product->add($request);
        
        // Set success message and redirect to homepage
        $_SESSION['success'] = 'Product added successfully';
        header('Content-type: application/json');
        echo json_encode(['status' => 'success']);      
        
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
