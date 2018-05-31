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


$count = $db->query("SELECT COUNT(ID_RUNNER) FROM runner join team on runner.team=team.id_team")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM runner join team on runner.team=team.id_team ORDER BY ID_RUNNER");
$stmt->execute();
$clients = $stmt->fetchAll();


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | RiverRun</title>
    <?php include 'navbar.php' ?>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

<!--	--><?php //include 'navbar.php' ?>
<div class="container">
    <h1>Seznam bežců</h1>

    Aktuální počet běžců v týmu: <?= $count ?>

    <br/><br/>

    <!--	<a href="new.php">New Good</a>-->

    <br/><br/>

    <div class="table">
        <table class="table table-hover">
            <tr>
                <th>Identifikační číslo</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>Tým</th>
            </tr>
            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td><?= $row['id_runner'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['name'] ?></td>
                </tr>

            <?php } ?>

        </table>
    </div>
    <h3><a href='index.php'>Menu</a></h3>

    <?php include 'footer.php' ?>
</div>
</body>

</html>
