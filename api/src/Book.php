<?php

//klasa reprezentujaca pojedyncza ksiazke
class Book implements JsonSerializable{
    private $id;
    private $title;
    private $author;
    private $description;
    
    public function __construct() {
        $this->id = -1;
        $this->title = '';
        $this->author = '';
        $this->description = '';       
    }
    //id niepodane zwroci all books a podane zwroci pojedyncza ksiazke 
    public static function loadFromDB(mysqli $conn, $id = null){
        if(is_null($id)){
            //pobieramy all books
            $result = $conn->query('SELECT * FROM Books');
        }else{
            //pobieramy pojedyncza ksiazke
            $result = $conn ->query("SELECT * FROM Books WHERE id= '" .intval($id). "'");
        }
        
        $booklist = [];
        
        if($result && $result->num_rows>0){ //sprawdzamy czy db coś zwróciło
            foreach($result as $row){
                $dbBook = new Book();
                $dbBook-> id=$row['id'];
                $dbBook-> title=$row['title'];
                $dbBook-> author=$row['author'];
                $dbBook-> description = $row['description'];
                
                $bookList = json_encode($dbBook); // bez interferjsu tak NIE ZADZIAŁA
            }
        }
        return $bookList;
    }
    
    public function jsonSerialize() {
        //funkcja zwraca nam dane z obiektu do json_encode
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description
        ];
    }
    
    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getAuthor() {
        return $this->author;
    }

    function getDescription() {
        return $this->description;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setDescription($description) {
        $this->description = $description;
    }


    
    
}







    
?>