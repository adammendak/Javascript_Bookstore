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
        if (isset($_POST['title']) && strlen($_POST['title']) > 0 &&
            isset($_POST['author']) && strlen($_POST['author']) > 0 &&
            isset($_POST['description']) && strlen($_POST['description']) > 0) {

            $book = new Book;
            $book->setAuthor($_POST['author']);
            $book->setTitle($_POST['title']);
            $book->setDescription($_POST['description']);
            $book->addBookToDB($conn);
            echo json_encode($book);
        }
        break;

    case('PUT'):
        parse_str(file_get_contents('php://input'), $put_vars);
        if  (isset($put_vars['id']) &&
            (isset($put_vars['newAuthor']) && strlen($put_vars['newAuthor']) > 0) ||
            (isset($put_vars['newDescription']) && strlen($put_vars['newDescription']) > 0) ||
            (isset($put_vars['newTitle']) && strlen($put_vars['newTitle']) > 0)) {
            $id = $put_vars['id'];
            $newAuthor = $put_vars['newAuthor'];
            $newDescription = $put_vars['newDescription'];
            $newtitle = $put_vars['newTitle'];

            $book->setAuthor($newAuthor);
            $book->setDescription($newDescription);
            $book->setTitle($newtitle);
            $book->updateBook($conn);
        }
        break;

    case('DELETE'):
        parse_str(file_get_contents('php://input'), $put_vars);
        Book::deleteBook($conn);
        $result = ['DeleteResult' => 'Ksiazka skasowana'];
        echo json_encode($result);
        break;

}
?>
