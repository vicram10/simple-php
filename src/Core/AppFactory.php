<?php

namespace Src\Core;

use Db\Models\MySqlDriver;
use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Src\Core\Router;

class AppFactory {
    public readonly Request $request;

    static function allocIntanceFor():self {
        $request = new Request(query:$_GET, request: $_REQUEST);
        $self = new self($request);
        return $self;
    }

    function run():void{        
        $dotenv = Dotenv::createImmutable(Defs::getRootDirectory());
        $dotenv->load();        
        
        $dbDriver = MySqlDriver::allocInstanceFor();
        
        require join('/',[Defs::getRootDirectory(),'src','Routes','web.php']);

        Router::dispatch($dbDriver);
    }

    //-----------
    // privates

    private function __construct(Request $request) {
        $this->request = $request;
    }
}