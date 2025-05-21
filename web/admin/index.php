<?php
  ob_start();
  session_start();

  require_once "../includes/config/db.php";
  require_once "./includes/functions/utilities.php";
  require_once "./includes/functions/queries.php";
  require_once "./includes/functions/auth.php";

  if (!isset($_SESSION['role'])) {
    redirect("index.php");
  }

  include "./includes/layout/admin_header.php";
?>

<div id="wrapper">
  <?php 
    require_once "includes/layout/admin_navigation.php";

    $page = $_GET['page'] ?? 'dashboard';
    $pagePath = __DIR__ . "/pages/{$page}.php";

    if (file_exists($pagePath)) {
      require_once $pagePath;
    } else {
      require_once __DIR__ . "/pages/dashboard.php"; 
    }
  ?>
</div>
    
<?php require_once "includes/layout/admin_footer.php" ?>
