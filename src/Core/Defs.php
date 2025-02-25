<?php

namespace Src\Core;

use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader as TwigLoader;

class Defs {
    const envIdDev = 1
        , envIdProd = 10;
    const envSlugDev = 'dev'
        , envSlugProd = 'prod';
    const defaultEnv = 'mainEnv';

    static function getSelectedEnv():string {
        return $_ENV['APP_ENV'];
    }
    
    static function getEnvId():int {
        return self::_envMap[self::getSelectedEnv()];
    }

    static function isProdEnv():bool {
        return self::getSelectedEnv() === self::envSlugProd;
    }
    
    static function getRootDirectory():string {
        return dirname(dirname(__DIR__));
    }

    static function getGlobalVariables():array {
        return [
            'root' => self::getRootDirectory(),
            'env' => self::getSelectedEnv(),
            'isProd' => self::isProdEnv()
        ];
    }

    static function getTemplateLoader(array $opts = []):TwigEnvironment {
        if (!isset(self::$_template)) {
            $loader = new TwigLoader(self::getRootDirectory().'/src/Views');
            self::$_template = new TwigEnvironment($loader,$opts);
        }
        return self::$_template;
    }

    //-----------
    // privates

    private const _envMap = [
        self::envSlugDev => self::envIdDev,
        self::envSlugProd => self::envIdProd,
    ];

    private static TwigEnvironment $_template;
}