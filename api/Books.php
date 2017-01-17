<?php

$dir = dirname(__FILE__);
include($dir . '/src/Db.php');
include($dir . '/src/Book.php');

$conn = DB::connect();
header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case('GET'):
        if (isset($_GET['id']) && intval($_GET['id']) > 0) {
            //sprawdzamy czy przeslane jest pojedynczej ksiazki
            $books = Book:: loadFromDB($conn, $_GET['id']);
        } else {
            //pobieramy wszystkie ksiazki
            $books = Book:: loadFromDB($conn);
        }
        echo json_encode($books);
        break;

    case('POST'):
        if(!isset($_POST['_method'])) {
            if (isset($_POST['title']) && strlen($_POST['title']) > 0 &&
                isset($_POST['author']) && strlen($_POST['author']) > 0 &&
                isset($_POST['description']) && strlen($_POST['description']) > 0
            ) {
                $book = new Book();
                $book->setAuthor($_POST['author']);
                $book->setTitle($_POST['title']);
                $book->setDescription($_POST['description']);
                $book->addBookToDB($conn);
                json_encode($book);
            }
        } elseif($_POST['_method'] == 'DELETE') {
            $book = Book::loadBookById($conn, $_POST['id']);
            if ($book->deleteBook($conn)) {
                $result = "ksiazka skasowana";
            } else {
                $result = "nieudana proba kasowania";
            };

            echo json_encode($result);
        }
        break;

    case('PUT'):
        parse_str(file_get_contents('php://input'), $put_vars);

        if (isset($put_vars['id']) &&
            (isset($put_vars['updateAuthor']) && strlen($put_vars['updateAuthor']) > 0) ||
            (isset($put_vars['updateDescription']) && strlen($put_vars['updateDescription']) > 0) ||
            (isset($put_vars['updateTitle']) && strlen($put_vars['updateTitle']) > 0)
        ) {
            $id = $put_vars['id'];
            $updateAuthor = $put_vars['updateAuthor'];
            $updateDescription = $put_vars['updateDescription'];
            $updateTitle = $put_vars['updateTitle'];


            $book = Book::loadBookById($conn, $id);
            $book->setAuthor($updateAuthor);
            $book->setDescription($updateDescription);
            $book->setTitle($updateTitle);
            $book->updateBook($conn);
            echo json_encode($book);
        }
        break;

    case('DELETE'):
        parse_str(file_get_contents('php://input'), $put_vars);
        $id = $put_vars['id'];
        $book = Book::loadBookById($conn, $id);
        if ($book->deleteBook($conn)) {
            $result = "ksiazka skasowana";
        } else {
            $result = "nieudana proba kasowania";
        };

        echo json_encode($result);
        break;

}
?>
