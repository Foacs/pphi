<?php
/**
 * Copyright Foacs
 * contributor(s): Alexis DINQUER
 *
 * (2019-08-15)
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

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use PPHI\DataSource\DataSourceManager;
use PPHI\DataSource\Expert\Processor;
use PPHI\DataSource\Source\MySQLDataSource;
use PPHI\Exception\UnknownDataSourcesTypeException;
use PPHI\utils\PPHILogger;

class DataSourceManagerTest extends TestCase
{
    /**
     * @var DataSourceManager
     */
    private $victim;

    /**
     * @var MockInterface
     */
    private $processor;

    protected function setUp(): void
    {
        parent::setUp();
        PPHILogger::getInstance()->setIgnoreFile(true);
        $this->processor = Mockery::mock(Processor::class);
        $this->processor->allows()->pushExpert(Mockery::any());

        $this->victim = new DataSourceManager($this->processor, []);
    }

    public function testLoadWithMysql()
    {
        $sqlDataSource = Mockery::mock(MySQLDataSource::class);
        $sqlDataSource->allows()->setUp(Mockery::any());
        $this->processor->allows()->execute("mysql")->andReturn($sqlDataSource);
        $dataSource = [
            "type" => "mysql"
        ];

        try {
            $this->victim->load(["mysql" => $dataSource]);
            self::assertNotEmpty($this->victim->getDataSources());
            self::assertEquals($sqlDataSource, $this->victim->getDataSources()['mysql']);
        } catch (UnknownDataSourcesTypeException $e) {
            self::fail("Failed to assert");
        }
    }

    public function testLoadWithWrongDS()
    {
        $this->expectException(UnknownDataSourcesTypeException::class);
        $this->processor->allows()->execute("smth")->andReturn(null);
        $dataSource = [
            "type" => "smth"
        ];
        $this->victim->load(["mysql" => $dataSource]);
    }


    public function testLoadEmptyDataSource()
    {
        try {
            self::assertEquals(0, $this->victim->load([]));
        } catch (UnknownDataSourcesTypeException $e) {
            self::fail("Failed to assert");
        }
    }
}
