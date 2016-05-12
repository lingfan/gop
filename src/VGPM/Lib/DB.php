<?php
namespace VGPM\Lib;

use PDO;

/**
 * Class db
 */
class DB {

	protected $_name = '';

	protected $_primary = '';

	private $_pdo = null;
	private $_t   = 0;

	/**
	 * 构造函数
	 */
	public function __construct() {
		$this->_pdo = $this->connect();
	}

	/**
	 * 获取单条数据
	 *
	 * @param int $value
	 */
	public function get($value) {
		$sql = sprintf('SELECT * FROM %s WHERE %s = %s', $this->getTableName(), $this->_primary, $value);
		return $this->fetch($sql);
	}

	/**
	 * 获取多条数据
	 *
	 * @param int $values
	 */
	public function gets($field, $values) {
		$sql = sprintf('SELECT * FROM %s WHERE %s IN %s', $this->getTableName(), $field, $this->quoteArray($values));
		return $this->fetchAll($sql);
	}

	/**
	 * 查询所有数据
	 */
	public function getAll($orderBy = []) {
		$sort = $this->sqlSort($orderBy);
		$sql  = sprintf('SELECT * FROM %s %s', $this->getTableName(), $sort);
		return $this->fetchAll($sql);
	}

	/**
	 * 查询所有数据
	 */
	public function max($field = "", $params = []) {
		if ($field == "") $field = $this->_primary;
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT max(%s) AS num FROM %s WHERE %s ', $field, $this->getTableName(), $where);
		return $this->fetchCloum($sql, 0);
	}

	/**
	 * 查询所有数据
	 */
	public function min($field = "", $params = []) {
		if ($field == "") $field = $this->_primary;
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT min(%s) AS num FROM %s WHERE %s ', $field, $this->getTableName(), $where);
		return $this->fetchCloum($sql, 0);
	}

	/**
	 * 获取分页列表数据
	 *
	 * @param array $params
	 * @param int   $page
	 * @param int   $limit
	 */
	public function getList($start = 0, $limit = 20, array $params = [], array $orderBy = []) {
		$where = $this->sqlWhere($params);
		$sort  = $this->sqlSort($orderBy);
		$sql   = sprintf('SELECT * FROM %s WHERE %s %s LIMIT %d,%d', $this->getTableName(), $where, $sort, intval($start), intval($limit));
		return $this->fetchAll($sql);
	}

	/**
	 * 根据条件查询
	 *
	 * @param array $were
	 */
	public function getBy($params, array $orderBy = []) {
		if (!is_array($params)) return false;
		$where = $this->sqlWhere($params);
		$sort  = $this->sqlSort($orderBy);
		$sql   = sprintf('SELECT * FROM %s WHERE %s %s', $this->getTableName(), $where, $sort);
		return $this->fetch($sql);
	}

	/**
	 * @param unknown_type $params
	 *
	 * @return boolean|mixed
	 */
	public function getsBy($params, $orderBy = []) {
		if (!is_array($params) || !is_array($orderBy)) return false;
		$where = $this->sqlWhere($params);
		$sort  = $this->sqlSort($orderBy);
		$sql   = sprintf('SELECT * FROM %s WHERE %s %s', $this->getTableName(), $where, $sort);
		return $this->fetchAll($sql);
	}

