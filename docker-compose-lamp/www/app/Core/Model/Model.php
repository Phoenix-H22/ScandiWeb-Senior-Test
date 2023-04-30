<?php

namespace App\Core\Model;

use App\Core\Database\Database;

abstract class Model extends Database
{
    protected string $tableName ="products";
    protected string $query;
    protected array $bindings = [];
    public static $instance = null;

    public function all(): array
    {
        $products = $this->pdo->prepare("SELECT * FROM $this->tableName");
        $products->execute();
        return $products->fetchAll();
    }

    public function create(array $request)
    {
        $products = $this->pdo->prepare("INSERT INTO $this->tableName (sku, name, price, type, property) VALUES (:sku, :name, :price, :type, :property)");
        $products->bindParam('sku', $request['sku']);
        $products->bindParam('name', $request['name']);
        $products->bindParam('price', $request['price']);
        $products->bindParam('type', $request['productType']);
        $products->bindParam('property', $request['property']);
        $new = $products->execute();
        if (!$new) {

        }
    }
    public static function select($name = '*')
    {
        $instance = new static();
        $instance->query = "SELECT $name FROM $instance->tableName";
        $instance->bindings = [];
        self::$instance = $instance;
        return $instance;
    }
    public static function where($name, $value)
    {

        self::$instance->query .= " WHERE $name = :$name";
        self::$instance->bindings = [$name => $value];
        return self::$instance;
    }
    public function get()
    {
        $products = $this->pdo->prepare($this->query);
        $products->execute($this->bindings);
        return $products->fetchAll();
    }

    public function delete(array $request)
    {
        foreach ($request as $product) {
            $id = (int)$product;
            $products = $this->pdo->prepare("DELETE FROM $this->tableName WHERE id = :id");
            $products->bindParam('id', $id);
            $products->execute();
        }
    }
}
