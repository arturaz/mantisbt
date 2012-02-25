<?php
# MantisBT - a php based bugtracking system

# Copyright (C) 2002 - 2009  MantisBT Team - mantisbt-dev@lists.sourceforge.

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

namespace MantisBT\Database;

use MantisBT\Database\PDO\MySQL\MySQLDriver;
use MantisBT\Exception\Database\DatabaseTypeNotSupported;
use MantisBT\Exception\Database\ParameterCountMismatch;
use MantisBT\Exception\Database\QueryFailed;
use MantisBT\Exception\UnspecifiedException;

/**
 * Abstract database driver class.
 * @package MantisBT
 * @subpackage classes
 */
abstract class DriverAbstract {
    /**
	 * array - cache of column info
	 */
    protected $columns = array();
    /**
	 * array - cache of table info
	 */
    protected $tables  = null;

    /**
	 * string - db host name
	 */
    protected $dbHost;
    /**
	 * string - db host user
	 */
    protected $dbUser;
    /**
	 * string - db host password
	 */
    protected $dbPass;
    /**
	 * string - db name
	 */
    protected $dbName;
    /**
	 * string - db dsn
	 */
    protected $dbDsn;

	protected $tableNamePrefix = '';
	protected $tableNameSuffix = '';

    /** @var array Database or driver specific options, such as sockets or TCPIP db connections */
    protected $dbOptions;

    /** @var int Database query counter (performance counter).*/
    protected $queries = 0;

    /** @var bool Debug level */
    protected $debug  = false;

    /**
     * Destructor
     */
    public function __destruct() {
        $this->dispose();
    }

	/**
	 * Loads and returns a database instance with the specified type and library.
	 * @param string $type database type of the driver (e.g. pdo_pgsql)
	 * @return Database driver object derived from MantisBT\Database\DriverAbstract
	 */
	public static function getDriverInstance($type) {
		static $driver = null;
		if(is_null($driver)) {
			switch(strtolower($type)) {
				case 'pdo_mysql':
					$driver = new MySQLDriver;
					break;
				default:
					throw new DatabaseTypeNotSupported($type);
					break;
			}
		}
		return $driver;
	}

    /**
     * Diagnose database and tables, this function is used
     * to verify database and driver settings, db engine types, etc.
     *
     * @return string null means everything ok, string means problem found.
     */
    public function diagnose() {
        return null;
    }

    /**
     * Attempt to create the database
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     *
     * @return bool success
     */
    public function createDatabase( $dbHost, $dbUser, $dbPass, $dbName, array $dbOptions=null ) {
        return false;
    }

    /**
     * Close database connection and release all resources
     * and memory (especially circular memory references).
     * Do NOT use connect() again, create a new instance if needed.
     * @return void
     */
    public function dispose() {
        $this->columns = array();
        $this->tables  = null;
    }

    /**
     * Called before each db query.
     * @param string $sql
     * @param array array of parameters
     * @param int $type type of query
     * @param mixed $extrainfo driver specific extra information
     * @return void
     */
    protected function queryStart( $sql, array $params=null ) {
        $this->last_sql       = $sql;
        $this->last_params    = $params;
        $this->last_time      = microtime(true);

		$this->queries++;
    }

	/**
	 * Called immediately after each db query.
	 */
	public function queryEnd() {}

    /**
     * Reset internal column details cache
     * @param string $table - empty means all, or one if name of table given
     * @return void
     */
    public function resetCaches() {
        $this->columns = array();
        $this->tables  = null;
    }

    /**
     * Attempt to change db encoding toUTF-8 if possible
     * @return bool success
     */
    public function changeDbEncoding() {
        return false;
    }

    /**
     * Enable/disable debugging mode
     * @param bool $state
     * @return void
     */
    public function setDebug($state) {
        $this->debug = $state;
    }

    /**
     * Returns debug status
     * @return bool $state
     */
    public function getDebug() {
        return $this->debug;
    }

    /**
     * Returns number of queries done by this database
     * @return int
     */
    public function perfGetQueries() {
        return $this->queries;
    }

	/**
	 * Verify parameters to SQL query string
	 * @param string $sql SQL query string (or a portion thereof)
	 * @param array $parameters Query parameters
	 * @return array An array containing: [0] = SQL query string, [1] = array of parameters
	 */
	public function checkSqlParameters($queryString, array $parameters = null) {
		$expectedParameterCount = substr_count($queryString, '?');
		$actualParameterCount = 0;
		if ($parameters !== null) {
			$actualParameterCount = count($parameters);
		} else {
			$parameters = array();
		}

		if ($expectedParameterCount !== $actualParameterCount) {
			throw new ParameterCountMismatch($queryString, $parameters);
		}

		if ($actualParameterCount === 0) {
			return array($queryString, array());
		} else {
			// cast booleans to 1/0 int
			foreach ($parameters as $parameterName => $parameterValue) {
				$parameters[$parameterName] = is_bool($parameterValue) ? (int)$parameterValue : $parameterValue;
			}

			return array($queryString, array_values($parameters));
		}
	}

	public function getTableNamePrefix() {
		return $this->tableNamePrefix;
	}

	public function setTableNamePrefix($prefix) {
		$this->tableNamePrefix = $prefix;
	}

	public function getTableNameSuffix() {
		return $this->tableNameSuffix;
	}

	public function setTableNameSuffix($suffix) {
		$this->tableNameSuffix = $suffix;
	}

	protected function remapTableNames($statement) {
		$mappings = array('{' => $this->getTableNamePrefix(),
		                  '}' => $this->getTableNameSuffix());
		return strtr($statement, $mappings);
	}

	/* legacy functions */
	public function legacyNullDate() {
        return "1970-01-01 00:00:01";
    }

	public function legacyTimestamp( $date ) {
		$timestamp = strtotime( $date );
		if ( $timestamp == false ) {
			throw new UnspecifiedException();
		}
		return $timestamp;
	}
}
