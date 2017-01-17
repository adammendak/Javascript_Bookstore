$(function () {

    function loadAllBooks() {
        $.ajax({
            url: 'api/Books.php',
            type: 'GET',
            dataType: 'json',
            success: function (result) {
                //w result jest lista ksiazek
                for (var i = 0; i < result.length; i++) {
                    //obiekt js z pojedyncza ksiazka
                    var book = JSON.parse(result[i]);
                    var bookDiv = $('<div>');
                    bookDiv.addClass('singleBook');
                    bookDiv.html('<h3 data-id="' + book.id + '">' + book.title + '</h3><img src="http://localhost/Bookstore/img/bookIcon.png"><div class="description"></div></div>');
                    $('#bookList').append(bookDiv)
                }
            },
            error: function () {
                console.log('wystapil blad');
            }
        });
    }

    function reload() {
        $('#bookList').html('');
        loadAllBooks();
    }

    $('#showBooks').on('click', function (event) {
        $('#bookList').html('');
        event.preventDefault();
        loadAllBooks();

    })


    $('#addBook').on('click', function (event) {
        event.preventDefault();
        var addTitle = $('#titleInput').val();
        var addAuthor = $('#authorInput').val();
        var addDesc = $('#descriptionInput').val();
        var AjaxToSend = {};
        AjaxToSend.title = addTitle;
        AjaxToSend.author = addAuthor;
        AjaxToSend.description = addDesc;
        $.ajax({
            url: 'api/Books.php',
            type: 'POST',
            data: AjaxToSend,
            dataType: 'json',
            success: function () {
                alert('ksiazka Dodana');
                reload();

            },
            error: function () {
                console.log('blad dodawania ksiazki');
            },
            complete: function () {
            }

        });
    });


    $('#bookList').on('click', '.singleBook', function showForm() {
        event.preventDefault();
        var book = {};
        book.id = $(this).find('h3').data('id');
        var bookInfo = $(this).find('.description');
        $.ajax({
            url: 'api/Books.php',
            type: 'GET',
            data: {id: book.id},
            dataType: 'json',
            success: function (result) {
                var resultParase = JSON.parse(result);
                var Form = 'Autor: ' + resultParase.author + '<br>'
                    + 'Opis: ' + resultParase.description + '<br><br>'
                    + '<div id = "updateForm"><form>'
                    + '<label>Zmien Tytul: <input id="updateTitle" type="text" name="updateTitle" placeholder="' + resultParase.title + '"></label><br>'
                    + '<label>Zmien Autora:<input id ="updateAuthor" type="text" name="updateAuthor" placeholder="' + resultParase.author + '"></label><br>'
                    + '<labe> Zmien Opis: <input id="updateDescription" type="text" name="updateDescription" placeholder="' + resultParase.description + '"></label><br>'
                    + '<label><input id="updateSubmit" type="submit" name="updateSubmit" value="zmień wartości"></label>'
                    + '<label><input id="deleteBook" type="submit" value="delete"></label>'
                    + '</form></div>';
                bookInfo.html(Form);
            },
            error: function (err) {
                console.log('blad');
                console.log(err);
            },
            complete: function () {
            }

        });
    });

    $('#bookList').on('click', '#updateForm', function (event) {
        event.stopPropagation();
      });

    $('#bookList').on('click', '#updateSubmit', function (event) {
        event.stopPropagation();
        event.preventDefault();
        var book = {};
        book.id = $(this).parent().parent().parent().parent().parent().parent().find('h3').data('id');
        book.updateAuthor = $('#updateAuthor').val();
        book.updateTitle = $('#updateTitle').val();
        book.updateDescription = $('#updateDescription').val();
        $.ajax({
            url: 'api/Books.php',
            type: 'PUT',
            data: {
                id: book.id,
                updateAuthor: book.updateAuthor,
                updateTitle: book.updateTitle,
                updateDescription: book.updateDescription
            },
            dataType: 'json',
            success: function (result) {
                var Label = $("h3[data-id='" + result.id + "']");
                Label.html(result.title);
                var changeName = 'Autor: ' + result.author + '<br>'
                    + 'Opis: ' + result.description + '<br>';
                $(Label).parent().find('.description').html(changeName);
            },
            error: function (err) {
                console.log('blad ');
                console.log(err);
            },
            complete: function () {
            }
        });
    });
    $('#bookList').on('click', '#deleteBook', function (event) {
        event.stopPropagation();
        event.preventDefault();


        var BookToDel = $(this).parent().parent().parent().parent().parent().parent().find('h3').data('id');
        $.ajax({
            url: 'api/Books.php',
            // type: 'DELETE',
            type: 'POST',
            data: {id: BookToDel, _method: 'DELETE' },
            dataType: 'json',
            success: function (result) {
                alert(result);
                reload();
            },
            error: function (err) {
                console.log('blad ');

            },
            complete: function () {
            }
        });
    });
})
    
    
