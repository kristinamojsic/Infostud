<?php

session_start();
if(!isset($_SESSION['rola']))
{
    $ima_pristup = 0;
    
}
else
{
    if($_SESSION['rola']!=3)
        $ima_pristup = 0;
    else
        $ima_pristup = 1;
}
if(!$ima_pristup)
{
    echo "<p><strong>Žao nam je, samo admin ima pristup ovoj stranici.</strong></p><a href='pocetna.php'>Početna stranica</a>";
}
else{
    $rola = $_SESSION['rola'];
    require_once 'db.php';
    $db = new Db();
    $id_korisnika = $_GET['id'];
    $db->izbrisiKorisnika($id_korisnika);
    header("Location:admin.php");
}
?>