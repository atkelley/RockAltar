<?php 
  if(isset($_GET['id'])) {
    $id = escape($_GET['id']);
    $query = "UPDATE articles SET views = 0 WHERE id = $id ";
    $send_query = mysqli_query($connection, $query);

    if(!$send_query) {
      die("Query failed: " . mysqli_error($connection));
    }

    header("Location: view_all_posts.php");
  }
?>