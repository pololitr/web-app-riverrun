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

//if ($current_team_id == NULL) {
//    header("Location: createTeam.php");
//    exit();
//}
//$count = $db->query("SELECT COUNT(ID_SECTION) FROM section")->fetchColumn();

$stmt_b = $db->prepare("select team.id_team, team.name from team order by team.id_team");
$stmt_b->execute();
$team_section = $stmt_b->fetchAll();

$stmt_b = $db->prepare("SELECT id_cs FROM current_state");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];

//if ($current_status["id_cs"] == 1) {
//    header("Location: runnerSection.php");
//    exit();
//}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $time_id = $_POST['section_picker_team'];
    $stmt = $db->prepare("select runner_section.id_rs, section.id_section, section.start, section.finish, runner.id_runner, runner.firstname, runner.lastname, runner_section.time from section join runner_section on section.id_section=runner_section.id_s join runner on runner_section.id_r=runner.id_runner join team on runner.team=team.id_team where team.id_team= ? order by section.ID_SECTION");
    $stmt->execute(array($time_id));
    $clients = $stmt->fetchAll();
}
else{
    $stmt = $db->prepare("select runner_section.id_rs, section.id_section, section.start, section.finish, runner.id_runner, runner.firstname, runner.lastname, runner_section.time from section join runner_section on section.id_section=runner_section.id_s join runner on runner_section.id_r=runner.id_runner join team on runner.team=team.id_team where team.id_team!=NULL order by section.ID_SECTION");
    $clients = $stmt->fetchAll();
}
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>RiverRun 2018 | Kapitánská sekce</title>
    <?php include 'navbar.php' ?>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
<div class="container">
    <h1>Výsledky týmů dle sekcí</h1>

<!--    --><?php //if ($current_status["id_cs"] == 3) { ?>
        <form action="" method="POST">
            Vyberte tým
            <select name='section_picker_team' class='selectpicker'>
                <?php foreach ($team_section as $tr) {

                    $tr_b = $tr[0];
                    $tr_c = $tr[1];
                    ?>
                    <option value="<?= $tr_b ?>"><?= "Číslo týmu: ", $tr_b, " ", $tr_c ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" class="cancelbtn" style="background-color: #4CAF50; margin: 5px 5px 5px 5px; width:20%">Zobrazit výsledky</button>
        </form>
<!--    --><?php //} ?>

    <br/>
    <h2>Výsledky týmu</h2>
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


    <!--    <h3><a href='index.php'>Menu</a></h3>-->

    <?php include 'footer.php' ?>
</div>
</body>

</html>
