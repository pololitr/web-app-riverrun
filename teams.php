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


$count = $db->query("SELECT COUNT(ID_TEAM) FROM team")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM team  ORDER BY ID_TEAM");
$stmt->execute();
$clients = $stmt->fetchAll();


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | River Run</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include 'navbar.php' ?>

</head>

<body>
<div class="container">
    <h1>Seznam týmů</h1>
    Celkovy počet týmů: <?= $count ?>
    <br/><br/>
    <br/><br/>
    <div class="table">
            <table class="table table-hover">
            <tr>
                <th>Číslo týmu</th>
                <th>Název týmu</th>
                <th>Číslo kapitána</th>
                <th>Počet vozidel</th>
                <th>Počet běžců</th>
            </tr>

            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td><?= $row['id_team'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['captain_id'] ?></td>
                    <td><?= $row['car_count'] ?></td>
                    <td><?= $row['runners_count'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

<!--    <h3><a href='index.php'>Menu</a></h3>-->

    <?php include 'footer.php' ?>
</div>
</body>

</html>
