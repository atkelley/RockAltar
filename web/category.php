<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>
    
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <?php
        if(isset($_GET['category'])){
          $per_page = 5;
          $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
          $offset = ($page == 1) ? 0 : ($page * $per_page) - $per_page;
          $categories = array("news" => "1", "interviews" => "2", "reviews" => "3", "videos" => "4", "podcasts" => "5");
  
          $query = "SELECT articles.id, articles.title, articles.date, articles.image, articles.content,
                    articles.description, articles.user, users.firstname, users.lastname 
                    FROM articles 
                    INNER JOIN users ON articles.user = users.id
                    WHERE articles.status = 'published'
                    AND articles.category = ". $categories[$_GET['category']];
  
          $select_published_articles_query = mysqli_query($connection, $query);
          $count = mysqli_num_rows($select_published_articles_query);
          $count  = ceil($count / $per_page); 

          if($count < 1) {
            echo "<h1 class='text-center'>No " . $_GET['category'] . " found.</h1>";
          } else {
            $select_published_articles_query->data_seek($offset);
      
            for ($i = $offset; $i < $offset + 5; $i++) {
              $row = mysqli_fetch_assoc($select_published_articles_query);

              if (!empty($row)) {
                $id = $row['id'];
                $title = $row['title'];
                $author = $row['firstname'] . " " . $row['lastname'];
                $user = $row['user'];
                $date = date_create($row['date']);
                $date = date_format($date, "l, F dS, Y");
                $image = $row['image'];
                $description = (strlen($row['description']) > 200) ? substr($row['description'], 0, strpos($row['description'], ' ', 200)) . "..." : $row['description'];
              ?>
                <div class="row news-section">
                  <div class="col-md-6 news-section-left">
                    <a href="article.php?id=<?php echo $id; ?>">
                      <img class="img-responsive news-image" src="<?php echo $image;?>" alt="">
                    </a>  
                  </div>
                  <div class="col-md-6 news-section-right">
                    <div class="row news-title">
                      <a href="article.php?id=<?php echo $id; ?>"><?php echo $title ?></a>
                    </div>
                    <div class="row news-author-date">
                      by <a href="author.php?user=<?php echo $user ?>"><?php echo $author ?></a>
                      <span class="glyphicon glyphicon-time"></span> on <?php echo $date ?>
                    </div>
                    <div class="row news-description">
                      <a href="article.php?id=<?php echo $id; ?>"><?php echo $description ?></a><br>
                    </div>
                  </div>
                </div>
                <hr><?php 
              } 
            } 
          } 
        } else {
          $count = 0;
          echo "<h1 class='text-center'>No articles found.</h1>";
        } 
      ?>

      <ul class="pager">
        <?php 
          for ($i = 1; $i <= $count; $i++) {
            $link = "<li class='article-link'><a";

            if ($i == $page) {
              $link .= " class='active-link'>{$i}</a></li>";
            } else {
              if ($i == 1) {
                $link .= " href='category.php?category={$_GET['category']}'>{$i}</a></li>";
              } else {
                $link .= " href='category.php?category={$_GET['category']}&page={$i}'>{$i}</a></li>";
              }
            }
            
            echo $link;
          }
        ?>
      </ul>
    </div>
      
    <?php include "includes/sidebar.php"; ?>
  </div>

  <?php include "includes/footer.php"; ?>
