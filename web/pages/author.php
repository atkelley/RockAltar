<div class="author">
  <?php
    if(isset($_GET['user'])){
      $per_page = 5;
      $p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
      $offset = ($p == 1) ? 0 : ($p * $per_page) - $per_page;
      $published_articles_by_author = get_published_articles_by_author($_GET['user']);
      $total_rows = mysqli_num_rows($published_articles_by_author);
      $total_pages  = ceil($total_rows / $per_page); 
      $author = get_user_profile($_GET['user']);

      echo "<h1 class='text-center author-title'>" . $author['firstname'] . " " . $author['lastname'] . "'s articles" . 
      "<img src=" . $author['image'] . " class='author-image'>" . "</h1>";

      if($total_rows < 1) {
        echo "<h3 class='text-center'>No articles found.</h3>";
      } else {
        $articles = [];

        while ($row = mysqli_fetch_assoc($published_articles_by_author)) {
          $articles[] = $row;
        }

        $paginated_articles = array_slice($articles, $offset, $per_page);
        include './includes/components/article_card.php'; 
        
        foreach ($paginated_articles as $article) {
          echo render_article_card($article);
        } 
      } 
    } 
  ?>

  <ul class="pager">
    <?php render_pagination($total_pages, $p, 'index.php', ['page' => 'author', 'user' => $_GET['user']]); ?>
  </ul>
</div>
