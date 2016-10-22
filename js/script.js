$(function(){
   //pobieramy WSYSTKIE ksiazki
   $.ajax({
       url:'api/books.php',
       type:'GET',
       dataType:'json',
       success: function(result){
           //w result jest lista ksiazek
           for(var i=0; i<result.length;i++){
               //obiekt js z pojedyncza ksiazka
               var book = JSON.parse(result[i]);
               var bookDiv = $('<div>');
               bookDiv.addClass('singleBook');
               bookDiv.html('<h3 data-id="' + book.id + '">' +book.title + '</h3><div class="description"></div>');
               //wpinamy ksiazke na strone
               $('#bookList').append(bookDiv)
           }
       },
       error: function(){
           console.log('wystapil blad');
       }
   })
    
    
    
});