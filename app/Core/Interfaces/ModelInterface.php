<?php
namespace App\Core\Interfaces;
/**
 * ModelInterface interface is responsible for creating a contract for models
 */
interface ModelInterface
{
    public function create(array $request);
    public function update(array $request);
    public function delete(array $request);
    public function all();
}