<?php include "includes/admin_header.php"; ?>

<div id="wrapper">
  <?php include "includes/admin_navigation.php" ?>
        
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Admin Dashboard
            <span class="pull-right">User: 
              <strong>
                <a href="profile.php">
                  <?php 
                    if(isset($_SESSION['username'])) {
                      echo $_SESSION['username'];
                    }
                  ?>
                </a>
              </strong>
            </span>
          </h1>
        </div>
      </div>
                
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-green">
            <a href="articles.php">
              <div class="panel-heading panel-heading-green">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-file-text fa-5x"></i>
                  </div>
                      
                  <div class="col-xs-9 text-right"> 
                    <?php 
                      $query = "SELECT * FROM articles";
                      $select_all_articles = mysqli_query($connection, $query);
                      $articles_count = mysqli_num_rows($select_all_articles);
                      echo "<div class='huge'>{$articles_count}</div>"
                    ?>
                    <div>Articles</div>
                  </div>
                </div>
              </div>
            </a>

            <a href="articles.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="panel panel-red">
            <a href="categories.php">
              <div class="panel-heading panel-heading-red">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-list fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php 
                      $query = "SELECT * FROM categories";
                      $select_all_categories = mysqli_query($connection, $query);
                      $categories_count = mysqli_num_rows($select_all_categories);
                      echo "<div class='huge'>{$categories_count}</div>"
                    ?>
                    <div>Categories</div>
                  </div>
                </div>
              </div>
            </a>

            <a href="categories.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="panel panel-yellow">
            <a href="users.php">
              <div class="panel-heading panel-heading-yellow">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-user fa-5x"></i>
                  </div>

                  <div class="col-xs-9 text-right">
                    <?php 
                      $query = "SELECT * FROM users";
                      $select_all_users = mysqli_query($connection, $query);
                      $users_count = mysqli_num_rows($select_all_users);
                      echo "<div class='huge'>{$users_count}</div>"
                    ?>                
                    <div> Users</div>
                  </div>
                </div>
              </div>
            </a>

            <a href="users.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="panel panel-primary">
            <a href="comments.php">
              <div class="panel-heading panel-heading-blue">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>

                  <div class="col-xs-9 text-right">
                    <?php 
                      $query = "SELECT * FROM comments";
                      $select_all_comments = mysqli_query($connection, $query);
                      $comments_count = mysqli_num_rows( $select_all_comments);
                      echo "<div class='huge'>{$comments_count}</div>"
                    ?>
                    <div>Comments</div>
                  </div>
                </div>
              </div>
            </a>

            <a href="comments.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
      </div>                         
      <?php 
        $query = "SELECT * FROM articles WHERE status = 'published' ";
        $select_all_published_query = mysqli_query($connection, $query);
        $published_count = mysqli_num_rows($select_all_published_query);
                                                                                
        $query = "SELECT * FROM articles WHERE status = 'draft' ";
        $select_all_draft_query = mysqli_query($connection, $query);
        $draft_count = mysqli_num_rows($select_all_draft_query);

        $query = "SELECT * FROM comments WHERE status = 'approved' ";
        $approved_comments_query = mysqli_query($connection, $query);
        $approved_count = mysqli_num_rows($approved_comments_query);

        $query = "SELECT * FROM comments WHERE status = 'unapproved' ";
        $unapproved_comments_query = mysqli_query($connection, $query);
        $unapproved_count = mysqli_num_rows($unapproved_comments_query);

        $query = "SELECT * FROM users WHERE role = 'subscriber'";
        $select_all_subscribers_query = mysqli_query($connection, $query);
        $subscribers_count = mysqli_num_rows($select_all_subscribers_query);
      ?>
      <div class="row chart-box">       
        <script type="text/javascript">
          google.load("visualization", "1.1", {packages:["bar"]});
          google.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([['RockAltar Admin Data', 'Count'],
              <?php                     
                $element_text = ['All Articles','Active Articles','Draft Articles', 'Comments', 'Approved Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];       
                $element_count = [$articles_count, $published_count, $draft_count, $comments_count, $approved_count, $unapproved_count, $users_count, $subscribers_count, $categories_count];

                for($i = 0; $i < 9; $i++) {
                  echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                }                                            
              ?>
            ]);

            var options = {
              chart: {
                title: '',
                subtitle: ''
              },
              legend: { position: "none" },
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, options);
          }
        </script>
                               
        <div id="columnchart_material" style="width: 'auto'; height: 450px;"></div>   
      </div>
     </div>
    </div>
        
    <?php include "includes/admin_footer.php" ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
      $(document).ready(function(){
        var pusher =   new Pusher('5a3f3c2f772965086cb9', {
            cluster: 'us2',
            encrypted: true
        });

        var notificationChannel =  pusher.subscribe('notifications');
        notificationChannel.bind('new_user', function(notification){
          var message = notification.message;
          toastr.success(`${message} just registered`);
        });
      });
    </script>
