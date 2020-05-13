<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Genres</a>
          <div class="dropdown-menu">
            <ul class="nav navbar-nav">
              <?php 
                $query = "SELECT * FROM genres LIMIT 8";
                $select_all_genres_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_genres_query)) {
                  $genre_id = $row['id'];
                  $genre_name = $row['name'];
                  echo "<li class='nav-item'><a class='dropdown-item' href='genre.php?genre=" . strtolower($genre_name) . "'>{$genre_name}</a></li><br>";
                }           
              ?>
            </ul>
          </div>
        </li>
      </ul>

      <ul class="nav navbar-nav">
        <?php 
          $query = "SELECT * FROM categories LIMIT 5";
          $select_all_categories_query = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_all_categories_query)) {
            $id = $row['id'];
            $name = $row['name'];
            echo "<li><a href='category.php?category=" . strtolower($name) . "'>{$name}</a></li>";
          }           
        ?>
                                                    
        <?php 
          if(isset($_SESSION['user_role'])) {
            if(isset($_GET['p_id'])) {  
              $the_post_id = $_GET['p_id'];
              echo "<li><a href='/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
            }
          }
        ?>
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
        <?php if(isLoggedIn()): ?>
          <li class="nav-item"><a class="nav-link" href="admin">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="includes/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php endif; ?>                
        <li class="nav-item"><a class="nav-link" href="registration.php">Registration</a></li>
      </ul>
    </div>
  </div>
</nav>
