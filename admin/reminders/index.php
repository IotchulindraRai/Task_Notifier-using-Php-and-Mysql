<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Task Reminders</h3>
		<div class="card-tools">
			<a href="<?= base_url ?>admin/?page=reminders/manage_reminder" class="btn btn-flat btn-primary"><span class="fas fa-plus-square"></span>  Add New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<div class="table-responsive">
				<table class="table table-hover table-sm table-striped table-bordered" id="list">
					<colgroup>
						<?php if($_settings->userdata('type') == 1): ?>
							<col width="5%">
							<col width="15%">
							<col width="20%">
							<col width="20%">
							<col width="15%">
							<col width="15%">
							<col width="10%">
						<?php else: ?>
							<col width="5%">
							<col width="15%">
							<col width="30%">
							<col width="25%">
							<col width="15%">
							<col width="10%">
						<?php endif; ?>

						
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Date Created</th>
							<th>Title</th>
							<th>Schedule</th>
							<?php if($_settings->userdata('type') == 1): ?>
							<th>User</th>
							<?php endif; ?>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
							if($_settings->userdata('type') == 1){
								$sql = "SELECT *, COALESCE((SELECT CONCAT(`lastname`, ', ', `firstname`) FROM `users` where `users`.id = `reminder_list`.`user_id`) , 'User Does Not Exist') as user_fullname from `reminder_list` order by `title` asc ";
							}else{
								$sql = "SELECT * from `reminder_list` where `user_id` = '{$_settings->userdata('id')}' order by `title` asc ";
							}
							$qry = $conn->query($sql);
							while($row = $qry->fetch_assoc()):
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo date("Y-m-d g:i A",strtotime($row['created_at'])) ?></td>
								<td class=""><?= $row['title'] ?></td>
								<td>
									<?php 
										if(date("Y-m-d", strtotime($row['remind_from'])) == date("Y-m-d", strtotime($row['remind_to']))){
											echo date("M d,Y", strtotime($row['remind_from']));
										}elseif(date("Y-m", strtotime($row['remind_from'])) == date("Y-m", strtotime($row['remind_to']))){
											echo date("M d-", strtotime($row['remind_from'])).date(" d, Y", strtotime($row['remind_to']));
										}else{
											echo date("M d, Y", strtotime($row['remind_from'])).date(" - M d, Y", strtotime($row['remind_to']));
										}
									?>
								</td>
								<?php if($_settings->userdata('type') == 1): ?>
									<td><?= strtoupper($row['user_fullname']) ?></td>
								<?php endif; ?>
								<td class="text-center">
									<?php if($row['status'] == 1): ?>
										<span class="badge badge-success px-3 rounded-pill">Active</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
											Action
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item view-data" href="<?= base_url."admin/?page=reminders/view_reminder&id=".$row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item edit-data" href="<?= base_url."admin/?page=reminders/manage_reminder&id=".$row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Task Reminder permanently?","delete_reminder",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
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
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>