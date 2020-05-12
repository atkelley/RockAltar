<?php
  if(ifItIsMethod('post')){
    if(isset($_POST['login'])){
      if(isset($_POST['username']) && isset($_POST['password'])){
        login_user($_POST['username'], $_POST['password']);
      } else {
        redirect('index');
      }
    }
  }
?>

<div class="col-md-4">
  <div class="well newsletter">
    <h4 class="newsletter-section-title">Newsletter</h4>
    <h6>Sign up to receive the latest news, articles and updates from RockAltar!</h6>
    <form method="post">
      <div class="input-group">
        <input name="search" type="text" class="form-control" placeholder="Your email address">
        <span class="input-group-btn">
          <button name="submit" class="btn btn-default" type="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </form>
  </div>

  <div class="well">     
    <?php 
      $query = "SELECT * FROM articles WHERE category = 4 LIMIT 1";
      $select_videos_sidebar_query = mysqli_query($connection, $query);   
      
      while($row = mysqli_fetch_assoc($select_videos_sidebar_query)) {
        $id = $row['id'];
        $title = $row['title'];
        $image = $row['image'];
        $name = $row['name'];
      }
    ?>
    <h4 class="video-section-title">Top Video</h4>
    <div class="row">
      <div class="col-lg-12 video-box">
        <a href="article.php?id=<?php echo $id; ?>">
          <img class="img-responsive video-image" src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
          <img src="images/blue-play-button.png" alt="blue-play-button" class="video-play-button">
        </a>
        <a href="article.php?id=<?php echo $id; ?>">
          <p class="video-text"><?php echo $name; ?> - <?php echo $title; ?></p>
        </a>
      </div>
    </div>
  </div>

  <div class="well">     
    <?php 
      $query = "SELECT * FROM articles WHERE category = 5 LIMIT 1";
      $select_podcasts_sidebar_query = mysqli_query($connection, $query);   
      
      while($row = mysqli_fetch_assoc($select_podcasts_sidebar_query)) {
        $id = $row['id'];
        $title = $row['title'];
        $image = $row['image'];
      }
    ?>
    <h4 class="podcast-section-title">Top Podcast</h4>
    <div class="row">
      <div class="col-lg-12">
        <a href="article.php?id=<?php echo $id; ?>">
          <img class="img-responsive podcast-image" src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
          <img src="images/blue-play-button.png" alt="blue-play-button" class="podcast-play-button">
        </a>
        <a href="article.php?id=<?php echo $id; ?>">
          <p class="podcast-text"><?php echo $title; ?></p>
        </a>
      </div>
    </div>
  </div>

  <div class="well">     
  <?php 
      $query = "SELECT * FROM articles WHERE category = 3 LIMIT 1";
      $select_albums_sidebar_query = mysqli_query($connection, $query);   
      
      while($row = mysqli_fetch_assoc($select_albums_sidebar_query)) {
        $id = $row['id'];
        $title = $row['title'];
        $image = $row['image'];
        $name = $row['name'];
        $description = $row['description'];
      }
    ?>
    <h4 class="album-section-title">Top Album</h4>
    <div class="row">
      <div class="col-md-5 album-image-box">
        <a href="article.php?id=<?php echo $id; ?>">
          <img class="img-responsive album-image" src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
        </a>
      </div>
      <div class="col-md-7 album-text">
        <a href="article.php?id=<?php echo $id; ?>">
          <h4 class="album-band-name"><strong><?php echo $name; ?></strong></h4>
        </a>
        <h5 class="album-title"><em><?php echo $title; ?></em></h5>
        <a href="article.php?id=<?php echo $id; ?>">
          <h5 class="album-description"><?php echo $description; ?></h5>
        </a>
      </div>
    </div>
  </div>

  <?php include "widget.php"; ?>
</div>
            