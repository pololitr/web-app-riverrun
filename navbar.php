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
//$current_state_desc = $state["description"];
?>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">River Run 2018</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Domů</a></li>
            <li><a href="myteam.php">Můj tým</a></li>
            <li><a href="runnerSection.php">Úseky</a></li>

        </ul>
        <ul class="nav navbar-nav">
            <li><h2>Současný stav je: <?=$current_state_name?><h2></li>
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