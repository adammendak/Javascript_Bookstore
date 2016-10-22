<?php

class DB{
    static private $conn = null; //własność przechowywująca połączenie 
    
    static public function connect(){
        if(!is_null(self::$conn)){
            //polacznie istnieje
            return self::$conn;
        }else{
            self::$conn= new mysqli('localhost', 'root', 'coderslab', 'Bookstore');
            //ustawiamy kodowanie połączenia na unicode
            self::$conn->set_charset('utf8');
            if(self::$conn->connect_error){
                die('Connection error: '. self::$conn->connect_errno);
            }
            //zwracamy połaczenie 
            return self::$conn;
        }
    }
    
    static public function disconnect(){
        self::$conn->close();
        self::$conn = null;
        
        return true;
    }
}