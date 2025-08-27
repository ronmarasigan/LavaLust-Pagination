<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
	<div class="container mt-3 ">
	<form action="<?=site_url('author');?>" method="get" class="col-sm-4 float-end d-flex">
		<?php
		$q = '';
		if(isset($_GET['q'])) {
			$q = $_GET['q'];
		}
		?>
        <input class="form-control me-2" name="q" type="text" placeholder="Search" value="<?=html_escape($q);?>">
        <button type="submit" class="btn btn-primary" type="button">Search</button>
	</form>
	<h2>Author Lists</h2>
	<table class="table table-striped">
		<thead>
		<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Email</th>
			<th>Birthdate</th>
			<th>Added</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach(html_escape($all) as $author): ?>
		<tr>
			<td><?=$author['first_name'];?></td>
			<td><?=$author['last_name'];?></td>
			<td>j<?=$author['email'];?></td>
			<td><?=$author['birthdate'];?></td>
			<td><?=$author['added'];?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php
	echo $page;?>
	</div>
</body>
</html>