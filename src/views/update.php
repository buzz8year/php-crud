<!DOCTYPE html>
<html>
<head>
	<title>Taskboard</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body style="padding: 60px">

<a class="btn btn-default" href="<?= $data['basepath'] ?>">Backhome</a><br/><br/>

<?php if ($data['message']) : ?>
	<pre><?= $data['message'] ?></pre>
<?php endif; ?>

<br/><br/>

<h3>Task editing</h3>

<div class="row">
	<div class="col-lg-6 col-md-12">
		<form action="<?= $data['form_action'] ?>" method="post">

			<div class="form-group">
				<input type="hidden" name="task_id" value="<?= ($data['task'])->getId() ?>" >
				<input type="email" class="form-control" name="task_usermail" id="task-usermail" placeholder="Your email..." required value="<?= ($data['task'])->getUserEmail() ?>" >
			</div>

			<div class="form-group">
				<input type="text" class="form-control" name="task_name" id="task-name" placeholder="Task name..." value="<?= ($data['task'])->getName() ?>" >
			</div>

			<div class="form-group">
				<textarea class="form-control" rows="5" name="task_text" id="task-text" placeholder="Task summary..."><?= htmlspecialchars_decode(($data['task'])->getText()) ?></textarea>
			</div>

			<br/><br/>

			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>




<script type="text/javascript">

$(document).ready(function(){
	setTimeout(function(){
		$('.flash-message').fadeOut(2000);
	}, 4000);
});

</script>



</body>
</html>


