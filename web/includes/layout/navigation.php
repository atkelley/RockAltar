<?php
  if(check_method('post')){
    if(isset($_POST['login'])){
      if(isset($_POST['username']) && isset($_POST['password'])){
        login_user($_POST['username'], $_POST['password']);
      } else {
        redirect('index.php');
      }
    }
  }
?>

<nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">RockAltar</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Genres</a>
          <div class="dropdown-menu">
            <ul class="nav navbar-nav">
              <?php 
                $all_genres= confirm_query("SELECT * FROM genres");

                while($row = mysqli_fetch_assoc($all_genres)) {
                  echo "<li class='nav-item'><a class='dropdown-item' href='index.php?page=genre&genre=" . strtolower($row['name']) . "'>{$row['name']}</a></li>";
                }           
              ?>
            </ul>
          </div>
        </li>
      </ul>
      
      <ul class="nav navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
          <div class="dropdown-menu">
            <ul class="nav navbar-nav">
              <?php 
                $all_categories = confirm_query("SELECT * FROM categories");

                while($row = mysqli_fetch_assoc($all_categories)) {
                  echo "<li class='nav-item'><a class='dropdown-item' href='index.php?page=category&category=" . strtolower($row['name']) . "'>{$row['name']}</a></li>";
                }           
              ?>
            </ul>
          </div>
        </li>
      </ul>

      <nav class="nav navbar-nav navbar-light bg-light navbar-search pull-right">
        <form action="search.php" method="post" class="form-inline">
          <div class="input-group">
            <input name="search" type="text" class="form-control" required>
            <span class="input-group-btn">
              <button name="submit" class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </form>
      </nav>

      <ul class="nav navbar-nav pull-right">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile</a>
          <div class="dropdown-menu">
            <ul class="nav navbar-nav">
              <?php if(logged_in()): ?>
                <li class="nav-item"><a class="dropdown-item admin" href="/admin/index.php"><span class="glyphicon glyphicon-user glyphicon-navigation-user"></span><?php echo $_SESSION['username'] ?></a></li>
                <li class="nav-item"><a class="dropdown-item" href="logout.php">Logout</a></li>
              <?php else: ?>
                <li class="nav-item"><a class="dropdown-item" href="login.php">Login</a></li>
              <?php endif; ?>         
                <li class="nav-item registration-item"><a class="dropdown-item" href="registration.php">Registration</a></li>
            </ul>
          </div>
        </li>
      </ul>

      <ul class="nav navbar-nav pull-right">
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
