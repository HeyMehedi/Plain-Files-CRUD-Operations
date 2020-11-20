<?php
require_once "inc/functions.php";

session_name('auth');
session_start([
    'cookie_lifetime' => 300, // 5mins
]);

$error = false;
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$fp = fopen("./data/users.txt", "r");
if ($username && $password) {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = false;
    $_SESSION['role'] = false;
    while ($data = fgetcsv($fp)) {
        if ($username == $data[0] && md5($password) == $data[1]) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $data[2];
            header('location: /');
        }
    }
    $error = true;
}

if (isset($_GET['logout'])) {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = false;
    session_destroy();
    header('location: /');
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Session with Login</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="Md Mehedi Hasan">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <!-- Milligram CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>Simple Auth Example</h2>
                <?php
                include_once 'inc/templates/nav.php';

                if (true == $_SESSION['loggedin']) {
                    echo "<p><br/>Hello Admin, Welcome!</p>";
                } else {
                    echo "<p><br/>Hello Stranger, Login Below</p>";
                }
                if ($error) {
                    echo "<blockquote>Username and Password didn't match</blockquote>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php if (false == $_SESSION['loggedin']): ?>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form method="POST">
                    <label for="username">Username</label>
                    <input type="text" name="username">
                    <label for="password">Password</label>
                    <input type="password" name="password">
                    <button type="submit" name="submit"> Login </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif;?>
    </body>
</html>
