<?php

namespace Src\Controllers;

class WelcomeController 
extends DefaultController {
    function index() {
        return $this->renderView('welcome.hello');
    }
}