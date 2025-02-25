<?php

use Src\Core\Defs;

function view(string $view, array $data = []):string {
    $loader = Defs::getTemplateLoader();
    $path = explode('.',$view);
    $viewPath = join('/',$path);
    $template = $loader->load($viewPath.'.twig');
    return $template->render($data);
}