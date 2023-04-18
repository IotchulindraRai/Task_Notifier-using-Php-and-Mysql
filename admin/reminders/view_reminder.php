<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *, COALESCE((SELECT CONCAT(`lastname`, ', ', `firstname`) FROM `users` where `users`.id = `reminder_list`.`user_id`) , 'User Does Not Exist') as user_fullname from `reminder_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="pt-2 pb-5 px-2 bg-navy">
	<h3 class="text-center"><b>Task Reminder Details</b></h3>
</div>
<div class="card card-outline rounded-0 mt-n4 col-lg-7 col-md-8 col-sm-12 col-xs-12 col-12 mx-auto">
	<div class="card-body">
        <div class="container-fluid">
			<div class="card rounded-0 card-outline card-navy shadow mb-3">
				<div class="card-header rounded-0">
					<div class="card-title"><b><?= $title ?? "" ?></b></div>
				</div>
				<div class="card-body rounded-0">
					<div class="container-fluid">
						<div><?= $description ?? "" ?></div>
					</div>
				</div>
			</div>
			<dl>
				<dt>Task Reminder Schedule</dt>
				<?php if(isset($remind_from) && isset($remind_to)): ?>
					<dd class="pl-4">
						<?php 
							if(date("Y-m-d", strtotime($remind_from)) == date("Y-m-d", strtotime($remind_to))){
								echo date("M d,Y", strtotime($remind_from));
							}elseif(date("Y-m", strtotime($remind_from)) == date("Y-m", strtotime($remind_to))){
								echo date("M d-", strtotime($remind_from)).date(" d, Y", strtotime($remind_to));
							}else{
								echo date("M d, Y", strtotime($remind_from)).date(" - M d, Y", strtotime($remind_to));
							}
						?>
					</dd>
				<?php endif; ?>
				<?php if($_settings->userdata('type') == 1 && isset($user_id)): ?>
					<dt><b>User to Remind</b></dt>
					<dd class="pl-4"><?= ucwords($user_fullname ?? "N/A") ?></dd>
				<?php endif; ?>
				<?php if(isset($status)): ?>
					<dt><b>Status</b></dt>
					<dd class="pl-4">
						<?php if($status == 1): ?>
							<span class="badge badge-success px-3 rounded-pill">Active</span>
						<?php else: ?>
							<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
						<?php endif; ?>
					</dd>
				<?php endif; ?>
			</dl>
		</div>
	</div>
	<div class="card-footer py-2">
		<div class="row align-items-center justify-content-center">
			<div class="col-lg-3 col-md-3 col-sm-6 m-1">
				<a href="<?= base_url."admin/?page=reminders/manage_reminder&id=".($id ?? '') ?>" class="btn btn-primary rounded-pill w-100"><i class="fa fa-edit"></i> Edit</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 m-1">
				<button type="button" data-id="<?= $id ?? "" ?>" class="btn btn-danger rounded-pill w-100" id="delete_data"><i class="fa fa-trash"></i> Delete</button>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 m-1">
				<a href="<?= base_url."admin/?page=reminders" ?>" class="btn btn-secondary rounded-pill w-100"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<script>
	function delete_reminder($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_reminder",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('<?= base_url."admin/?page=reminders" ?>');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	$(document).ready(function(){
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this Task Reminder permanently?","delete_reminder",[$(this).attr('data-id')])
		})
	})
</script>