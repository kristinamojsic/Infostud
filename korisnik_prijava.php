<?php
session_start();
if(isset($_SESSION['korisnicko_ime']))
{
    header("Location:pocetna.php");
}
require_once 'db.php';
$db = new Db();
if(isset($_POST['prijava']))
{
    
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $sifra = $_POST['sifra'];
    if($db->proveriKorisnika($korisnicko_ime,$sifra))
    {
        $korisnik = $db->proveriKorisnika($korisnicko_ime,$sifra);
        $_SESSION['korisnicko_ime'] = $korisnik['korisnicko_ime'];
        $_SESSION['rola'] = $korisnik['rola'];
        $_SESSION['autorizovan'] = $korisnik['id'];
        echo '<script type="text/javascript"> window.open("pocetna.php","_self");</script>';      
    }
    else 
    {
        $pogresno = "<br><br><p style='color:red'>Pogrešno korisničko ime ili šifra! Pokušajte ponovo.</p>";
    }
}


?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prijava</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body
        {
            
            background-image:linear-gradient(rgba(120,120,230,0.9),rgb(203,158,203));
            background-repeat:no-repeat;
            background-attachment: fixed;
            margin:auto;
        }

        .kont
        {
            padding-bottom:2%;
            border-radius:20px;
            background-color: white; 
            margin-left: 33%;
            margin-right:33%; 
            margin-top:3%; 
        }
        .inp
        {
            border:none;
            background-color:rgba(195, 132, 214,0.5);
            border-radius: 15px;
            height:30px;
            width:250px
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
        .topnav a.active {
                background-color: rgba(204, 119, 253,0.8);
                color: white;
            }
        
            button:hover {
                opacity: 0.8;
                }
            #button:hover
            {
                opacity: 0.8;
            }
            button, #button
            {
                padding: 10px 16px;
                border:none;
                background-image:linear-gradient(to right,rgba(69, 69, 241,0.8),rgb(202, 134, 202));
                width:30%;
                border-radius: 15px; 
                color:white;
            }
            h2 {
                font-family: 'Source Sans Pro', sans-serif;
            }

    </style>
</head>

<body >

<div class="topnav">
<a href="korisnik_prijava.php" class="active"><i class="fa fa-fw fa-user"></i>Log in</a>
<a href="istaknuti.html">Poslodavci</a>
<a  href="pocetna.php"><i class="fa fa-fw fa-home"></i>Početna</a>
            
            
</div>
<div class="text-center kont">
        <br><br>
        <img src="images/blog-wp-login-1200x400.png" style="width:450px; height:150px;">
        <h2 style="color:rgba(69, 69, 241,0.9)"><b>Prijava</b></h2><br>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <i style="color:purple;"class="fa fa-fw fa-user" ></i><input type="text"  class= "inp"name="korisnicko_ime" placeholder="Korisničko ime" required><br><br>
            <i style="color:purple;"class="fa fa-key" ></i><input type="password" class="inp" name="sifra" placeholder="Šifra" required >
            <br><br>
            <input type="submit" id="button" name="prijava" value="Prijavite se"> </input>
            <?php 
            if(isset($pogresno)){
                echo $pogresno;
            }
            ?>
            </form><br>
            <div>
                <b style="font-size: 16px;color:rgba(69, 69, 241,0.9)">Niste član?</b><br>
                <button onclick="window.location.href='korisnik_registracija.php'" >Napravite nalog</button>
            </div>
</div>

</body>
</html>