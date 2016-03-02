<?php
/**
 * Created by PhpStorm.
 * User: tzhweda9
 * Date: 18/01/16
 * Time: 14:24
 */

namespace App\Models\Traits;


trait Authorization
{
    public function have($relation_name, $id) {
        return (bool) $this->$relation_name()->where($this->getKeyName(),'=',$id)->count();
    }
}