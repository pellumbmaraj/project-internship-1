<?php 
	session_start();

	if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

		include "db_conn.php";
		include "php/helper.php";

		$categories = get_categories($conn);
		$authors = get_authors($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Book</title>
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
		          <a class="nav-link active" href="add-book.php">Add Book</a>
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
		<form enctype="multipart/form-data" action="php/add.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
			<h1 class="text-center p-5 display-4 fs-3">
				Add New Book
			</h1>
			<?php
		  	if (isset($_GET['error'])) {
		  ?>
			  <div class="alert alert-danger" role="alert">
			  	<?=htmlspecialchars($_GET['error']);?>
				</div>
			<?php } else if (isset($_GET['success'])) {
				?>

				<div class="alert alert-success" role="alert">
				  <?=htmlspecialchars($_GET['success']);?>
				</div>

			<?php } ?>
			<div class="mb-3">
		    <label for="author-name" 
		    	   class="form-label">Book Title</label>
		    <input type="text" 
	    		   class="form-control" 
	    		   name="title"
	    		   id="title">
		  </div>
		  <div class="mb-3">
		    <label for="author-name" 
		    	   class="form-label">Book Description</label>
		    <input type="text" 
	    		   class="form-control" 
	    		   name="description"
	    		   id="description">
		  </div>
		  <div class="mb-3">
		    <label for="author-name" 
		    	   class="form-label">Author</label>
		    <select name="author" class="form-control">
	    		<option value="0">
	    			Select author
	    		</option>
	    		<?php 
	    			if ($authors == 0) {} else { 
	    			foreach($authors as $author) { ?>
	    				<option value=<?=$author['id'];?>>
			    			<?=$author['author'];?>
			    		</option>
	    		<?php }} ?>
	    	</select>
		  </div>
		  <div class="mb-3">
		    <label for="author-name" 
		    	   class="form-label">Book Category</label>
	    	<select name="category" class="form-control">
	    		<option value="0">
	    			Select category
	    		</option>
	    		<?php 
	    			if ($categories == 0) {} else { 
	    			foreach($categories as $category) { ?>
	    				<option value=<?=$category['id'];?>>
			    			<?=$category['name'];?>
			    		</option>
	    		<?php }} ?>
	    	</select>
		  </div>
		  <div class="mb-3">
		    <label for="author-name" 
		    	   class="form-label">Book Cover</label>
		    <input type="file" 
	    		   class="form-control" 
	    		   name="cover"
	    		   id="cover">
		  </div>
		  <div class="mb-3">
		    <label for="author-name" 
		    	   class="form-label">Book File</label>
		    <input type="file" 
	    		   class="form-control" 
	    		   name="file"
	    		   id="file">
		  </div>

		  <button type="submit" onclick="add_author()" class="btn btn-success">Add</button>
		</form>
	</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

<?php
	} else {
		header("Location: login.php");
		exit;
	}
?>