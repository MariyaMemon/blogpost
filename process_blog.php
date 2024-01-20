<?php
$host = 'localhost';
$dbname = 'blog';
$user = 'root';
$password = '';

$db_connection = null;

try {
    $db_connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog');


if (!isset($_COOKIE['user'])) {
    header("Location: Hom.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST["title"];
    $body = $_POST["body"];

    $target_dir = "blogUpload/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check === false) {
        echo "Sorry, your file is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picturePath = $target_file;

            $user_id = getUserIdByEmail();

            $insert_statement = "INSERT INTO blogpost (user_id, picture, post_title, post_body) 
                                 VALUES (:user_id, :picture, :post_title, :post_body)";
            $statement = $db_connection->prepare($insert_statement);
            $statement->bindParam(":user_id", $user_id);
            $statement->bindParam(":picture", $picturePath);
            $statement->bindParam(":post_title", $title);
            $statement->bindParam(":post_body", $body);

            if ($statement->execute()) {
                echo "Blog post added successfully.";
            } else {
                echo "Failed to add blog post.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


function getUserIdByEmail() {
    global $db_connection;

    if (isset($_COOKIE['user'])) {
        $email = $_COOKIE['user'];

        if ($db_connection instanceof PDO) {
            $stmt = $db_connection->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result['user_id'] : false;
        } else {
            echo "Database connection is not properly set up.";
        }
    }

    return false;
}

$userID = getUserIdByEmail();

if ($userID) {
    echo "User ID for the logged-in user: $userID";
} else {
    echo "User not found or not logged in";
}
?>



