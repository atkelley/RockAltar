<?php 
  session_start();
  require_once "includes/config/db.php"; 
  require_once "includes/functions/utilities.php";
  require_once "includes/functions/queries.php";
  require_once "includes/functions/auth.php";

  require_once "includes/layout/header.php";
  require_once "includes/layout/navigation.php";
  require_once "includes/components/jumbotron.php";
?>

<div class="main-container">
  <main class="main">
    <?php
      $request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

      $direct_pages = ['contact', 'register', 'login', 'logout', 'forgot', 'reset', 'thank', 'search'];
      $allowed_pages = ['home', 'article', 'genre', 'category', 'author'];

      if (in_array($request_uri, $direct_pages)) {
        require_once "{$request_uri}.php";
      } else {
        $page = $_GET['page'] ?? 'home';

        if (in_array($page, $allowed_pages)) {
          require_once "pages/{$page}.php";
        } else {
          redirect("index.php");
        }
      }  
    ?>
  </main>
  <?php require_once "./includes/layout/sidebar.php"; ?>
</div>

<?php require_once "includes/layout/footer.php"; ?>