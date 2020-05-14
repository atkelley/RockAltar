$('document').ready(function(){
  fadeThem();
});

function fadeThem() {
  $(".jumbo-message-latin").fadeOut(5000, function() {
    $(this).fadeIn(5000, fadeThem());

    $(".jumbo-message").fadeIn(5000, function() {
      $(this).fadeOut(5000, fadeThem());
    });
  });

  $(".jumbo-title").fadeOut(5000, function() {
    $(this).fadeIn(5000, fadeThem());

    $(".jumbo-title-latin").fadeIn(5000, function() {
      $(this).fadeOut(5000, fadeThem());
    });
  });
}