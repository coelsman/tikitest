<?php

namespace App\Models;

use App\Models\Abstracts\Model as ModelAbstract;
use App\Utils\UUID;

class BaseModel extends ModelAbstract
{
    public function __construct()
    {
        $this->id = UUID::generate();
    }
}
