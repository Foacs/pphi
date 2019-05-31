<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 13/05/19
 * Time: 19:55
 */

namespace PPHI\Connector;

/**
 * Class ConnectorError
 * @package PPHI\Connector
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.1.0-alpha First time this was introduced
 */
class ConnectorError
{

    /**
     * @var string
     */
    private $message;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var \ReflectionClass
     */
    private $class;

    /**
     * @var ?\Exception
     */
    private $exception;

    /**
     * ConnectorError constructor.
     *
     * @param string $className The class name which call the error (use get_class($this))
     * @param string $message The error message
     * @param int $code The code
     * @param \Exception|null $exception The exception which create this error
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function __construct(string $className, string $message, int $code = 0, ?\Exception $exception = null)
    {
        try {
            $this->class = new \ReflectionClass($className);
        } catch (\ReflectionException $ignored) {
        }
        $this->message = $message;
        $this->code = $code;
        $this->exception = $exception;
    }

    /**
     * Gets the error message
     *
     * @return string Error message
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the error message
     *
     * @param string $message The error message
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Gets the error code
     *
     * @return int The error code
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Sets the error code
     *
     * @param int $code The error code
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * Get the class which has created this error
     *
     * @return \ReflectionClass The caller class
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function getClass(): \ReflectionClass
    {
        return $this->class;
    }

    /**
     * Sets the class which create this error
     *
     * @param \ReflectionClass $class The caller class
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function setClass(\ReflectionClass $class): void
    {
        $this->class = $class;
    }

    /**
     * Gets the exception which create the error
     *
     * @return \Exception|null Exception which create the error
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function getException(): ?\Exception
    {
        return $this->exception;
    }

    /**
     * Sets the error which create the error
     *
     * @param \Exception|null $exception The error
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function setException(?\Exception $exception): void
    {
        $this->exception = $exception;
    }
}
