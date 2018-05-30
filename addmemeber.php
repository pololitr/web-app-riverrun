<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 30.05.2018
 * Time: 16:22
 */
require 'db.php';
require 'user_required.php';

$current_user_id = $current_user["id_runner"];
$current_team_id = $current_user["team"];

if ($current_team_id == NULL){
    header("Location: createTeam.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $avg_phase = $_POST['avg_phase'];

    # TODO PRO STUDENTY osetrit vstupy, email a heslo jsou povinne, atd.
    # TODO PRO STUDENTY jde se prihlasit prazdnym heslem, jen prototyp, pouzit filtry


    #vlozime usera do databaze
    $stmt = $db->prepare("INSERT INTO runner(email, password, firstname, lastname, avg_phase,captain, team ) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array(NULL, NULL,$firstname, $lastname,$avg_phase ,0, $current_team_id));

    #ted je uzivatel ulozen, bud muzeme vzit id posledniho zaznamu pres last insert id (co kdyz se to potka s vice requesty = nebezpecne), nebo nacist uzivatele podle mailove adresy (ok, bezpecne)

    echo("Běžec přidán");

}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Nový běžec</title>
    <!--	<link rel="stylesheet" type="text/css" href="styles.css">-->
</head>

<body>

<h1>Přidej nového běžce</h1>

<form action="" method="POST">

    Jmnéno<br/>
    <input type="text" name="firstname" value=""><br/><br/>

    Příjmení<br/>
    <input type="text" name="lastname" value=""><br/><br/>

    Minut na kilometr<br/>
    <input type="text" name="avg_phase" value=""><br/><br/>


    <input type="submit" value="vytvoř běžce"> or <a href="/index.php">Cancel</a>

</form>

<div class="container">
    <h3><a href='index.php'>Menu</a></h3>
    <h3><a href='myteam.php'>Tým</a></h3>
</div>

</body>

</html>
