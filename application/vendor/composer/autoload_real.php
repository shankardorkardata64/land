<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd0a21b040e85a574ac8cb2e514f3c765
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitd0a21b040e85a574ac8cb2e514f3c765', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd0a21b040e85a574ac8cb2e514f3c765', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd0a21b040e85a574ac8cb2e514f3c765::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
