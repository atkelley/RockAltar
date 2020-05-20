<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">RockAltar Admin</a>
  </div>
  <ul class="nav navbar-right top-nav">
    <li><a href="">Users Online: <span class="usersonline"></span></a></li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>            
        <?php
          if(isset($_SESSION['username'])) {
            echo $_SESSION['username'];
          }
        ?>
        <b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li class="profile-link"><a href="../index.php"><i class="fa fa-fw fa-home"></i> HOME</a></li>
        <li class="profile-link"><a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a></li>
        <li class="divider"></li>
        <li><a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
      </ul>
    </li>
  </ul>

  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
      <li><a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
      <li><a href="./articles.php"><i class="fa fa-fw fa-pencil"></i> Articles</a></li>
      <?php if(is_admin($_SESSION['username'])): ?> 
        <li><a href="./users.php"><i class="fa fa-fw fa-users"></i> Users</a></li>
      <?php endif; ?>
      <li><a href="./categories.php"><i class="fa fa-fw fa-archive"></i> Categories</a></li>     
      <li><a href="./genres.php"><i class="fa fa-fw fa-music"></i> Genres</a></li>         
      <li><a href="comments.php"><i class="fa fa-fw fa-comments"></i> Comments</a></li>
    </ul>
  </div>
</nav>
        