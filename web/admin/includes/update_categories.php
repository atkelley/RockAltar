<form action="" method="post" id="category-update-box">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <?php
          if(isset($_GET['edit'])){
            $id = escape($_GET['edit']);
            $query = "SELECT * FROM categories WHERE id = $id ";
            $select_categories_id = mysqli_query($connection, $query);  

            while($row = mysqli_fetch_assoc($select_categories_id)) {
              $id = $row['id'];
              $name = $row['name'];        
              ?><input value="<?php echo $name; ?>" type="text" class="form-control" name="name"><?php 
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
            redirect("categories.php"); 
          }
        ?>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <input class="btn btn-warning" type="submit" name="update_category" value="Update">
        <button class="btn btn-default">Cancel</button>
      </div>
    </div>
  </div>
</form>

<script>
  $("button").click(function(){
    $("#category-update-box").empty();
  });
</script>