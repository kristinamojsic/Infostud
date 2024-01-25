<?php
session_start();
if(isset($_SESSION['rola']))
{
    $rola = $_SESSION['rola'];
    $id = $_SESSION['autorizovan'];
}
else 
{
    $rola = 0;

}

?>
<html>
    <head>
        <title>Informacije o oglasu</title>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>

    function prijava(id_oglasa, p)
    {
        if(p)
        {
            window.open('prijava_konkurs.php?id_oglasa=' + id_oglasa, '_blank');
        }
        else
        {
            alert("Već ste se prijavili na konkurs!");
        }
        

    }
    function sacuvani(id_oglasa, s)
    {
        if(s)
        {
            window.location = "dodaj_sacuvani.php?id_oglasa=" + id_oglasa;
            
        }
        else
        {
            window.location = "prikazi_sacuvane.php";
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
                background-color: transparent;
                overflow: hidden;
            }
            h1
            {
                color:rgb(204, 119, 253);
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
                padding-top:20px;
                margin:30px;
                margin-top:5px;
            }
            #firma
            {
                text-decoration:none;
                font-weight:bold;
                color:black;
            }
            #prijava {
                
                text-decoration:none;
                background-color: rgba(69, 69, 241,0.8);
                height:20px;
                /*position:relative;
                left:1000px;
                bottom:40px;
                */
                position:absolute;
                top:150px;
                right:180px;
                cursor:pointer;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                font-size: 16px;
            }
            #bell{
                color: rgba(69, 69, 241,0.8);
                font-size:34px;
                position:absolute;
                top:153px;
                right:110px;
                cursor:pointer;
            }
        </style>
</head>
<body>
<?php 

if($rola == 1){
    echo "<div class='topnav'>
    <a href='azuriraj_podatke.php'  title='Azuriraj podatke' >Moj nalog <i class='fa f1-fw fa-user'></i></a>
    <a href='prikazi_moje_oglase.php'>Moji oglasi</a>
    <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
    <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
        
</div><br><br>";
}
else if($rola == 2)
{
    echo "<div class='topnav'> <a href='azuriraj_podatke.php'  title='Azuriraj podatke' >Moj nalog <i class='fa f1-fw fa-user'></i></a>
    <a href='prikazi_sacuvane.php'>Sačuvani oglasi</a>
    <a href='prikazi_konkurisane.php'>Prijavljeni konkursi</a>
    <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
</div><br><br>" ;
}
else if($rola==0)
{
    echo "<div class='topnav'>
    <a href='korisnik_prijava.php'><i class='fa fa-fw fa-user'></i>Log in</a>
    <a href='poslodavci.html'>Poslodavci</a>
    <a  href='pocetna.php'><i class='fa fa-fw fa-home'></i>Početna</a>
    </div><br><br>";
}
else if($rola==3)
{
    echo "<div class='topnav'>
    <a href='admin.php' class='active' >Administracija <i class='fas fa-user-cog'></i></a>
    <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
    </div><br><br>";
}


require_once 'db.php';
$db = new Db();

$id_oglasa = $_GET['id'];

$oglas = $db->stampajOglas($id_oglasa);
if(count($oglas) == 1 )
{
    echo "<div class='kont'>";
    echo "<h1><b>".$oglas[0]['pozicija']."</b></h1>";
    ?>
    <p><i class='fa fa-building' style='color:purple'></i><a id='firma' href="firma.php?id=<?php echo $oglas[0]['id_poslodavca']?>"><b><?php echo $oglas[0]['firma']?></b></a></p>
    <?php 
    echo "<p><i class='fa fa-map-marker' style='color:red'></i><b> ".$oglas[0]['naziv_grada']."</b></p>";
    echo "<p><i class='fa fa-clock-o'></i><b> Datum postavljanja: ".$oglas[0]['datum']."</b></p>";
    echo "<p><i class='fa fa-calendar'></i><b> Rok prijave: ".$oglas[0]['rok']."</b></p>";
    echo "<i class='fa fa-book' style='color:red;font-size:24px'></i><h2 style='display:inline-block'> Obrazovanje i iskustvo:</h2><br>";
    echo $oglas[0]['potrebna_skolska_sprema'];
    echo "<h2><b>Opis posla:</b></h2>";
    echo $oglas[0]['opis_i_pogodnost'];
    
    /*if($rola == 2)
    {
        $prijava = $db->proveriPrijavu($id, $id_oglasa);
        
        $sacuvan = $db->proveriSacuvane($id,$id_oglasa);
        ?>
        <a  onclick="prijava(<?php echo $id_oglasa?>,<?php echo $prijava?>)" id='prijava'>Prijavi se </a>
        
        <a onclick="sacuvani(<?php echo $id_oglasa?>,<?php echo $sacuvan?>)" id='bell' title='Sačuvaj oglas'><i class='fa fa-bell'></i></a>
       <?php 
    }*/
    echo "</div><br>";
    }


?>
</body>
</html> 
