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
 *
 * This software includes
 */
namespace PPHI\UnitTest;

use Mockery;
use PHPUnit\Framework\TestCase;
use PPHI\Connector\Database\MySQLConnector;
use PPHI\DataSource\Source\DataSource;
use PPHI\DataSource\Source\MySQLDataSource;

class MySQLConnectorTest extends TestCase
{
    /**
     * @var MySQLConnector
     */
    private $victim;

    private $pdo;

    private $MySQLDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->victim = new MySQLConnector();
        $this->pdo = Mockery::mock(\PDO::class);
        $this->MySQLDataSource = Mockery::mock(MySQLDataSource::class);
    }

    public function testConnectWrongDataSource()
    {
        self::assertFalse($this->victim->connect(Mockery::mock(DataSource::class)));
        self::assertNotNull($this->victim->getError());
    }

    public function testConnectWithMySQLDS()
    {
        $this->MySQLDataSource->allows()->getUrl()->andReturn("");
        $this->MySQLDataSource->allows()->getDatabase()->andReturn("");
        $this->MySQLDataSource->allows()->getPassword()->andReturn("");
        $this->MySQLDataSource->allows()->getUsername()->andReturn("");
        $this->MySQLDataSource->allows()->getPort()->andReturn(80);
        self::assertTrue($this->victim->connect($this->MySQLDataSource, $this->pdo));
    }
}
