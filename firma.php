<?php 
session_start();
if(isset($_SESSION['autorizovan']))
{
    $rola = $_SESSION['rola'];
    $id = $_SESSION['autorizovan'];
}
else 
{
    $rola = 0;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Recenzije</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <script>
        function ukloni(id_poslodavca)
        {
            if(confirm('Da li ste sigurni da želite da obrišete komentar?'))
            {
                window.location = "ukloni_komentar.php?id_poslodavca=" + id_poslodavca;
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
        button
        {
            text-decoration:none;
            background-color: rgba(69, 69, 241,0.8);
            height:30px;
            cursor:pointer;
            border: none;
            color: white;
            padding: 5 10 5 10;
            text-align: center;
            font-size: 16px;
        }
    </style>

</head>
<body>
    <?php
    require_once 'db.php';
    $db = new Db();
    $id_poslodavca = $_GET['id'];
    
    if($rola == 0 ){
        echo "<div class='topnav'>
        <a href='korisnik_prijava.php'><i class='fa fa-fw fa-user'></i>Log in</a>
        
        <a href='istaknuti.html'>Poslodavci</a>
        <a  href='pocetna.php'><i class='fa fa-fw fa-home'></i>Početna</a>
        </div>
        <br> <br>";
    
    }
    else if($rola == 1){
        echo "
        <div class='topnav'>
        <a href='azuriraj_podatke.php'>Moj nalog <i class='fa f1-fw fa-user'></i></a>
        <a href='prikazi_moje_oglase.php'>Moji oglasi</a>
        <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
        <a href='pocetna.php'  ><i class='fa fa-fw fa-home' ></i>Početna</a>
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
    else if($rola==3){
        echo "<div class='topnav'>
        <a href='admin.php' class='active' >Administracija <i class='fas fa-user-cog'></i></a>
        <a href='pocetna.php' ><i class='fa fa-fw fa-home' ></i>Početna</a>
    </div>";
    }
    
    if($db->vidiKomentareIOcene($id_poslodavca)){
        echo "<div style='margin-top:20px'>";
        $niz = $db->vidiKomentareIOcene($id_poslodavca);
        foreach($niz as $komentar)
        {
            echo "<div class='kont'>
                    <p id='datum'>".$komentar['datum']."</p>
                    <p><b style='font-size:18px'>".$komentar['korisnicko_ime']."</b></p>
                    
                    <p>".$komentar['komentar']."</p>
                    
                    <p>Ocena: ".$komentar['ocena']."</p>";
                    if($rola==2 && $komentar['id_kandidata'] == $id)
                    {
                        echo "<button onclick='ukloni($id_poslodavca)'>Ukloni recenziju</button>";
                    }
                    echo "</div>";
        }
        
        echo "</div>";
    }
    else 
    {
        echo "<p style='text-align:center;color:white;font-size:24px'>Nema komentara o poslodavcu.</p>";
    }
    
    ?>
</body>
</html>