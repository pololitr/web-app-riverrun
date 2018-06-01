<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 06.05.2018
 * Time: 16:15
 */
require 'db.php';
require 'user_required.php';
$current_user_id = $current_user["id_runner"];
$current_team_id = $current_user["team"];


if ($current_team_id == NULL) {
    header("Location: createTeam.php");
    exit();
}
//$count = $db->query("SELECT COUNT(ID_SECTION) FROM section")->fetchColumn();

$stmt = $db->prepare("select runner_section.id_rs, section.id_section, section.start, section.finish, runner.id_runner, runner.firstname, runner.lastname, runner_section.time from section join runner_section on section.id_section=runner_section.id_s join runner on runner_section.id_r=runner.id_runner join team on runner.team=team.id_team where team.captain_id= $current_user_id order by section.ID_SECTION");
$stmt->execute();
$clients = $stmt->fetchAll();

$stmt_b = $db->prepare("select section.id_section, section.start, section.finish from section join runner_section on section.ID_SECTION = runner_section.ID_S where runner_section.id_t=$current_team_id and runner_section.id_r is NULL order by section.ID_SECTION");
$stmt_b->execute();
$team_section = $stmt_b->fetchAll();

$stmt_d = $db->prepare("SELECT ID_RUNNER,firstname,lastname FROM runner where runner.team = $current_team_id ORDER BY ID_RUNNER");
$stmt_d->execute();
$team_runners_id_names = $stmt_d->fetchAll();

$stmt_b = $db->prepare("SELECT id_cs FROM current_state");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];

if ($current_status["id_cs"] == 1) {
    header("Location: runnerSection.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $team_sections_time = $_POST['section_picker_time'];
    $time_section = $_POST['time'];

    $stmt_d = $db->prepare("UPDATE runner_section set time = ? where id_t = $current_team_id and id_s = $team_sections_time");
    $stmt_d->execute(array($time_section));
    echo("Úseku $team_sections_ids byl nastaven čas $time_section");
    header('Location: runnerSection_multiple.php');
}


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | RiverRun</title>
    <?php include 'navbar.php' ?>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
<div class="container">
    <h1>Rozpis přidělených úseků</h1>

    <?php if ($current_status["id_cs"] == 3) { ?>
        <form action="" method="POST">
            <h2>Vyberte sekci</h2>
            <select name='section_picker_time' class='selectpicker'>
                <?php foreach ($clients as $ts) { ?>
                    <option value="<?= $ts['id_section'] ?>"><?= "ID: ", $ts['id_section'], " ", $ts['start'], " -> ", $ts['finish'] ?>
                    </option>
                <?php } ?>
            </select><br>
            Zadej čas (HH:MM)<br>
            <input type="time" name="time" value=""><br>
            <input type="submit" value="Zadej čas" class="login loginmodal-submit">
        </form>
    <?php } ?>

    <br/>
    <h2>Přidělené úsely</h2>
    <div class="table">
        <table class="table table-hover">
            <tr>
                <th>ID sekce</th>
                <th>Start</th>
                <th>Finish</th>
                <th>ID běžce</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>Čas</th>

            </tr>
            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td><?= $row['id_section'] ?></td>
                    <td><?= $row['start'] ?></td>
                    <td><?= $row['finish'] ?></td>
                    <td><?= $row['id_runner'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['time'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <br/><br/>


    <h3><a href='index.php'>Menu</a></h3>

    <?php include 'footer.php' ?>
</div>
</body>

</html>
