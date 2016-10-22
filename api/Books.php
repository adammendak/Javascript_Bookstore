<?php

// plik do ktorego bedzie laczyl sie js

$dir = dirname(__FILE__); //zwraca aktualny katalog
//includujemy pliki polaczenia z baza i klase book
include($dir . '/src/Db.php');
include($dir . '/src/Book.php');

//laczymy sie z bza
$conn = DB::connect();
//plik zawsze zwraca JSONa
header('Content-Type: application/json');
//sprawdzamy w jaki sposob sie polaczyl JS (typ get post )

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //zgodnie z REST GET zwraca dane
    if (isset($_GET['id']) && intval($_GET['id']) > 0) {
        //sprawdzamy czy przeslane jest pojedynczej ksiazki
        $books = Book :: loadFromDB($conn, $_GET['id']);
        //zwraca tablice jednoelementowa
    } else {
        //pobieramy wszystkie ksiazki
        $books = Book :: loadFromDB($conn);
    }

    echo json_encode($books);
} elseif ($_SERVER['REQUEST_METHOD'] == 'METHOD') {
    //zgodnie z REST POST dodaje dane itd.
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //pobieramy przeslane dane 
    parse_str(file_get_contents('php://input'), $put_vars);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
}
?>
