<?php
    
    // Set the header to allow JSON responseponse
    header('Content-Type: application/json');
    include 'db_conn.php';
    include 'php/helper.php';

    $response = array();

    if (isset($_POST['option'])) {

      if ($_POST['option'] == 'author') {
        if ($_POST['action'] == 'edit') {

          $old_author = $_POST['old_author'];
          $new_author = $_POST['new_author'];

          $sql = "UPDATE authors SET author=?  WHERE author=?";
          $stmt = $conn->prepare($sql);
          if ($stmt->execute([$new_author, $old_author])) {
            
            $response['status'] = 'success';
            $response['message'] = 'Updated successfully';
            echo json_encode($response);
          
          } else {

            $response['status'] = 'error';
            $response['message'] = 'Unknown error occurred';
            echo json_encode($response);

          }

        } else if ($_POST['action'] == 'delete') {
          
          $author = $_POST['old_author'];

          $sql = "SELECT * FROM authors WHERE author=?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$author]);

          if ($stmt->rowCount() == 1) {
            $id = $stmt->fetch();

            $sql = "DELETE FROM authors WHERE author=?";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([$author])) {

              $sql = "UPDATE books SET author_id=0 WHERE author_id=?";
              $stmt = $conn->prepare($sql);

              if ($stmt->execute([$id['id']])) {
                $response['status'] = 'success';
                $response['message'] = 'Deleted successfully';
                echo json_encode($response);
              } else {
                $response['status'] = 'error';
                $response['message'] = 'Unknown error occurred';
                echo json_encode($response);
              }
            
            } else {

              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);

            }
          } else {
            $response['status'] = 'error';
            $response['message'] = 'Unknown error occurred';
            echo json_encode($response);
          }

        }

      } else if ($_POST['option'] == 'category') {
        
        if ($_POST['action'] == 'edit') {

          $old_category = $_POST['old_category'];
          $new_category = $_POST['new_category'];

          $sql = "UPDATE categories SET name=?  WHERE name=?";
          $stmt = $conn->prepare($sql);
          if ($stmt->execute([$new_category, $old_category])) {
            
            $response['status'] = 'success';
            $response['message'] = 'Updated successfully';
            echo json_encode($response);
          
          } else {

            $response['status'] = 'error';
            $response['message'] = 'Unknown error occurred';
            echo json_encode($response);

          }

        } else if ($_POST['action'] == 'delete') {
          
          $category = $_POST['old_category'];

          $sql = "SELECT * FROM categories WHERE name=?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$category]);

          if ($stmt->rowCount() == 1) {
            $id = $stmt->fetch();

            $sql = "DELETE FROM categories WHERE name=?";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([$category])) {

              $sql = "UPDATE books SET category_id=0 WHERE category_id=?";
              $stmt = $conn->prepare($sql);

              if ($stmt->execute([$id['id']])) {
                $response['status'] = 'success';
                $response['message'] = 'Deleted successfully';
                echo json_encode($response);
              } else {
                $response['status'] = 'error';
                $response['message'] = 'Unknown error occurred';
                echo json_encode($response);
              }
            
            } else {

              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);

            }
          } else {
            $response['status'] = 'error';
            $response['message'] = 'Unknown error occurred';
            echo json_encode($response);
          }

        }

      } else if ($_POST['option'] == 'book') {
        
        $old_title = $_POST['old_title'];
        $old_author = $_POST['old_author'];
        $old_desc = $_POST['old_desc'];
        $old_category = $_POST['old_category'];
        $old_image = $_POST['old_image'];
        $old_file = $_POST['old_file'];

        $sql = "SELECT * FROM books WHERE title=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$old_title]);

        $book_id = $stmt->fetch()['id'];

        if ($_POST['action'] == 'edit') {
          $status = 0;

          if (isset($_POST['new_title'])) {
            $new_title = $_POST['new_title'];
            $sql = "UPDATE books SET title=? WHERE title=?";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$new_title, $old_title])) {
              $status = 1;
            } else {
              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);
            }
          } 

          if (isset($_POST['new_author'])) {
            $new_author = $_POST['new_author'];

            $sql = "SELECT * FROM authors WHERE author=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_author]);

            if ($stmt->rowCount == 1) {
              $new_aid = $stmt->fetch()['id'];
            } else {
              $sql = "INSERT INTO authors (author) VALUES (?)";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$new_author]);

              $sql = "SELECT * FROM authors WHERE author=?";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$new_author]);
              $new_aid = $stmt->fetch()['id'];
            }

            $sql = "UPDATE books SET author_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([$new_aid, $book_id])) {
              $status = 1;
            } else {
              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);
            }

          }

          if (isset($_POST['new_desc'])) {
            $new_desc = $_POST['new_desc'];
            $sql = "UPDATE books SET description=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$new_desc, $book_id])) {
              
            } else {
              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);
            }
          }

          if (isset($_POST['new_category'])) {
            $new_category = $_POST['new_category'];

            $sql = "SELECT * FROM categories WHERE name=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_category]);

            if ($stmt->rowCount == 1) {
              $new_cid = $stmt->fetch()['id'];
            } else {
              $sql = "INSERT INTO categories (name) VALUES (?)";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$new_category]);

              $sql = "SELECT * FROM categories WHERE name=?";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$new_category]);
              $new_cid = $stmt->fetch()['id'];
            }

            $sql = "UPDATE books SET category_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([$new_cid, $book_id])) {
              $status = 1;
            } else {
              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);
            }
          }

          if (isset($_FILES['new_image'])) {

            $allowed_ext_img = array("jpg", "jpeg", "png");
            unlink("uploads/files/".$old_file);
            $image = upload_files($_FILES['new_image'], $allowed_ext_img, "cover");
            $image_name = $image['data'];

            $sql = "UPDATE books SET cover=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$image_name, $book_id])) {
              $status = 1;
            } else {
              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);
            }
          }

          if (isset($_FILES['new_file'])) {

            $allowed_ext_img = array("jpg", "jpeg", "png");
            unlink("uploads/files/".$old_file);
            $file = upload_files($_FILES['new_file'], $allowed_ext_file, "files");
            $file_name = $file['data'];

            $sql = "UPDATE books SET file=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$file_name, $book_id])) {
              $status = 1;
            } else {
              $response['status'] = 'error';
              $response['message'] = 'Unknown error occurred';
              echo json_encode($response);
            }
          }

          if ($status == 1) {
            $response['status'] = 'success';
            $response['message'] = 'Updated successfully';
            echo json_encode($response);
          }

        } else if ($_POST['action'] == 'delete') {

          $sql = "SELECT * from authors WHERE author=?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$old_author]);
          $author_id = $stmt->fetch()['id'];

          $sql = "SELECT * from categories WHERE name=?";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$old_category]);
          $category_id = $stmt->fetch()['id'];

          $sql = "DELETE FROM books WHERE title=? AND author_id=? AND description=? AND category_id=? AND cover=? AND file=?";
          $stmt = $conn->prepare($sql);

          if ($stmt->execute[$old_title, $author_id, $old_desc, $category_id, $old_image, $old_file]) {
            $response['status'] = 'success';
            $response['message'] = 'Deleted successfully';
            echo json_encode($response);
          } else {
            $response['status'] = 'error';
            $response['message'] = 'Unknown error occurred';
            echo json_encode($response);
          }

        }
      } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
      }
    }
?>