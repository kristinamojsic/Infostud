<?php
session_start();
if(isset($_SESSION['autorizovan']))
{
    $rola = $_SESSION['rola'];
}else
{
    $rola = 0;
}


?>
<html>

<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title> Oglašavanje </title>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
            
        body {
            margin: 0;
            padding: 0;
            background-image:linear-gradient(rgba(120,120,230,0.9),rgb(203,158,203));
            background-size: cover;
            font-family: sans-serif;
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
        
        .search-field {
            height: 30px;
            padding: 10px;
            border-radius: 25px;
            border: none;
            outline: none;
        }
        
        .search-btn {
            height: 50px;
            width: 150px;
            background:rgba(204, 119, 253,0.8);
            border: none;
            color: white;
            border-radius: 25px;

        }
        
        h1 {
            /*margin: 0. 0 10px;*/
            margin-left:10px;
            padding: 0;
            color: #fff
        }
        
        .box {
            position: absolute;
        }
        
        input {
            position: relative;
            display: inline-block;
            font-size: 20px;
            box-sizing: border-box;
            transition: 5s;
        }
        
        input[type="text"] {
            background: #fff;
            width: 340px;
            height: 50px;
            border: none;
            outline: none;
            padding: 0 25px;
            border-radius: 25px 0 0 25px;
        }
        .oblast {
            border-radius: 25px;
            border-color: white;
            background-color: white;
            position: relative;
            display: inline-block;
            font-size: 20px;
            box-sizing: border-box;
            transition: .5s;
            width: 400px;
            font-style: oblique;
            color: grey;
        }
        
        .grad {
            margin-left:10px;
            border-radius: 25px;
            border-color: white;
            background-color: white;
            position: relative;
            display: inline-block;
            font-size: 20px;
            width: 600px;
            font-style: oblique;
            color: grey;
        }
       .first {
            min-height: 100vh;
            width: 100%;
            background-image: url("images/banner.png"), linear-gradient(rgb(69, 69, 241), rgb(202, 134, 202));
            background-position: center;
            background-size: cover;
            position: relative;
            overflow: hidden;
        }
        
    
        .text-box {
            width: 90%;
            color: #fff;
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-35%, 120%);
            text-align: center;
        }
    
        .text-box h2 {
            font-size: 30px;
            color: #fff;
        }
    
        .hero-btn {
            display: inline;
            text-decoration: none;
            color: #fff;
            border: 1px solid #fff;
            border-radius: 25px;
            padding: 15px 30px;
            font-size: 14px;
            background-color:rgb(204, 119, 253,0.8);
            position: relative;
            cursor: pointer;
            transform: translate(930%,-130%)
        }
        
        .hero-btn:hover {
            border: 1px solid rgb(240, 207, 24);
            background: rgb(69, 69, 241);
            transition: 1s;
        }
        
        
        @media screen and (max-width: 500px) {
            .navbar a {
                float: none;
                display: block;
            }
            .text-box {
                font-size: 20px;
            }
            .row {
                display: flex;
                flex-wrap: wrap;
                padding: 0 4px;
            }
        
            .campus {
                margin: auto;
                text-align: center;
                padding-top: 100px;
                width: 80%
            }
            .column {
                flex-basis: 31%;
                border-radius: 10px;
                margin-bottom: 5%;
                text-align: left;
            }
            .row img {
                padding: 10px;
            }
    }
    </style>
</head>

