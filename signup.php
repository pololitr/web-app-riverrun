<?php

session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //$email = $_POST['email'];
    //$password = $_POST['password'];
    //$email = $_POST['email'];
    //$firstname = $_POST['firstname'];
    //$lastname = $_POST['lastname'];
    //$avg_phase = $_POST['avg_phase'];


    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password_check = htmlspecialchars(trim($_POST['password_check']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));

    # dalsi moznosti je vynutit bcrypt: PASSWORD_BCRYPT
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $errors = array();
    if (isset($_POST['email'])) {
        if (!ctype_alnum($_POST['email'])) {
            $errors[] = 'Email může obsahovat jen písmena a číslice.';
        }
        if (strlen($_POST['email']) > 30) {
            $errors[] = 'Email nemůže být delší než 30 znaků.';
        }
    } else {
        $errors[] = 'Email nesmí být prázdný.';
    }
    if (isset($_POST['password'])) {
        if ($_POST['password'] != $_POST['password_check']) {
            $errors[] = 'Hesla se neshodují';
        }
        if (strlen($_POST['password_check']) < 8) {
            $errors[] = 'heslo je moc krátké';
        }
        if (empty($_POST['password'])) {
            $errors[] = 'Heslo nesmí být prázdné';
        }
    }
    if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
        if (empty($_POST['firstname']) or empty($_POST['lastname'])) {
            $errors[] = 'Jméno a příjemní nesmí být prázdené';
        }
    }

    # $password = md5($_POST['password']); #chybi salt

    # $password = hash("sha256" , $password); #chybi salt

    # viz http://php.net/manual/en/function.password-hash.php
    # salt lze generovat rucne (nedoporuceno), nebo to nechat na php, ktere salt rovnou pridat do hashovaneho hesla

    /**
     * We just want to hash our password using the current DEFAULT algorithm.
     * This is presently BCRYPT, and will produce a 60 character result.
     *
     * Beware that DEFAULT may change over time, so you would want to prepare
     * By allowing your storage to expand past 60 characters (255 would be good)
     */
    # dalsi moznosti je vynutit bcrypt: PASSWORD_BCRYPT
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    #vlozime usera do databaze
    $stmt = $db->prepare("INSERT INTO runner(email, password, firstname, lastname,captain ) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(array($email, $hashed, $firstname, $lastname, 1));

    #ted je uzivatel ulozen, bud muzeme vzit id posledniho zaznamu pres last insert id (co kdyz se to potka s vice requesty = nebezpecne), nebo nacist uzivatele podle mailove adresy (ok, bezpecne)

    $stmt = $db->prepare("SELECT ID_RUNNER FROM runner WHERE email = ? LIMIT 1"); //limit 1 jen jako vykonnostni optimalizace, 2 stejne maily se v db nepotkaji
    $stmt->execute(array($email));
    $user_id = (int)$stmt->fetchColumn();

    $_SESSION['ID_RUNNER'] = $user_id;

    header('Location: index.php');

}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>RiverRun 2018 | Registrace</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="container log text-center">
<h1>River Run 2018 kapitánská sekce</h1>
<h2>Nový kapitánský účet</h2>
<form action="" method="POST">
    <div class="imgcontainer">
        <img src="img/avatar2.png" alt="Avatar" class="avatar">
    </div>
    <div class="container log text-center">
        <input type="email" placeholder="Váš email" name="email" value="" required>
        <input type="password" placeholder="Vaše heslo" name="password" value="" required>
        <input type="password" placeholder="Vaše heslo znovu" name="password_check" value="" required>
        <input type="text" placeholder="Vaše jméno" name="firstname" value="" required>
        <input type="text" placeholder="Vaše příjmení" name="lastname" value="" required>
        <button type="submit">Vytvořit účet</button>
        <br/>nebo<br/> <a href="signin.php">Zpět k přihlášení</a>
    </div>
</form>
<?php include 'footer.php' ?>
</div>
</body>

</html>
