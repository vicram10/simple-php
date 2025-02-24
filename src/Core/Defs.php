<?php

namespace Src\Core;

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
    static function getRootDirectory():string {
        return dirname(dirname(__DIR__));
    }

    //-----------
    // privates

    private const _envMap = [
        self::envSlugDev => self::envIdDev,
        self::envSlugProd => self::envIdProd,
    ];
}