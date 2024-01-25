<?php
session_start();
if(!isset($_SESSION['rola']))
{
    $ima_pristup = 0;
    
}
else
{
    if($_SESSION['rola']!=2)
        $ima_pristup = 0;
    else
        $ima_pristup = 1;
}
if(!$ima_pristup)
{
    echo "<p><strong>Žao nam je, nemate pristup ovoj stranici. Vaša sesija je istekla ili nista prijavljeni kao kandidat.</strong></p><a href='pocetna.php'>Početna stranica</a>";
}
else{
    $rola = $_SESSION['rola'];
    $id = $_SESSION['autorizovan'];
    ?>
<html>
    <head>
        <title>Konkurisani oglasi</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            function odjava(id_oglasa)
            {
                if(confirm("Da li ste sigurni da želite da se odjavite sa konkursa?"))
                {
                    window.location = "ukloniPrijavu.php?id_oglasa=" + id_oglasa ;
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
                margin:auto;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
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
                background-color:rgba(204, 119, 253,0.8);
                color: white;
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
                #odjavaa,#komentar {
            /*border-radius:15px;*/
                    text-decoration:none;
                    /*background-color: rgb(167, 12, 206);*/
                    background-color: rgba(69, 69, 241,0.8);
                    height:50px;
                    position:relative;
                    left:850px;
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
                left:900px;
                bottom:40px;
                cursor:pointer;
            }

    </style>


</head>
<body>
<div class="topnav">
            <a href='azuriraj_podatke.php'  title='Azuriraj podatke' >Moj nalog <i class='fa f1-fw fa-user'></i></a>
            <a href='prikazi_sacuvane.php'>Sačuvani oglasi</a>
            <a href='prikazi_konkurisane.php' class='active'>Prijavljeni konkursi</a>
            <a href='pocetna.php'><i class='fa fa-fw fa-home' ></i>Početna</a>
   
    </div>
    <?php
    require_once 'db.php';
    $db = new Db();
    $niz = $db->listaKonkurisanih($id);
    
    if($niz)
    {
        
        foreach($niz as $oglas)
        {
            
            ?>
            <div style="font-size:20px;"class='kont'>
                
                <h2><a href="prikazi_jedan_oglas.php?id=<?php echo $oglas['id']?>" ><?php echo  $oglas['pozicija']?></a></h2>
                <p><i class='fa fa-building' style='color:purple'></i><a href="firma.php?id=<?php echo $oglas['id_poslodavca']?>" style='text-decoration:none'><b><?php echo $oglas['firma']?></b></a></p>
            <?php
            $id_oglasa = $oglas['id'];
            $sacuvan = $db->proveriSacuvane($id,$id_oglasa);
            
            echo "<p><i class='fa fa-map-marker' style='color:red'></i><b> ".$oglas['naziv_grada']."</b></p>";
            echo "<p><i class='fa fa-clock-o'></i><b> Datum postavljanja: ".$oglas['datum']."</b></p>";
            echo "<p><i class='fa fa-calendar'></i><b> Rok za prijavu: ".$oglas['rok']."</b></p>";

            ?>
            <a href="review.php?id_poslodavca=<?php echo $oglas['id_poslodavca']?> " id='komentar'>Oceni firmu</a> 
            <a onclick="odjava(<?php echo $id_oglasa?>)" id='odjavaa' style='left:870px'>Odustani </a>
           
            <a onclick="sacuvani(<?php echo $id_oglasa?>,<?php echo $sacuvan?>)" id='bell' title='Sačuvaj oglas'><i class='fa fa-bell'></i></a>
        </div><br>
            
      <?php
    }}
    else 
{
    echo "<p style='text-align:center;color:white;font-size:24px'>Niste se prijavili ni na jedan trenutno aktivan oglas.</p>";
}
}
    ?>
</body>
</html>