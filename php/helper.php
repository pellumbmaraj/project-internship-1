<?php 
	
	/*
		File to help with some basic functions.

	*/

	// Function to get the author of the book based on some id
	function get_author($id, $conn) {
		$sql = "SELECT * from authors WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$id]);

		if ($stmt->rowCount() == 1) {
			$author = $stmt->fetch();
		} else {
			$author = 0;
		}

		return $author;
	}

	// Function to get all the authors
	function get_authors($conn) {
		$sql = "SELECT * FROM authors ORDER BY id DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$authors = $stmt->fetchAll();
		} else {
			$authors = 0;
		}

		return $authors;
	}

	// Function to get the book based on some id
	function get_book($id, $conn) {
		$sql = "SELECT * FROM books WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$id]);

		if ($stmt->rowCount() > 0) {
			$book = $stmt->fetch();
		} else {
			$book = 0;
		}

		return $book;
	}

	// Function to get all the books from database
	function get_books($conn) {
		$sql = "SELECT * FROM books ORDER BY id DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$books = $stmt->fetchAll();
		} else {
			$books = 0;
		}

		return $books;
	}

	// Function to get all the categories
	function get_categories($conn) {
		$sql = "SELECT * FROM categories ORDER BY id DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$categories = $stmt->fetchAll();
		} else {
			$categories = 0;
		}

		return $categories;
	}

	// Function to get the category based on some id
	function get_category($id, $conn) {
		$sql = "SELECT * FROM categories WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$id]);

		if ($stmt->rowCount() > 0) {
			$catgegory = $stmt->fetch();
		} else {
			$category = 0;
		}

		return $catgegory;
	}

	function upload_files($files, $allowed_ext, $path) {
		$fname = $files['name'];
		$tmp_name = $files['tmp_name'];
		$ferror = $files['error'];

		if ($ferror === 0) {

			$file_ex = pathinfo($fname, PATHINFO_EXTENSION);
			$file_ex_lc = strtolower($file_ex);

			if (in_array($file_ex, $allowed_ext)) {
				$new_fname = uniqid("", true).'.'.$file_ex_lc;
				$file_upload_path = '../uploads/'.$path.'/'.$new_fname;
				move_uploaded_file($tmp_name, $file_upload_path);

				$scs['status'] = 'success';
				$scs['data'] = $new_fname;
				return $scs;

			} else {
				$err['status'] = 'error';
				$err['data'] = 'Unallowed file extention';
				return $err;
			}
		} else {
			$err['status'] = 'error';
			$err['data'] = 'Error occurred while uploading';
			return $err;
		}
	}

	function update_author($author, $conn) {
		$sql = "UPDATE ";
	}
?>