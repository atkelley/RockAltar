<?php
  if(check_method('post')){
    if(isset($_POST['login'])){
      if(isset($_POST['username']) && isset($_POST['password'])){
        login_user($_POST['username'], $_POST['password']);
      } else {
        redirect('index');
      }
    }
  }
?>

<nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">RockAltar</a>
    </div>


    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Genres</a>
          <div class="dropdown-menu">
            <ul class="nav navbar-nav">
              <?php 
                $query = "SELECT * FROM genres LIMIT 5";
                $select_all_genres_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_genres_query)) {
                  $id = $row['id'];
                  $name = $row['name'];
                  echo "<li class='nav-item'><a class='dropdown-item' href='genre.php?genre=" . strtolower($name) . "'>{$name}</a></li>";
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
                $query = "SELECT * FROM categories LIMIT 5";
                $select_all_categories_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                  $id = $row['id'];
                  $name = $row['name'];
                  echo "<li class='nav-item'><a class='dropdown-item' href='category.php?category=" . strtolower($name) . "'>{$name}</a></li>";
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
                <li class="nav-item"><a class="dropdown-item admin" href="admin"><span class="glyphicon glyphicon-user glyphicon-navigation-user"></span><?php echo $_SESSION['username'] ?></a></li>
                <li class="nav-item"><a class="dropdown-item" href="includes/logout.php">Logout</a></li>
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
