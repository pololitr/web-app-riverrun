<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 30.05.2018
 * Time: 22:39
 */

require 'db.php';
require 'user_required.php';
$current_user_id = $current_user["id_runner"];


$count = $db->query("SELECT COUNT(ID_TEAM) FROM team")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM team  ORDER BY ID_TEAM");
$stmt->execute();
$clients = $stmt->fetchAll();

$stmt_b = $db->prepare("SELECT id_team FROM team  ORDER BY ID_TEAM");
$stmt_b->execute();
$teams_ids = $stmt_b->fetchAll();
//var_dump($teams_ids);


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | RiverRun</title>

    <link rel="stylesheet" type="text/css" href="styles.css">
    <?php include 'navbar.php' ?>

</head>

<body>
<div class="container">
<!--	--><?php //include 'navbar.php' ?>

<h1>Průběžné výsledky týmů</h1>

Celkový počet týmů: <?= $count ?>

<br/><br/>

<!--	<a href="new.php">New Good</a>-->

<br/><br/>

    <div class="table">
        <table class="table table-hover">
    <tr>
        <th>Identifikační číslo týmu</th>
        <th>Nazev týmu</th>
        <th>Počet běžců</th>
        <th>Celkový čas</th>
        <th>Zaběhnuto úseků</th>
    </tr>

    <?php foreach ($teams_ids as $row) {
        $t_id = $row["id_team"];
        $stmt_c = $db->prepare("select team.id_team, team.name, team.runners_count, SEC_TO_TIME( SUM( TIME_TO_SEC( runner_section.time) ) ) AS timeSum, COUNT(runner_section.id_rs) as runned from runner_section join team on runner_section.id_t=team.id_team where runner_section.time != '00:00:00'and runner_section.id_t = $t_id");
        $stmt_c->execute();
        $results = $stmt_c->fetchAll();
        foreach ($results as $row_b) {
            ?>
            <tr>
                <td><?= $row_b["id_team"] ?></td>
                <td><?= $row_b['name'] ?></td>
                <td><?= $row_b['runners_count'] ?></td>
                <td><?= $row_b['timeSum'] ?></td>
                <td><?= $row_b['runned'] ?></td>
            </tr>
        <?php }
    } ?>
</table>
    <h3><a href='index.php'>Menu</a></h3>
</div>
<?php include 'footer.php' ?>
</body>

</html>
