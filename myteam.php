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

if ($current_user_team == NULL){
    header("Location: createTeam.php");
    exit();
}
//else

$count = $db->query("SELECT COUNT(ID_RUNNER) FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id")->fetchColumn();

$stmt = $db->prepare("SELECT ID_RUNNER, FIRSTNAME, LASTNAME, AVG_PHASE FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id ORDER BY ID_RUNNER");
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
	<h1>Seznam bežců</h1>
	Aktuální počet běžců v týmu: <?= $count ?>
	<br/><br/>

<div class="container">
    <h3><a href='addmemeber.php'>Nový člen týmu</a></h3>
</div>
	<br/><br/>
	<table>
		<tr>
			<th></th>
			<th>Identifikační číslo</th>
			<th>Jméno</th>
			<th>Příjmení</th>
            <th>Čas na kilometr</th>
		</tr>

		<?php foreach($clients as $row) { ?>

			<tr>
				<td class="center">
				</td>
				<td><?= $row['ID_RUNNER'] ?></td>
				<td><?= $row['FIRSTNAME'] ?></td>
				<td><?= $row['LASTNAME'] ?></td>
                <td><?= $row['AVG_PHASE'] ?></td>
                <td><a href='delete.php?id_runner=<?= $row['ID_RUNNER'] ?>'><button type="button">SMAZAT</button></a></td>


			</tr>

			<?php } ?>

		</table>


<div class="container">
    <h3><a href='index.php'>Menu</a></h3>
</div>

		</body>

		</html>
