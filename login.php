<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/insert.css">
</head>

<body>

    <?php

    if (isset($_POST['login'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $connection = mysqli_connect("localhost", "root", "");
        mysqli_select_db($connection, "Oreficeria");

        $q_utenti = "SELECT password FROM utenti WHERE username = \"$username\";";
        $utenti = mysqli_query($connection, $q_utenti);
        $user = mysqli_fetch_array($utenti);

        if (hash_equals($user['password'], crypt($password, "_S4..pass"))) {
            $_SESSION['username'] = $username;
            header("location: .");
        } else {
            $error = "Login non riuscito. Riprova.";
        }
    }

    ?>

    <div class="form-container">
        <form action='' method='post'>
            <div class="form-group">
                <label for="username">Username</label>
                <input style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; width: 97%;" type="text"
                    name="username" maxlength="25" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; width: 97%;" type="password"
                    name="password" maxlength="25" required>
            </div>

            <?php
            if (!empty($error)) {
                echo "<p style='color: red'>$error</p>";
            }
            ?>

            <input type="submit" name="login" value="Accedi">
        </form>

</body>

</html>
