<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 26.05.2018
 * Time: 16:47
 */
require 'db.php';
require 'user_required.php';
$current_user_id = $current_user["id_runner"];
$current_user_team = $current_user["team"];

if ($current_user_team != NULL) {
    header("Location: myteam.php");
    exit();
} else


    require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //TODO name musi byt uniqe
    //TODO cpitan boolean
    $team_name = $_POST['name'];
    $captain_id = $current_user['id_runner'];
    $c_team_members = $_POST['runners_count'];
    $c_team_cars = $_POST['car_count'];

    //vytvor team
    $stmt = $db->prepare("INSERT INTO team(NAME,captain_id, car_count, runners_count) VALUES (?, ?, ?, ?)");
    $stmt->execute(array($team_name, $captain_id, $c_team_cars, $c_team_members));

    //ziskej id noveho tymu
    $stmt_b = $db->prepare("SELECT id_team from team where team.name = ?");
    $stmt_b->execute(array($team_name));
    $team_id_from_db = $stmt_b->fetchAll()[0];


    //vloz id teamu kapitanovi
    $stmt_e = $db->prepare("UPDATE runner set team = ? where runner.id_runner = $current_user_id");
    $stmt_e->execute(array($team_id_from_db['id_team']));

    //ziskej id vsech sekci
    $stmt_c = $db->prepare("SELECT section.id_section from section");
    $stmt_c->execute();
    $sections_ids = $stmt_c->fetchAll();

    var_dump($team_id_from_db);

    //Vytvor tymovy zaznam v sekcich
    foreach ($sections_ids as $row) {
        $row_b = $row[0];
        //var_dump($row_b);
        $stmt_d = $db->prepare("INSERT INTO runner_section(id_s, id_t, id_r) VALUES (?, ?, ?)");
        $stmt_d->execute(array($row_b, $team_id_from_db[0], NULL));

    }
    echo("tým vytvořen");
    header('Location: createTeam.php');
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánská sekce | Vltava Run 201x</title>
    <!--	<link rel="stylesheet" type="text/css" href="styles.css">-->
</head>

<body>

<h1>Vytvoření nového týmu</h1>

<h2>Zadej název nového týmu a jeho počet vozidel a bežců</h2>

<form action="" method="POST">

    Název týmu<br/>
    <input type="text" name="name" value=""><br/><br/>

    Počet vozidel<br/>
    <select name="car_count">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select><br/><br/>

    Počet běžců<br/>
    <select name="runners_count">
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select><br/><br/>

    <input type="submit" value="Vytvoř tým"> or <a href="index.php">Zrušit</a>

</form>

<div class="container">
    <h3><a href='index.php'>Menu</a></h3>
</div>

</body>

</html>
