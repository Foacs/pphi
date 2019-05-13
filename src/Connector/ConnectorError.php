<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 13/05/19
 * Time: 19:55
 */

namespace PPHI\Connector;

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
     * @param string $className The class name which call the error (use get_class($this))
     * @param string $message The error message
     * @param int $code The code
     * @param \Exception|null $exception
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
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the error message
     *
     * @param string $message The error message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return \ReflectionClass
     */
    public function getClass(): \ReflectionClass
    {
        return $this->class;
    }

    /**
     * @param \ReflectionClass $class
     */
    public function setClass(\ReflectionClass $class): void
    {
        $this->class = $class;
    }

    /**
     * @return \Exception|null
     */
    public function getException(): ?\Exception
    {
        return $this->exception;
    }

    /**
     * @param \Exception|null $exception
     */
    public function setException(?\Exception $exception): void
    {
        $this->exception = $exception;
    }
}
