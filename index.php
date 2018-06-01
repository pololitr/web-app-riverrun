<?php
/**
 * Created by PhpStorm.
 * User: chms00
 * Date: 06.05.2018
 * Time: 14:40
 */
require 'db.php';
# pripojeni do db
# pristup jen pro prihlaseneho uzivatele
require 'user_required.php';
// http://php.net/manual/en/session.examples.basic.php
// Sessions can be started manually using the session_start() function. If the session.auto_start directive is set to 1, a session will automatically start on request startup.
// http://stackoverflow.com/questions/4649907/maximum-size-of-a-php-session
// You can store as much data as you like within in sessions. All sessions are stored on the server. The only limits you can reach is the maximum memory a script can consume at one time, which by default is 128MB.
//http://stackoverflow.com/questions/217420/ideal-php-session-size
# offset pro strankovani
$stmt_b = $db->prepare("SELECT id_cs FROM current_state");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];


?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8"/>
    <title>Kapitánva sekce | River Run</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include 'navbar.php' ?>
</head>
<body>
<div class="container text-center">
    <h1>Rozcestí kapitána</h1>
    <p>Výchozí bod pro řízení týmu</p>

    <?php
    if ($current_status["id_cs"] == 4) { ?>
        <h3><a href='results.php'>Výsledky</a></h3>
    <?php } ?>
    <h3><a href='myteam.php'>Můj tým</a></h3>
    <h3><a href='runnerSection.php'>Tým - Úseky</a></h3>
    <h3><a href='teams.php'>Všechny týmy</a></h3>
    <h3><a href='runners.php'>Všichni běžci</a></h3>
    <h3><a href='sections.php'>Všechny úseky</a></h3>
    <h3><a href='runners_sections_time.php'>Výsledky běžců dle týmů</a></h3>
    <br>
    <h3><a href='signout.php' onclick="return confirm('Oprvadu odhlásit?');">Odhlásit</a></h3>
</div>

<?php include 'footer.php' ?>
</div>
</body>
</html>