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

$count = $db->query("SELECT COUNT(ID_SECTION) FROM section")->fetchColumn();

$stmt = $db->prepare("SELECT * FROM section  ORDER BY ID_SECTION ASC LIMIT 10 OFFSET ?");// LIMIT 12 OFFSET ?");
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->execute();
$clients = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>RiverRun 2018 | Kapitánská sekce</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include 'navbar.php' ?>
</head>
<body>
<div class="container">
    <h1>Seznam všech úseků</h1>
    Celkovy počet všech úseků: <?= $count ?>
    <br/><br/>
    <br/><br/>
    <div class="table">
        <table class="table table-hover">
            <tr>
                <th></th>
                <th>Číslo useku</th>
                <th>Start</th>
                <th>Cíl</th>
                <th>Délka(km)</th>
                <th>Náročnost</th>
                <th></th>
            </tr>
            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td class="center">
                    </td>
                    <td><?= $row['id_section'] ?></td>
                    <td class="right"><?= $row['start'] ?></td>
                    <td><?= $row['finish'] ?></td>
                    <td><?= $row['kilometers'] ?></td>
                    <td><?= $row['difficulty'] ?></td>
                </tr>
            <?php } ?>
        </table>
        <div class="pagination">
            <?php for($i=1; $i<=ceil($count/10); $i++) { ?>

                <a class="<?= $offset/10+1==$i ? "active" : ""  ?>" href="sections.php?offset=<?= ($i-1)*10 ?>"><?= $i ?></a>

            <?php } ?>
        </div>
    </div>
<!--    <h3><a href='index.php'>Menu</a></h3>-->
    <br/>
    <br/>
    <?php include 'footer.php' ?>
</div>
</body>

</html>
