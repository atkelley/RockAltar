<?php
  function get_rows_count($table) {
    return mysqli_num_rows(confirm_query("SELECT * FROM " . $table));
  }

  function get_all_published_articles_count() {
    return mysqli_num_rows(confirm_query("SELECT * FROM articles WHERE status = 'published'"));
  }


  function get_all_drafted_articles_count() {
    return mysqli_num_rows(confirm_query("SELECT * FROM articles WHERE status = 'draft'"));
  }


  function get_all_approved_comments_count() {
    return mysqli_num_rows(confirm_query("SELECT * FROM comments WHERE status = 'approved'"));
  }


  function get_all_unapproved_comments_count() {
    return mysqli_num_rows(confirm_query("SELECT * FROM comments WHERE status = 'unapproved'"));
  }


  function get_all_subscribers_count() {
    return mysqli_num_rows(confirm_query("SELECT * FROM users WHERE role = 'subscriber'"));
  }


  function get_article_comments_count($id) {
    return mysqli_num_rows(confirm_query("SELECT * FROM comments WHERE post_id = " . $id));
  }


  function copy_article($post_id) {
    $copy_article_query = confirm_query("SELECT * FROM articles WHERE id = '{$post_id}'");

    while ($row = mysqli_fetch_array($copy_article_query)) {
      $title       = $row['title'];
      $category    = $row['category'];
      $genre       = $row['genre'];
      $description = $row['description'];
      $name        = $row['name'];
      $user        = $row['user'];
      $status      = $row['status'];
      $image       = $row['image'] ; 
      $content     = $row['content'];
    }

    $query = "INSERT INTO articles (category, title, user, date, image, content, status, genre, description) ";
    $query .= "VALUES({$category}, '{$title}', '{$user}', CURDATE(), '{$image}', '{$content}', '{$status}', '{$genre}', '{$description}') "; 
    confirm_query($query); 
  }


  function get_article($id) {
    $query = "SELECT articles.title, articles.date, articles.image, articles.content, articles.status,
          articles.description, articles.category, articles.user, users.firstname, users.lastname,
          articles.name, articles.genre
          FROM articles 
          INNER JOIN users ON articles.user = users.id
          WHERE articles.id = " . $id;

    $get_article_query = confirm_query($query);  

    $row = mysqli_fetch_assoc($get_article_query);

    $date = date_create($row['date']);
    $date = date_format($date, "l, F jS, Y");

    return [
      'title'       => $row['title'],
      'user'        => $row['user'],
      'name'        => isset($row['name']) ? $row['name'] : "",
      'date'        => $date,
      'image'       => $row['image'],
      'status'      => $row['status'],
      'category'    => $row['category'],
      'genre'       => $row['genre'],
      'description' => $row['description'],
      'content'     => $row['content'],
    ];
  }


  function get_all_articles() {
    $query = "SELECT articles.id, articles.title, articles.date, 
          articles.image, articles.user, users.firstname, users.lastname, 
          users.username, articles.status, articles.views, 
          (SELECT COUNT(id) FROM comments WHERE articles.id = comments.post_id) AS comments,
          categories.name AS category, genres.name AS genre
          FROM articles 
          INNER JOIN users ON articles.user = users.id
          INNER JOIN genres ON articles.genre = genres.id
          INNER JOIN categories ON articles.category = categories.id
          ORDER BY articles.date DESC";

    return confirm_query($query);  
  }

  
  function get_all_published_articles() {
    $confirm_query("SELECT * FROM articles WHERE status = 'published'");
  }


  function get_all_article_comments($id) {
    $query = "SELECT 
          comments.id,
          articles.title,
          comments.post_id,
          comments.author,
          comments.email,
          comments.content,
          comments.status,
          comments.date
          FROM comments 
          INNER JOIN articles ON comments.post_id = articles.id
          WHERE post_id = {$id}";

    return confirm_query($query);  
  }


  function get_all_comments() {
    $query = "SELECT 
          comments.id,
          articles.title,
          comments.post_id,
          comments.author,
          comments.email,
          comments.content,
          comments.status,
          comments.date,
          articles.user
          FROM comments 
          INNER JOIN articles ON comments.post_id = articles.id";
          
    return confirm_query($query);  
  }


  function get_comment($id) {
    $query = "SELECT 
              articles.user,
              comments.post_id,
              comments.author,
              comments.email,
              comments.content,
              comments.status
              FROM comments 
              INNER JOIN articles ON comments.post_id = articles.id
              WHERE comments.id = {$id}";
    $get_comment_query = confirm_query($query);

    if (!$get_comment_query || mysqli_num_rows($get_comment_query) === 0) {
      return null; 
    }

    $row = mysqli_fetch_assoc($get_comment_query);

    return [
      'user'    => $row['user'],
      'post_id' => $row['post_id'],
      'author'  => $row['author'],
      'email'   => $row['email'],
      'content' => $row['content'],
      'status'  => $row['status'],
    ];
  }


  function update_article($form_data, $id) {
    global $connection; 

    $fields = ['name', 'title', 'user', 'status', 'category', 'description', 'content']; 
    $selected_fields = [];

    foreach ($fields as $field) {
      if (isset($form_data[$field]) && $form_data[$field] !== '') {
        $value = mysqli_real_escape_string($connection, trim($form_data[$field]));
        $selected_fields[] = "$field = '$value'";
      }
    }

    $image = !empty($form_data['image']) ? escape($form_data['image']) : "../../../assets/images/placeholder.jpg";
    $selected_fields[] = "image = '$image'";
    $selected_fields[] = "date = CURDATE()";

    $query = "UPDATE articles SET " . implode(', ', $selected_fields) . " WHERE id = $id";
    $update_article_query = confirm_query($query);

    if (!$update_article_query) {
      error_log("Query failed: " . mysqli_error($connection));
      return false;
    }

    return true;
  }


  function add_comment($form_data) {
    global $connection; 

    $fields = ['article', 'author', 'email', 'content'];
    
    foreach ($fields as $field) {
      $form_data[$field] = escape($form_data[$field]);
    }

    $form_data['status'] = isset($form_data['status']) ? escape($form_data['status']) : "unapproved";

    $query = "INSERT INTO comments(post_id, author, email, content, status, date) ";        
    $query .= "VALUES({$form_data['article']}, '{$form_data['author']}', '{$form_data['email']}', '{$form_data['content']}', '{$form_data['status']}', NOW()) ";    
    $add_comment_query = confirm_query($query);

    if (!$add_comment_query) {
      error_log("Query failed: " . mysqli_error($connection));
      return false;
    }

    return true;
  }


  function update_comment($form_data, $post_id, $id) {
    global $connection; 

    $fields = ['author', 'email', 'content', 'status']; 
    $selected_fields = [];

    foreach ($fields as $field) {
      if (isset($form_data[$field]) && $form_data[$field] !== '') {
        $value = mysqli_real_escape_string($connection, trim($form_data[$field]));
        $selected_fields[] = "$field = '$value'";
      }
    }

    $selected_fields[] = "post_id = '$post_id'";
    $selected_fields[] = "date = NOW()";

    $query = "UPDATE comments SET " . implode(', ', $selected_fields) . " WHERE id = $id";
    $update_comment_query = confirm_query($query);

    if (!$update_comment_query) {
      error_log("Query failed: " . mysqli_error($connection));
      return false;
    }

    return true;
  }


  function delete_article_and_comments($id) {
    if (get_article_comments_count($id) > 0) {
      $query = "DELETE articles, comments
                FROM articles
                INNER JOIN comments ON articles.id = comments.post_id
                WHERE articles.id = {$id}";
    } else {
      $query = "DELETE FROM articles WHERE id = {$id}";
    }

    confirm_query($query);
  }


  function add_article($form_data) {
    global $connection;

    $fields = ['title', 'user', 'name', 'category', 'genre', 'content', 'description'];
    
    foreach ($fields as $field) {
      $form_data[$field] = escape($form_data[$field]);
    }

    $image = !empty($form_data['image']) ? escape($form_data['image']) : "../../../assets/images/placeholder.jpg";
    $form_data['image'] = $image;

    $query = "INSERT INTO articles(category, genre, title, user, name, date, image, content, status, description, views, comments) ";        
    $query .= "VALUES('{$form_data['category']}', '{$form_data['genre']}', '{$form_data['title']}', '{$form_data['user']}', '{$form_data['name']}', ";   
    $query .= "CURDATE(), '{$form_data['image']}', '{$form_data['content']}', 'draft', '{$form_data['description']}', 0, 0)"; 
    $add_article_query = confirm_query($query);

    if (!$add_article_query) {
      error_log("Query failed: " . mysqli_error($connection));
      return false;
    }

    return true;
  }
?>