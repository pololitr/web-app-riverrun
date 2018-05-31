<?php
//pripojeni do db na loaclu
//$db = new PDO('mysql:host=127.0.0.1:3306;dbname=chms00;charset=utf8', 'root', 'tondovomama69');
$db = new PDO('mysql:host=127.0.0.1;dbname=chms00;charset=utf8', 'chms00', 'gDcgEE4EgRmRwCJTGy');
//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
?>

