
<?php
  $per_page = 5;
  $p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
  $offset = ($p == 1) ? 0 : ($p * $per_page) - $per_page;
  $published_articles = get_published_articles();
  $total_rows = mysqli_num_rows($published_articles);
  $total_pages  = ceil($total_rows / $per_page); 

  if($total_rows < 1) {
    echo "<h1 class='text-center'>No articles...yet.</h1>";
  } else {
    $articles = [];

    while ($row = mysqli_fetch_assoc($published_articles)) {
      $articles[] = $row;
    }

    $paginated_articles = array_slice($articles, $offset, $per_page);
    include './includes/components/article_card.php'; 

    foreach ($paginated_articles as $article) {
      echo render_article_card($article);
    }
  } 
?>

<ul class="pager">
  <?php render_pagination($total_pages, $p, 'index.php', ['page' => 'home']); ?>
</ul>
