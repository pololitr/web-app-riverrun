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
$current_user_team = $current_user["team"];

if ($current_user_team == NULL) {
    header("Location: createTeam.php");
    exit();
}


$count = $db->query("SELECT COUNT(ID_RUNNER) FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id")->fetchColumn();

$stmt = $db->prepare("SELECT ID_RUNNER, FIRSTNAME, LASTNAME, runners_count, team.runners_count FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id ORDER BY ID_RUNNER");
$stmt->execute();
$clients = $stmt->fetchAll();

$clients_b = $clients[0];
$count_set = $clients_b['runners_count'];

$stmt_b = $db->prepare("SELECT id_cs FROM current_state");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];

$result = $count_set - $count;
if ($current_status["id_cs"] != 1) {
    header("Location: myteam_lite.php");
    exit();
}
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | VltavaRun</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <?php include 'navbar.php' ?>
</head>
<body>
<!--	--><?php //include 'navbar.php' ?>
<h1>Seznam bežců</h1>
Aktuální počet běžců v týmu: <?= $count ?><br>
Počet běžců v týmu zadných při registraci: <?= $count_set ?>

<?php
if (($count_set - $count) > 0) { ?>
    <h2>Chybí vložit <?php echo($result) ?> běžce/běžců do týmu</h2>
<?php } ?>
<br/>
<?php if ($count < $count_set) { ?>
    <div class="container">
        <h3><a href='addmemeber.php'>Nový člen týmu</a></h3>
    </div>
<?php } ?>
<br/>
<table>
    <tr>
        <th>Identifikační číslo</th>
        <th>Jméno</th>
        <th>Příjmení</th>
        <!--            <th>Čas na kilometr</th>-->
    </tr>

    <?php foreach ($clients as $row) { ?>

        <tr>
            <td><?= $row['ID_RUNNER'] ?></td>
            <td><?= $row['FIRSTNAME'] ?></td>
            <td><?= $row['LASTNAME'] ?></td>
            <!--                <td>--><? //= $row['AVG_PHASE'] ?><!--</td>-->
            <td><a href='delete.php?id_runner=<?= $row['ID_RUNNER'] ?>'><button type="button">SMAZAT</button></a></td>
        </tr>

    <?php } ?>

</table>


<div class="container">
    <h3><a href='index.php'>Menu</a></h3>
</div>
<?php include 'footer.php' ?>
</body>

</html>
