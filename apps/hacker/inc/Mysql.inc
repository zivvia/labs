<?php




define("ERROR_MYSQL_CONNECT",			"错误1:      无法连接到数据库");
define("ERROR_MYSQL_SQL",				"错误2:      在执行一个 SQL 出错");
define("ERROR_MODEL",					"错误3:      错误的 MODEL 参数");
define("ERROR_ACTION",					"错误3:      未知的命令");

/**
* 数据库辅助类。
*/
class Mysql {

    /**
	 * 查询总次数。
	 * 
	 * @var int
	 */
    public $querynum = 0;

    /**
	 * 连接对象。
	 * 
	 * @var object
	 */
    private $link;

    /**
	 * 构造函数。
	 * 
	 * @param string $dbhost 主机名。
	 * @param string $dbuser 用户。
	 * @param string $dbpw 密码。
	 * @param string $dbname 数据库名。
	 * @param int $pconnect 是否持续连接。
	 */
	function Mysql($dbhost, $dbuser, $dbpw, $dbname, $pconnect = true) {
		
		if($pconnect) {

            if(!$this->link = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
                $this->halt(ERROR_MYSQL_CONNECT);
            }

        } else {

            if(!$this->link = @mysql_connect($dbhost, $dbuser, $dbpw)) {
                $this->halt(ERROR_MYSQL_CONNECT);
            }

        }

        if($this->version() > '5.0.1') {
        	mysql_query("SET sql_mode=''", $this->link);
        }

        if($dbname) {
            mysql_select_db($dbname, $this->link);
        }
    }
	
	/**
	 * 设置编码。
	 * 
	 * @param string $dbcharset 字符集。
	 * @return 是否成功。
	 */
	function set_character($dbcharset)  {
		
		@mysql_query("set names $dbcharset;");
		
		if($this->version() > '5.0.1')  {
			return mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary", $this->link);
		}
	}

    /**
	 * 选择数据库。
	 * 
	 * @param string $dbname 数据库名。
	 * @return 是否成功。
	 */
    function select_db($dbname) {

        return mysql_select_db($dbname, $this->link);

    }

    /**
	 * 取出结果集中一条记录
	 * 
	* @param object $query 结果集。
	* @param int $result_type 类型。
	* @return array 数组。
	 */
    function fetch_array($query, $result_type = MYSQL_ASSOC) {

        return mysql_fetch_array($query, $result_type);

    }

    /**
	 * 取出所有结果
	 * 
	 * @param object $query 结果集。
	* @param int $result_type 类型。
	 * @return array 数组。
	 */
    function fetch_all($query, $result_type = MYSQL_ASSOC) {

        $result = array();

        $num = 0;

        while($ret = mysql_fetch_array($query, $result_type)){
            $result[$num++] = $ret;
        }

        return $result;

    }

    /**
	 * 从结果集中取得一行作为枚举数组
	 * 
	 * @param object $query 结果集。
	 * @return array 数组。
	 */
    function fetch_row($query) {

        return mysql_fetch_row($query);
		
    }

    /**
	 * 返回查询结果 。
	 * 
	 * @param object $query 结果集。
	 * @param string $row 行数。
	 * @return mixed 结果。
	 */
    function result($query, $row) {

        return @mysql_result($query, $row);

    }

    /**
	 * 查询SQL 。
	 * 
	 * @param string $sql 语句。
	 * @return object 结果集。
	 */
    function query($sql) {

        if(!($query = mysql_query($sql, $this->link))) {
            $this->halt(ERROR_MYSQL_SQL, $sql);
        }

        $this->querynum++;

        return $query;

    }
	
	/**
	 * 执行SQL 返回影响的数目。
	 *
	 * @param string $sql 语句。
	 * @return int 影响的条数。
	 */
	function commit($sql) {
		if(!mysql_query($sql, $this->link)) {
			$this->halt(ERROR_MYSQL_SQL, $sql);
		}
		
		
		return mysql_affected_rows($this->link);
	}
	
    /**
	 * 无缓存查询SQL。
	 * 
	* @param string $sql 语句。
	* @return object 结果集。
	 */
    function unbuffered_query($sql) {

        $func = @function_exists('mysql_unbuffered_query') ?

                'mysql_unbuffered_query' : 'mysql_query';

        if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
            $this->halt(ERROR_MYSQL_SQL, $sql);
        }

        $this->querynum++;

        return $query;

    }
	
	/**
	 * 获取指定索引列名。
	 * @param object $query 查询。
	 * @param Number $index 索引。
	 * @return String 列名。
	 */
	function field_name($query, $index){
		
		return mysql_field_name($query, $index);
		
	}
	
	/**
	 * 获取列名。
	 * @param object $query 查询。
	 * @param Number $index 索引。
	 * @return Array 列名。
	 */
	function fields($query){
		$ret = array();
		$numberfields = $this->num_fields($query);
		for($i = 0; $i < $numberfields; $i++){
			array_push($ret, $this->field_name($query, $i));
		}
		return $ret;
	}

    /**
 	 * 获取影响条数。
 	 * 
 	 * @return int 影响的条数。
 	 */
    function affected_rows() {

        return mysql_affected_rows($this->link);

    }

    /**
	 * 返回错误信息。
	 *
	 * @return array 数组的错误内容。
	 */
    function error() {

        return (($this->link) ? mysql_error($this->link) : mysql_error());

    }

    /**
	 * 返回错误代码。
	 *
	 * @return int 错误码。
	 */
    function errno() {

        return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());

    }

	/**
	 * 获取结果条数。
	 *
	 * @param object $query 结果集。
	 * @return int 数目。
	 */
    function num_rows($query) {

        return mysql_num_rows($query);

    }

    /**
	 * 取字段总数。
	 * 
	 * @param object $query
	 * @return int
	 */
    function num_fields($query) {

        return mysql_num_fields($query);

    }

    /**
	 * 释放结果集。
	 * 
	 * @param object $query 结果集。
	 * @return bool 是否成功。
	 */
    function free_result($query) {

        return mysql_free_result($query);

    }

    /**
	 * 返回自增ID 。
	 * 
	 * @return int 刚插入的值的自动化序号。
	 */
    function insert_id() {

        return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);

    }

    /**
	 * 从结果集中取得列信息并作为对象返回。
	 * 
	 * @param object $query 结果集。
	 * @return object 对象。
	 */
    function fetch_fields($query) {

        return mysql_fetch_field($query);

    }

    /**
	 * 返回mysql版本。
	 * 
	 * @return string 版本字符串。
	 */
    function version() {
		
        return mysql_get_server_info($this->link);
		
    }

    /**
	 * 关闭连接。
	 * 
	 * @return bool 是否成功。
	 */
    function close() {
		
        return mysql_close($this->link);
		
    }

    /**
	 * 输出错误信息。
	 * 
	 * @param string $message 内容。
	 * @param string $sql 发送错误的代码。
	 */
    function halt($message = '', $sql = '') {
		
        echo $message;
		
		if($sql && defined("DEBUG")){
			echo "<br />SQL : " . $sql;
			echo "<br />ERR : " . $this->error();
		}
			
        exit;
		
    }

}

?>
