<?php
# pripojeni do db
require 'db.php';
require 'user_required.php';

$stmt = $db->prepare("UPDATE runner_section set id_r = NULL where id_rs = ?");
$stmt->execute(array($_GET['id_rs']));


header('Location: runnerSection.php');

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
