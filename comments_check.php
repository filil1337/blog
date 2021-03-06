<?php
require_once "db_connection.php";
require_once "functions.php";

if (isset($_GET["postId"])) {
    $postid = sanitizeMySql($conn, $_GET["postId"]);
}
$stmt = $conn->stmt_init();
$comment = $_POST["comment"]; // no sanitizeMySql, nl2br() on output instead 
$email = sanitizeMySql($conn, $_POST["email"]);
$name = sanitizeMySql($conn, $_POST["name"]);

// IF EMAIL IS VALID
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $query = "INSERT INTO comments VALUES (NULL, '$email', NULL, '$name', '$postid', '$comment')";
    if ($stmt->prepare($query)) {
        $stmt->execute();
        header ("Location: comments.php?post=$postid#comments");
    } else {
        echo mysqli_error();
    }
} else {
    header ("Location: comments.php?post=$postid&email=invalid#start");
}
?>
