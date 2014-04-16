<?php
class db
{
    private static $instance;
    private $debug;

    public function __construct()
	{
        if ($instance = mysql_connect(DB_HOST, DB_USER, DB_PASS))
		{
            mysql_select_db(DB_NAME, $instance);
            $query_result = mysql_query('SET NAMES `utf8`',$instance);
            $query_result = mysql_query('SET CHARACTER SET `utf8`',$instance);
		} else
            exit('Tiek veikti uzlabojumi!');
        $this->debug = array();
    }

	public static function query($query)
	{
        if (!self::$instance) self::$instance = new db();
		$ret = null;
		$result = mysql_query($query);
		if (mysql_errno() != 0)
		{
			self::$instance->debug[] = mysql_error();
		    self::$instance->debug[] = $query;
        }
		if (@mysql_num_rows($result) > 0)
		{
			$ret = array();
			while ($r = mysql_fetch_assoc($result))
				$ret[] = $r;
		}
		@mysql_free_result($result);
		return $ret;
	}

	public static function query_value($query)
	{
        if (!self::$instance) self::$instance = new db();
		$result = mysql_query($query);
		if (mysql_errno() != 0)
		{
			self::$instance->debug[] = mysql_error();
		    self::$instance->debug[] = $query;
        }
		if($row = @mysql_fetch_array($result))
			return $row[0];
		else
			return '';
	}

	public static function query_row($query)
	{
        if (!self::$instance) self::$instance = new db();
		$ret = null;
		$result = mysql_query($query);
		if (mysql_errno() != 0)
		{
			self::$instance->debug[] = mysql_error();
		    self::$instance->debug[] = $query;
        }
		if ($row = @mysql_fetch_assoc($result))
		{
            $ret = $row;
            mysql_free_result($result);
        }
		return $ret;
	}

	public static function insert_id()
	{
        if (!self::$instance) self::$instance = new db();
		return mysql_insert_id();
	}

    public static function affected_rows()
	{
        if (!self::$instance) self::$instance = new db();
        return mysql_affected_rows();
    }

	public static function clean_sql($str)
	{
        if (!self::$instance) self::$instance = new db();
		$str = trim($str);
		if (get_magic_quotes_gpc())
			$str = stripslashes($str);
		$str = mysql_real_escape_string($str);
		return $str;
	}

    public static function get_debug()
	{
        if (!self::$instance) self::$instance = new db();
		if (!empty(self::$instance->debug))
		{
			//echo '<pre>';
			return var_dump(self::$instance->debug);
			//echo '</pre>';
		}
		else
			return 'No SQL errors!';
    }
}