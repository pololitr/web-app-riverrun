<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 06.05.2018
 * Time: 16:15
 */
require 'db.php';

$stmt = $db->prepare("select state, description from current_state join state on current_state.id_cs = state.id_stat");
$stmt->execute();
$state = $stmt->fetchAll()[0];

$current_state_name = $state["state"];
$current_state_desc = $state["description"];
?>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">River Run 2018</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Domů</a></li>
            <li><a href="myteam.php">Můj tým</a></li>
            <li><a href="runnerSection.php">Tým - Úseky</a></li>
            <li >
                <a style="font-weight: bold;" href="" onclick="return confirm(' Současný stav je:\n <?=$current_state_name?> \n\n To znamená:\n <?=$current_state_desc?>' );">
                    Současný stav je: <?=$current_state_name?>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Přihlášen jako <?= $current_user['firstname']," ", $current_user['lastname'] ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="signout.php">Odhlásit</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>