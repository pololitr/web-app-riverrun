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
            $errors[] = 'Přezdivka může obsahovat jen písmena a číslice.';
        }
        if (strlen($_POST['email']) > 30) {
            $errors[] = 'Přezdivka nemůže být delší než 30 znaků.';
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
    if (isset($_POST['firstname'])&&isset($_POST['firstname'])) {
        if (empty($_POST['firstname']) or empty($_POST['lastname'])) {
            $errors[] = 'Jméno a příjemní nesmí být prázdené';
        }
    }

	# TODO PRO STUDENTY osetrit vstupy, email a heslo jsou povinne, atd.
	# TODO PRO STUDENTY jde se prihlasit prazdnym heslem, jen prototyp, pouzit filtry

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
	$stmt->execute(array($email, $hashed,$firstname, $lastname ,1));
	
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
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
<!--	<link rel="stylesheet" type="text/css" href="styles.css">-->
</head>

<body>
	
		<h1>River Run 2018 Kapitánská sekce</h1>

		<h2>Nový kapitánský účet</h2>
	
		<form action="" method="POST">
	  
			Váš email<br/>
			<input type="text" name="email" value="" required><br/><br/>
	  
			Heslo<br/>
			<input type="password" name="password" value="" required><br/><br/>

            Heslo Znovu<br/>
            <input type="password" name="password_check" value="" required><br/><br/>

            Jmnéno<br/>
            <input type="text" name="firstname" value="" required><br/><br/>

            Příjmení<br/>
            <input type="text" name="lastname" value="" required><br/><br/>

			<input type="submit" value="Vytvořit účet"> or <a href="signin.php">Zpět k přihlášení</a>
		
		</form>
	
</body>

</html>
