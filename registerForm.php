<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    if (strlen($username) < 5 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: Hom.php?registrationError=Invalid%20username%20or%20email%20format");
        exit();
    } else {
        
        $db_connection = new PDO("mysql:host=localhost;dbname=blog", "root", "");

        $insert_statement = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $statement = $db_connection->prepare($insert_statement);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $password);

        if ($statement->execute()) {
            header("Location: Hom.php?registrationSuccess=Registration%20successful.%20You%20can%20now%20log%20in.");
            exit();
        } else {
            header("Location: Hom.php?registrationError=Registration%20failed.%20Please%20try%20again.");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<style>
         body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 8px;
    }

    input {
        padding: 8px;
        margin-bottom: 16px;
    }

    button {
        padding: 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    </style>
<body>

    <?php if (isset($_GET['registrationSuccess'])): ?>
        <p style="color: green;"><?php echo urldecode($_GET['registrationSuccess']); ?></p>
        <?php endif; ?>
        
        <?php if (isset($_GET['registrationError'])): ?>
            <p style="color: red;"><?php echo urldecode($_GET['registrationError']); ?></p>
            <?php endif; ?>

            <div class="form-container"> 
            <form class="container" action="" method="post">
    <h2>User Registration</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Register</button>
</form>
</div>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            function displayAlert() {
                var urlParams = new URLSearchParams(window.location.search);

                if (urlParams.has('registrationSuccess')) {
                    alert(urlParams.get('registrationSuccess'));
                } else if (urlParams.has('registrationError')) {
                    alert(urlParams.get('registrationError'));
                }
            }
            displayAlert();
        });
    </script>
</body>
</html>


