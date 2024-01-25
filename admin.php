<?php
session_start();
$rola = $_SESSION['rola'];
if($rola!=3)
{
    echo "<p><strong>Žao nam je, nemate pristup ovoj stranici.<br><br>Vaša sesija je istekla ili niste prijavljeni kao admin.</strong></p>";
}
else
{


?>
<html>
<head>
<link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title> Administracija </title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function brisi(id_korisnika)
        {
            if(confirm("Da li ste sigurni da želite da obrišete korisnika, kao i njegove oglase?"))
            {
                window.location = "obrisiKorisnika.php?id=" + id_korisnika;
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
            
                background-color:white;
                padding:30px;
                margin:20px;
                border: 1px solid blue;
            }
            h2
            {
                color:rgb(204, 119, 253);
            }
            .kont a{
                position:relative;
                left:1150px;
                bottom:200px;
                top:3px;
                height:50px;
                width:50px;
            }
            .kont a img{
                height:50px;
                width:50px;
            }
            
            a
            {
                text-decoration:none;
                cursor:pointer;
            }
           
            .broj
            {
                margin-top:unset;
                margin-left:20px;     
                color:white;
                font-size:20px;
                font-weight:bold;
                display:inline-block;
                padding:10px;
                background-color:rgba(204, 119, 253,0.8);
            }
            
        </style></head>

<body>

<div class='topnav'>

        <a href='odjava.php' >Odjavi se <i class='fa fa-sign-out'></i></a>
        <a href='admin.php' class='active' >Administracija <i class='fas fa-user-cog'></i></a>
        <a href='pocetna.php' ><i class="fa fa-fw fa-home" ></i>Početna</a>
</div>
<br><br>
<?php
    require_once 'db.php';
    $db = new Db();

    $niz = $db->sviKorisnici();
    $niz2 = $db->stampajListuOglasa(null,null);
    $korisnici = count($niz);
    $oglasi = count($niz2);
    echo "<p class='broj' ><i>Broj prijavljenih korisnika: $korisnici</i></p>
    <p class='broj' style='position:relative;left:740px;'><i>Broj aktivnih oglasa: $oglasi</i></p>
    ";

    if($niz)
    {
        foreach($niz as $korisnik)
        {?>       
        <div style="font-size:20px;"class='kont'>
            <h2><i style='color:black'>korisničko ime: </i><?php echo $korisnik['korisnicko_ime']?></h2>
        <?php
        echo "<h2> <i style='color:black'>ime: </i> ".$korisnik['ime']."</b></h2>";
        echo "<h2><i  style='color:black'>prezime: </i> ".$korisnik['prezime']."</h2>";
        echo "<h2><i  style='color:black'>email: </i> ".$korisnik['email']."</h2>";
        ?>
        <a href="izmeniKorisnika.php?id=<?php echo $korisnik['id']?>" title='Izmeni korisnika'><img src="images/update.png"  ></a>
        <a onclick="brisi(<?php echo $korisnik['id']?>)" title="Obriši korisnika"><img src="images/delete3.png" ></a>
        </div><br>
    <?php
    }
    }
    else 
    {
        echo "<strong style='font-size:20px;color:white;text-align:center'>Lista korisnka je prazna</strong>";
    }

}
?>
</body>
</html>