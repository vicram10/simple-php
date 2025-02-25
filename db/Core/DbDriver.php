<?php

namespace Db\Core;

use DateTimeImmutable;
use Src\Core\BaseObject;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\ConnectionInterface;
use Src\Core\Defs;
use Db\Core\DbAdapter;

abstract class DbDriver 
implements DbAdapter { 
    /** @var ConnectionInterface[] $conn */   
    static protected $conn = [];

    function __construct(int $envId){
        $this->envId = $envId;
    }

    function getEnvId(): int {
        return $this->envId;
    }

    function toDbDate(DateTimeImmutable $date): string { 
        return $date->format('Y-m-d H:i:s');
    }
    
    function fromDbDate(string $date): DateTimeImmutable { 
        return BaseObject::immutableUtc($date);
    }
    
    function getConnection():ConnectionInterface {
        if (self::$conn[Defs::defaultEnv]??null){
            return self::$conn[Defs::defaultEnv];
        }        
        $config = require join('/',[Defs::getRootDirectory(),'Config','database.php']);
        $capsule = new Capsule;
        // Configurar todas las conexiones
        foreach ($config['connections'] as $name => $settings) {
            $capsule->addConnection($settings, $name);
        }
        // Usar la conexión por defecto
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    }

    // -----------
    // privates

    private int $envId;
}