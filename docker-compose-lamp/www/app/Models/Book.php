<?php

namespace App\Models;

class Book extends Product
{
    public function add($request)
    {
        $request['property'] = 'Weight: ' . $request['weight'] . 'KG';
        $this->create($request);
    }
}
