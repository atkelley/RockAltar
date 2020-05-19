<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $query = "SELECT * FROM users";
      $select_users = mysqli_query($connection, $query);  

      while($row = mysqli_fetch_assoc($select_users)) {
        $id             = $row['id'];
        $username            = $row['username'];
        $password       = $row['password'];
        $firstname      = $row['firstname'];
        $lastname       = $row['lastname'];
        $email          = $row['email'];
        $image          = $row['image'];
        $role           = $row['role'];
        echo "<tr>"; 
        echo "<td>$id </td>";
        echo "<td>$username</td>";
        echo "<td>$firstname</td>";
        // $query = "SELECT * FROM categories WHERE id = {$category} ";
        // $select_categories_id = mysqli_query($connection,$query);  

        // while($row = mysqli_fetch_assoc($select_categories_id)) {
        //   $cat_id = $row['cat_id'];
        //   $cat_title = $row['cat_title']; 
        //   echo "<td>{$cat_title}</td>";
        // }
       
        echo "<td>$lastname</td>";
        echo "<td>$email</td>";
        echo "<td>$role</td>";

        $query = "SELECT * FROM articles WHERE category = $id ";
        $select_article_id_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_article_id_query)){
          // $id = $row['id'];
          $title = $row['title'];
          // echo "<td><a href='../article.php?id=$id'>$title</a></td>";
        }

        echo "<td><a href='users.php?source=edit_user&user={$id}'>Edit</a></td>";
        echo "<td><a href='users.php?delete={$id}'>Delete</a></td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>
                     
<?php
  // if(isset($_GET['change_to_admin'])) {
  //   $id = escape($_GET['change_to_admin']);
  //   $query = "UPDATE users SET role = 'admin' WHERE id = $id   ";
  //   $change_to_admin_query = mysqli_query($connection, $query);
  //   header("Location: users.php");
  // }

  // if(isset($_GET['change_to_sub'])){
  //   $id = escape($_GET['change_to_sub']);
  //   $query = "UPDATE users SET role = 'subscriber' WHERE id = $id   ";
  //   $change_to_sub_query = mysqli_query($connection, $query);
  //   header("Location: users.php"); 
  // }

  if(isset($_GET['delete'])){
    if(isset($_SESSION['role'])) {
      if($_SESSION['role'] == 'admin') {
        $id = escape($_GET['delete']);
        $query = "DELETE FROM users WHERE id = {$id} ";
        $delete_user_query = mysqli_query($connection, $query);
        header("Location: users.php");
      }   
    }
  }
?>     