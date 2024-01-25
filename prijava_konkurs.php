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
    $id_oglasa = $_GET['id_oglasa'];
    require_once 'db.php';
    $db = new Db();
    $pozicija = $db->uzmiPoziciju($id_oglasa)[0]['pozicija'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prijava na konkurs</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            #forma
            {
                padding-bottom:2%;
                border-radius:20px;
                background-color: white;
                margin-left: 33%; 
                margin-right:33%; 
                /*margin-top:5%;*/
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
            
            input, textarea
            {
                border:none;
                background-color:rgba(195, 132, 214,0.5);
                border-radius: 15px
            }
            input[name='prijava']
            {
                padding:10px;
            }
            input[name='prijava']:hover
            {
                opacity:0.8;
                
                        
            }
       </style> 
    </head>
    <body>
        <section class='first'>
        <div class="topnav">
            <a href='azuriraj_podatke.php'  title='Azuriraj podatke' >Moj nalog <i class='fa f1-fw fa-user'></i></a>
            <a href='prikazi_sacuvane.php'>Sačuvani oglasi</a>
            <a href='prikazi_konkurisane.php'>Prijavljeni konkursi</a>
            <a href='pocetna.php'><i class='fa fa-fw fa-home' ></i>Početna</a>
   
    </div>
        <div class="text-center" id="forma" >
            <br>
            <h2 style="color:rgba(69, 69, 241,0.9)"><b>Prijava na konkurs: <br> <?php echo $pozicija?></b></h2><br>
            <form action="prijava_konkurs?id_oglasa=<?php echo $id_oglasa?>" method="post" enctype="multipart/form-data">
                <input type="text" name="ime" id="ime" placeholder="Ime:" required><br><br>
                <input type="text" name="prezime" id="prezime" placeholder="Prezime:" required><br><br>
                <textarea  rows="3" cols="50" name="strucna_sprema" id="strucna_sprema" placeholder="Strucna sprema:" required></textarea><br><br>
                
                <textarea  rows="3" cols="50" name="radno_iskustvo" id="radno_iskustvo" placeholder="Radno iskustvo:" required></textarea><br><br>
                <div class="text-center" style="display:inline-block">
                    <span style="color:rgba(69, 69, 241,0.9)">CV:</span>
                    <input type="file" style="display:inline-block;" id="CV" name="CV" placeholder="CV" required><br><br>
        </div>
        <div>
        <input type="submit" name="prijava" value="Potvrdi prijavu" style="color:white;background-image:linear-gradient(to right,rgba(69, 69, 241,0.8),rgb(202, 134, 202));" >
        </div>
</section>
<?php



if(isset($_POST['prijava'])){
    
    $strucna_sprema = $_POST['strucna_sprema'];
    $radno_iskustvo = $_POST['radno_iskustvo'];
    $CV_name = $_FILES['CV']['name'];
    $CV_tmp = $_FILES['CV']['tmp_name'];
    $CV = file_get_contents($CV_tmp);
    
    if($db->dodajPrijavu($id,$strucna_sprema,$radno_iskustvo,$CV,$id_oglasa)){
        echo "<p class='text-center' style='font-size:18px;color:white'>Uspešno ste se prijavili na konkurs.</p>";
    }
}   
}

?>