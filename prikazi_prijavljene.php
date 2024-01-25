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
<html>
    <head>
        <title>Lista prijavljenih</title>
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
        ol
        {
            background-color:white;
            margin:auto 40px;
            padding-top:20px;
           
        }
        li
        {
            font-size:20px;
            margin-top:20px;
        }
        ol li::marker{
            color:rgba(69, 69, 241,0.8);
        }

        p
        {
            margin-top:30px;
            font-size:25px;
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
$id = $_GET['id'];
$niz = $db->listaPrijavljenih($id);
if($niz)
{
    echo "<ol>";
    foreach($niz as $prijava)
    {
        
        echo "<li>";
        echo "<b>Ime:</b>".$prijava['ime']."<br>";
        echo "<b>Prezime:</b>".$prijava['prezime']."<br>";
        echo "<b>Email:</b>".$prijava['email']."<br>";
        echo "<b>Grad:</b>".$prijava['naziv_grada']."<br>";
        echo "<b>Pol:</b>".$prijava['pol']."<br>";
        echo "<b>Stručna sprema:</b>".$prijava['strucna_sprema']."<br>";
        echo "<b>Radno iskustvo:</b>".$prijava['radno_iskustvo']."<br>";
        
        $CV = $prijava['CV'];
        ?>
        
        <a  download="CV_<?php echo $prijava['ime']?>_<?php echo $prijava['prezime']?>.PDF" href="data:application/pdf;base64,<?php echo base64_encode($CV)?>">Preuzmite CV</a>
    </li><br>
    
        <?php
        
    }
    echo "</ol>";
}

else
{
    echo "<p style='text-align:center;color:white;font-size:24px'>Još uvek nema prijavljenih na dati konkurs!</p>";
}
}
    ?>
    
</body>
</html>
    
