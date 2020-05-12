<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<div class="container">
  <div class="row">     
    <div class="col-md-8">
      <?php
        $per_page = 5;
        $page = (isset($_GET['page'])) ? $_GET['page'] : "";
        $page_1 = ($page == "" || $page == 1) ? 0 : ($page * $per_page) - $per_page;

        $query = "SELECT articles.id, articles.title, articles.date, articles.image, 
                  articles.description, articles.user, users.firstname, users.lastname 
                  FROM articles 
                  INNER JOIN users ON articles.user = users.id
                  WHERE articles.category = 1 
                  AND articles.status = 'published'
                  ORDER BY date DESC LIMIT $page_1, $per_page";

        $select_published_articles_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($select_published_articles_query);
        echo $count;

        if($count < 1) {
          echo "<h1 class='text-center'>No articles found.</h1>";
        } else {
          $count  = ceil($count / $per_page); 

          while($row = mysqli_fetch_assoc($select_published_articles_query)) {
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
          <hr>
  <?php }  } ?>
      <ul class="pager">
        <?php 
          for($i = 1; $i <= $count; $i++) {
            if($i == $page) {
              echo "<li'><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
              echo "<li'><a href='index.php?page={$i}'>{$i}</a></li>";
            }
          }
        ?>
      </ul>
    </div>
      
    <?php include "includes/sidebar.php";?>
  </div>

<?php include "includes/footer.php";?>