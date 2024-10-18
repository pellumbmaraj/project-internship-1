<?php

	include "db_conn.php";
	include "php/helper.php";
	$books = get_books($conn);

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BookMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#">BookMaster</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" aria-current="page" href="index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="login.php">Login</a>
		      	</li>
		      	<li class="nav-item">
		          <a class="nav-link" href="#">About</a>
		      	</li>
		      	<li class="nav-item">
		          <a class="nav-link" href="#">Contact</a>
		      	</li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<?php if ($books == 0) {} else { ?>
		<h4 class="mt-5">All Books</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Author</th>
					<th>Description</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				foreach ($books as $book) { 
					$i++;

				?>
				<tr>
					<td><?=$i;?></td>
					<td>
						<img width="100" src="uploads/cover/<?=$book['cover']?>">
						<a class="link-dark d-block text-center" href="uploads/files/<?=$book['file']?>">
						<?=$book['title']?></a></td>
					<td><?php 
						$author = get_author($book['author_id'], $conn);
						if ($author == 0) {
							echo "Undefined";
						} else {
							echo $author['author'];
						}
					 ?></td>
					<td><?=$book['description']?></td>
					<td><?php 
						$category = get_category($book['category_id'], $conn);
						if ($category == 0) {
							echo "Undefined";
						} else {
							echo $category['name'];
						}
					 ?></td>
					<td>
						<button type="button" class="btn btn-success downloadBtn" id="downloadBtn">
						  Download
						</button>

						
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>
	</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="js/store.js"></script>

</body>
</html>