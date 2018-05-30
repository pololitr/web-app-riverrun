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
$count = $db->query("SELECT COUNT(ID_SECTION) FROM section")->fetchColumn();

$stmt = $db->prepare("select runner_section.id_rs, section.id_section, section.start, section.finish, runner.id_runner, runner.firstname, runner.lastname from section join runner_section on section.id_section=runner_section.id_s join runner on runner_section.id_r=runner.id_runner join team on runner.team=team.id_team where team.captain_id= $current_user_id order by section.ID_SECTION");
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

if ($current_status["id_cs"] != 1){
    header("Location: runnerSection_multiple.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $team_sections_ids = $_POST['section_picker_section'];
    $team_runners_ids_names = $_POST['section_picker_runner'];

    $stmt_d = $db->prepare("UPDATE runner_section set id_r = ? where id_t = $current_team_id and id_s = $team_sections_ids");
    $stmt_d->execute(array($team_runners_ids_names));
    echo("Úsek $team_sections_ids přiřazen bežci $team_runners_ids_names");
    header('Location: runnerSection.php');
}


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | VltavaRun</title>

    <link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

<!--	--><?php //include 'navbar.php' ?>

<h1>Rozpis přidělených úseků</h1>
Celkový počet úseků: <?= $count ?>
<br/>
<h2>Přiřaď úseky</h2>
<form action="" method="POST">
    Vyberte sekci
    <select name='section_picker_section' class='selectpicker'>
        <?php foreach ($team_section as $ts) {
            $ts_b = $ts[0];
            $ts_c = $ts[1];
            $ts_d = $ts[2];
            ?>
            <option value="<?= $ts_b ?>"><?= "ID: ", $ts_b, " ", $ts_c, " -> ", $ts_d ?>
            </option>
        <?php } ?>
    </select>
    Vyberte běžce
    <select name='section_picker_runner' class='selectpicker'>
        <?php foreach ($team_runners_id_names as $tr) {
            $tr_b = $tr[0];
            $tr_c = $tr[1];
            $tr_d = $tr[2];
            ?>
            <option value="<?= $tr_b ?>"><?= "ID: ", $tr_b, " ", $tr_c, " ", $tr_d ?>
            </option>
        <?php } ?>
    </select>
    <input type="submit" value="Přiřaď" class="login loginmodal-submit">
</form>

<h2>Přidělené úsely</h2>
<table>
    <tr>
        <th>ID sekce</th>
        <th>Start</th>
        <th>Finish</th>
        <th>ID běžce</th>
        <th>Jméno</th>
        <th>Příjmení</th>
        <th>Zrušit</th>

    </tr>
    <?php foreach ($clients as $row) { ?>
        <tr>
            <td><?= $row['id_section'] ?></td>
            <td><?= $row['start'] ?></td>
            <td><?= $row['finish'] ?></td>
            <td><?= $row['id_runner'] ?></td>
            <td><?= $row['firstname'] ?></td>
            <td><?= $row['lastname'] ?></td>
            <!--            <td><a href='delete.php?id_rs=--><? //= $row['id_rs'] ?><!--'>Delete</a></td>-->
            <td><a href='update.php?id_rs=<?= $row['id_rs'] ?>'>
                    <button type="button">SMAZAT</button>
                </a></td>

        </tr>
    <?php } ?>
</table>
<br/>
<table>
    <h2>Doposud nepřidělené úseky</h2>
    <tr>
        <th>ID sekce</th>
        <th>Start</th>
        <th>Finish</th>
    </tr>
    <?php foreach ($team_section as $row) { ?>
        <tr>
            <td><?= $row['id_section'] ?></td>
            <td><?= $row['start'] ?></td>
            <td><?= $row['finish'] ?></td>
        </tr>
    <?php } ?>
</table>
<div class="container">
    <h3><a href='index.php'>Menu</a></h3>
</div>

</body>

</html>
