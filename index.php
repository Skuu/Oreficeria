<?php
session_start();
if ($_SESSION['username'] == '') {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <button><a href="./insert.php">Aggiungi oggetto</a></button>
    <button><a href="./view.php">Visualizza</button></a>
    <a href="./logout.php">Logout</a>
</body>

</html>
