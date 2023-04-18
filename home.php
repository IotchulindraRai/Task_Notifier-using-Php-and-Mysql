<h3 class="text-center"><b>Today's Task Reminders</b></h3>
<hr class="mx-auto border-dark bg-opacity-100 my-2" style="width:50px; border-width:3px;">
<?php 
$task_query = $conn->query("SELECT *, COALESCE((SELECT CONCAT(`lastname`, ', ', `firstname`) FROM `users` where `users`.id = `reminder_list`.`user_id`) , 'User Does Not Exist') as user_fullname FROM `reminder_list` where ('".date('Y-m-d')."' BETWEEN `remind_from` and `remind_to` OR `remind_from` = '".date('Y-m-d')."' OR `remind_to` = '".date('Y-m-d')."') and `status` = 1 ");
if($task_query->num_rows > 0):
    $i=1;
?>
<div id="taskSlider">
    <div class="reminders">
    <?php while($row = $task_query->fetch_assoc()): ?>
        <div class="p-1 w-100 reminders-item <?= $i == 1 ? "active" : "" ?>">
            <div class="card rounded-0 card-outline card-navy">
                <div class="card-header rounded-0">
                    <div class="card-title"><b><?= $row['user_fullname'] ?></b></div>
                </div>
                <div class="card-body rounded-0">
                    <div class="container-fluid">
                        <h3 class="text-center"><b><?= $row['title'] ?></b></h3>
                        <div class="truncate-3"><?= $row['description'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php $i++; ?>
    <?php endwhile; ?>
    </div>
</div>
<?php else: ?>
    <div class="text-center text-muted">No Task Reminder Today</div>
<?php endif; ?>
