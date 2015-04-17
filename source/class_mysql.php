<?php
/**
 * ³éÈ¡uchomeµÄDBÀà
 * $Id: class_mysql.php  2010-09-25 11:33:10Z $
 */

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

class dbstuff {
    var $querynum = 0;
    var $link;
    var $charset;
    function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE) {
        if($pconnect) {
            if(!$this->link = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
                $halt && $this->halt('Can not connect to MySQL server');
            }
        } else {
            if(!$this->link = @mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
                $halt && $this->halt('Can not connect to MySQL server');
            }
        }

        if($this->version() > '4.1') {
            if($this->charset) {
                @mysql_query("SET character_set_connection=$this->charset, character_set_results=$this->charset, character_set_client=binary", $this->link);
            }
            if($this->version() > '5.0.1') {
                @mysql_query("SET sql_mode=''", $this->link);
            }
        }
        if($dbname) {
            @mysql_select_db($dbname, $this->link);
        }
        $cache_options = array(
            'servers' => array(
                '192.168.1.82:11211', // localhost, default port
            ),
            'compress' => true, // compress data in Memcache (slower, but uses less memory)
                'persistent' => FALSE,
            'group' => 'default'
       );
       
    }

    function select_db($dbname) {
        return mysql_select_db($dbname, $this->link);
    }

    function fetch_array($query, $result_type = MYSQL_ASSOC) {
        return mysql_fetch_array($query, $result_type);
    }

    function query($sql, $type = '') {
        if(SQL_BUG) {
            global $_SGLOBAL;
            $sqlstarttime = $sqlendttime = 0;
            $mtime = explode(' ', microtime());
            $sqlstarttime = number_format(($mtime[1] + $mtime[0] - $_SGLOBAL['supe_starttime']), 6) * 1000;
        }
        $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
            'mysql_unbuffered_query' : 'mysql_query';
        if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
            $this->halt('MySQL Query Error', $sql);
        }
        if(SQL_BUG) {
            $mtime = explode(' ', microtime());
            $sqlendttime = number_format(($mtime[1] + $mtime[0] - $_SGLOBAL['supe_starttime']), 6) * 1000;
            $sqltime = round(($sqlendttime - $sqlstarttime), 3);

            $explain = array();
            $info = mysql_info();
            if($query && preg_match("/^(select )/i", $sql)) {
                $explain = mysql_fetch_assoc(mysql_query('EXPLAIN '.$sql, $this->link));
            }
            $_SGLOBAL['debug_query'][] = array('sql'=>$sql, 'time'=>$sqltime, 'info'=>$info, 'explain'=>$explain);
        }
        $this->querynum++;
        return $query;
    }

    function affected_rows() {
        return mysql_affected_rows($this->link);
    }

    function error() {
        return (($this->link) ? mysql_error($this->link) : mysql_error());
    }

    function errno() {
        return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
    }

    function result($query, $row) {
        $query = @mysql_result($query, $row);
        return $query;
    }

    function num_rows($query) {
        $query = mysql_num_rows($query);
        return $query;
    }

    function num_fields($query) {
        return mysql_num_fields($query);
    }

    function free_result($query) {
        return mysql_free_result($query);
    }

    function insert_id() {
        return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
    }

    function fetch_row($query) {
        $query = mysql_fetch_row($query);
        return $query;
    }

    function fetch_fields($query) {
        return mysql_fetch_field($query);
    }

    function version() {
        return mysql_get_server_info($this->link);
    }

    function close() {
        return mysql_close($this->link);
    }

    function halt($message = '', $sql = '') {
        $dberror = $this->error();
        $dberrno = $this->errno();
        $help_link = "http://faq.comsenz.com/?type=mysql&dberrno=".rawurlencode($dberrno)."&dberror=".rawurlencode($dberror);
        echo "<div style=\"position:absolute;font-size:11px;font-family:verdana,arial;background:#EBEBEB;padding:0.5em;\">
                <b>MySQL Error</b><br>
                <b>Message</b>: $message<br>
                <b>SQL</b>: $sql<br>
                <b>Error</b>: $dberror<br>
                <b>Errno.</b>: $dberrno<br>
                <a href=\"$help_link\" target=\"_blank\">Click here to seek help.</a>
                </div>";
        exit();
    }
    // cache
    function &getArray($sql, $result_type = MYSQL_ASSOC) {
        if ($sql == '') return FALSE;
        $result = $this->query($sql);
        if (!$result) return FALSE;
        $data = $this->fetch_array($result);
        return $data;
    }

    function &getAll($sql, $result_type = MYSQL_ASSOC) {
        if ($sql == '') return FALSE;
        $result = $this->query($sql);
        if (!$result) return FALSE;
        $data = array();
        while($row = $this->fetch_array($result))
            $data[] = $row;
        return $data;
    }
    
    function getOne($sql) {
        if ($sql == '') return FALSE;
        $result = $this->query($sql);
        if (!$result) return FALSE;
        if ($row = $this->fetch_row($result)) {
            $data = reset($row);
            return $data;
        }
        return FALSE;
    }

    function cacheGet($key) {
        return $this->cache->get($key);
    }

    function cacheSet($key, $var, $expire){
        return $this->cache->set($key, $var, $expire);
    }

    function cacheRemove($key){
        return $this->cache->delete($key);
    }

    function cacheGetArray($sql, $timed = 60, $key = NULL, $reload = FALSE, $result_type = MYSQL_ASSOC) {
        if ($sql == '') return FALSE;
        if ($timed < 1) return $this->getArray($sql);
        if (empty($key)) $key = 'sql_r'.md5($sql).$result_type;
        if ($reload || ($data = $this->cacheGet($key)) === FALSE) {
            $data = $this->getArray($sql);
            $this->cacheSet($key, $data, $timed);
        }
        return $data;
    }

    function cacheGetAll($sql, $timed = 60, $key = NULL, $reload = FALSE, $result_type = MYSQL_ASSOC) {
        if ($sql == '') return FALSE;
        if ($timed < 1) return $this->getAll($sql);
        if (empty($key)) $key = 'sql_a'.md5($sql).$result_type;
        if ($reload || ($data = $this->cacheGet($key)) === FALSE) {
            $data = $this->getAll($sql);
            $this->cacheSet($key, $data, $timed);
        }
        return $data;
    }

    function cacheGetOne($sql, $timed = 60, $key = NULL, $reload = FALSE) {
        if ($sql == '') return FALSE;
        if ($timed < 1) return $this->getOne($sql);
        if (empty($key)) $key = 'sql_o'.md5($sql);
        if ($reload || ($data = $this->cacheGet($key)) === FALSE) {
            $data = $this->getOne($sql);
            $this->cacheSet($key, $data, $timed);
        }
        return $data;
    }
}

?>