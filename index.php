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
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Vltava Run</title>
</head>
<body>
<?php include 'header.php' ?>
<div class="container">
    <div class="title text-center">
        <div class="centered">
            <h1>Main landing page</h1>
            <p>Výchozí bod pro kapitána</p>
        </div>
    </div>
</div>

<div class="container">
    <h3><a href='myteam.php'>Muj team</a></h3>
    <h3><a href='teams.php'>Vsechny teamy</a></h3>
    <h3><a href='runners.php'>Vsichni bezci</a></h3>
    <h3><a href='sections.php'>Useky</a></h3>
    <h3><a href='runnerSection.php'>Useky-bezci-team</a></h3>
    <br>
    <h3><a href='signout.php'>Odhlásit</a></h3>
</div>
<?php include 'footer.php' ?>
</body>
</html>