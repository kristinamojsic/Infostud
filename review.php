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
    $id_poslodavca = $_GET['id_poslodavca'];
    require_once 'db.php';
    $db = new Db();
    $naziv_firme = $db->uzmiFirmu($id_poslodavca)[0]['firma'];
    
    

?>
<!DOCTYPE html>


<head>
    <title>Ostavi komentar</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">    


    <style>
        * {
            position: center;
            padding: 0;
        }
        
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
            margin-left:100px;
            margin-right:100px;
        }
        .rate {
            height: 46px;
            padding: 0 10px;
            position:relative;
            right:500px;
            
        }
        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }
        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }
        
        .rate:not(:checked)>label:before {
            content: '★ ';
            margin: 0;
        }
        
        .rate>input:checked~label {
            color: #ffc700;
        }
        
        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }
        
        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
        
        .col-md-3 {
            position: center;
            border: grey;
        }
        
        .btn {
            padding: 4px;
        }
        input[type=submit],input[type=reset]
        {
            border: 1px solid #fff;
            padding: 15px 30px;
            position:relative;
            
            border-radius: 25px;
            background-color:rgb(226 175 255 / 80%);
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #deb217;
        }
        h3
        {
            color:white;
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
    
    <div class="text-center kont">
        <h3>Recite nam nešto o Vašoj saradnji sa poslodavcem: <?php echo $naziv_firme?></h3>
        <hr style="border-top:1px dotted white;" />
        <form action="review.php?id_poslodavca=<?php echo $id_poslodavca;?>" method="post">
            <h3>Ocena:</h3>

                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" required/>
                    <label for="star5" >5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" >3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1">1 star</label>
                


            </div>
            <br>
            <br>
            
                <h3>Recenzija:</h3>
                <textarea id="review" class="form-control" name="review" style="resize:none; height:100px; width:500px;position:relative;left:330px" required></textarea>
            <br>
            <input type='submit' value="Potvrdi" name="potvrdi">
            <input type='reset' style="background-color:#c1c1c1" value="Odustani" name="odustani">
    
        
    </div>
    
    <?php
    if(isset($_POST['potvrdi'])){
        
        
        $ocena = $_POST['rate'];
        $komentar = $_POST['review'];
        
      

       if($db->dodajKomentarIOcenu($id, $id_poslodavca, $komentar, $ocena))
        {
            
            echo "<br><p style='color:white;text-align:center;font-size:20px'>Vaša recenzija je zabeležena. Zahvaljujemo na izdvojenom vremenu.</p>";
            
        }
        else
        {
            
        }
    }
}?>
</body>

</html>