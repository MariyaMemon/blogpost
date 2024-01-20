<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $db_connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['action']) && isset($data['postId'])) {
    $action = $data['action'];
    $postId = $data['postId'];
    $userId = getUserIdByEmail();

    if ($userId) {
        switch ($action) {
            case 'follow':
                handleFollowInteraction($userId, $postId);
                break;
            case 'like':
                handleLikeInteraction($userId, $postId);
                break;
            case 'share':
                handleShareInteraction($userId, $postId);
                break;
            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not authenticated']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

function handleFollowInteraction($userId, $postId) {
    global $db_connection;

    try {
        $stmt = $db_connection->prepare("SELECT * FROM followers WHERE user_id = :userId AND post_id = :postId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'error' => 'User already follows the post']);
            return;
        }
        $stmt = $db_connection->prepare("INSERT INTO followers (user_id, post_id) VALUES (:userId, :postId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error handling follow interaction']);
    }
}

function handleLikeInteraction($userId, $postId) {
    global $db_connection;

    try {
       
        $stmt = $db_connection->prepare("SELECT * FROM likes WHERE user_id = :userId AND post_id = :postId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'error' => 'User already liked the post']);
            return;
        }

        $stmt = $db_connection->prepare("INSERT INTO likes (user_id, post_id) VALUES (:userId, :postId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error handling like interaction']);
    }
}

function handleShareInteraction($userId, $postId) {
    global $db_connection;

    try {
        
        $stmt = $db_connection->prepare("SELECT * FROM shares WHERE user_id = :userId AND post_id = :postId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'error' => 'User already shared the post']);
            return;
        }

        $stmt = $db_connection->prepare("INSERT INTO shares (user_id, post_id) VALUES (:userId, :postId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error handling share interaction']);
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
?>

