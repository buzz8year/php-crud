<?php

?>

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

<h3>Authentication</h3>

<div class="row">
	<div class="col-lg-6 col-md-12">
		<form action="<?= $data['form_action'] ?>" method="post">

			<div class="form-group">
				<input type="text" class="form-control" name="login" placeholder="Your email..." required>
			</div>

			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Task name..." required>
			</div>

			<br/><br/>

			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>

</body>
</html>


