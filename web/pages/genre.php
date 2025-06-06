<div class="genre">
  <?php
    if(isset($_GET['genre'])){
      $per_page = 5;
      $p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
      $offset = ($p == 1) ? 0 : ($p * $per_page) - $per_page;
      $published_articles_by_genre = get_published_articles_by_genre($_GET['genre']);
      $total_rows = mysqli_num_rows($published_articles_by_genre);
      $total_pages  = ceil($total_rows / $per_page); 

      echo "<h1 class='text-center genre-title'>Genre: " . $_GET['genre'] . "</h1>";
      
      if($total_rows < 1) {
        echo "<h3 class='text-center'>No articles found.</h3>";
      } else {
        $articles = [];

        while ($row = mysqli_fetch_assoc($published_articles_by_genre)) {
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
    <?php render_pagination($total_pages, $p, 'index.php', ['page' => 'genre', 'genre' => $_GET['genre']]); ?>
  </ul>
</div>