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

if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
} else {
    $offset = 0;
}
//$stmt = $db->prepare("SELECT * FROM goods ORDER BY id DESC LIMIT 10 OFFSET ?");



$count = $db->query("SELECT COUNT(ID_RUNNER) FROM runner join team on runner.team=team.id_team")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM runner join team on runner.team=team.id_team ORDER BY ID_RUNNER DESC LIMIT 10 OFFSET ?");
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->execute();
$clients = $stmt->fetchAll();


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | RiverRun</title>
    <?php include 'navbar.php' ?>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

<!--	--><?php //include 'navbar.php' ?>
<div class="container">
    <h1>Seznam bežců</h1>

    Aktuální počet všech běžců: <?= $count ?>

    <br/><br/>

    <!--	<a href="new.php">New Good</a>-->

    <br/><br/>

    <div class="table">
        <table class="table table-hover">
            <tr>
                <th>Číslo bežce</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>Tým</th>
            </tr>
            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td><?= $row['id_runner'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['name'] ?></td>
                </tr>

            <?php } ?>

        </table>
    </div>
    <div class="pagination">
        <?php for($i=1; $i<=ceil($count/10); $i++) { ?>

            <a class="<?= $offset/10+1==$i ? "active" : ""  ?>" href="runners.php?offset=<?= ($i-1)*10 ?>"><?= $i ?></a>

        <?php } ?>
    </div>
<!--    <h3><a href='index.php'>Menu</a></h3>-->

    <?php include 'footer.php' ?>
</div>
</body>

</html>
