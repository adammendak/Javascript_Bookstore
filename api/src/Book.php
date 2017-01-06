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

    public static function loadFromDB(mysqli $conn, $id = null)
    {
        if (is_null($id)) {
            $result = $conn->query("SELECT * FROM books");
        } else {
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

    static public function loadBookById(mysqli $connection, $id){
        $query = "SELECT * FROM books WHERE id = ". $connection ->real_escape_string($id);
        $res = $connection -> query($query);
        if($res && $res -> num_rows == 1){
            $row = $res -> fetch_assoc();
            $book = new Book();
            $book->id = $row['id'];
            $book->setTitle($row['title']);
            $book->setAuthor($row['author']);
            $book->setDescription($row['description']);

            return $book;
        }else{
            return null;
        }

    }
    public function addBookToDB(mysqli $conn)
    {
        if ($this->id == -1) {
            $query = "INSERT INTO `books` (title, author, description) VALUES ('$this->title','$this->author','$this->description')";
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
        if ($this->id != -1) {
            $query = "UPDATE books SET title='$this->title', author='$this->author', description='$this->description' WHERE id='$this->id'";
            if ($conn->query($query)) {
//                $this->id = $conn->insert_id;
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function deleteBook(mysqli $conn)
    {
        if($this->id != -1){
            $query = "DELETE From books WHERE id ='" . $this->id . "'";
            if($conn->query($query)) {
                return  true;
            } else {
                return false;
            }
        }
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