<?php
session_start();
$id = $_SESSION['autorizovan'];
$id_poslodavca = $_GET['id_poslodavca'];
require_once 'db.php';
$db = new Db();
if($db->ukloniKomentar($id, $id_poslodavca))
{
    header("Location:firma.php?id=$id_poslodavca");
}
else
{
    header("Location:firma.php?id=$id_poslodavca");
}

?>