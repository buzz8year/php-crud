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

<h3>New task creation</h3>

<div class="row">
	<div class="col-lg-6 col-md-12">
		<form action="<?= $data['form_action'] ?>" method="post">

			<div class="form-group">
				<input type="text" class="form-control" name="task_usermail" placeholder="Your email..." required>
			</div>

			<div class="form-group">
				<input type="text" class="form-control" name="task_name" placeholder="Task name...">
			</div>

			<div class="form-group">
				<textarea class="form-control" rows="5" name="task_text" placeholder="Task summary..."></textarea>
			</div>

			<br/><br/>

			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>

</body>
</html>


