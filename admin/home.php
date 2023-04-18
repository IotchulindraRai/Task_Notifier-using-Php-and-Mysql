<style>
  #system-cover{
    width:100%;
    height:45em;
    object-fit:cover;
    object-position:center center;
  }
  #today_task_card .product-info{
    margin-left:unset !important;
  }
</style>
<h1 class="">Welcome, <?php echo $_settings->userdata('firstname')." ".$_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 <?= ($_settings->userdata('type') == 1)? 'col-sm-4 col-md-4' : 'col-sm-6 col-md-6' ?>">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-sticky-note"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Active Task Reminders</span>
        <span class="info-box-number text-right h5">
          <?php 
            if($_settings->userdata('type') == 1){
              $active_reminders = $conn->query("SELECT * FROM `reminder_list` where `status` = 1")->num_rows;
            }else{
              $active_reminders = $conn->query("SELECT * FROM `reminder_list` where `status` = 1 and `user_id` = '{$_settings->userdata('id')}'")->num_rows;
            }
            echo format_num($active_reminders);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 <?= ($_settings->userdata('type') == 1)? 'col-sm-4 col-md-4' : 'col-sm-6 col-md-6' ?>">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-sticky-note"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Inactive Task Reminders</span>
        <span class="info-box-number text-right h5">
          <?php 
            if($_settings->userdata('type') == 1){
              $inactive_reminders = $conn->query("SELECT * FROM `reminder_list` where `status` = 0")->num_rows;
            }else{
              $inactive_reminders = $conn->query("SELECT * FROM `reminder_list` where `status` = 0 and `user_id` = '{$_settings->userdata('id')}'")->num_rows;
            }
            echo format_num($inactive_reminders);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <?php if($_settings->userdata('type') == 1): ?>
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Users</span>
        <span class="info-box-number text-right h5">
          <?php 
            $users = $conn->query("SELECT id FROM `users`")->num_rows;
            echo format_num($users);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <?php endif; ?>
</div>
<div class="container-fluid">
  <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 col-12 mx-auto">
    <div class="card" id="today_task_card">
      <div class="card-header">
        <h3 class="card-title">Your Today's Task(s)</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          <?php 
          $task_query = $conn->query("SELECT * FROM `reminder_list` where ('".date('Y-m-d')."' BETWEEN `remind_from` and `remind_to` OR `remind_from` = '".date('Y-m-d')."' OR `remind_to` = '".date('Y-m-d')."') and `user_id` = '{$_settings->userdata('id')}' and `status` = 1 ");
          if($task_query->num_rows > 0):
          while($row = $task_query->fetch_assoc()):
          ?>
          <li class="item">
            <div class="product-info">
              <a href="<?= base_url."admin/?page=reminders/view_reminder&id=". $row['id'] ?>" class="product-title"><?= $row['title'] ?></a>
              <span class="product-description">
                <p class="text-truncate"><?= $row['description'] ?></p>
              </span>
            </div>
          </li>
          <?php endwhile; ?>
          <?php else: ?>
            <li>
              <div class="text-muted text-center"><em>No Task Reminder Today.</em></div>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <!-- /.card-body -->
      <div class="card-footer text-center">
        <a href="<?= base_url.'admin/?page=reminders' ?>" class="uppercase">View All Task Reminders</a>
      </div>
      <!-- /.card-footer -->
    </div>
  </div>
</div>
