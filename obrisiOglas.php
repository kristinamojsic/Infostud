<?php

session_start();
if(!isset($_SESSION['rola']))
{
    $ima_pristup = 0;
    
}
else
{
    if($_SESSION['rola']!=1)
        $ima_pristup = 0;
    else
        $ima_pristup = 1;
}
if(!$ima_pristup)
{
    echo "<p><strong>Žao nam je, nemate pristup ovoj stranici. Vaša sesija je istekla ili nista prijavljeni kao poslodavac.</strong></p><a href='pocetna.php'>Početna stranica</a>";
}
else{
    $rola = $_SESSION['rola'];
    $id = $_SESSION['autorizovan'];
    require_once 'db.php';
    $db = new Db();
    $id_oglasa = $_GET['id'];
    $db->obrisiOglas($id_oglasa);
    header("Location:prikazi_moje_oglase.php");
}
?>