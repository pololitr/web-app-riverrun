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

$count = $db->query("SELECT COUNT(ID_SECTION) FROM section")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM section  ORDER BY ID_SECTION");// LIMIT 12 OFFSET ?");
//$stmt->bindValue(1, $offset, PDO::PARAM_INT);
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
    <h1>Seznam useku</h1>
    celkovy pocet useku: <?= $count ?>
    <br/><br/>
    <br/><br/>
    <div class="table">
        <table class="table table-hover">
            <tr>
                <th></th>
                <th>Identifikační číslo useku</th>
                <th>Start</th>
                <th>Cíl</th>
                <th>Délka(km)</th>
                <th>Náročnost</th>
                <th></th>
            </tr>
            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td class="center">
                    </td>
                    <td><?= $row['id_section'] ?></td>
                    <td class="right"><?= $row['start'] ?></td>
                    <td><?= $row['finish'] ?></td>
                    <td><?= $row['kilometers'] ?></td>
                    <td><?= $row['difficulty'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <h3><a href='index.php'>Menu</a></h3>
    <br/>
    <br/>
    <?php include 'footer.php' ?>
</div>
</body>

</html>
