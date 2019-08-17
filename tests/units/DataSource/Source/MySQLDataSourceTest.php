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

use PHPUnit\Framework\TestCase;
use PPHI\DataSource\Source\MySQLDataSource;
use PPHI\Exception\WrongMySQLDataSourcesConfigurationException;
use PPHI\utils\PPHILogger;

class MySQLDataSourceTest extends TestCase
{
    /**
     * @var MySQLDataSource
     */
    private $victim;

    protected function setUp(): void
    {
        parent::setUp();
        PPHILogger::getInstance()->setIgnoreFile(true);
        $this->victim = new MySQLDataSource("name");
    }

    public function testSetUpWithoutMySQL()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $this->victim->setUp([]);
    }

    public function testSetUpNoConfigArray()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => 'smth'];
        $this->victim->setUp($config);
    }

    public function testSetUpEmptyArray()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => []];
        $this->victim->setUp($config);
    }

    public function testSetUpNoURL()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => [
            "port" => 1,
            "username" => "smith",
            "password" => "password",
            "database" => "db",
        ]];
        $this->victim->setUp($config);
    }

    public function testSetUpNoUserName()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => [
            "URL" => "url",
            "port" => 1,
            "password" => "password",
            "database" => "db",
        ]];
        $this->victim->setUp($config);
    }

    public function testSetUpNoPort()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => [
            "URL" => "url",
            "username" => "smith",
            "password" => "password",
            "database" => "db",
        ]];
        $this->victim->setUp($config);
    }

    public function testSetUpNoPassword()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => [
            "URL" => "url",
            "port" => 1,
            "username" => "smith",
            "database" => "db",
        ]];
        $this->victim->setUp($config);
    }

    public function testSetUpNoDb()
    {
        $this->expectException(WrongMySQLDataSourcesConfigurationException::class);
        $config = ['mysql' => [
            "URL" => "url",
            "port" => 1,
            "username" => "smith",
            "password" => "password",
        ]];
        $this->victim->setUp($config);
    }

    public function testSetUpRightConfig()
    {
        $config = ['mysql' => [
            "url" => "url",
            "port" => 1,
            "username" => "smith",
            "password" => "password",
            "database" => "db"
        ]];
        try {
            $this->victim->setUp($config);
        } catch (WrongMySQLDataSourcesConfigurationException $e) {
            self::fail("Failed to assert");
        }
        self::assertEquals("mysql", $this->victim->getType());
        self::assertEquals("url", $this->victim->getUrl());
        self::assertEquals(1, $this->victim->getPort());
        self::assertEquals("smith", $this->victim->getUsername());
        self::assertEquals("password", $this->victim->getPassword());
        self::assertEquals("db", $this->victim->getDatabase());
    }
}
