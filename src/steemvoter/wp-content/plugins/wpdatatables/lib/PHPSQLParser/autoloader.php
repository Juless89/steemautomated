<?php

namespace PHPSQLParser;

/**
 * Autoloader
 */
class Autoloader
{
    /** @const string */
    const NAMESPACE_PREFIX = 'PHPSQLParser\\';

    /**
     * Register
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Autoload
     *
     * @param string $class
     */
    public static function autoload($class)
    {
        $prefixLength = strlen(self::NAMESPACE_PREFIX);
        if (0 === strncmp(self::NAMESPACE_PREFIX, $class, $prefixLength)) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
            $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . $file . '.php');
            if (file_exists($file)) {
                /** @noinspection PhpIncludeInspection Dynamic includes */
                require_once $file;
            }
        }
    }
}
