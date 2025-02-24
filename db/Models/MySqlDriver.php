<?php

namespace Db\Models;

use Src\Core\Defs;


class MySqlDriver 
extends DbDriver {
    static function allocInstanceFor(?int $envId = 0):DbDriver {
        if (!$envId){
            $envId = Defs::getEnvId();
        }
        return new MySqlDriver($envId);
    }
}