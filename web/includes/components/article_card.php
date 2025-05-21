 <?php 
  function render_article_card($article) {
    $id = $article['id'];
    $title = $article['title'];
    $author = $article['firstname'] . " " . $article['lastname'];
    $user = $article['user'];
    $date = date_create($article['date']);
    $date = date_format($date, "l, F jS, Y");
    $image = $article['image'];
    $genre = $article['genre'];
    $category = $article['category'];
    $description = (strlen($article['description']) > 200) ? substr($article['description'], 0, strpos($article['description'], ' ', 200)) . "..." : $article['description'];
    ob_start();
?>

  <div class="row article-card">
    <div class="col-md-6 article-card-left">
      <a href="index.php?page=article&id=<?php echo $id; ?>">
        <img class="img-responsive article-card-image" src="<?php echo $image; ?>" alt="">
      </a>  
    </div>
    <div class="col-md-6 article-card-right">
      <div class="row article-card-title">
        <a href="index.php?page=article&id=<?php echo $id; ?>"><?php echo $title ?></a>
      </div>
      <div class="row article-card-date-box">
        by <a href="index.php?page=author&user=<?php echo $user; ?>"><?php echo $author ?></a>
        <span class="glyphicon glyphicon-time"></span> on <?php echo $date ?>
      </div>
      <div class="row article-card-badge-box">
        <a href="index.php?page=category&category=<?php echo strtolower($category); ?>">
          <span class="badge badge-pill badge-category"><?php echo $category; ?></span>
        </a>  
        <a href="index.php?page=genre&genre=<?php echo strtolower($genre); ?>">
          <span class="badge badge-pill badge-genre"><?php echo $genre; ?></span>
        </a>  
      </div>
      <div class="row article-card-description">
        <a href="index.php?page=article&id=<?php echo $id; ?>"><?php echo $description ?></a><br>
      </div>
    </div>
  </div>
 
  <?php return ob_get_clean();
}