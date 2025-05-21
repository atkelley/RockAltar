<?php
  function confirm_query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);

    if(!$result) { 
      die("Query failed: " . mysqli_error($connection)); 
    }

    return $result;
  }

  
  function redirect($location) {
    header("Location: {$location}", true, 302); 
    exit;
  }


  function logged_in(){
    return (isset($_SESSION['role'])) ? true : false;
  }
  

  function check_method($method = null){
    return ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) ? true : false;
  }


  function render_pagination($total_pages, $current_page, $base_url, $extra_params = []) {
    echo '<ul class="pager">';
    
    for ($i = 1; $i <= $total_pages; $i++) {
      $active = ($i == $current_page) ? " class='active-link'" : "";
      
      $params = array_merge($extra_params, ['p' => $i]);
      $query_string = http_build_query($params);
      
      $href = ($i == $current_page) 
        ? "<li><a{$active}>{$i}</a></li>" 
        : "<li><a href='{$base_url}?{$query_string}'>{$i}</a></li>";

      echo $href;
    }

    echo '</ul>';
  }
?>