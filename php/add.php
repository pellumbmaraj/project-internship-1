<?php

	/**

		File to contain the add logic

	**/
	
	include "helper.php";
	include "../db_conn.php";	

	session_start();

	function is_empty($var, $text, $location, $msg, $data) {
		if (empty($var)) {
			$err = "The ".$text." is required";
			header("Location: $location?$msg=$err&$data");
			exit;	
		}
		return 0;
	}

	if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
		if (isset($_POST['author-name'])) {
			$name = $_POST['author-name'];
			if (empty($name)) {
				$err = "The author is required";
				header("Location: ../add-author.php?error=$err");
				exit;
			} else {
				$sql = "INSERT INTO authors (author) VALUES (?)";
				$stmt = $conn->prepare($sql);
				$res = $stmt->execute([$name]);

				if ($res) {
					$scs = "Sucessfully added";
					header("Location: ../add-author.php?success=$scs");
					exit;
				} else {
					$err = "Unknown error occurred";
					header("Location: ../add-author.php?error=$err");
					exit;
				}
			}
		} else if (isset($_POST['category-name'])) {
			$name = $_POST['category-name'];
			if (empty($name)) {
				$err = "The category is required";
				header("Location: ../add-category.php?error=$err");
				exit;
			} else {
				$sql = "INSERT INTO categories (name) VALUES (?)";
				$stmt = $conn->prepare($sql);
				$res = $stmt->execute([$name]);

				if ($res) {
					$scs = "Sucessfully added";
					header("Location: ../add-category.php?success=$scs");
					exit;
				} else {
					$err = "Unknown error occurred";
					header("Location: ../add-category.php?error=$err");
					exit;
				}
			}		
		} else if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['author']) && isset($_POST['category']) && isset($_FILES['cover']) && isset($_FILES['file'])) {
			
			$title = $_POST['title'];
			$description = $_POST['description'];
			$author = $_POST['author'];
			$category = $_POST['category'];

			$user_input = 'title='.$title.'&category='.$category.'&desc='.$description;

			$text = "book title";
			$location = "../add-book.php";
			$msg = "error";
			is_empty($title, $text, $location, $msg, $user_input);

			$text = "book description";
			$location = "../add-book.php";
			$msg = "error";
			is_empty($description, $text, $location, $msg, $user_input);

			$text = "book author";
			$location = "../add-book.php";
			$msg = "error";
			is_empty($author, $text, $location, $msg, $user_input);

			$text = "book category";
			$location = "../add-book.php";
			$msg = "error";
			is_empty($category, $text, $location, $msg, $user_input);

			echo $author;

			$allowed_ext = array("jpg", "jpeg", "png");
			$path = "cover";
			$cover_upload = upload_files($_FILES['cover'], $allowed_ext, $path);

			if ($cover_upload['status'] == "error") {
				$err = $cover_upload['data'];
				header("Location: ../add-book.php?error=$err&$user_input");
				exit;
			} else {
				$allowed_ext = array("pdf", "docx", "pptx");
				$path = "files";
				$file_upload = upload_files($_FILES['file'], $allowed_ext, $path);

				if ($file_upload['status'] == "error") {
					$err = $file_upload['data'];
					header("Location: ../add-book.php?error=$err&$user_input");
					exit;
				} else {
					$file_url = $file_upload['data'];
					$cover_url = $cover_upload['data'];

					$sql = "INSERT INTO books (title, author_id, description, category_id, cover, file) VALUES (?,?,?,?,?,?)";
					$stmt = $conn->prepare($sql);
					$res = $stmt->execute([$title, $author, $description, $category, $cover_url, $file_url]);

					if ($res) {
						$scs = "Sucessfully added";
						header("Location: ../add-book.php?success=$scs");
						exit;
					} else {
						$err = "Unknown error occurred";
						header("Location: ../add-book.php?error=$err");
						exit;
					}
					
				}
				
			}

		} else {
			header("Location: ../admin.php");
			exit;
		}
	} else {
		header("Location: ../login.php");
		exit;
	}

?>