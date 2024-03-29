<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitda2fd760ea5b5e6a1cb9de7784030788
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Services\\' => 9,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Services',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitda2fd760ea5b5e6a1cb9de7784030788::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitda2fd760ea5b5e6a1cb9de7784030788::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitda2fd760ea5b5e6a1cb9de7784030788::$classMap;

        }, null, ClassLoader::class);
    }
}
