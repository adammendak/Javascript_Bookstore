<?php
class DB
{
    static private $conn = null;

    static public function connect()
    {
        if (!is_null(self::$conn)) {
            //polacznie istnieje
            return self::$conn;
        } else {
            self::$conn = new mysqli('xxxxx', 'xxxx', 'xxxxxx', 'xxxxxx');
            self::$conn->set_charset('utf8');
            if (self::$conn->connect_error) {
                die('Connection error: ' . self::$conn->connect_errno);
            }
            return self::$conn;
        }
    }

    static public function disconnect()
    {
        self::$conn->close();
        self::$conn = null;

        return true;
    }
}

?>
