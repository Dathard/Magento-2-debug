<?php

namespace App\Model\Framework\App\ObjectManager;

class Singleton
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Singleton constructor.
     */
    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
}