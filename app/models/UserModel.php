<?php

//TODO: ���-�� ����� �� ���, �� � ������ ������ ������������ �������� � ������������ ������� �� ����
require_once(APP_DIR . 'components/' . DATABASE_CLASS . '.php');

/**
 * Class UserModel
 *
 * ������ �� ������������.
 */
class UserModel
{
    /**
     * ���������� � ������������.
     * @var
     */
    public $userInfo;

    /**
     * �������� ������� � ��.
     * @var string
     */
    protected static $tableName = 'users';

    /**
     * �����������.
     *
     * @param int $id ������������� ������������
     */
    public function __construct($id = null)
    {
        if ($id)
        {
            $className = DATABASE_CLASS;
            $db = new $className;
            $this->userInfo = $db->selectQuery('SELECT * FROM ' . self::$tableName . ' WHERE id=%s', $id);
        }
    }

    public static function GetAllUsers()
    {
        $className = DATABASE_CLASS;
        $db = new $className;
        // SELECT users.*, cities.name as city_name FROM users LEFT JOIN cities ON cities.id = users.city_id;
        $usersTb = self::$tableName;
        $citiesTb = City::$tableName;
        $query = "SELECT $usersTb.*, $citiesTb.name as city_name FROM $usersTb "
            . "LEFT JOIN $citiesTb ON $citiesTb.id = $usersTb.city_id";
        $res = $db->selectQuery($query);
        return $res;
    }

    public static function updateUser($id, $name, $value)
    {
        $name = str_replace('`', '', $name);
        $className = DATABASE_CLASS;
        $db = new $className;
        $res = $db->query('UPDATE ' . self::$tableName . " SET `$name`=%s WHERE id=%s", $value, $id);
        return $res;
    }

    public static function createUser($name, $age, $city)
    {
        $className = DATABASE_CLASS;
        $db = new $className;
        $res = $db->query('INSERT INTO ' . self::$tableName . ' SET name=%s, age=%s, city_id=%s', $name, $age, $city);
        return $res;
    }

    /**
     * �������� ������ ������������.
     *
     * @param array $info ������ ����� ������������.
     * @return array ������ ������. ������ ���� ��� ������.
     */
    public static function verifyUserInfo($info)
    {
        $errorList = [];

        if (isset($info['name']))
        {
            $nameLenght = mb_strlen($info['name'], DOCUMENT_ENCODING);
            if ($nameLenght < 1)
            {
                $errorList[] = '������ ��� ������������';
            }
            elseif ($nameLenght > 30)
            {
                $errorList[] = '��� ������������ ������ 30 ��������';
            }
        }

        if (isset($info['age']))
        {
            if (strlen($info['age']) < 1)
            {
                $errorList[] = '���� �������� ������';
            }
            else
            {
                $age = (int)$info['age'];
                if ($age < 0)
                {
                    $errorList[] = '������� �� ����� ���� �������������';
                }
                elseif ($age > 255)
                {
                    $errorList[] = '���� ��� ����� �� �����. ���� �� �������� - ���������� � ��������������';
                }
            }
        }

        return $errorList;
    }

}
