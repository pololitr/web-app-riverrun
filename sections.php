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
    <meta charset="utf-8" />
    <title>Kapitánova sekce | VltavaRun</title>

    <link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

<!--	--><?php //include 'navbar.php' ?>

<h1>Seznam useku</h1>

celkovy pocet useku: <?= $count ?>

<br/><br/>

<!--	<a href="new.php">New Good</a>-->

<br/><br/>

<table>

    <tr>

        <th></th>
        <th>Identifikační číslo useku</th>
        <th>Start</th>
        <th>Cíl</th>
        <th>Délka(km)</th>
        <th>Náročnost</th>
        <th></th>


    </tr>

    <?php foreach($clients as $row) { ?>

        <tr>
            <td class="center">
                <!--					<a href='buy.php?id=--><?//= $row['id'] ?><!--'>Buy</a>-->
            </td>

            <td><?= $row['id_section'] ?></td>
            <td class="right"><?= $row['start'] ?></td>
            <td><?= $row['finish'] ?></td>
            <td><?= $row['kilometers'] ?></td>
            <td><?= $row['difficulty'] ?></td>

            <td class="center" nowrap>
                <!--					<a href='update_optimistic.php?id=--><?//= $row['id'] ?><!--'>Edit (optimistic lock)</a><br>-->
                <!--					<a href='update_pessimistic.php?id=--><?//= $row['id'] ?><!--'>Edit (pessimistic lock)</a><br>-->
                <!--					<a href='delete.php?id=--><?//= $row['id'] ?><!--'>Delete</a>-->
            </td>

        </tr>

    <?php } ?>

</table>
<div class="container">
    <h3><a href='index.php'>Menu</a></h3>
</div>

<br/>

<!--<div class="pagination">-->
<!--    --><?php //for($i=1; $i<=ceil($count/10); $i++) { ?>
<!---->
<!--        <a class="--><?//= $offset/10+1==$i ? "active" : ""  ?><!--" href="index.php?offset=--><?//= ($i-1)*10 ?><!--">--><?//= $i ?><!--</a>-->
<!---->
<!--    --><?php //} ?>
<!--</div>-->


<br/>

</body>

</html>
