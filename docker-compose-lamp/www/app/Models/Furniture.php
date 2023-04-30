<?php

namespace App\Models;

use App\Core\Model\Model;

class Furniture extends Model
{
    public function add($request)
    {

        $request['property'] = 'Dimension: ' . $request['height'] . 'x' . $request['width'] . 'x' . $request['length'];
        $this->create($request);
    }
}
