<?php
session_start();
if(isset($_SESSION['korisnicko_ime']))
{
    header("Location:pocetna.php");
}
require_once 'db.php';
$db = new Db();
if(isset($_POST['registracija']))
{   
    
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $email = $_POST['email'];;
    $sifra = $_POST['sifra'];
    $ponovljena = $_POST['sifra_potvrda'];
    $pol = $_POST['pol'];
    $id_grada = $_POST['id_grada'];
    $rola = $_POST['rola'];
    if($rola == 1)
    {
        $firma = $_POST['firma'];
    }
    
    if($sifra==$ponovljena)
    {
        if(isset($firma) && $id = $db->dodajKorisnika($ime,$prezime,$korisnicko_ime,$email,$sifra,$pol,$id_grada,$rola,$firma))
        {
            $_SESSION['autorizovan'] = $id;
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            $_SESSION['rola'] = $rola;
            echo '<script type="text/javascript"> window.open("pocetna.php","_self");</script>'; 
        }
        else if ($id = $db->dodajKorisnika($ime,$prezime,$korisnicko_ime,$email,$sifra,$pol,$id_grada,$rola))
        {
            $_SESSION['autorizovan'] = $id;
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            $_SESSION['rola'] = $rola;
            echo '<script type="text/javascript"> window.open("pocetna.php","_self");</script>'; 
        }
    }
    else 
    {
        $pogresna_sifra = "<p style='color:red;background-color:white'> Šifre se ne poklapaju!</p>";
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function firma_visible(){
            firm = document.getElementById("firma");
            if(document.getElementById("1").checked){
                firm.style.display='block';
            }
            else{
                firm.style.display='none';
            }
        }
        
        </script>
    <style>
        body
        {
            /*background-image:linear-gradient(rgba(69, 69, 241,0.8),rgb(202, 134, 202));*/
            background-image:linear-gradient(rgba(120,120,230,0.9),rgb(203,158,203));
                background-repeat:no-repeat;
                background-attachment: fixed;
        }
        input[type="submit"]
        {
            padding: 10px 16px;
            border:none;
            background-image:linear-gradient(to right,rgba(69, 69, 241,0.8),rgb(202, 134, 202));
            width:30%;
            border-radius: 15px;
            color:white;
        }
        
        input[type="submit"]:hover {
            opacity: 0.8;
            }
        input
        {
            border:none;
        }
        p,input[type="text"],input[type="password"],select
        {
            background-color:rgba(195, 132, 214,0.5);
            border-radius: 15px;
        }
        .kont 
        {
            padding-bottom:2%;
            border-radius:20px;
            background-color: white;
             margin-left: 33%; 
             margin-right:33%; 
             margin-top:0%;
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
        .hide{
            display:inline;
        }

    </style>
</head>
<body >
    <div class="topnav">
    <a href="korisnik_prijava.php" class="active"><i class="fa fa-fw fa-user"></i>Log in</a>
           
            <a href="istaknuti.html">Poslodavci</a>
            <a  href="pocetna.php"><i class="fa fa-fw fa-home"></i>Početna</a>
            
    </div>
    <div class=" text-center kont">
        <br><br>
        <h2 style="color:rgba(69, 69, 241,0.9)"><b> Registracija </b></h2><br>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <input type="text" name="ime" placeholder="Ime" required><br><br>
                <input type="text" name="prezime" placeholder="Prezime" required><br><br>
                <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required><br><br>
                <input type="text" name="email" placeholder="E-mail" required><br><br>
                <input type="password" name="sifra" placeholder="Šifra" required>
                <br><br>
                <input type="password" name="sifra_potvrda" placeholder="Potvrdite šifru" required>
                <br><br>
                <p style="display:inline-block;width:45px;">Pol:</p>
                <input type = "radio" name = "pol" id = "m" value='muski'>Muški
                <input type = "radio" name = "pol" id = "z" value='zenski'>Ženski<br>
                <!--<input type="text" name="grad" placeholder="Grad" required>-->
                <span style="color:rgba(69, 69, 241,0.9)">grad</span><br>
            <select name="id_grada" id="grad" required>
            <option name="beograd" value="1">Beograd</option>
                <option name="novi_sad" value="2">Novi Sad</option>
                <option  name="nis" value="3">Niš</option>
                <option name="kragujevac" value="4">Kragujevac</option>
                <option name="pristina" value="5">Priština</option>
                <option name="subotica" value="6">Subotica</option>
                <option name="zrenjanin" value="7">Zrenjanin</option>
                <option name="pancevo" value="8">Pančevo</option>
                <option name="cacak" value="9">Čačak</option>
                <option name="krusevac" value="10">Kruševac</option>
                <option name="kraljevo" value="11">Kraljevo</option>
                <option name="novi_pazar" value="12">Novi Pazar</option>
                <option name="smederevo" value="13">Smederevo</option>
                <option name="leskovac" value="14">Leskovac</option>
                <option name="uzice" value="15">Užice</option>
                <option name="vranje" value="16">Vranje</option>
                <option name="valjevo" value="17">Valjevo</option>
                <option name="sabac" value="18">Šabac</option>
                <option name="sombor" value="19">Sombor</option>
                <option name="pozarevac" value="20">Požarevac</option>
                <option name="pirot" value="21">Pirot</option>
                <option name="zajecar" value="22">Zaječar</option>
                <option name="kikinda" value="23">Kikinda</option>
                <option name="sremska_mitrovica" value="24">Sremska Mitrovica</option>
                <option name="jagodina" value="25">Jagodina</option>
                <option name="vrsac" value="26">Vršac</option>
                <option name="bor" value="27">Bor</option>
                <option name="prokuplje" value="28">Prokuplje</option>
                <option name="loznica" value="29">Loznica</option>
                <option name="arandjelovac" value="30">Aranđelovac</option>
                <option name="batocina" value="31">Batočina</option>
                <option name="backa_palanka" value="32">Bačka Palanka</option>
                <option name="aleksinac" value="33">Aleksinac</option>
                <option name="batajnica" value="34">Batajnica</option>
                <option name="becej" value="35">Bečej</option>
                <option name="borca" value="36">Borča</option>
                <option name="bujanovac" value="37">Bujanovac</option>
                <option name="velika_plana" value="38">Velika Plana</option>
                <option name="vrnjacka_banja" value="39">Vrnjacka Banja</option>
                <option name="gornji_milanovac" value="40">Gornji Milanovac</option>
                <option name="zlatibor" value="41">Zlatibor</option>
                <option name="ivanjica" value="42">Ivanjica</option>
                <option name="indjija" value="43">Inđija</option>
                <option name="knjazevac" value="44">Knjaževac</option>
                <option name="kula" value="45">Kula</option>
                <option name="lazarevac" value="46">Lazarevac</option>
                <option name="mladenovac" value="47">Mladenovac</option>
                <option name="negotin" value="48">Negotin</option>
                <option name="obrenovac" value="49">Obrenovac</option>
                <option name="paracin" value="50">Paraćin</option>
                <option name="pec" value="51">Peć</option>
                <option name="pirot" value="52">Pirot</option>
                <option name="pozega" value="53">Požega</option>
                <option name="prijepolje" value="54">Prijepolje</option>
                <option name="prizren" value="55">Prizren</option>
                <option name="ruma" value="56">Ruma</option>
                <option name="sjenica" value="57">Sjenica</option>
                <option name="smederevska_palanka" value="58">Smederevska Palanka</option>
                <option name="futog" value="59">Futog</option>
                <option name="sid" value="60">Šid</option>
                <option name="surcin" value="61">Surčin</option>
                <option name="temerin" value="62">Temerin</option>
                <option name="cuprija" value="63">Ćuprija</option>
                <option name="online" value="64">online</option>
                </select><br><br>
                <p style="display:inline-block;width:120px;">Prijavite se kao:</p><br>
                <input type="radio" name="rola"  value= "1" id="1" onclick="firma_visible()">Poslodavac<br>
                <input type="radio" name="rola"  value="2" id="2" onclick="firma_visible()">Kandidat
                <br>
                <input type="text" style='display:none;margin-left:31%;' id="firma" name="firma" placeholder="Firma"><br>
                <?php
                if(isset($pogresna_sifra))
                {
                    echo $pogresna_sifra;
                }
                ?>
                <input type="submit" name="registracija" value="Registrujte se">
            </form>
        </div>
</body>
</html>