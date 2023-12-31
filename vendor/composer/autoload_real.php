<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit4c3bca42adf38fd5f460e5b59bad64ec
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

        spl_autoload_register(array('ComposerAutoloaderInit4c3bca42adf38fd5f460e5b59bad64ec', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit4c3bca42adf38fd5f460e5b59bad64ec', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit4c3bca42adf38fd5f460e5b59bad64ec::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
