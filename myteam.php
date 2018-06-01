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



$count = $db->query("SELECT COUNT(ID_RUNNER) FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id")->fetchColumn();

$stmt = $db->prepare("SELECT ID_RUNNER, FIRSTNAME, LASTNAME, runners_count, team.runners_count FROM runner join team on runner.team=team.id_team where captain_id = $current_user_id ORDER BY ID_RUNNER");
$stmt->execute();
$clients = $stmt->fetchAll();

$clients_b = $clients[0];
$count_set = $clients_b['runners_count'];

$stmt_b = $db->prepare("SELECT id_cs FROM current_state");
$stmt_b->execute();
$current_status = $stmt_b->fetchAll()[0];

if ($current_user_team == NULL && $current_status["id_cs"]!= 1){
    header("Location: index.php");
    exit();
}
elseif ($current_user_team == NULL) {
    header("Location: createTeam.php");
    exit();
}

$result = $count_set - $count;
if ($current_status["id_cs"] != 1) {
    header("Location: myteam_lite.php");
    exit();
}
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8"/>
    <title>Kapitánova sekce | VltavaRun</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php include 'navbar.php' ?>
</head>
<body>
<div id="id01" class="modal">
    <?php include 'addmemeber_modal.php' ?>
</div>
<div class="container">
    <h1>Seznam bežců</h1>
    Aktuální počet běžců v týmu: <?= $count ?><br>
    Počet běžců zadaných při vytvoření týmu: <?= $count_set ?>

    <?php
    if (($count_set - $count) > 0) { ?>
        <h3>Chybí vložit <?php echo($result) ?> běžce/běžců do týmu</h3>
    <?php } ?>
    <br/>
    <?php if ($count < $count_set) { ?>

    <button onclick="document.getElementById('id01').style.display='block'" style="padding-left: 10px;padding-right: 10px;width:auto; margin-bottom: 10px;margin-right: 5px">Nový člen týmu</button>
        <a href='runnerSection.php'><button type="button" style="padding-left: 10px;padding-right: 10px;width:auto; margin-bottom: 10px">Přiřaď členům úseky</button></a>



    <?php } ?>
    <br/>
    <div class="table">
        <table class="table table-hover">
            <tr>
                <th>Číslo běžce</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>Odeber člena</th>
            </tr>
            <?php foreach ($clients as $row) { ?>
                <tr>
                    <td><?= $row['ID_RUNNER'] ?></td>
                    <td><?= $row['FIRSTNAME'] ?></td>
                    <td><?= $row['LASTNAME'] ?></td>
                    <td><a href='delete.php?id_runner=<?= $row['ID_RUNNER'] ?>'>
                            <button type="button" class="cancelbtn" onclick="return confirm('Oprvadu smazat?');">SMAZAT</button>
                        </a></td>
                </tr>
            <?php } ?>

        </table>
    </div>


<!--    <h3><a href='index.php'>Menu</a></h3>-->
</div>
<?php include 'footer.php' ?>
<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>

</html>
