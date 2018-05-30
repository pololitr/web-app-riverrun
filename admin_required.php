<?php
require 'db.php';
# php HTTP autentizace
# http://php.net/manual/en/features.http-auth.php

$valid_passwords = array("admin" => "admin");
$valid_users = array_keys($valid_passwords);


$user = @$_SERVER['PHP_AUTH_USER'];
$password = @$_SERVER['PHP_AUTH_PW'];


$validated = (in_array($user, $valid_users)) && ($password == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="Dneska je venku hezky"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Unauthorized");
}

$stmt = $db->prepare("SELECT id_stat, state, description FROM state order by id_stat");
$stmt->execute();
$status = $stmt->fetchAll();

$stmt_b = $db->prepare("SELECT id_stat, state, description FROM state join current_state cs on state.id_stat = cs.id_cs order by id_stat");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $set_status = $_POST['state_picker'];

    $stmt_d = $db->prepare("UPDATE current_state set id_cs = ?");
    $stmt_d->execute(array($set_status));

    header('Location: admin_required.php');
}


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Vltava Run</title>
</head>
<body>
<p>Současný status závodu je <?= "<h1>",$current_status["state"],"</h1><br>",$current_status["description"]?></p>
</br>
Vyberte status závodu
<form action="" method="POST">
    <select name='state_picker' class='selectpicker'>
        <?php foreach ($status as $tr) {
            var_dump($tr);
            $tr_b = $tr[0];
            $tr_c = $tr[1];
            $tr_d = $tr[2];
            ?>
            <option value="<?= $tr_b ?>"><?= "ID: ", $tr_b, " ~ ", $tr_c, " -> ", $tr_d ?>
            </option>
        <?php } ?>
    </select>
    <input type="submit" value="Přiřaď" class="login loginmodal-submit">
</form>
<h3><a href='signout.php'>Odhlásit</a></h3>
</body>
</html>