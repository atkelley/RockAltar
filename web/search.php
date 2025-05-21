<?php 
  include "includes/config/db.php"; 
  include "includes/layout/header.php";
  include "includes/layout/navigation-special.php";
?>
    
<div class="container">
  <div class="row">            
    <div class="col-md-8">
      <?php
        $per_page = 5;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $offset = ($page == 1) ? 0 : ($page * $per_page) - $per_page;

        if(isset($_POST['submit']) || isset($_GET['search'])){
          $search_term = (isset($_POST['submit'])) ? $_POST['search'] : $_GET['search'];
          $search      = trim($search_term);
          $search      = str_replace(' ', '', $search);
          $search      = stripslashes($search);
          $search      = htmlspecialchars($search);

          $query = "SELECT 
                    articles.id, articles.title, articles.date, articles.image, 
                    articles.description, articles.user, users.firstname, users.lastname,
                    categories.name AS category, genres.name AS genre
                    FROM articles
                    INNER JOIN users ON articles.user = users.id
                    INNER JOIN genres ON articles.genre = genres.id
                    INNER JOIN categories ON articles.category = categories.id
                    WHERE genres.name 
                    LIKE '%$search%' 
                    OR categories.name
                    LIKE '%$search%'
                    OR users.firstname
                    LIKE '%$search%'
                    OR users.lastname
                    LIKE '%$search%'
                    OR users.username
                    LIKE '%$search%' 
                    OR articles.name
                    LIKE '%$search%' 
                    OR articles.title
                    LIKE '%$search%' 
                    OR articles.description
                    LIKE '%$search%' ";
          $search_query = mysqli_query($connection, $query);
          $results = mysqli_num_rows($search_query);
          $count  = ceil($results / $per_page); 
  
          if($results < 1) {
            echo '<h1 class="text-center search-title"><strong>No articles for "'. $search_term. '" found</strong></h1>';
          } else {
            if ($results == 1) {
              echo '<h1 class="text-center search-title"><strong>'. $results . ' article for "'. $search_term . '" found</strong></h1>';
            } else {
              echo '<h1 class="text-center search-title"><strong>'. $results . ' articles for "'. $search_term . '" found</strong></h1>';
            }
            
            $search_query->data_seek($offset);
  
            for ($i = $offset; $i < $offset + 5; $i++) {
              $row = mysqli_fetch_assoc($search_query);
  
              if (!empty($row)) {
                $id = $row['id'];
                $title = $row['title'];
                $author = $row['firstname'] . " " . $row['lastname'];
                $user = $row['user'];
                $date = date_create($row['date']);
                $date = date_format($date, "l, F dS, Y");
                $image = $row['image'];
                $genre = $row['genre'];
                $category = $row['category'];
                $description = (strlen($row['description']) > 200) ? substr($row['description'], 0, strpos($row['description'], ' ', 200)) . "..." : $row['description'];
      ?>
                <div class="row news-section">
                  <div class="col-md-6 news-section-left">
                    <a href="article.php?id=<?php echo $id; ?>">
                      <img class="img-responsive news-image" src="<?php echo $image; ?>" alt="">
                    </a>  
                    <a href="category.php?category=<?php echo strtolower($category); ?>">
                      <span class="badge badge-pill badge-category"><?php echo $category; ?></span>
                    </a>  
                    <a href="genre.php?genre=<?php echo strtolower($genre); ?>">
                      <span class="badge badge-pill badge-genre"><?php echo $genre; ?></span>
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
        <?php } } } ?>
        <ul class="pager">
          <?php 
            for ($i = 1; $i <= $count; $i++) {
              $link = "<li class='article-link'><a";
  
              if ($i == $page) {
                $link .= " class='active-link'>{$i}</a></li>";
              } else {
                if ($i == 1) {
                  $link .= " href='search.php?search={$search_term}'>{$i}</a></li>";
                } else {
                  $link .= " href='search.php?page={$i}&search={$search_term}'>{$i}</a></li>";
                }
              }
              
              echo $link;
            }
          ?>
        </ul>
  <?php } else {
          header("Location: index.php");
        }
  ?>
    </div>
      
    <?php include "includes/sidebar.php"; ?>
  </div>

  <?php include "includes/footer.php"; ?>