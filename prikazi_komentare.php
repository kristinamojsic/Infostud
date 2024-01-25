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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Komentari i ocene</title>

        <style>
            body
            {   
                margin:auto;
                background-image:linear-gradient(rgba(120,120,230,0.9),rgb(203,158,203));
                background-repeat:no-repeat;
                background-attachment: fixed;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            }
            .topnav {
               background-color:transparent;
               overflow: hidden;
               
           }
           .topnav a {
               line-height: 1.42857143;
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
           .kont
           {
                background-color:#f4f4f4;;
                border:1px solid grey;
                margin-left:20px;
                margin-right:20px;
                
                padding:10px;
                padding-top:0px;
                padding-left:20px;
                
           }
           #datum
        {
            color:grey;
            position:absolute;
            left:1250px;
            font-size:14px;
        }
            </style>
</head>
<body>
    <div class="topnav">
    <a href='odjava.php' >Odjavi se <i class='fa fa-sign-out'></i></a>
        <a href='prikazi_komentare.php'class='active' >Komentari <i class='	fa fa-comments'></i></a>
        <a href='prikazi_moje_oglase.php'>Moji oglasi</a>
        <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
        <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
    </div>
    <?php
    require_once 'db.php';
    $db = new Db();
    if($db->vidiKomentareIOcene($id))
    {
        echo "<div style='margin-top:20px'>";
        $niz = $db->vidiKomentareIOcene($id);
        foreach($niz as $komentar)
        {
            echo "<div class='kont'>
                    <p id='datum'>".$komentar['datum']."</p>
                    <p><b style='font-size:18px'>".$komentar['korisnicko_ime']."</b></p>
                    
                    <p>".$komentar['komentar']."</p>
                    <!--<p>Ocena:<i class='fa fa-fw fa-star-o' style='background-color:yellow'></i> ".$komentar['ocena']."</p></div>-->
                    <p>Ocena: ".$komentar['ocena']."</p>
                </div>";
        }
        echo "</div>";
    }
    else 
    {
        echo "<p style='text-align:center;color:white;font-size:24px'>Još uvek nemate komentare!</p>";
    }
}
    ?>
</body>
</html>