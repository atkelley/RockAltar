<div id="page-wrapper" class="page-wrapper-admin">
  <div class="container-fluid">
    <div class="row row-admin">
      <div class="col-lg-12">
        <h1 class="page-header">Admin Dashboard
          <span class="pull-right">User: 
            <strong>
              <a href="/admin/index.php?page=profile">
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
              
    <div class="row row-admin">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
          <a href="/admin/index.php?page=articles">
            <div class="panel-heading panel-heading-green">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-file-text fa-5x"></i>
                </div>      
                <div class="col-xs-9 text-right"> 
                  <div class='huge'><?php echo get_rows_count('articles'); ?></div><div>Articles</div>
                </div>
              </div>
            </div>
          </a>

          <a href="/admin/index.php?page=articles">
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
          <a href="/admin/index.php?page=categories">
            <div class="panel-heading panel-heading-red">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-list fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo get_rows_count('categories'); ?></div><div>Categories</div>
                </div>
              </div>
            </div>
          </a>

          <a href="/admin/index.php?page=categories">
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
          <a href="/admin/index.php?page=users">
            <div class="panel-heading panel-heading-yellow">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-user fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo get_rows_count('users'); ?></div><div>Users</div>
                </div>
              </div>
            </div>
          </a>

          <a href="/admin/index.php?page=users">
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
          <a href="/admin/index.php?page=comments">
            <div class="panel-heading panel-heading-blue">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-comments fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo get_rows_count('comments'); ?></div><div>Comments</div>
                </div>
              </div>
            </div>
          </a>

          <a href="/admin/index.php?page=comments">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div>   
    <?php include "./includes/components/chart.php"; ?>                      
  </div>
</div>