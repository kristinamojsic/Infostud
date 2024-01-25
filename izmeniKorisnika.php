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
    


?><html>
    <head>
        <title>Izmena korisnika</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
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
            .kont
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

    <a href='odjava.php' >Odjavi se <i class='fa fa-sign-out'></i></a>
    <a href='admin.php' class='active' >Administracija <i class='fas fa-user-cog'></i></a>
    <a href='pocetna.php' ><i class="fa fa-fw fa-home" ></i>Početna</a>
    
    </div>
        
<?php

require_once 'db.php';

$db = new Db();
$id_korisnika= $_GET["id"];

$korisnik = $db->uzmiPodatkeOKorisniku($id_korisnika);
?>
<div class="text-center kont">

    <form action="<?php $_SERVER["PHP_SELF"] ?>" method='post'>
    <p><b>Ime:</b><br><input type="text" name="ime" value="<?php echo $korisnik[0]['ime']?>"></p>
    <p><b>Prezime: </b><br><input type="text" name="prezime" value="<?php echo $korisnik[0]['prezime']?>"></p>
    <p><b>Korisničko ime: </b><br><input type="text" name="korisnicko_ime" value="<?php echo $korisnik[0]['korisnicko_ime']?>"></p>
    <p><b>Email:</b><br> <input type="text" name="email" value="<?php echo $korisnik[0]['email']?>"></p>
    <p><b>Firma:</b><br> <input type="text" style="width:500px"  name="firma" value="<?php echo $korisnik[0]['firma']?>"></p>
    <br><p><input class="button" type="submit" name="izmeni" value='Izmeni'></p>


</form>
</div>
<?php


   if (isset ($_POST["izmeni"])) {
        $korisnicko_ime = $_POST["korisnicko_ime"];
        $email = $_POST["email"];
        $ime = $_POST["ime"];
        $prezime = $_POST["prezime"];
        $firma = $_POST["firma"];
        if($db->izmeniKorisnika($id_korisnika,$korisnicko_ime,$email,$ime,$prezime,$firma))
        {
            header("Refresh:0");
            
        }
        else{
            header("Refresh:0");
            
        }
   }
}
?>
</body>
</html>