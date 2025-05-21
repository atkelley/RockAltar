const isAdminPage = window.location.pathname.includes('/admin');

if (!isAdminPage) {
  $(document).ready(() => {
    const $title = $('.jumbo-title');
    const $titleLatin = $('.jumbo-title-latin');
    const $message = $('.jumbo-message');
    const $messageLatin = $('.jumbo-message-latin');

    let showingLatin = false;

    const toggleFade = () => {
      if (showingLatin) {
        $title.css('opacity', 1);
        $titleLatin.css('opacity', 0);
        $message.css('opacity', 0);
        $messageLatin.css('opacity', 1);
      } else {
        $title.css('opacity', 0);
        $titleLatin.css('opacity', 1);
        $message.css('opacity', 1);
        $messageLatin.css('opacity', 0);
      }

      showingLatin = !showingLatin;
      setTimeout(toggleFade, 7500);
    };

    setTimeout(toggleFade, 2500);
  });
} else {
  const chartBox = document.querySelector('.chart-box');
  if (chartBox) {
    $(window).resize(() => drawChart());
  }

  $(document).ready(() => {
    $('#select_all_boxes').click((event) => {
      if(this.checked) {
        $('.checkBoxes').each(() => this.checked = true);
      } else {
        $('.checkBoxes').each(() => this.checked = false);
      }
    });

    $(".delete_link").on('click', function() {
      let type = $(this).attr("data-type");
      let comments = $(this).attr("data-comments");
      let message = "Delete this " + type;

      if (parseInt(comments)) {
        message += " and its " + comments;
        message += (comments == 1) ? " comment" : " comments";
      } 

      $(".modal_delete_link").attr("href", "index.php?page=articles&delete=" + $(this).attr("rel"));
      $("#delete_modal .modal-body h3").text(message + "?");
      $("#delete_modal").modal('show');
    });
    
    $(".edit_link").on('click', function() {
      $("#edit_modal .modal-body #hidden").attr("value", $(this).attr("rel"));
      $("#edit_modal .modal-body #input").attr("value", $(this).attr("data-entity"));
      $("#edit_modal").modal('show');
    });

    $(".reset_link").on('click', function() {
      $(".modal_reset_link").attr("href", "index.php?page=articles&reset=" + $(this).attr("rel"));
      $("#reset_modal .modal-body h3").text("Zero the views on this article?");
      $("#reset_modal").modal('show');
    });
  });
}