$(function() {

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
                    bookDiv.html('<h3 data-id="' + book.id + '">' + book.title + '</h3><div class="description"></div>');
                    $('#bookList').append(bookDiv)
                }
            },
            error: function () {
                console.log('wystapil blad');
            }
        });
    }

    loadAllBooks();

    var addBook = $('#addButton');
    $('#addBook').on('click', function (event) {
        event.preventDefault();
        var addTitle = $('#titleInput').val();
        var addAuthor = $('#authorInput').val();
        var addDesc = $('#descriptionInput').val();
        var AjaxToSend = {};
        AjaxToSend.title = addTitle;
        AjaxToSend.author = addAuthor;
        AjaxToSend.description = addDesc;
        console.log(AjaxToSend);
        $.ajax({
            url: 'api/Books.php',
            type: 'POST',
            data: AjaxToSend,
            dataType: 'json',
            success: function (result) {
                console.log('ksiazka Dodana');
                loadAllBooks();
            },
            error: function () {
                console.log('blad dodawania ksiazki');
            },
            complete: function () {
                console.log('ukonczo');
            }

        });
    });

})
    
    
