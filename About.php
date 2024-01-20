<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {   
    $email = $_POST["email"];
    $password = $_POST["password"];

    setcookie("user", $email, time() + (86400 * 30), "/"); 
    header("Location: Hom.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #555;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        .dropdown {
            float: left;
            overflow: hidden;
        }

        .dropdown .dropbtn {
            font-size: 16px;  
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #555;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .footer-container div {
            flex: 1;
            margin: 10px;
        }

        h3 {
            border-bottom: 2px solid white;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        a {
            display:block;
            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .social-media img {
            width: 30px;
            margin-right: 10px;
        }

        .copyright {
            margin-top: 20px;
        }
        section {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

       section h1, h2, h3 {
            color: #333;

        }

        p {
            line-height: 1.6;
        }
        img {
            
            border-radius: 8px;
           
        }
        .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.error-message {
    color: red;
}
    </style>
</head>
<body>

<header>
    <h1>StellarVista <img src="logo.png" alt=""></h1>
</header>

<nav>
    <a href="Hom.php">Blog</a>
    <a href="About.php">About</a>
    <a href="add_blog.php">Add Blog</a>

    <div class="dropdown">
    <?php if (isset($_COOKIE['user'])): ?>
        <button class="dropbtn">Welcome, <?php echo htmlspecialchars($_COOKIE['user']); ?> &#9660;</button>
        <div class="dropdown-content">
            <a href="logout.php">Logout</a>
        </div>
    <?php else: ?>
            <button class="dropbtn" onclick="openLoginModal()">Login &#9660;</button>
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeLoginModal()">&times;</span>
                    <?php if (isset($loginError)): ?>
                        <p style="color: red;"><?php echo $loginError; ?></p>
                    <?php endif; ?>
                    <form action="" method="post">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required><br>

                        <button type="submit">Login</button>
                    </form>
                    <p>Not registered yet? <a href="registerForm.php">Register here</a></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>

<section>

<img src="astro.jpg" alt="Astronomy Image" />
    <h2>About Our Astronomy Blog</h2>

    <p>Welcome to <strong>StellarVista <img src="logo.png" height="20px" alt=""></strong>, where the wonders of the cosmos come to life! Our blog is your go-to destination for exploring the beauty, mysteries, and latest discoveries in the vast realm of astronomy.</p>

    <h3>Our Mission</h3>
    <p>At <strong>StellarVista <img src="logo.png" height="20px" alt=""></strong>, our mission is to inspire curiosity and ignite a passion for the celestial wonders that surround us...</p>

    <h3>Contact Us</h3>
    <p>Have a question, suggestion, or just want to say hello? Feel free to <a href="#">contact us</a> anytime. We love hearing from our readers and fellow space enthusiasts.</p>

</section>


<footer>
    <div class="footer-container">
        <div class="quick-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="Hom.php">Home</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="add_blog.php">Contact</a></li>
            </ul>
        </div>

        <div class="contact-info">
            <h3>Contact Information</h3>
            <p>Email: mariyamemon54.com</p>
            <p>Phone: +92 3473129630 </p>
        </div>

        <div class="social-media">
            <h3>Connect with Us</h3>
            <a href="#" target="_blank"><i class='bx bxl-facebook-circle' style='color:#2769c3'></i> facebook</a>
            <a href="#" target="_blank"><i class='bx bxl-twitter' style='color:#2769c3'></i> Twitter</a>
        </div>
    </div>

    <div class="copyright">
        <p>&copy; 2024 StellarVista <img src="logo.png" height="20px" alt=""> All Rights Reserved.</p>
    </div>
</footer>
<script src="hom.js"></script>
</body>
</html>