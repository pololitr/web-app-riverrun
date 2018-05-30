<?php
//pripojeni do db na loaclu
$db = new PDO('mysql:host=127.0.0.1:3306;dbname=riverrun;charset=utf8', 'root', 'tondovomama69');

//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
?>