<?php
namespace App\Core\Interfaces;
/**
 * ProductInterface interface is responsible for creating a contract for products controller
 */
interface ProductInterface
{
    public function validateProductRequest($request, $isUpdate = false);
    public function create();
    public function update();
    public function delete();

}