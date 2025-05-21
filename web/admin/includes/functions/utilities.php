<?php
  function confirm_query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);

    if(!$result) { 
      die("Query failed: " . mysqli_error($connection)); 
    }

    return $result;
  }


  function set_message($msg){
    $_SESSION['message'] = (!$msg) ? $msg : "";
  }

  
  function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
  }
  
  
  function redirect($location) {
    header("Location: {$location}", true, 302); 
    exit;
  }


  function get_chart_data() {
    return [
      'All Articles' => get_rows_count('articles'),
      'Published Articles' => get_all_published_articles_count(),
      'Drafted Articles' => get_all_drafted_articles_count(),
      'All Comments' => get_rows_count('comments'),
      'Approved Comments' => get_all_approved_comments_count(),
      'Pending Comments' => get_all_unapproved_comments_count(),
      'Users' => get_rows_count('users'),
      'Subscribers' => get_all_subscribers_count(),
      'Categories' => get_rows_count('categories'),
    ];
  }


  function render_article_table_rows($articles) {
    $output = "";

    while ($row = mysqli_fetch_assoc($articles)) {
      $id       = $row['id'];
      $user     = $row['user'];
      $username = $row['username'];
      $author   = $row['firstname'] . " " . $row['lastname'];
      $title    = $row['title'];
      $category = $row['category'];
      $genre    = $row['genre'];
      $status   = $row['status'];
      $image    = $row['image'];
      $comments = $row['comments'];
      $date     = date_create($row['date']);
      $date     = date_format($date, "F jS, Y");
      $views    = $row['views'];

      $disabled = (!is_admin($_SESSION['username']) && $_SESSION['id'] != $user) ? "disabled" : "";

      $output .= "<tr>";
      $output .= "<td><input class='checkBoxes' type='checkbox' name='checkbox_array[]' value='{$id}'></td>";
      $output .= "<td><a href='../index.php?page=author&user={$user}'>{$username}</a></td>";
      $output .= "<td><a href='../index.php?page=article&id={$id}'>" . substr($title, 0, 50) . "...</a></td>";
      $output .= "<td><a href='../index.php?page=genre&genre=" . strtolower($genre) . "'>{$genre}</a></td>";
      $output .= "<td><a href='../index.php?page=category&category=" . strtolower($category) . "'>{$category}</a></td>";
      $output .= "<td>{$status}</td>";
      $output .= "<td><img width='100' src='{$image}' alt='image'></td>";
      $output .= ($comments > 0)
        ? "<td><a href='index.php?page=article_comments&id={$id}'>{$comments}</a></td>"
        : "<td>{$comments}</td>";
      $output .= "<td><a rel='{$id}' href='javascript:void(0)' class='btn btn-default reset_link' {$disabled}>{$views}</a></td>";
      $output .= "<td>{$date}</td>";
      $output .= "<td><a class='btn btn-warning' href='index.php?page=articles&source=edit&id={$id}' {$disabled}>Edit</a></td>";
      $output .= "<td><a rel='{$id}' data-type='article' data-comments=$comments href='javascript:void(0)' class='btn btn-danger delete_link' {$disabled}>Delete</a></td>";
      $output .= "</tr>";
    }

    return $output;
  }


  function render_article_comment_table_rows($article_comments)  {
    $output = "";

    while($row = mysqli_fetch_assoc($article_comments)) {
      $id      = $row['id'];
      $title   = $row['title'];
      $post_id = $row['post_id'];
      $author  = $row['author'];
      $email   = $row['email'];
      $content = $row['content'];
      $status  = $row['status'];
      $date = date("F dS, Y", strtotime($row['date']));
      $time = date('h:i A', strtotime($row['date']));

      $output .= "<tr>";
      $output .= "<td><input class='checkBoxes' type='checkbox' name='checkbox_array[]' value='{$id}'></td>";
      $output .= "<td>$author</td>";
      $output .= "<td>$content</td>";
      $output .= "<td>$email</td>";
      $output .= "<td><a href='../index.php?page=article&id=$post_id#comments'>$title</a></td>";
      $output .= "<td>$status</td>";       
      $output .= "<td>$date, $time</td>";
      $output .= "<td><a class='btn btn-warning' href='index.php?page=comments&source=edit&id={$id}&type=article'
      " . ((!is_admin($_SESSION['username']) && $_SESSION['email'] != $email) ? "disabled" : "") . "
      >Edit</a></td>";
      $output .= "<td><a rel='$id' href='javascript:void(0)' id='$post_id' data-type='article comment' class='btn btn-danger delete_link'
      " . ((!is_admin($_SESSION['username']) && $_SESSION['email'] != $email) ? "disabled" : "") . "
      >Delete</a></td>";
      $output .= "</tr>";
    }

    return $output;
  }


  function render_comment_table_rows($comments) {
    $output = "";

    while($row = mysqli_fetch_assoc($comments)) {
      $id      = $row['id'];
      $title   = $row['title'];
      $post_id = $row['post_id'];
      $author  = $row['author'];
      $email   = $row['email'];
      $content = $row['content'];
      $status  = $row['status'];
      $user    = $row['user'];
      $date = date("F dS, Y", strtotime($row['date']));
      $time = date('h:i A', strtotime($row['date']));

      $output .= "<tr>";
      $output .= "<td><input class='checkBoxes' type='checkbox' name='checkbox_array[]' value='{$id}'></td>";
      $output .= "<td><a href='../index.php?page=author&user={$user}'>{$author}</a></td>";
      $output .= "<td>$content</td>";
      $output .= "<td>$email</td>";
      $output .= "<td><a href='../index.php?page=article&id=$post_id#comments'>$title</a></td>";
      $output .= "<td>$status</td>";       
      $output .= "<td>$date, $time</td>";
      $output .= "<td><a class='btn btn-warning' href='index.php?page=comments&source=edit&id={$id}'
      " . ((!is_admin($_SESSION['username']) && $_SESSION['email'] != $email) ? "disabled" : "") . "
      >Edit</a></td>";
      $output .= "<td><a rel='$id' href='javascript:void(0)' data-type='comment' class='btn btn-danger delete_link'
      " . ((!is_admin($_SESSION['username']) && $_SESSION['email'] != $email) ? "disabled" : "") . "
      >Delete</a></td>";
      $output .= "</tr>";
    }

    return $output;
  }
  

  function render_user_table_rows($users) {
    $output = "";

    while($row = mysqli_fetch_assoc($users)) {
      $id             = $row['id'];
      $username       = $row['username'];
      $password       = $row['password'];
      $firstname      = $row['firstname'];
      $lastname       = $row['lastname'];
      $email          = $row['email'];
      $image          = (!empty($row['image'])) ? $row['image'] : "https://www.gravatar.com/avatar/" . hash('md4', strtolower($email)) . "?s=350&d=identicon&r=PG";
      $role           = $row['role'];

      $output .= "<tr>";
      $output .= "<td><input class='checkBoxes' type='checkbox' name='checkbox_array[]' value='$id'></td>";
      $output .= "<td><a href='../index.php?page=author&user={$id}'>$username</a></td>";
      $output .= "<td>$firstname</td>";     
      $output .= "<td>$lastname</td>";
      $output .= "<td>$email</td>";
      $output .= "<td><img width='100' src='$image' alt='image'></td>";
      $output .= "<td>$role</td>";
      $output .= "<td><a class='btn btn-warning' href='index.php?page=users&source=edit&user={$id}'>Edit</a></td>";
      $output .= "<td><a rel='$id' href='javascript:void(0)' data-entity='\"$username\"' data-type='user' class='btn btn-danger delete_link'>Delete</a></td>";
      $output .= "</tr>";
    }

    return $output;
  }


  function render_genre_or_category_table_rows($data, $type) {
    $output = "";

    while($row = mysqli_fetch_assoc($data)) {
      $id = $row['id'];
      $name = $row['name'];

      $output .= "<tr>";
      $output .= "<td>{$name}</td>";
      $output .= "<td><a rel='$id' data-entity='$name' href='javascript:void(0)' class='btn btn-warning edit_link
      " . (!is_admin($_SESSION['username']) ? "disabled" : "") . "
      '>Edit</a></td>";
      $output .= "<td><a rel='$id' data-entity='\"$name\"' data-type='$type' href='javascript:void(0)' class='btn btn-danger delete_link
      " . (!is_admin($_SESSION['username']) ? "disabled" : "") . "
      '>Delete</a></td>";
      $output .= "</tr>";
    }

    return $output;
  }
?>