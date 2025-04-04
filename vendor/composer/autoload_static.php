<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit71c55fb183e3aacacbc4a99f0a056f4e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Avcodewizard\\LaravelBackup\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Avcodewizard\\LaravelBackup\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit71c55fb183e3aacacbc4a99f0a056f4e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit71c55fb183e3aacacbc4a99f0a056f4e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit71c55fb183e3aacacbc4a99f0a056f4e::$classMap;

        }, null, ClassLoader::class);
    }
}