<body>
    <section class="first">
        <?php
        
        if($rola == 0 ){
            echo "<div class='topnav'>
            <a href='korisnik_prijava.php'><i class='fa fa-fw fa-user'></i>Log in</a>
            <a href='istaknuti.html'>Poslodavci</a>
            <a class='active' href='pocetna.php'><i class='fa fa-fw fa-home'></i>Početna</a>
            </div>
            <br> <br>";
        
        }
        else if($rola == 1){
            echo "
            <div class='topnav'>
            <a href='azuriraj_podatke.php'  title='Azuriraj podatke'>Moj nalog <i class='fa f1-fw fa-user'></i></a>
            <a href='prikazi_moje_oglase.php'>Moji oglasi</a>
            <a href='dodajOglas.php'><i class='fa fa-plus'></i> Dodaj oglas</a>
            <a href='pocetna.php'class='active'><i class='fa fa-fw fa-home' ></i>Početna</a>
        </div>
        <br> <br>";
        }
        else if($rola == 3)
        {
            echo "
            <div class='topnav'>
            <a href='admin.php'>Administracija <i class='fas fa-user-cog'></i></a> 
            <a href='pocetna.php?'class='active'><i class='fa fa-fw fa-home' ></i>Početna</a>
            </div>
        <br> <br>";
        }
        else
        {
            echo "<div class='topnav'>
            <a href='azuriraj_podatke.php?'  title='Azuriraj podatke' >Moj nalog <i class='fa f1-fw fa-user'></i></a>
            <a href='prikazi_sacuvane.php'>Sačuvani oglasi</a>
            <a href='prikazi_konkurisane.php'>Prijavljeni konkursi</a>
            <a href='pocetna.php'class='active'  ><i class='fa fa-fw fa-home' ></i>Početna</a>
   
    </div><br><br>";
        }
    ?>
    <div class="box">
           
        <h1>Pretražite oglase:</h1>
        <form action="prikazi_oglase.php" method="post">
        <select style="border-radius: 25px;padding: 10px;" name="id_grada" id="grad" class="grad">
            <option  value="" hidden> Odaberi grad</option>
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
            <option name="vrnjacka_banja" value="39">Vrnjačka Banja</option>
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
            <option name="sid" value="60">Sid</option>
            <option name="surcin" value="61">Surčin</option>
            <option name="temerin" value="62">Temerin</option>
            <option name="cuprija" value="63">Ćuprija</option>
            <option name="online" value="64">online</option>
            
            </select>

        <select style="border-radius: 25px;padding: 10px;" name="id_oblast_rada" id="oblast_rada" class="oblast" >
            <option value="" class="oblast1" hidden>Odaberi oblast rada</option>
            <option name="IT" value="1">IT</option>
            <option name="trgovina,prodaja" value="2">Trgovina, prodaja</option>
            <option name="masinstvo" value="3">Mašinstvo</option>
            <option name="elektrotehnika" value="4">Elektrotehnika</option>
            <option name="administracija" value="5">Administracija</option>
            <option name="arhitektura" value="6">Arhitektura</option>
            <option name="bankarstvo" value="7">Bankarstvo</option>
            <option name="biologija" value="8">Biologija</option>
            <option name="briga_o_lepoti" value="9">Briga o lepoti</option>
            <option name="dizajn" value="10">Dizajn</option>
            <option name="ekonomija(opste)" value="11">Ekonomija</option>
            <option name="farmacija" value="12">Farmacija</option>
            <option name="finansije" value="13">Finansije</option>
            <option name="fizika,matematika" value="14">Fizika, matematika</option>
            <option name="graficarstvo" value="15">Grafičarstvo</option>
            <option name="gradjevina" value="16">Građevina</option>
            <option name="hemija" value="17">Hemija</option>
            <option name="higijena" value="18">Higijena</option>
            <option name="jezici,knjizevnost" value="19">Jezici</option>
            <option name="kontrola kvaliteta" value="20">Kontrola kvaliteta</option>
            <option name="ljudski_resursi" value="21">Ljudski resursi</option>
            <option name="logistika" value="22">Logistika</option>
            <option name="magacin" value="23">Magacin</option>
            <option name="marketing, promocija" value="24">Marketing, promocija</option>
            <option name="mediji(novinarstvo, stampa)" value="25">Mediji</option>
            <option name="menadzment" value="26">Menadžment</option>
            <option name="obezbedjenje" value="27">Obezbeđenje</option>
            <option name="obrazovanje, briga o deci" value="28">Obrazovanje, briga o deci</option>
            <option name="odrzavanje" value="29">Održavanje</option>
            <option name="ostalo" value="30">Ostalo</option>
            <option name="poljoprivreda" value="31">Poljoprivreda</option>
            <option name="pozivni_centar" value="32">Pozivni centar</option>
            <option name="PR" value="33">PR</option>
            <option name="pravo" value="34">Pravo</option>
            <option name="priprema_hrane" value="35">Proizvodnja hrane</option>
            <option name="prozvodnja_i_montaza" value="36">Proizvodnja i montaža</option>
            <option name="psihologija" value="37">Psihologija</option>
            <option name="racunovodstvo, knjigovodstvo" value="38">Računovodstvo, knjigovodstvo</option>
            <option name="saobracaj" value="39">Saobraćaj</option>
            <option name="stomatologija" value="40">Stomatologija</option>
            <option name="tekstilna_industrija" value="41">Tekstilna industrija</option>
            <option name="telekomunikacije" value="42">Telekomunikacije</option>
            <option name="ugostiteljstvo" value="43">Ugostiteljstvo</option>
            <option name="veterina" value="44">Veterina</option>
            <option name="zdravstvo" value="45">Zdravstvo</option>
            <option name="zastita_na_radu" value="46">Zaštita na radu</option>
            
           </select>
                <br><br>
                <input type="submit" value="Pretraži" class="hero-btn">
            </form>
        </div></div>
    </section>
</body>
</html>