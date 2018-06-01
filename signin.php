<?php

session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    # zajimavost: mysql porovnani retezcu je case insensitive, pokud dame select na NECO@DOMENA.COM, najde to i zaznam neco@domena.com
    # viz http://dev.mysql.com/doc/refman/5.0/en/case-sensitivity.html

    $stmt = $db->prepare("SELECT * FROM runner WHERE email = ? LIMIT 1"); //limit 1 jen jako vykonnostni optimalizace, 2 stejne maily se v db nepotkaji
    $stmt->execute(array($email));
    $existing_user = @$stmt->fetchAll()[0];

    $is_captain = $existing_user[4];
//		var_dump($existing_user);
//		echo $existing_user[7];
//		die();

    if (password_verify($password, $existing_user["password"]) && $is_captain == 1) {

        $_SESSION['id_runner'] = $existing_user["id_runner"];

        header('Location: index.php');

    } else {

        die("Invalid user or password!");

    }

}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Something</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="container log text-center">
    <h1>River Run 2018 Kapitánská sekce</h1>

    <h2>Přihlaste se</h2>

    <form action="" method="POST">
        <div class="imgcontainer">
            <img src="img/avatars.png" alt="Avatar" class="avatar">
        </div>
        <div class="container log text-center">
            <!--            <label><b>Zadejte email</b></label><br/>-->
            <input type="email" placeholder="Váš email" name="email" value="" required><br/>

            <!--            <label><b>Zadejte heslo</b></label><br/>-->
            <input type="password" placeholder="Vaše heslo" name="password" value="" required><br/>

            <button type="submit">Přihlásit</button>
        </div>

    </form>

    <br/>
    <div class="container log text-center" >
        <a href="signup.php">Vytvořit účet</a><br/>
        <a href="admin_required.php">Manage</a>
    </div>
    <?php include 'footer.php' ?>
</div>
</body>

</html>
