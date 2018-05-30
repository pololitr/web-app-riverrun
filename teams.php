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
	<meta charset="utf-8" />
	<title>Kapitánova sekce | VltavaRun</title>

	<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

<!--	--><?php //include 'navbar.php' ?>

	<h1>Seznam tymu</h1>

	celkovy pocet tymu: <?= $count ?>

	<br/><br/>

<!--	<a href="new.php">New Good</a>-->

	<br/><br/>

	<table>

		<tr>

			<th></th>
			<th>Identifikační číslo týmu</th>
			<th>Nazev týmu</th>
			<th>ID kapitána</th>
            <th>Počet vozidel</th>
            <th>Počet běžců</th>
			<th></th>


		</tr>

		<?php foreach($clients as $row) { ?>

			<tr>
				<td class="center">
<!--					<a href='buy.php?id=--><?//= $row['id'] ?><!--'>Buy</a>-->
				</td>

				<td><?= $row['id_team'] ?></td>
				<td class="right"><?= $row['name'] ?></td>
				<td><?= $row['captain_id'] ?></td>
                <td><?= $row['car_count'] ?></td>
                <td><?= $row['runners_count'] ?></td>

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
		</body>

		</html>
