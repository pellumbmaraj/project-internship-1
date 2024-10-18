<?php 
	session_start();

	if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

		include "db_conn.php";
		include "php/helper.php";
		$books = get_books($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BookMaster ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="admin.php">BookMaster</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" aria-current="page" href="index.php">Store</a>
		        </li>
		      	<li class="nav-item">
		          <a class="nav-link" href="add-book.php">Add Book</a>
		      	</li>
		      	<li class="nav-item">
		          <a class="nav-link" href="add-category.php">Add Category</a>
		      	</li>
		      	<li class="nav-item">
		          <a class="nav-link" href="add-author.php">Add Author</a>
		      	</li>
		      	<li class="nav-item">
		          <a class="nav-link" href="logout.php">Logout</a>
		      	</li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<div id="alertBox" class="alert" style="display: none;" role="alert"></div>
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
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning button-book" data-bs-toggle="modal" data-bs-target="#staticBackdropEditBook">
						  Edit
						</button>

						<!-- Modal -->
						<div class="modal fade" id="staticBackdropEditBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h1 class="modal-title fs-5" id="staticBackdropLabel">Editing Book</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        <div class="mb-3">
									    <input type="text" 
									    			 class="form-control" 
									    			 name="newTitle" 
									    			 id="newTitle"
									    			 placeholder="Enter the new title">
									  </div>
									  <div class="mb-3">
									    <input type="text" 
									    			 class="form-control" 
									    			 name="newAuthor" 
									    			 id="newAuthor"
									    			 placeholder="Enter the new author">
									  </div>
									  <div class="mb-3">
									    <input type="text" 
									    			 class="form-control" 
									    			 name="newDesc" 
									    			 id="newDesc"
									    			 placeholder="Enter the new description">
									  </div>
									  <div class="mb-3">
									    <input type="text" 
									    			 class="form-control" 
									    			 name="newCategory" 
									    			 id="newCategory"
									    			 placeholder="Enter the new category">
									  </div>
									  <div class="mb-3">
									  	<label for="cover" 
		    	   								 class="form-label">New Book Cover</label>
									    <input type="file" 
									    			 class="form-control" 
									    			 name="cover" 
									    			 id="cover">
									  </div>
									  <div class="mb-3">
									    <label for="file" 
		    	   								 class="form-label">New Book File</label>
									    <input type="file" 
									    			 class="form-control" 
									    			 name="file" 
									    			 id="file">
									  </div>						      
									</div>
						      <div class="modal-footer">
						        <button type="button" id="btnCancelEditBook" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						        <button type="button" id="btnApproveEditBook" class="btn btn-primary">Approve</button>
						      </div>
						    </div>
						  </div>
						</div>

						<!-- Button trigger modal -->
						<button type="button" class="btn btn-danger button-book" data-bs-toggle="modal" data-bs-target="#staticBackdropDeleteBook">
						  Delete
						</button>

						<!-- Modal -->
						<div class="modal fade" id="staticBackdropDeleteBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h1 class="modal-title fs-5" id="staticBackdropLabel">Deleting Book</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        <div class="alert alert-danger" role="alert">
						        	Are you sure you want to do this?
										</div>						      </div>
						      <div class="modal-footer">
						        <button type="button" id="btnCancelDeleteBook" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						        <button type="button" id="btnApproveDeleteBook" class="btn btn-primary">Approve</button>
						      </div>
						    </div>
						  </div>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>

		<?php 
		$categories = get_categories($conn);
		if ($categories == 0) {} else { ?>
		<h4 class="mt-5">All Categories</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				foreach ($categories as $category) { 
					$i++;

				?>
				<tr>
					<td><?=$i;?></td>
					<td><?=$category['name'];?></td>
					<td>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning button-category" data-bs-toggle="modal" data-bs-target="#staticBackdropEditCategory">
						  Edit
						</button>

						<!-- Modal -->
						<div class="modal fade" id="staticBackdropEditCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h1 class="modal-title fs-5" id="staticBackdropLabel">Editing Category</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        <div class="mb-3">
									    <input type="text" 
									    			 class="form-control" 
									    			 name="newCategoryCat" 
									    			 id="newCategoryCat"
									    			 placeholder="Enter the new category">
									  </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" id="btnCancelEditCategory" class="btn btn-secondary cancel" data-bs-dismiss="modal">Cancel</button>
						        <button type="button" id="btnApproveEditCategory" class="btn btn-primary continue">Approve</button>
						      </div>
						    </div>
						  </div>
						</div>

						<!-- Button trigger modal -->
						<button type="button" class="btn btn-danger button-category" data-bs-toggle="modal" data-bs-target="#staticBackdropDeleteCategory">
						  Delete
						</button>

						<!-- Modal -->
						<div class="modal fade" id="staticBackdropDeleteCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h1 class="modal-title fs-5" id="staticBackdropLabel">Deleting Category</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        <div class="alert alert-danger" role="alert">
						        	Are you sure you want to do this?
										</div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" id="btnCancelDeleteCategory" class="btn btn-secondary cancel" data-bs-dismiss="modal">Cancel</button>
						        <button type="button" id="btnApproveDeleteCategory" class="btn btn-primary continue">Approve</button>
						      </div>
						    </div>
						  </div>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>

		<?php 
		$authors = get_authors($conn);
		if ($authors == 0) {} else { ?>
		<h4 class="mt-5">All Authors</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Author</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				foreach ($authors as $author) { 
					$i++;

				?>
				<tr id=<?="author-table-row-".$i?>>
					<td id=<?="author-table-data-number-".$i?>><?=$i;?></td>
					<td><?=$author['author'];?></td>
					<td>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-warning button-author" data-bs-toggle="modal" data-bs-target="#staticBackdropEditAuthor">
						  Edit
						</button>

						<!-- Modal -->
						<div class="modal fade" id="staticBackdropEditAuthor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h1 class="modal-title fs-5" id="staticBackdropLabel">Editing Category</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
								    <input type="text" 
								    			 class="form-control" 
								    			 name="authorNameAuth"
								    			 id="authorNameAuth" 
								    			 placeholder="Enter new author name">
						      </div>
						      <div class="modal-footer">
						        <button type="button" id="btnCancelEditAuthor" class="btn btn-secondary cancel" data-bs-dismiss="modal">Cancel</button>
						        <button type="button" id="btnApproveEditAuthor" class="btn btn-primary continue">Approve</button>
						      </div>
						    </div>
						  </div>
						</div>

						<!-- Button trigger modal -->
						<button type="button" class="btn btn-danger button-author" data-bs-toggle="modal" data-bs-target="#staticBackdropDeleteAuthor">
						  Delete
						</button>

						<!-- Modal -->
						<div class="modal fade" id="staticBackdropDeleteAuthor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h1 class="modal-title fs-5" id="staticBackdropLabel">Deleting Author</h1>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-body">
						        <div class="alert alert-danger" role="alert">
						        	Are you sure you want to do this?
										</div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" id="btnCancelDeleteAuthor" class="btn btn-secondary cancel" data-bs-dismiss="modal">Cancel</button>
						        <button type="button" id="btnApproveDeleteAuthor" class="btn btn-primary continue">Approve</button>
						      </div>
						    </div>
						  </div>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>
	</div>
    

  <script src="js/main.js" type="module"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
	} else {
		header("Location: login.php");
		exit;
	}
?>