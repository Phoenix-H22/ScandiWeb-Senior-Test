<?php

namespace App\Models;

class Dvd extends Product
{
    public function add($request)
    {
        $request['property'] = 'Size: ' . $request['size'] . ' MB';
        $this->create($request);
    }
}