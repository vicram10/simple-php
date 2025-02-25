<?php

namespace Src\Controllers;

use Db\Core\DbDriver;
use Src\Core\Defs;

abstract class DefaultController {
    
    protected $dbDriver;
    
    function __construct(DbDriver $dbDriver) {
        $this->dbDriver = $dbDriver;
    }

    function renderView(string $view, array $data = []):string {
        $vars = array_merge(Defs::getGlobalVariables(),$data);
        return view($view,compact('vars'));
    }
}