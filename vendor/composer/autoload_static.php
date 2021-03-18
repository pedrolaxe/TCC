<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb7ad637a37b11ad3557455367327d4d4
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mike42\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mike42\\' => 
        array (
            0 => __DIR__ . '/..' . '/mike42/gfx-php/src/Mike42',
            1 => __DIR__ . '/..' . '/mike42/escpos-php/src/Mike42',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb7ad637a37b11ad3557455367327d4d4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb7ad637a37b11ad3557455367327d4d4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb7ad637a37b11ad3557455367327d4d4::$classMap;

        }, null, ClassLoader::class);
    }
}