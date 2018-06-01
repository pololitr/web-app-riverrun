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

    $team_name = htmlspecialchars(trim($_POST['name']));
    $c_team_members = htmlspecialchars(trim($_POST['runners_count']));
    $c_team_cars = htmlspecialchars(trim($_POST['car_count']));

    $captain_id = $current_user['id_runner'];

    if (isset($_POST['name'])) {
        if (!ctype_alnum($_POST['name'])) {
            $errors[] = 'Název může obsahovat jen písmena a číslice.';
        }
        if (strlen($_POST['name']) > 20) {
            $errors[] = 'Název nemůže být delší než 20 znaků.';
        }
    } else {
        $errors[] = 'Název nesmí být prázdný.';
    }

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
    <title>RiverRun 2018 | Kapitánská sekce</title>
    <!--	<link rel="stylesheet" type="text/css" href="styles.css">-->
    <?php include 'navbar.php' ?>
</head>

<body>
<div class="container">

    <h1>Vytvoření nového týmu</h1>

    <h3>Zadej název nového týmu a jeho počet vozidel a bežců</h3>

    <form action="" method="POST" class="log">

        <input type="text" placeholder="Název týmu" name="name" value="" style="text-align: left;" required><br/><br/>

        Počet vozidel<br/>
        <label for="pocet_vozidel">
            <select name="car_count">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </label><br/><br/>

        Počet běžců<br/>
        <label for="pocet_bezcu">
            <select name="runners_count">
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </label><br/><br/>

        <!--    <input type="submit" value="Vytvoř tým">-->
        <button type="submit" style="width: 30%">Vytvoř tým</button>
        <a href='index.php'>
            <button type="button" style="background-color: #f44336; width: 30%" onclick="return confirm('Oprvadu odejít?')">
                Zrušit
            </button>
        </a>

    </form>
    <!--    <h3><a href='index.php'>Menu</a></h3>-->
</div>
<?php include 'footer.php' ?>
</body>

</html>
