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
        <title>Moji oglasi</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="text/javascript">
            function brisi(id_oglasa)
            {
                if(confirm("Da li ste sigurni da želite da obrišete oglas?"))
                {
                    window.location = "obrisiOglas.php?id=" + id_oglasa;
                }
            }

        </script>
        <style>
            body
            {  
                background-image:linear-gradient(rgba(120,120,230,0.9),rgb(203,158,203));
                background-repeat:no-repeat;
                background-attachment: fixed;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                margin:auto;
            }
            .topnav {
               
                
                background-color:transparent;
                overflow: hidden;
            }
            .topnav a {

                line-height: 1.42857143;
                
                margin-top:0px;
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
                
                background-color:white;
                padding:30px;
                margin:20px;
                
                border: 1px solid blue;
            }
            h2 a
            {
                color:rgb(204, 119, 253);
            }
            .container a img {
                position:relative;
                left:1100px;
                bottom:200px;
                height:50px;
                width:50px;
            }
            
            a
            {
                text-decoration:none;
                cursor:pointer;
            }
            .button 
            {
                /*border-radius:15px;*/
                text-decoration:none;
                /*background-color: rgb(167, 12, 206);*/
                background-color: rgba(69, 69, 241,0.8);
                height:50px;
                position:relative;
                right:110px;
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
        
        
        <a href='azuriraj_podatke.php?'  title='Azuriraj podatke' >Moj nalog <i class="fa f1-fw fa-user"></i></a>
        <a href='prikazi_moje_oglase.php' class="active">Moji oglasi</a>
        <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
        <a href='pocetna.php?' ><i class="fa fa-fw fa-home" ></i>Početna</a>
        
        
    </div>

<?php

require_once 'db.php';
$db = new Db();

$niz = $db->stampajMojeOglase($id);

if($niz)
{
    foreach($niz as $oglas)
    {
        ?>
        <div style="font-size:20px;"class='container'>
            
            <h2><a href="prikazi_jedan_oglas.php?id=<?php echo $oglas['id']?>"><?php echo  $oglas['pozicija']?></a></h2>
                  
        <?php
        echo "<p ><i class='fa fa-building' style='color:purple'></i><b> ".$oglas['firma']."</b></p>";
        echo "<p><i class='fa fa-map-marker' style='color:red'></i><b> ".$oglas['naziv_grada']."</b></p>";
        echo "<p><i class='fa fa-clock-o'></i><b> Datum postavljanja: ".$oglas['datum']."</b></p>";
        echo "<p><i class='fa fa-calendar'></i><b> Rok za prijavu: ".$oglas['rok']."</b></p>";
        ?>
        <a href="izmeniOglas.php?id=<?php echo $oglas['id']?>" title='Izmeni oglas'><img src="images/update.png"  ></a>
        <a onclick="brisi(<?php echo $oglas['id']?>)" title="Obriši oglas"><img src="images/delete3.png" ></a>
        <a href="prikazi_prijavljene.php?id=<?php echo $oglas['id']?>"  class="button"><b>Prijavljeni korisnici</b></a>
    </div><br>
    <?php
    }
}
else 
{
    echo "<p style='text-align:center;color:white;font-size:24px'>Još uvek nemate oglase!</p>";
}
}
?>
</body>
</html>