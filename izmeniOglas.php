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
    
   
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Izmena oglasa</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body
            {
                
                background-image:linear-gradient(rgba(120,120,230,0.9),rgb(203,158,203));
                background-repeat:no-repeat;
                background-attachment: fixed;
            }
            .topnav {
                background-color: transparent;
                overflow: hidden;
        }
            .topnav a {
                float: right;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }
            .topnav a:hover {
                background-color: rgba(204, 119, 253,0.8);
                color:rgba(69, 69, 241,0.9);
            }
            .topnav a.active
            {
                background-color:rgba(204, 119, 253,0.8);
            }
            .container
            {
                margin-top:40px;
            }
            p
            {
                font-size:20px;
            }
            b
            {
                color:white;
            }
            input
            {
                border:none;
            }
            .button
            {
                background-color: rgb(167, 12, 206);
                height:50px;
                cursor:pointer;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
  
                font-size: 16px;
            }
    </style>
    </head>
    <body>
    <div class='topnav'>
        
        <a href='azuriraj_podatke.php'  title='Azuriraj podatke' >Moj nalog <i class="fa f1-fw fa-user"></i></a>
        <a href='prikazi_moje_oglase.php' class="active">Moji oglasi</a>
        <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
        <a href='pocetna.php' ><i class="fa fa-fw fa-home" ></i>Početna</a>
        
        
    </div>
<?php

require_once 'db.php';

$db = new Db();
$id = $_GET["id"];

$oglas = $db->stampajOglas($id);
?>
<div class="text-center container">

    <form action="<?php $_SERVER["PHP_SELF"] ?>" method='post'>
    <p><b>Naziv:</b><br><input type="text" name="naziv" value="<?php echo $oglas[0]['pozicija']?>"></p>
    <p><b>Školska sprema: </b><br><input type="text" name="skolska_sprema" value="<?php echo $oglas[0]['potrebna_skolska_sprema']?>"></p>
    <p><b>Grad: </b><br><input type="text" name="grad" value="<?php echo $oglas[0]['naziv_grada']?>"></p>
    <p><b>Rok za prijavu:</b><br> <input type="date" name="rok" value="<?php echo $oglas[0]['rok']?>"></p>
    <p><b>Opis i pogodnost:</b><br> <textarea style="width:500px;height:150px"   name="opis_i_pogodnost" ><?php echo $oglas[0]['opis_i_pogodnost']?></textarea></p>
    <br><p><input class="button" type="submit" name="izmeni" value='Izmeni'></p>
    

</form>
</div>
<?php


   if (isset ($_POST["izmeni"])) {
        $naziv = $_POST["naziv"];
        $grad = $_POST["grad"];
        $skolska_sprema = $_POST["skolska_sprema"];
        $opis_i_pogodnost = $_POST["opis_i_pogodnost"];
        $rok = $_POST["rok"];
        
        if($db->izmeniOglas($id,$naziv,$grad,$skolska_sprema,$opis_i_pogodnost,$rok))
        {
            
            header("Location:prikazi_moje_oglase.php");
            
        }
        else{
            header("Location:prikazi_moje_oglase.php");
        }
   }
}
?>
</body>
</html>