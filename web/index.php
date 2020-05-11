<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<div class="container">
  <div class="row">     
    <div class="col-md-8">
      <?php
        $per_page = 10;
        $page = (isset($_GET['page'])) ? $_GET['page'] : "";
        $page_1 = ($page == "" || $page == 1) ? 0 : ($page * $per_page) - $per_page;

        $post_query_count = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) ? "SELECT * FROM posts" : "SELECT * FROM posts WHERE post_status = 'published'"; 
        $find_count = mysqli_query($connection,$post_query_count);
        $count = mysqli_num_rows($find_count);

        if($count < 1) {
          echo "<h1 class='text-center'>No posts available</h1>";
        } else {
          $count  = ceil($count /$per_page); 
          $query = "SELECT * FROM articles WHERE category = 53 LIMIT $page_1, $per_page";
          $select_all_articles_query = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_all_articles_query)) {
            $id = $row['id'];
            $title = $row['title'];
            $author = $row['author'] ? $row['author'] : "Staff Writer";
            $date = date_create($row['date']);
            $date = date_format($date, "l, F dS, Y");
            $image = $row['image'];
            $description = (strlen($row['description']) > 250) ? substr($row['description'], 0, strpos($row['description'], ' ', 200)) . "..." : $row['description'];
            // $pos = strpos($row['description'], ' ', 200);
            // $description = substr($row['description'], 0, $pos) . "...";
            $status = $row['status'];

          // while($row = mysqli_fetch_assoc($select_all_posts_query)) {
          //   $post_id = $row['post_id'];
          //   $post_title = $row['post_title'];
          //   $post_author = $row['post_user'] ? $row['post_user'] : "Staff Writer";
          //   $date = date_create($row['post_date']);
          //   $post_date = date_format($date, "l, F dS, Y");
          //   $post_image = $row['post_image'];
          //   $pos = strpos($row['post_desc'], ' ', 250);
          //   $post_desc = substr($row['post_desc'], 0, $pos) . "...";
          //   $post_status = $row['post_status'];
      ?>
          <div class="row post-section">
            <div class="col-md-6">
              <a href="post.php?p_id=<?php echo $id; ?>">
                <img class="img-responsive post-image" src="<?php echo $image;?>" alt="">
              </a>  
            </div>
            <div class="col-md-6">
              <div class="row post-title">
                <a href="post/<?php echo $id; ?>"><?php echo $title ?></a>
                by <a href="author_posts.php?author=<?php echo $author ?>&p_id=<?php echo $id; ?>"><?php echo $author ?></a>
              </div>
              <div class="row post-date">
              <strong>on <?php echo $date ?></strong>
              </div>
              <div class="row post-desc">
                <a href="post.php?p_id=<?php echo $id; ?>"><?php echo $description ?></a><br>
              </div>
              <!-- <div class="row post-button">
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> 
              </div> -->
            </div>
          </div>
          <hr>
  <?php }  } ?>
    </div>
      
    <?php include "includes/sidebar.php";?>
  </div>
  <ul class="pager">
    <?php 
      $number_list = array();

      for($i =1; $i <= $count; $i++) {
        if($i == $page) {
          echo "<li '><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
        } else {
          echo "<li '><a href='index.php?page={$i}'>{$i}</a></li>";
        }
      }
    ?>
  </ul>
<?php include "includes/footer.php";?>