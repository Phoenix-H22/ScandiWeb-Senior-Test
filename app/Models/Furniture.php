<?php

namespace App\Models;

use App\Core\Model\Model;
/**
 * Furniture class is responsible for create, update, delete and get all furnitures
 */

class Furniture extends Model
{
    public function add($request)
    {

        $request['property'] = 'Dimension: ' . $request['height'] . 'x' . $request['width'] . 'x' . $request['length'];
        $this->create($request);
    }
    public function updateRow($request)
    {
        $request['property'] = 'Dimension: ' . $request['height'] . 'x' . $request['width'] . 'x' . $request['length'];
        $this->update($request);
    }
}
