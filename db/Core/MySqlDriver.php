<?php

namespace Db\Core;

use Src\Core\Defs;
use Db\Core\DbDriver;

class MySqlDriver 
extends DbDriver {
    static function allocInstanceFor(?int $envId = 0):DbDriver {
        if (!$envId){
            $envId = Defs::getEnvId();
        }
        return new MySqlDriver($envId);
    }
}