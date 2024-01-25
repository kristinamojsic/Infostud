<?php
session_start();
if(!isset($_SESSION['rola']))
{
    $ima_pristup = 0;
    
}
else
{
    if($_SESSION['rola']!=2 && $_SESSION['rola']!=1)
        $ima_pristup = 0;
    else
        $ima_pristup = 1;
}
if(!$ima_pristup)
{
    echo "<p><strong>Žao nam je, nemate pristup ovoj stranici. Morate biti prijavljeni.</strong></p><a href='pocetna.php'>Početna stranica</a>";
}
else{
    $rola = $_SESSION['rola'];
    $id_korisnika = $_SESSION['autorizovan'];
?>
<!DOCTYPE html>
<html>
    <head><title>Ažuriranje podataka</title>
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
            position:fixed;
            top:0px;
            right:0px;
            z-index:-1;
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
            text-decoration: none;
        }
        .topnav a.active
        {
            background-color:rgba(204, 119, 253,0.8);
            text-decoration: none;
        }
        .kont
        {
            padding-bottom:2%;
            border-radius:20px;
            background-color: white; 
            margin-left: 33%;
            margin-right:33%;
            margin-top:50px;
            padding-top:10px;
        }
        .button{
            background-image:linear-gradient(to right,rgba(69, 69, 241,0.8),rgb(202, 134, 202));
            height:50px;
            cursor:pointer;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            font-size: 16px;
        }
        .button:hover
        {
            opacity:0.8;
        }
        .labela{
            background-color: rgba(202, 134, 202,0.5);     
            display:inline-block;
            width:130px;
            color:white;
            padding: 5px;
            height:27px;
        }
        
        
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <div class='topnav'>
    <?php
      
      if($rola == 1){
        echo "
        <a href='odjava.php' class='active'>Odjavi se <i class='fa fa-sign-out'></i></a>
        <a href='prikazi_komentare.php' >Komentari <i class='	fa fa-comments'></i></a>
        <a href='prikazi_moje_oglase.php'>Moji oglasi</a>
        <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
        <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
        
        
    </div>"  ;
      }  
      else{
        echo "
        <a href='odjava.php' class='active'>Odjavi se <i class='fa fa-sign-out'></i></a>
        <a href='prikazi_sacuvane.php'>Sačuvani oglasi</a>
        <a href='prikazi_konkurisane.php'>Prijavljeni konkursi</a>
        <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
        
        
    </div>"  ;
      }

        require_once 'db.php';
        $db = new Db();
        $korisnik = $db->uzmiPodatkeOKorisniku($id_korisnika);
    ?>
        
        <div class="kont text-center" >
        <h1 style="color:rgba(69, 69, 241,0.8); padding-bottom:18px">Izmenite podatke</h1>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <p><p class="labela">Ime:</p><input type="text" name="ime" value="<?php echo $korisnik[0]['ime']?>"></p>
        <p><p class="labela">Prezime:</p><input type="text" name="prezime" value="<?php echo $korisnik[0]['prezime']?>"></p>
        <p><p class="labela">Korisničko ime:</p><input type="text" name="korisnicko_ime" value="<?php echo $korisnik[0]['korisnicko_ime']?>"></p>
        <p><p class="labela">Email:</p> <input type="text" name="email" value="<?php echo $korisnik[0]['email']?>"></p>
        <p><p class="labela">Šifra: </p><input type="password" name="sifra" ></p>
        <p><p class="labela">Grad: </p><input type="text" name="grad" value="<?php echo $korisnik[0]['naziv_grada']?>"></p>
        <p><input class="button" type="submit" name="izmeni" value='Izmeni'></p>
        </form>
    </div>
    <?php
    if(isset($_POST['izmeni'])){
        $sifra = $korisnik[0]['sifra'];
        $ime=$_POST['ime'];
        $prezime=$_POST['prezime'];
        $korisnicko_ime=$_POST['korisnicko_ime'];
        $email=$_POST['email'];
        if(isset($_POST['sifra']))
        {
            $sifra=$_POST['sifra'];
        }
    
        $grad=$_POST['grad'];

        if($db->azurirajPodatke($id_korisnika,$ime,$prezime,$korisnicko_ime,$email,$sifra,$grad,$rola))
        {
            header("Refresh:0");
        }
        else
        {
            header("Refresh:0");
        }
        }


    }
    ?>
</body>
    </html>