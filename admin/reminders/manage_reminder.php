<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `reminder_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="pt-2 pb-5 px-2 bg-navy">
	<h3 class="text-center"><b><?= isset($id) ? "Update Task Reminder Details" : "Add New Task Reminder" ?></b></h3>
</div>
<div class="card card-outline rounded-0 mt-n4 col-lg-7 col-md-8 col-sm-12 col-xs-12 col-12 mx-auto">
	<div class="card-body">
        <div class="container-fluid">
			<form action="" id="reminder-form">
				<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
				<?php if($_settings->userdata('type') == 1): ?>
				<div class="form-group">
					<label for="user_id" class="control-label">User</label>
					<select type="text" name="user_id" id="user_id" class="form-control form-control-sm rounded-0" required>
						<option value="" <?= !isset($user_id) ? "seleted" : "" ?> disabled></option>
						<?php 
						$user_qry = $conn->query('SELECT * FROM `users` ORDER BY CONCAT(`lastname`,`firstname`,`middlename`) asc');
						while($row=$user_qry->fetch_assoc()):
						?>
						<option value="<?= $row['id'] ?>" <?= (isset($user_id) && $user_id == $row['id']) ? "selected" : ""  ?>><?= ucwords($row['lastname']. ' ' . $row['firstname']. " ". $row['middlename']) ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<?php else: ?>
					<input type="hidden" name="user_id" value="<?= $_settings->userdata('id') ?>">
				<?php endif; ?>
				<div class="form-group">
					<label for="title" class="control-label">Title</label>
					<input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" value="<?php echo $title ?? ''; ?>" autofocus required/>
				</div>
				<div class="form-group">
					<label for="description" class="control-label">Short Description</label>
					<textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo $description ?? ''; ?></textarea>
				</div>
				<div class="form-group">
					<label for="remind_from" class="control-label">Remind From</label>
					<input type="date" max="<?= isset($remind_to)? date("Y-m-d", strtotime($remind_to)) : "" ?>" name="remind_from" id="remind_from" class="form-control form-control-sm rounded-0" value="<?php echo $remind_from ?? "" ?>"  required/>
				</div>
				<div class="form-group">
					<label for="remind_to" class="control-label">Remind To</label>
					<input type="date" min="<?= isset($remind_from)? date("Y-m-d", strtotime($remind_from)) : "" ?>" name="remind_to" id="remind_to" class="form-control form-control-sm rounded-0" value="<?php echo $remind_to ?? "" ?>"  required/>
				</div>
				<div class="form-group">
					<label for="status" class="control-label">Status</label>
					<select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
						<option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
						<option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
					</select>
				</div>
				<div class="form-group">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-5 col-sm-12 m-1">
							<button class="btn btn-primary rounded-pill w-100">Save Data</button>
						</div>
						<div class="col-lg-4 col-md-5 col-sm-12 m-1">
							<?php if(!isset($id)): ?>
								<a href="<?= base_url."admin/?page=reminders" ?>" class="btn btn-secondary rounded-pill w-100">Cancel</a>
							<?php else: ?>
								<a href="<?= base_url."admin/?page=reminders/view_reminder&id=".$id ?>" class="btn btn-secondary rounded-pill w-100">Cancel</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		if($('select#user_id').length > 0){
			$('#user_id').select2({
				placeholder:"Please select User here",
				width: '100%',
				containerCssClass: 'rounded-0'
			})
		}
		$('#remind_from, #remind_to').change(function(){
			var from = $('#remind_from').val()
			var to = $('#remind_to').val()
			$('#remind_from').attr("max", to)
			$('#remind_to').attr("min", from)
		})
		$('#reminder-form').submit(function(e){
			e.preventDefault()
			var _this = $(this)
			var el = $('<div>')
				el.addClass('alert alert p-1 rounded-0')
				el.hide()
			start_loader()
			$.ajax({
				url: '<?= base_url ?>classes/Master.php?f=save_reminder',
				method:'POST',
				data: $(this).serialize(),
				dataType:'JSON',
				error: err=>{
					el.text('An error occurred while saving the data. Kindly refresh the page and redo your action.')
					_this.prepend(el)
					el.show('slideDown')
					end_loader()
					console.error(err)
				},
				success:function(resp){
					if(resp.status == 'success'){
						location.replace('<?= base_url."admin/?page=reminders/view_reminder&id=" ?>'+ resp.id)
						return false;
					}else{
						el.text('An error occurred while saving the data. Kindly refresh the page and redo your action.')
						_this.prepend(el)
						el.show('slideDown')
						console.error(resp)
					}
					end_loader()
				}
			})
		})
	})
</script>