<?php

namespace App\Models;
/**
 * DVD class is responsible for create, update, delete and get all DVDs
 */

class Dvd extends Product
{
    public function add($request)
    {
        $request['property'] = 'Size: ' . $request['size'] . ' MB';
        $this->create($request);
    }
    public function updateRow($request)
    {
        $request['property'] = 'Size: ' . $request['size'] . ' MB';
        $this->update($request);
    }
}
