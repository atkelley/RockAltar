<form method="post"> 
  <div class="col-md-4">
    <div class="form-group">
      <?php
        if(isset($_GET['edit'])){
          $id = escape($_GET['edit']);
          $query = "SELECT * FROM categories WHERE id = $id ";
          $select_categories_id = mysqli_query($connection, $query); 
          confirm_query($select_categories_id); 

          while($row = mysqli_fetch_assoc($select_categories_id)) {
            $id = $row['id'];
            $name = $row['name'];        
            ?><input value="<?php echo $name; ?>" type="text" class="form-control" name="name"></div></div><?php 
          }
        }  

        if(isset($_POST['update_category'])) {
          $name = escape($_POST['name']);
          $stmt = mysqli_prepare($connection, "UPDATE categories SET name = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, 'si', $name, $id);
          mysqli_stmt_execute($stmt);
          
          if(!$stmt) {
            die("Query failed: " . mysqli_error($connection));
          }

          mysqli_stmt_close($stmt);
          header("Location: categories.php");
        }
      ?>

  <div class="col-md-2">
    <div class="form-group">
      <input class="btn btn-warning" type="submit" name="update_category" value="Update">
      <button class="btn btn-default" name="update_category">Cancel</button>
    </div>
  </div>
</form>