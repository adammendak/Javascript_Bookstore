<?php

class Book implements JsonSerializable
{
    private $id;
    private $title;
    private $author;
    private $description;

    public function __construct()
    {
        $this->id = -1;
        $this->title = '';
        $this->author = '';
        $this->description = '';
    }

    //id niepodane zwroci all books a podane zwroci pojedyncza ksiazke 
    public static function loadFromDB(mysqli $conn, $id = null)
    {
        if (is_null($id)) {
            //pobieramy all books
            $result = $conn->query("SELECT * FROM books");
        } else {
            //pobieramy pojedyncza ksiazke
            $result = $conn->query("SELECT * FROM books WHERE id= '" . intval($id) . "'");
        }

        $booklist = [];

        if ($result && $result->num_rows > 0) {
            foreach ($result as $row) {
                $dbBook = new Book();
                $dbBook->id = $row['id'];
                $dbBook->title = $row['title'];
                $dbBook->author = $row['author'];
                $dbBook->description = $row['description'];

                $booklist [] = json_encode($dbBook);
            }
        }
        return $booklist;
    }

    public function addBookToDB(mysqli $conn)
    {
        if ($this->$id != -1) {
            $query = "INSERT INTO `books` ('id', 'title', 'author', 'description') VALUES('$this->id','$this->title','$this->author','$this->description')";
            if ($conn->query($query)) {
                $this->id = $conn->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function updateBook(mysqli $conn)
    {
        if ($this->$id != -1) {
            $query = "UPDATE books SET title = '$this->title', author='$this->author', description='$this->description' WHERE id= $this->id";
            if ($conn->query($query)) {

                $this->id = $conn->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function deleteBook(mysqli $conn)
    {
        if($this-> $id != -1){
            $query = "DELETE From books WHERE id ='" . $this->$id . "'";
            $conn->query($query);
            return true;
        }
        return false;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description
        ];
    }


    function getId()
    {
        return $this->id;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getAuthor()
    {
        return $this->author;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    function setAuthor($author)
    {
        $this->author = $author;
    }

    function setDescription($description)
    {
        $this->description = $description;
    }


}


?>