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
        $find_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($find_count);
        
        if(isset($_GET['user'])){
          $count  = ceil($count / $per_page); 
          $query = "SELECT * FROM articles WHERE user = " . $_GET['user'] . " ORDER BY date DESC LIMIT $page_1, $per_page";
          $select_all_posts_query = mysqli_query($connection, $query);
  
          while($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $id = $row['id'];
            $title = $row['title'];
            $author = $row['author'];
            $date = date_create($row['date']);
            $date = date_format($date, "l, F dS, Y");
            $image = $row['image'];
            $content = $row['content'];
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
                by <?php echo $author ?>
                <span class="glyphicon glyphicon-time"></span> on <?php echo $date ?>
              </div>
              <div class="row news-description">
                <a href="article.php?id=<?php echo $id; ?>"><?php echo $description ?></a><br>
              </div>
            </div>
          </div>
          <hr>
    <?php }        
        } else { ?>
          <h2>No posts from this author.</h2>
  <?php }?>
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



      <?php 
        if(isset($_POST['create_comment'])) {        
          $the_post_id = $_GET['p_id'];
          $comment_author = $_POST['comment_author'];
          $comment_email = $_POST['comment_email'];
          $comment_content = $_POST['comment_content'];

          if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content) ) {
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status,comment_date)";
            $query .= "VALUES ($the_post_id ,'{$comment_author}', '{$comment_email}', '{$comment_content }', 'unapproved',now())";                             
            $create_comment_query = mysqli_query($connection,$query);
                    
            if(!$create_comment_query ){
              die('QUERY FAILED' . mysqli_error($connection));
            }
                    
            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";         $query .= "WHERE post_id = $the_post_id ";
            $update_comment_count = mysqli_query($connection,$query);         
          } else {
            echo "<script>alert('Fields cannot be empty')</script>";    
          }
        }             
      ?> 
    </div>
    <?php include "includes/sidebar.php";?>
  </div>

  <?php include "includes/footer.php";?>
