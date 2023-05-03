<?php

namespace App\Models;
/**
 * Book class is responsible for create, update, delete and get all books
 */

class Book extends Product
{
    public function add($request)
    {
        $request['property'] = 'Weight: ' . $request['weight'] . 'KG';
        $this->create($request);
    }
    public function updateRow($request)
    {
        $request['property'] = 'Weight: ' . $request['weight'] . 'KG';
        $this->update($request);
    }
}
