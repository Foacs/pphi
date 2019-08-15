<?php
/**
 * Copyright Foacs
 * contributor(s): Alexis DINQUER
 *
 * (2019-08-14)
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

namespace PPHI\UnitTest;

use PHPUnit\Framework\TestCase;
use PPHI\Connector\ConnectorError;

class ConnectorErrorTest extends TestCase
{
    const MESSAGE = "A MESSAGE";
    const CODE = 0;

    /**
     * @var ConnectorError
     */
    private $victim;

    protected function setUp(): void
    {
        parent::setUp();
        $this->victim = new ConnectorError(get_class($this), self::MESSAGE, self::CODE, new \Exception("test"));
    }

    public function testConstructorWithWrongClassName()
    {
        try {
            self::assertNotNull(new ConnectorError("smthWrong", self::MESSAGE));
        } catch (\ReflectionException $e) {
            self::fail("Failed asserting don't throw a exception");
        }
    }

    public function testConstructorClassName()
    {
        self::assertNotNull($this->victim);
        self::assertNotNull($this->victim->getClass());
        self::assertEquals(get_class($this), $this->victim->getClass()->getName());
    }

    public function testConstructorMessage()
    {
        self::assertNotNull($this->victim->getMessage());
        self::assertEquals(self::MESSAGE, $this->victim->getMessage());
    }

    public function testConstructorCode()
    {
        self::assertNotNull($this->victim->getCode());
        self::assertEquals(self::CODE, $this->victim->getCode());
    }

    public function testConstructorException()
    {
        self::assertNotNull($this->victim->getException());
        self::assertEquals(new \Exception("test"), $this->victim->getException());
    }

    public function testSetClassName()
    {
        try {
            $this->victim->setClass(new \ReflectionClass(ConnectorError::class));
            self::assertNotNull($this->victim->getClass());
            self::assertEquals(new \ReflectionClass(ConnectorError::class), $this->victim->getClass());
            self::assertNotEquals(new \ReflectionClass(get_class($this)), $this->victim->getClass());
        } catch (\ReflectionException $e) {
            self::fail("Failed asserting don't throw exception");
        }
    }

    public function testSetMessage()
    {
        $msg = "Smth";

        $this->victim->setMessage($msg);
        self::assertNotNull($this->victim->getMessage());
        self::assertEquals($msg, $this->victim->getMessage());
        self::assertNotEquals(self::MESSAGE, $this->victim->getMessage());
    }

    public function testSetCode()
    {
        $code = 1;
        $this->victim->setCode($code);
        self::assertNotNull($this->victim->getCode());
        self::assertEquals($code, $this->victim->getCode());
        self::assertNotEquals(self::CODE, $this->victim->getCode());
    }

    public function testSetException()
    {
        $exception = new \Exception("smth");
        $this->victim->setException($exception);
        self::assertNotNull($this->victim->getException());
        self::assertEquals($exception, $this->victim->getException());
    }
}
