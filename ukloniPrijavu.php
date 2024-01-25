<?php
session_start();
if(!isset($_SESSION['rola']))
{
    $ima_pristup = 0;
    
}
else
{
    if($_SESSION['rola']!=2)
        $ima_pristup = 0;
    else
        $ima_pristup = 1;
}
if(!$ima_pristup)
{
    echo "<p><strong>Žao nam je, nemate pristup ovoj stranici. Vaša sesija je istekla ili nista prijavljeni kao kandidat.</strong></p><a href='pocetna.php'>Početna stranica</a>";
}
else{
    $rola = $_SESSION['rola'];
    $id = $_SESSION['autorizovan'];
    $id_oglasa = $_GET['id_oglasa'];


    require_once 'db.php';
    $db = new Db();
    $db->ukloniPrijavu($id,$id_oglasa);
    header("Location: prikazi_konkurisane.php");
}
?>