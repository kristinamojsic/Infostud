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
        
        <title>Odabrani oglasi</title>
        
        <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>

            function prijava(id_oglasa, p)
            {
                if(p)
                {
                    //window.location = "prijava_konkurs.php?id_oglasa=" + id_oglasa;
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
            .kont
            {
                background-color:white;
                padding:30px;
                margin:20px
            }
            h2 a
            {
                color:rgb(204, 119, 253);
                text-decoration:none;
            }
            a
            {
                text-decoration:none;
                color:black;
                
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
            #prijava {
                
                text-decoration:none;
                background-color: rgba(69, 69, 241,0.8);
                height:50px;
                position:relative;
                left:1000px;
                bottom:40px;
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
                position:relative;
                left:1050px;
                bottom:40px;
                cursor:pointer;
            }
    </style>
</head>
<body>

<?php

require_once 'db.php';
$db = new Db();

if(isset($_POST['id_grada']) && $_POST['id_grada']!="")
{
    $id_grada = $_POST['id_grada'];
}

if(isset($_POST['id_oblast_rada']) &&  $_POST['id_oblast_rada']!="")
{
    $id_oblast_rada = $_POST['id_oblast_rada'];    
}
if($_POST['id_grada']!="" && $_POST['id_oblast_rada']!="")
{
    $niz = $db->stampajListuOglasa($id_grada, $id_oblast_rada);
}
else if($_POST['id_grada']!="")
{
    $niz = $db->stampajListuOglasa($id_grada,null);
}
else if($_POST['id_oblast_rada']!="")
{
    $niz = $db->stampajListuOglasa(null, $id_oblast_rada);
}
else {
    
    $niz = $db->stampajListuOglasa(null, null);
    
}


if($rola == 0 ){
    echo "<div class='topnav'>
    <a href='korisnik_prijava.php'><i class='fa fa-fw fa-user'></i>Log in</a>
    <a href='istaknuti.html'>Poslodavci</a>
    <a  href='pocetna.php?'><i class='fa fa-fw fa-home'></i>Početna</a>
    </div>
    <br> <br>";
}
else if($rola == 1){
    echo "
    <div class='topnav'>
    <a href='azuriraj_podatke.php'>Moj nalog <i class='fa f1-fw fa-user'></i></a>
    <a href='prikazi_moje_oglase.php'>Moji oglasi</a>
    <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
    <a href='pocetna.php'><i class='fa fa-fw fa-home' ></i>Početna</a>
    
</div>
<br> <br>";
}
else if($rola==2)
{
    echo "<div class='topnav'>
    <a href='azuriraj_podatke.php'  title='Azuriraj podatke' >Moj nalog <i class='fa f1-fw fa-user'></i></a>
    <a href='prikazi_sacuvane.php'>Sačuvani oglasi</a>
    <a href='prikazi_konkurisane.php'>Prijavljeni konkursi</a>
    <a href='pocetna.php'  ><i class='fa fa-fw fa-home' ></i>Početna</a>

</div><br><br>";
}
else
{
    echo "<div class='topnav'>
    <a href='admin.php' class='active' >Administracija <i class='fas fa-user-cog'></i></a>
    <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
</div>";
}

if($niz)
{
    foreach($niz as $oglas)
    {
        $poslodavac = $oglas['id_poslodavca'];
        $id_oglasa = $oglas['id'];
        
        
        ?>
        <div class="kont">
            
            <h2><a target="_blank" href="prikazi_jedan_oglas.php?id=<?php echo $oglas['id']?>"><?php echo $oglas['pozicija']?></a></h2>       
            <p><i class='fa fa-building' style='color:purple'></i><a target='_blank' href="firma.php?id=<?php echo $oglas['id_poslodavca']?>"><b><?php echo $oglas['firma']?></b></a></p>
            <?php
        
        
        echo "<p><i class='fa fa-map-marker' style='color:red'></i><b> ".$oglas['naziv_grada']."</b></p>";
        echo "<p><i class='fa fa-clock-o'></i><b> Datum postavljanja: ".$oglas['datum']."</b></p>";
        echo "<p><i class='fa fa-calendar'></i><b> Rok za prijavu: ".$oglas['rok']."</b></p>";
        
       
        if($rola == 2){
            $prijava = $db->proveriPrijavu($id, $id_oglasa);
        
            $sacuvan = $db->proveriSacuvane($id,$id_oglasa);
            
            ?>
            <a  onclick="prijava(<?php echo $id_oglasa?>,<?php echo $prijava?>)" id='prijava'>Prijavi se </a>
            
            <a onclick="sacuvani(<?php echo $id_oglasa?>,<?php echo $sacuvan?>)" id='bell' title='Sačuvaj oglas'><i class='fa fa-bell'></i></a>
           <?php 
        }
        echo "</div><br>";
        
    }
}
else 
{
    echo "<p style='text-align:center;color:white;font-size:24px'>Žao nam je, nema dostupnih oglasa u Vašoj pretrazi.</p>";
}
?>

</body>
</html>