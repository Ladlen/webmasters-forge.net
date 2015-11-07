<?php

#require_once(dirname(__FILE__) . '/DatabaseComponent.php');

class MySqliDatabaseComponent implements DatabaseComponent
{
    protected static $mySqlLink;

    public function __construct()
    {
        $this->mysqliPrepare();
    }

    protected function mysqliPrepare()
    {
        if (is_null(self::$mySqlLink))
        {
            self::$mySqlLink = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
            if (mysqli_connect_errno())
            {
                throw new Exception('�� ����������� ���������� � ����� ������ : ' . mysqli_error(self::$mySqlLink));
            }
            $dbSelected = mysqli_select_db(self::$mySqlLink, MYSQL_DB);
            if (!$dbSelected)
            {
                throw new Exception('�� ���� ������� ���� ������ : ' . mysqli_error(self::$mySqlLink));
            }
            mysqli_set_charset(self::$mySqlLink, DOCUMENT_ENCODING);
        }
    }

    protected function replaceAndClean($sql)
    {
        $args = func_get_args();
        if (count($args) == 1)
        {
            return $args[0];
        }
        $query = array_shift($args);
        return vsprintf($query, array_map(array($this, 'escapeString'), $args));
    }

    /**
     * ������ �������.
     *
     * @param string $sql ������ SQL
     * @return stdClass ������, � ��������� rows ����� ��������� ������ �������� � �����������
     * @throws Exception
     */
    public function selectQuery($sql)
    {
        $ret = new stdClass();

        $query = call_user_func_array(array($this, 'replaceAndClean'), func_get_args());
        if (!$result = mysqli_query(self::$mySqlLink, $query))
        {
            throw new Exception('������ mysql : ' . mysqli_error(self::$mySqlLink));
        }

        $allRows = array();
        while ($row = mysqli_fetch_object($result))
        {
            $allRows[] = $row;
        }
        $ret->rows = $allRows;

        mysqli_free_result($result);

        return $ret;
    }

    /**
     * ������ SQL.
     *
     * @param string $sql ������ SQL
     * @return mixed ���������� ��������
     * @throws Exception
     */
    public function query($sql)
    {
        $query = call_user_func_array(array($this, 'replaceAndClean'), func_get_args());
        $ret = mysqli_query(self::$mySqlLink, $query);

        if (mysqli_errno(self::$mySqlLink))
        {
            $ret = false;
        }

        return $ret;
    }

    public function escapeString($string, $quotes = true)
    {
        $ret = mysqli_real_escape_string(self::$mySqlLink, $string);
        $ret = $quotes ? "'$ret'" : $ret;
        return $ret;
    }

}