	/**
	 * 根据参数统计总数
	 *
	 * @param array $params
	 */
	public function count($params = []) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT COUNT(*) FROM %s WHERE %s', $this->getTableName(), $where);
		return $this->fetchCloum($sql, 0);
	}

	/**
	 * @param unknown_type $sqlWhere
	 */
	public function searchBy($start, $limit, $sqlWhere = 1, array $orderBy = []) {
		$sort = $this->sqlSort($orderBy);
		$sql  = sprintf('SELECT * FROM %s WHERE %s %s LIMIT %d,%d', $this->getTableName(), $sqlWhere, $sort, $start, $limit);
		return $this->fetchAll($sql);
	}

	/**
	 * @param string $sqlWhere
	 *
	 * @return string
	 */
	public function searchCount($sqlWhere) {
		$sql = sprintf('SELECT COUNT(*) FROM %s WHERE %s', $this->getTableName(), $sqlWhere);
		return $this->fetchCloum($sql, 0);
	}

	/**
	 * 插入数据
	 *
	 * @param array $data
	 */
	public function insert($data, $rowCount = false) {
		if (!is_array($data)) return false;
		$sql = sprintf('INSERT INTO %s SET %s', $this->getTableName(), $this->sqlSingle($data));
		$ret = $this->execute($sql, [], $rowCount);
		if (!$rowCount) {
			$ret = $this->_pdo->lastInsertId();
		}
		return $ret;
	}

	/**
	 * 插入数据
	 *
	 * @param array $data
	 */
	public function mutiInsert($data) {
		if (!is_array($data)) return false;
		$sql = sprintf('INSERT INTO %s VALUES %s', $this->getTableName(), $this->quoteMultiArray($data));
		return $this->execute($sql);
	}

	/**
	 * 更新数据并返回影响行数
	 *
	 * @param array $data
	 * @param int   $value
	 */
	public function update($data, $value) {
		if (!is_array($data)) return false;
		$sql = sprintf('UPDATE %s SET %s WHERE %s = %d', $this->getTableName(), $this->sqlSingle($data), $this->_primary, intval($value));
		return $this->execute($sql, [], false);
	}

	/**
	 * 批量更新并返回执行结果
	 *
	 * @param array $field
	 * @param array $values
	 *
	 * @return array
	 */
	public function updates($field, $values, $data) {
		if (!$field || !is_array($values)) return false;
		$sql = sprintf('UPDATE %s SET %s WHERE %s IN %s', $this->getTableName(), $this->sqlSingle($data), $field, $this->quoteArray($values));
		return $this->execute($sql, [], false);
	}

	/**
	 * 指量更新
	 *
	 * @param array $data
	 * @param array $params
	 *
	 * @return boolean
	 */
	public function updateBy($data, $params) {
		if (!is_array($data) || !is_array($params)) return false;
		$where = $this->sqlWhere($params);
		$sql   = sprintf('UPDATE %s SET %s WHERE %s', $this->getTableName(), $this->sqlSingle($data), $where);
		return $this->execute($sql, [], false);
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 */
	public function replace($data) {
		if (!is_array($data)) return false;
		$sql = sprintf('REPLACE %s SET %s', $this->getTableName(), $this->sqlSingle($data));
		return $this->execute($sql, [], false);
	}

	/**
	 * increment an field by params
	 *
	 * @param string $field
	 * @param array  $where
	 */
	public function increment($field, $params, $step = 1) {
		if (!$field || !$params) return false;
		$where = $this->sqlWhere($params);
		$sql   = sprintf('UPDATE %s SET %s=%s+%d WHERE %s ', $this->getTableName(), $field, $field, $step, $where);
		return $this->execute($sql, [], false);
	}

	/**
	 * 删除数据并返回影响行数
	 *
	 * @param int $value
	 */
	public function delete($value) {
		$sql = sprintf('DELETE FROM %s WHERE %s = %d', $this->getTableName(), $this->_primary, intval($value));
		return $this->execute($sql, [], true);
	}

	/**
	 * 删除多条数据并返回执行结果
	 *
	 * @param int $value
	 */
	public function deletes($field, $values) {
		if (!$field || !is_array($values)) return false;
		$sql = sprintf('DELETE FROM %s WHERE %s IN %s', $this->getTableName(), $field, $this->quoteArray($values));
		return $this->execute($sql, [], false);
	}

	/**
	 * @param array $params
	 *
	 * @return boolean
	 */
	public function deleteBy($params) {
		if (!is_array($params)) return false;
		$where = $this->sqlWhere($params);
		$sql   = sprintf('DELETE FROM %s WHERE %s', $this->getTableName(), $where);
		return $this->execute($sql, [], true);
	}

	/**
	 * 获取最后插入的ID
	 */
	public function getLastInsertId() {
		return $this->_pdo->lastInsertId();
	}

	/**
	 * 获取表名
	 */
	public function getTableName() {
		return $this->_name;
	}

	/**
	 * 根据sql查询
	 *
	 * @param string $sql
	 */
	public function fetch($sql, $params = [], $fetch_style = PDO::FETCH_ASSOC) {
		$stmt = $this->getStatement($sql, $params);
		return $stmt->fetch($fetch_style);
	}

	/**
	 * 查询column列结果
	 *
	 * @param string $sql
	 * @param array  $cloum
	 */
	public function fetchCloum($sql, $column_number = null, $params = []) {
		$stmt = $this->getStatement($sql, $params);
		return $stmt->fetchColumn($column_number);
	}

	/**
	 * 查询所有结果集
	 *
	 * @param string $sql
	 * @param array  $params
	 * @param int    $fetch_style
	 */
	public function fetchAll($sql, $params = [], $fetch_style = PDO::FETCH_ASSOC) {
		$stmt = $this->getStatement($sql, $params);
		return $stmt->fetchAll($fetch_style);
	}

	/**
	 * 执行sql并返回影响行数
	 *
	 * @param array $params
	 * @param bool  $rowCount
	 */
	public function execute($sql, $params = [], $rowCount = false) {
		$stmt = $this->_pdo->prepare($sql);
		$ret  = $stmt->execute($params);

		if (!$ret) {
			trigger_error(__METHOD__ . ':' . json_encode($stmt->errorInfo()) . ':' . json_encode(func_get_args()));
			return false;
		}

		return $rowCount ? $stmt->rowCount() : true;
	}

	/**
	 * 获取PDOStatement
	 *
	 * @param string $sql
	 * @param array  $params
	 */
	public function getStatement($sql, $params = []) {
		$stmt = $this->_pdo->prepare($sql);
		$ret  = $stmt->execute($params);
		if (!$ret) {
			trigger_error(__METHOD__ . ':' . json_encode($stmt->errorInfo()) . ':' . json_encode(func_get_args()));
			return false;
		}
		return $stmt;
	}


	/**
	 * 字符串过滤
	 *
	 * @param string $string
	 * @param int    $parameter_type
	 */
	public function quote($string, $parameter_type = null) {
		return $this->_pdo->quote($string, $parameter_type);
	}

	/**
	 * @param string $connType
	 *
	 * @throws PDOException
	 */
	public function connect() {

		$dbConf = Config::get('db');
		$dsn    = sprintf("mysql:host=%s;port=%s;dbname=%s", $dbConf['hostname'], $dbConf['port'], $dbConf['database']);
		try {
			$option = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::ATTR_PERSISTENT => false];
			$dbh    = new PDO($dsn, $dbConf['username'], $dbConf['password'], $option);
			$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			trigger_error('DB Connection failed:' . $e->getMessage() . json_encode($dbConf));
			exit;
		}
		return $dbh;
	}

	/**
	 * 批量绑定参数
	 *
	 * @param PDOStament $stmt
	 * @param array      $params
	 */
	public function bindValues($stmt, $params) {
		if (!is_array($params)) {
			throw new Exception('Error unexpected paraments type' . gettype($params));
		}
		$keied = (array_keys($params) !== range(0, sizeof($params) - 1));
		foreach ($params as $key => $value) {
			if (!$keied) $key = $key + 1;
			$stmt->bindValue($key, $value, $this->_getDataType($value));
		}
	}


	/**
	 * 解析多个占位符
	 *
	 * @param string $text
	 * @param array  $value
	 * @param int    $type
	 * @param int    $count
	 */
	public function quoteInto($text, $value, $type = null, $count = null) {
		if ($count === null) {
			return str_replace('?', $this->quote($value, $type), $text);
		} else {
			while ($count > 0) {
				if (strpos($text, '?') !== false) {
					$text = substr_replace($text, $this->quote($value, $type), strpos($text, '?'), 1);
				}
				--$count;
			}
			return $text;
		}
	}

	/**
	 * 过滤数组转换成sql字符串
	 *
	 * @param array $params
	 */

	public function quoteArray($variable) {
		if (empty($variable) || !is_array($variable)) return '';
		$_returns = [];
		foreach ($variable as $value) {
			$_returns[] = $this->quote($value);
		}
		return '(' . implode(', ', $_returns) . ')';
	}

	/**
	 * 过滤二维数组将数组变量转换为多组的sql字符串
	 *
	 * @param array $var
	 */
	public function quoteMultiArray($var) {
		if (empty($var) || !is_array($var)) return '';
		$_returns = [];
		foreach ($var as $val) {
			if (!empty($val) && is_array($val)) {
				$_returns[] = $this->quoteArray($val);
			}
		}
		return implode(', ', $_returns);
	}

	/**
	 * 组装单条 key=value 形式的SQL查询语句值
	 *
	 * @param array $array
	 */
	public function sqlSingle($array) {
		if (!is_array($array)) return '';
		$str = [];
		foreach ($array as $key => $val) {
			$str[] = $this->fieldMeta($key) . '=' . $this->quote($val);
		}
		return $str ? implode(',', $str) : '';
	}

	/**
	 * where 条件组装
	 *
	 * @param array $array
	 *
	 * @return string
	 */
	public function sqlWhere($array) {
		if (!is_array($array)) return 1;
		$str = [];
		foreach ($array as $field => $val) {
			if (is_array($val)) {
				if (is_array($val[0])) { //'id'=>array(array('>', 0), array('<', 10))
					foreach ($val as $v) {
						list($op, $value) = $v;
						$str[] = $this->_where($field, strtoupper($op), $value);
					}
				} else { //'id'=>array('>', 0)
					list($op, $value) = $val;
					$str[] = $this->_where($field, strtoupper($op), $value);
				}
			} else { //'id'=>0
				$str[] = $this->_where($field, "=", $val);
			}
		}
		return $str ? implode(' AND ', $str) : 1;
	}

	/**
	 * where 条件匹配
	 *
	 * @param string $field
	 * @param string $op
	 * @param string $value
	 *
	 * @return string
	 */
	public function _where($field, $op, $value) {
		$str = "";
		switch ($op) {
			case ">":
			case "<":
			case ">=":
			case "<=":
			case "!=":
				$str .= $this->fieldMeta($field) . $op . $this->quote($value);
				break;
			case "IN":
				$str .= $this->fieldMeta($field) . $op . $this->quoteArray($value);
				break;
			case "LIKE":
				$str .= sprintf("%s LIKE %s", $this->fieldMeta($field), $this->quote("%" . $this->filterLike($value) . "%"));
				break;
			case "=" :
				$str .= $this->fieldMeta($field) . '=' . $this->quote($value);
				break;
		}
		return $str;
	}

	/**
	 * @param unknown_type $sort
	 *
	 * @return string
	 */
	public function sqlSort($sort) {
		if (!is_array($sort) || !count($sort)) return '';
		$str    = ' ORDER BY ';
		$orders = [];
		foreach ($sort as $key => $value) {
			$orders[] = $key . ' ' . $value;
		}
		return $str . implode(', ', $orders);
	}

	/**
	 * sql关键字段过滤
	 *
	 * @param array $data
	 */
	public function fieldMeta($data) {
		$data = str_replace(['`', ' '], '', $data);
		return ' `' . $data . '` ';
	}

	/**
	 * @param string $keyWord
	 *
	 * @return string
	 */
	public function filterLike($keyWord) {
		$search  = ['[', '%', '_', '/'];
		$replace = ['[[]', '[%]', '[_]', '[/]'];
		return str_replace($search, $replace, $keyWord);
	}


	/**
	 * 获得绑定参数的类型
	 *
	 * @param string $variable
	 *
	 * @return int
	 */
	private function _getDataType($var) {
		$types = [
			'boolean' => PDO::PARAM_BOOL,
			'integer' => PDO::PARAM_INT,
			'string'  => PDO::PARAM_STR,
			'NULL'    => PDO::PARAM_NULL
		];
		return isset($types[gettype($var)]) ? $types[gettype($var)] : PDO::PARAM_STR;
	}
}