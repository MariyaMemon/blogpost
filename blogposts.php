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
$user_id = getUserIdByEmail();

$select_statement = "SELECT blogpost.*, users.username FROM blogpost JOIN users ON blogpost.user_id = users.user_id";

try {
    $db_connection = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);

    $statement = $db_connection->prepare($select_statement);
    $statement->execute();
    $blogposts = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
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

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>My Blog</title>
</head>
<body>

<?php
if (!empty($blogposts)):
    foreach($blogposts as $blogpost):
        $post_id = $blogpost["post_id"]; 
        $post_title = $blogpost["post_title"];
        $post_body = $blogpost["post_body"];
        $post_date = $blogpost["post_date"];
        $post_date = date_create($post_date);
        $post_date = date_format($post_date, "jS F, Y");
        $username = $blogpost["username"];
        $picture = $blogpost["picture"]; 
    ?>


<section class="blogpost">
    <div class="blogtitle"><?=$post_title?></div>
    <?php if (!empty($picture)): ?>
        <img src="<?=$picture?>" alt="Blog Picture">
    <?php endif; ?>
    <div><?=$post_body?></div>
    <div class="blogdate"><small>Posted on: <?=$post_date?> by <?=$username?></small></div>

    <div class="interaction-buttons">
    <button class="like-button" data-post-id="<?=$post_id?>" onclick="handleInteraction('like', <?=$post_id?>)">
    Like
</button>

<button class="follow-button" data-post-id="<?=$post_id?>" onclick="handleInteraction('follow', <?=$post_id?>)">
    Follow
</button>

<button class="share-button" data-post-id="<?=$post_id?>" onclick="handleInteraction('share', <?=$post_id?>)">
    Share
</button>
    
    </div>
</section>
<?php
    endforeach;
else:
?>
<p>No blog posts available.</p>
<?php
endif;
?>

<script>
    function handleInteraction(action, postId) {
        const data = {
            action: action,
            postId: postId
        };

        fetch('interaction.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(response => {
            console.log('Raw Response:', response);  

            if (response.success) {
                console.log(`${action} handled successfully for post ID ${postId}`);
                updateButtonUI(action, postId);
            } else {
                console.error(`Failed to handle ${action} for post ID ${postId}: ${response.error}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function updateButtonUI(action, postId) {
        const button = document.querySelector(`.${action}-button[data-post-id="${postId}"]`);

        if (button) {
            switch (action) {
                case 'like':
                    button.innerText = 'Liked'; 
                    break;
                case 'follow':
                    button.innerText = 'Followed'; 
                    break;
                case 'share':
                    button.innerText = 'Shared'; 
                    break;
            }
            
            button.disabled = true; 
        }
    }
</script>

</script>

</body>
</html>
