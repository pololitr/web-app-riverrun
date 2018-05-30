<?php
# pripojeni do db
require 'db.php';
require 'user_required.php';

$current_user_id = $current_user["id_runner"];
$current_user_team = $current_user["team"];

if($current_user_id = $_GET['id_runner']){
    header('Location: myteam.php');
}

$stmt = $db->prepare("UPDATE runner set team = NULL where id_runner = ? and team = $current_user_team and id_runner != $current_user_id");
$stmt->execute(array($_GET['id_runner']));

$stmt_b = $db->prepare("DELETE FROM runner WHERE id_runner=?");
$stmt_b->execute(array($_GET['id_runner']));

header('Location: myteam.php');

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>PHP Shopping App</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

</body>

</html>
