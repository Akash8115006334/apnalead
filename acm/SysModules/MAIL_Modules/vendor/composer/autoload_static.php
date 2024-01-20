<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb6e277fae92c30e4feadd0b32e40adde
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb6e277fae92c30e4feadd0b32e40adde::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb6e277fae92c30e4feadd0b32e40adde::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb6e277fae92c30e4feadd0b32e40adde::$classMap;

        }, null, ClassLoader::class);
    }
}
