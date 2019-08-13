<?php
/**
 * Copyright Foacs
 * contributor(s): Alexis DINQUER
 *
 * (2019-05-13)
 *
 * contact@foacs.me
 *
 * This software is a computer program whose purpose is to handle data persistence in PHP
 *
 * This software is governed by the CeCILL-C license under french law and
 * abiding by the rules of distribution of free software. You can use,
 * modify and/ or redistribute the software under the terms of the CeCILL-C
 * license as circulated by CEA, CNRS and INRIA at the follow URL
 * "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy,
 * modify and redistribute granted by the license, users are provided only
 * with a limited warranty and the software's authors, the holder of the
 * economic rights, and the successive licensors have only limited
 * liability.
 *
 * In this respect, the user's attention is drawn to the risk associated
 * with loading, using, modifying and/ or developing or reproducing the
 * software by the user in light of its specific status of free software,
 * that may mean that it is complicated to manipulate, and that also
 * therefore means that it is reserved for developers and experienced
 * professionals having in-depth computer knowledge. Users are therefore
 * encouraged to load and test the software's suitability as regards their
 * requirements in conditions enabling the security of their systems and/or
 * data to be ensure and, more generally, to use and operate it in the
 * same conditions as regards security.
 *
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL-C license and that you accept its terms.
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
