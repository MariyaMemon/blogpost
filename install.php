<?php

require_once 'server.php';

$table_blogpost = "
CREATE TABLE IF NOT EXISTS blogpost (
    post_id int AUTO_INCREMENT,
    post_title varchar(200) NOT NULL,
    post_body text NOT NULL,
    post_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT PK_blogpost_post_id PRIMARY KEY (post_id)
);";

$insert_statment = "INSERT INTO blogpost (post_title, post_body, post_date) VALUES (:post_title, :post_body, :post_date)";

$blogs = [
    [
        "post_title" => "My first blog post",
        "post_body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aperiam provident libero quisquam velit. Libero illum blanditiis, rem minus expedita consequuntur iusto! Ex, earum magnam dignissimos alias expedita nostrum impedit asperiores corporis non eos! Ipsum, est consequatur? Deleniti rem culpa vitae nulla. Quaerat placeat necessitatibus dolore modi illo quae ab.",
        "post_date" => "2019-10-20" // YYYY-MM-DD
    ],
    [
        "post_title" => "This is my second blog post",
        "post_body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aperiam provident libero quisquam velit. Libero illum blanditiis, rem minus expedita consequuntur iusto! Ex, earum magnam dignissimos alias expedita nostrum impedit asperiores corporis non eos! Ipsum, est consequatur? Deleniti rem culpa vitae nulla. Quaerat placeat necessitatibus dolore modi illo quae ab.",
        "post_date" => "2020-10-10" // YYYY-MM-DD
    ],
    [
        "post_title" => "My recent blog post, a bit longer",
        "post_body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti aperiam provident libero quisquam velit. Libero illum blanditiis, rem minus expedita consequuntur iusto! Ex, earum magnam dignissimos alias expedita nostrum impedit asperiores corporis non eos! Ipsum, est consequatur? Deleniti rem culpa vitae nulla. Quaerat placeat necessitatibus dolore modi illo quae ab. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate consectetur, laudantium aspernatur ducimus autem quisquam praesentium molestiae esse illo et eligendi, veniam deserunt saepe obcaecati ea! Nostrum rerum eum quaerat iure, debitis libero eos! Adipisci ad vel amet, dolores id, at animi, voluptas veritatis accusamus repellat perspiciatis fuga! Dolorem, numquam!",
        "post_date" => "2021-09-21" // YYYY-MM-DD
    ]
];

try {
    $db_connection = new PDO("mysql:host=localhost", DB_USER, DB_PASS);

    $db_connection->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);

    $db_connection = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db_connection->exec($table_blogpost);

    // In case page refesh, do not insert rows repeatedly.
    $row_count = (int) $db_connection->query("SELECT count(*) FROM blogpost")->fetchColumn();

    // If there no row (which means table is just created), add some rows.
    if($row_count === 0) {

        $blog_post_title = "";
        $blog_post_body = "";
        $blog_post_date = "";

        $statment = $db_connection->prepare($insert_statment);
        $statment->bindParam(":post_title", $blog_post_title);
        $statment->bindParam(":post_body", $blog_post_body);
        $statment->bindParam(":post_date", $blog_post_date);

        foreach($blogs as $blog) {
            $blog_post_title = $blog['post_title'];
            $blog_post_body = $blog['post_body'];
            $blog_post_date = $blog['post_date'];

            $statment->execute();
        }
    }

    $success = true;
}
catch (PDOException $e) {
    echo $e.getMessage();
    $success = false;
}

$message = $success?
"Congratulations: instalation is successful":
"Oops: instalation is unsuccessful";
?>

<h1><?=$message?></h1>

