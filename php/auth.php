<?php
session_start();
	session_encode();

	function is_empty($var, $text, $location, $msg, $data) {
		if (empty($var)) {
			$err = "The ".$text." is required";
			header("Location: $location?$msg=$err&$data");
			exit;	
		}
		return 0;
	}

	include "../db_conn.php";

	if (isset($_POST['email']) && isset($_POST['password'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		$text = "email";
		$location = "../login.php";
		$msg = "error";
		is_empty($email, $text, $location, $msg, "");

		$text = "password";
		$location = "../login.php";
		$msg = "error";
		is_empty($password, $text, $location, $msg, "");

		$sql = "SELECT * FROM users WHERE email=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$email]);

		if ($stmt->rowCount() == 1) {
			$user = $stmt->fetch();

			$user_id = $user['id'];
			$user_fullname = $user['fullname'];
			$user_email = $user['email'];
			$user_password = $user['password'];

			if ($email === $user_email) {
				if (password_verify($password, $user_password)) {
					$_SESSION['user_id'] = $user_id;
					$_SESSION['user_fullname'] = $user_fullname;
					$_SESSION['user_email'] = $user_email;
					header("Location: ../admin.php");
				} else {
					$err = "Incorret credentials";
					header("Location: ../login.php?error=$err");
				}
			} else {
				$err = "Incorret credentials";
				header("Location: ../login.php?error=$err");
			}
			
		} else {
			$err = "Incorret credentials";
			header("Location: ../login.php?error=$err");
		}
	}
?>