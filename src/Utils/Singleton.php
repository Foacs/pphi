<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 13:44
 */

namespace PPHI\Utils;

/**
 * Trait Singleton
 * @package PPHI\Utils
 */
trait Singleton
{

    protected static $instance;

    /**
     * Get an instance of the singleton class
     *
     * @return Singleton Instance of class
     */
    final public static function getInstance()
    {
        return isset(self::$instance) ? self::$instance : self::$instance = new self();
    }

    /**
     * Singleton constructor.
     */
    final private function __construct()
    {
        $this->preInit();
    }

    /**
     * Initialise vars
     */
    protected function preInit()
    {
    }
}
