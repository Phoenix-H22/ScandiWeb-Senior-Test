<?php

namespace App\Core\Model;

use App\Core\Database\Database;
use App\Core\Interfaces\ModelInterface;
/**
 * abstract class Model is responsible for creating a contract for models
 */

abstract class Model extends Database implements ModelInterface
{
    protected string $tableName ="products";
    protected string $query;
    protected array $bindings = [];
    public static $instance = null;
    /**
     * all method is responsible for returning all products
     *
     * @return array
     */

    public function all(): array
    {
        $products = $this->pdo->prepare("SELECT * FROM $this->tableName");
        $products->execute();
        return $products->fetchAll();
    }
    /**
     * create method is responsible for creating a new product
     *
     * @param array $request
     * @return void
     */

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
    /**
     * select method is responsible for selecting a specific column from a table
     *
     * @param string $name
     * @return object
     */
    public static function select($name = '*')
    {
        $instance = new static();
        $instance->query = "SELECT $name FROM $instance->tableName";
        $instance->bindings = [];
        self::$instance = $instance;
        return $instance;
    }
    /**
     * where method is responsible for selecting a specific row from a table
     *
     * @param string $name
     * @param string $value
     * @return object
     */
    public static function where($name, $value)
    {

        self::$instance->query .= " WHERE $name = :$name";
        self::$instance->bindings = [$name => $value];
        return self::$instance;
    }
    /**
     * andWhere method is responsible for selecting a specific row from a table
     *
     * @param string $name
     * @param string $value
     * @return object
     */
    public function get()
    {
        $products = $this->pdo->prepare($this->query);
        $products->execute($this->bindings);
        return $products->fetchAll();
    }
    /**
     * update method is responsible for updating a specific product
     *
     * @param array $request
     * @return void
     */
    public function update(array $request)
    {
        $products = $this->pdo->prepare("UPDATE $this->tableName SET sku = :sku, name = :name, price = :price, type = :type, property = :property WHERE id = :id");
        $products->bindParam('id', $request['id']);
        $products->bindParam('sku', $request['sku']);
        $products->bindParam('name', $request['name']);
        $products->bindParam('price', $request['price']);
        $products->bindParam('type', $request['productType']);
        $products->bindParam('property', $request['property']);
        $products->execute();
    }
    /**
     * find method is responsible for finding a specific product
     *
     * @param integer $id
     * @return array
     */
    public function find($id)
    {
        $products = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE id = :id");
        $products->bindParam('id', $id);
        $products->execute();
        return $products->fetch();
    }
    /**
     * delete method is responsible for deleting a specific product
     *
     * @param array $request
     * @return void
     */

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
