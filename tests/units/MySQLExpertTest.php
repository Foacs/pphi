<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 19:10
 */

namespace PPHI\UnitTest;

use PHPUnit\Framework\TestCase;
use PPHI\DataSource\Expert\Expert;
use PPHI\DataSource\Expert\MySQLExpert;
use PPHI\DataSource\Source\DataSource;

class MySQLExpertTest extends TestCase
{

    /**
     * @var MySQLExpert
     */
    private $victim;

    private $mockExpert;
    private $mockDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->victim = new MySQLExpert();
        $this->mockExpert = $this->createMock(Expert::class);
        $this->mockDataSource = $this->createMock(DataSource::class);
        $this->mockExpert->method('execute')->with('test')->willReturn($this->mockDataSource);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->victim = null;
        $this->mockExpert = null;
    }

    public function testExecuteWithMySQL()
    {
        self::assertNotNull($this->victim->execute('mysql'));
        self::assertIsObject($this->victim->execute('mysql'));
    }

    public function testExecuteWithEmpty()
    {
        self::assertNull($this->victim->execute(''));
    }

    public function testExecuteWithTestAndNextExpert()
    {
        $this->victim->setNext($this->mockExpert);
        self::assertNotNull($this->victim->execute('test'));
        self::assertSame($this->mockDataSource, $this->victim->execute('test'));
    }
}
