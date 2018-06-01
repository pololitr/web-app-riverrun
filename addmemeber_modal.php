<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 30.05.2018
 * Time: 16:22
 */
//require 'db.php';
//require 'user_required.php';
//require 'myteam.php';

$current_user_id = $current_user["id_runner"];
$current_team_id = $current_user["team"];

if ($current_team_id == NULL) {
    header("Location: createTeam.php");
    exit();
}

$count = $db->query("SELECT COUNT(ID_RUNNER) FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id")->fetchColumn();

$stmt = $db->prepare("SELECT ID_RUNNER, FIRSTNAME, LASTNAME, runners_count FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id ORDER BY ID_RUNNER");
$stmt->execute();
$clients = $stmt->fetchAll();

$clients_b = $clients[0];
$count_set = $clients_b['runners_count'];

if ($count >= $count_set) {
    header("Location: myteam.php");
    exit();
}

$stmt_b = $db->prepare("SELECT id_cs FROM current_state");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];

if ($current_status["id_cs"] != 1) {
    header("Location: myteam_lite.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
//    $avg_phase = $_POST['avg_phase'];

    # TODO PRO STUDENTY osetrit vstupy, email a heslo jsou povinne, atd.
    # TODO PRO STUDENTY jde se prihlasit prazdnym heslem, jen prototyp, pouzit filtry


    #vlozime usera do databaze
    $stmt = $db->prepare("INSERT INTO runner(email, password, firstname, lastname,captain, team ) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(array(NULL, NULL, $firstname, $lastname, 0, $current_team_id));

    #ted je uzivatel ulozen, bud muzeme vzit id posledniho zaznamu pres last insert id (co kdyz se to potka s vice requesty = nebezpecne), nebo nacist uzivatele podle mailove adresy (ok, bezpecne)

    echo("Běžec přidán");

    header("Location: myteam.php");
    exit();
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Nový běžec</title>
    <!--    <link rel="stylesheet" type="text/css" href="style.css">-->
</head>
<body>
<div class="modal-content animate ">
    <div class="container_2">
        <h1>Přidej nového běžce</h1>
        <form action="" method="POST" style="padding: 10px 10px 10px 10px;">
            <input type="text" placeholder="Jméno nového člena" name="firstname" value="" required><br/>
            <input type="text" placeholder="Příjmení nového člena" name="lastname" value="" required><br/>
            <button type="submit" id=>Vytvoř běžce</button>
            <br/>
            <button type="button" class="mod01" style=" background-color: #f44336;" onclick="document.getElementById('id01').style.display='none'">Zrušit</button>
            <br/>
        </form>
    </div>
</div>
</body>
</html>
