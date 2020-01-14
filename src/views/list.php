<!DOCTYPE html>
<html>
<head>
	<title>Taskboard</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body style="padding: 60px">

<a class="btn btn-default pull-right" href="<?= $data['current_path'] ?>/create">+ Create New</a>
<a class="btn btn-default" href="<?= $data['current_path'] ?>">Backhome</a>

<a class="btn btn-default" href="<?= $data['base_path'] ?>?r=auth/log<?= $data['inout_string'] ?>">Sign <?= $data['inout_string'] ?></a>

<br/><br/>

<div style="height:60px">
	<?php if ($data['message']) : ?>
		<pre class="flash-message"><?= $data['message'] ?></pre>
	<?php endif; ?>
</div>

<br/><br/>

<table class="table table-striped table-bordered">

	<thead>
		<tr>
			<th>
				<a href="<?= $data['current_path'] ?>&sort=<?= $data['sort_invert'] ?>id">
					ID <?php if ($data['sort'] == 'id') echo ($data['sort_invert'] ? '&#8675;' : '&#8673;'); ?>
				</a>
			</th>
			<th>
				<a href="<?= $data['current_path'] ?>&sort=<?= $data['sort_invert'] ?>name">
					Name <?php if ($data['sort'] == 'name') echo ($data['sort_invert'] ? '&#8675;' : '&#8673;'); ?>
				</a>
			</th>
			<th>
				<a href="<?= $data['current_path'] ?>&sort=<?= $data['sort_invert'] ?>user_email">
					Email <?php if ($data['sort'] == 'user_email') echo ($data['sort_invert'] ? '&#8675;' : '&#8673;'); ?>
				</a>
			</th>
			<th>Text</th>
			<th>
				<a href="<?= $data['current_path'] ?>&sort=<?= $data['sort_invert'] ?>status">
					State <?php if ($data['sort'] == 'status') echo ($data['sort_invert'] ? '&#8675;' : '&#8673;'); ?>
				</a>
			</th>
			<th>Edit</th>
		</tr>
	</thead>

	<tbody>
	<?php if (isset($data['tasks']) && sizeof($data['tasks'])) : ?>
		<?php foreach ($data['tasks'] as $key => $task) : ?>

			<tr>
				<td><?= $task->getId() ?></td>
				<td><?= $task->getName() ?></td>
				<td><?= $task->getUserEmail() ?></td>
				<td>
					<?php 
						// WARNING: As to xss-potential text, - htmlspecialchars() is obligatory!
						print htmlspecialchars($task->getText());
					?>
				</td>


				<td class="text-primary">

					<?php if ($task->getStatus() === 1) : ?>

						<i class="glyphicon glyphicon-time"></i>
						<span class="change-status" data-id="<?= $task->getId() ?>" title="Mark as completed" style="cursor:pointer"> in progress </span>

					<?php elseif ($task->getStatus() === 2) : ?>

						<i class="glyphicon glyphicon-ok"></i>
						<span>completed</span>

					<?php endif; ?>

				</td>

				<td>
					<a href="<?= $data['current_path'] ?>/update&id=<?= $task->getId() ?>"> Edit <?php if ($task->getEdited() === 1) print '(edited by admin)'; ?></a>
				</td>

			</tr>

		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>

</table>

<ul class="pagination">

	<?php for ($i = 1; $i <= $data['pages']; $i++) : ?>
		<?php if ($i == $data['page']) : ?>
			<li class="active">
				<a><?= $i ?></a>
			</li>
		<?php else : ?>
			<li>
				<a href="<?= $data['current_path'] ?>&page=<?= $i ?>"><?= $i ?></a>
			</li>
		<?php endif; ?>
	<?php endfor; ?>

</ul>





<script type="text/javascript">
$(document).on('click', '.change-status', function(){
	if ( confirm('Sure to set task status \'Completed\'?') ) 
	{ 
		var id = $(this).attr('data-id');
		$.ajax({
            url: '<?= $data['current_path'] ?>/finalize',
            data: { id: id },
            method: 'post',
            success: function(data){
                location.reload();
            },			
		});
	}
});
$(document).ready(function(){
	setTimeout(function(){
		$('.flash-message').fadeOut(2000);
	}, 4000);
});
</script>




</body>
</html>