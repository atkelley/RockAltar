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
      $query = "SELECT * FROM categories";
      $select_categories_sidebar = mysqli_query($connection,$query);         
    ?>
    <h4 class="video-section-title">Top Video</h4>
    <div class="row">
      <div class="col-lg-12 video-box">
        <!-- <img class="img-responsive post-image" src="images/<?php echo $post_image;?>" alt=""> -->
        <img class="img-responsive video-image" src="https://picsum.photos/320/200" alt="">
        <img src="images/blue-play-button.png" alt="red-play-button" class="video-play-button">
        <p class="video-text">Band Name - Song Name</p>
      </div>
    </div>
  </div>

  <div class="well">     
    <?php 
      $query = "SELECT * FROM categories";
      $select_categories_sidebar = mysqli_query($connection,$query);         
    ?>
    <h4 class="podcast-section-title">Top Podcast</h4>
    <div class="row">
      <div class="col-lg-12">
        <!-- <img class="img-responsive post-image" src="images/<?php echo $post_image;?>" alt=""> -->
        <img class="img-responsive podcast-image" src="https://picsum.photos/320/200" alt="">
        <img src="images/blue-play-button.png" alt="red-play-button" class="podcast-play-button">
        <p class="podcast-text">Band Name - Song Name</p>
      </div>
    </div>
  </div>

  <div class="well">     
    <?php 
      $query = "SELECT * FROM categories";
      $select_categories_sidebar = mysqli_query($connection,$query);         
    ?>
    <h4 class="album-section-title">Top Album</h4>
    <div class="row">
      <div class="col-md-5">
        <!-- <img class="img-responsive post-image" src="images/<?php echo $post_image;?>" alt=""> -->
        <img class="img-responsive album-image" src="https://picsum.photos/" alt="">
      </div>
      <div class="col-md-7 album-text">
        <h5 class="album-band-name"><strong>Band Name</strong></h5>
        <h5 class="album-title"><strong>Album Title</strong></h5>
        <h5 class="album-rating"><strong>Rating: <span class="album-rating-punch">4.0 / 5.0</span></strong></h5>
      </div>
    </div>
  </div>

  <?php include "widget.php"; ?>
</div>
            