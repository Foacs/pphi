<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 18:48
 */

namespace PPHI\UnitTest;

use PHPUnit\Framework\TestCase;
use PPHI\DataSource\Expert\Expert;
use PPHI\DataSource\Expert\Processor;
use PPHI\DataSource\Source\MySQLDataSource;

class ProcessorTest extends TestCase
{
    /**
     * @var Processor
     */
    private $victim;

    private $mockExpertMySQL;
    private $mockExpertOther;

    public function setUp(): void
    {
        parent::setUp();
        $this->victim = new Processor();
        $this->mockExpertMySQL = $this->createMock(Expert::class);
        $this->mockExpertMySQL->method('execute')->with('mysql')->willReturn(new MySQLDataSource(""));

        $this->mockExpertOther = $this->createMock(Expert::class);
        $this->mockExpertOther->method('execute')->with('')->willReturn(null);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->victim = null;
        $this->mockExpertOther = null;
    }

    public function testEmptyChain()
    {
        $this->assertNull($this->victim->getExpert());
    }

    public function testNotEmptyAfterPushing()
    {
        $this->victim->pushExpert($this->mockExpertOther);
        $this->assertNotNull($this->victim->getExpert());
    }

    public function testNotEmptyAfterPushingTwice()
    {
        $this->victim->pushExpert($this->mockExpertOther);
        $this->victim->pushExpert($this->mockExpertMySQL);
        $this->assertNotNull($this->victim->getExpert());
    }

    public function testChainAfterPushingTwice()
    {
        $this->victim->pushExpert($this->mockExpertOther);
        $this->victim->pushExpert($this->mockExpertMySQL);
        $this->assertSame($this->mockExpertMySQL, $this->victim->getExpert());
    }

    public function testExecuteCallExpert()
    {
        $this->victim->pushExpert($this->mockExpertMySQL);

        $this->assertNotNull($this->victim->execute("mysql"));
    }
}
