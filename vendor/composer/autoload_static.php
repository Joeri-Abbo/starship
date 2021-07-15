<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit83d17fde805f79dcb74cf0b73e0ee1be
{
    public static $files = array (
        '52f2f3f7188d48c24cbcdda965ce839b' => __DIR__ . '/../..' . '/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Starship\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Starship\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit83d17fde805f79dcb74cf0b73e0ee1be::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit83d17fde805f79dcb74cf0b73e0ee1be::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
