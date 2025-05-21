<?php
  function render_comment_card($comment) {
    $comment_date = date("D, F jS, Y", strtotime($comment['date']));
    $comment_time = date('g:i A', strtotime($comment['date']));
    $comment_content= $comment['content'];
    $comment_author = $comment['author'];
    ob_start();
?>

  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="https://www.gravatar.com/avatar/<?php echo hash('md4', $row['email']); ?>?s=32&d=identicon&r=PG" alt="gravatar">
    </a>
    <div class="media-body">
      <h4 class="media-heading"><?php echo $comment_author; ?>
        <small><?php echo $comment_date; ?> at <?php echo $comment_time; ?></small>
      </h4>
      <?php echo $comment_content; ?>
    </div>
  </div>

  <?php return ob_get_clean();
}