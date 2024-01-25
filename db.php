<?php

class Db 
{
    const host = "localhost";
    const dbname = "projekat";
    const user = "root";
    const pass = "";
    
    private $dbh;
    
    function __construct() 
    {
        try
        {
            $string = "mysql:host=".self::host.";dbname=".self::dbname;
            $this->dbh = new PDO($string, self::user, self::pass);
        } catch (Exception $e) 
        {
            echo "greska prilikom konekcije sa bazom!";
            die();
        }
    }
    function __destruct() 
    {
        $this->dbh = null;
    }

    public function proveriKorisnika($korisnicko_ime,$sifra)
    {
        $sifra = sha1($sifra);
        $sql = "SELECT * FROM korisnik WHERE korisnicko_ime = '$korisnicko_ime' AND sifra = '$sifra'";

        $pdo_izraz = $this->dbh->query($sql);
        if($pdo_izraz)
        {
            return $pdo_izraz->fetch(PDO::FETCH_ASSOC);
        }
        
    }

    public function dodajKorisnika($ime,$prezime,$korisnicko_ime,$email,$sifra,$pol,$id_grada,$rola,$firma=null){
        
        try 
        {
            //$sql1 = "SELECT id from grad where naziv_grada='$grad'";
            //$pdo_izraz1 = $this->dbh->query($sql1);
            //$id_grada = $pdo_izraz1->fetch(PDO::FETCH_ASSOC)['id'];
            $sifraa=sha1($sifra);
            if(isset($firma))
            {
                $sql = "INSERT INTO korisnik(ime,prezime,korisnicko_ime, sifra, rola, id_grada, email,pol,firma) VALUES ('$ime','$prezime','$korisnicko_ime', '$sifraa', '$rola', '$id_grada', '$email', '$pol','$firma')";
            }
            else 
            {
                $sql = "INSERT INTO korisnik(ime,prezime,korisnicko_ime, sifra, rola, id_grada, email,pol) VALUES ('$ime','$prezime','$korisnicko_ime', '$sifraa', '$rola', '$id_grada', '$email', '$pol')";
            }
            $pdo_izraz = $this->dbh->exec($sql);
            $sql2 = "SELECT id from korisnik where ime='$ime' ";
            $pdo_izraz2 = $this->dbh->query($sql2);
            $id = $pdo_izraz2->fetch(PDO::FETCH_ASSOC)['id'];
            return $id;
        }
        catch(PDOException $e)
        {
            echo "Greska: ";
            echo $e->getMessage();
        }

    }
    public function uzmiPodatkeOKorisniku($id_korisnika)
    {
        try
        {
            $sql = "SELECT g.naziv_grada, k.* FROM korisnik k join grad g on k.id_grada=g.id WHERE k.id='$id_korisnika'";
            $pdo_izraz = $this->dbh->query($sql);
            if($pdo_izraz)
            {
                //var_dump($pdo_izraz->fetchALL(PDO::FETCH_ASSOC));
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            }
        }
        catch(PDOException $e)
        {
            echo "Greska: ";
            echo $e->getMessage();
           
        }
        

    }
    public function azurirajPodatke($id_korisnika,$ime, $prezime,$korisnicko_ime,$email,$sifra,$grad,$rola)
    {
        
        try
        {
            $sifra = sha1($sifra);
            $sql = "UPDATE korisnik SET ime = :ime, prezime = :prezime, korisnicko_ime = :korisnicko_ime, sifra = :sifra, id_grada = :id_grada, email = :email WHERE id = :id_korisnika";
            $sql2 = "SELECT id FROM grad WHERE naziv_grada='$grad'";
            $pdo_izraz2 = $this->dbh->query($sql2);
            $id_grada = $pdo_izraz2->fetchALL(PDO::FETCH_ASSOC)[0]['id'];
            $pdo_izraz = $this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':ime', $ime);
            $pdo_izraz->bindParam(':prezime', $prezime);
            $pdo_izraz->bindParam(':korisnicko_ime', $korisnicko_ime);
            $pdo_izraz->bindParam(':sifra', $sifra);
            $pdo_izraz->bindParam(':id_grada', $id_grada);
            $pdo_izraz->bindParam(':email', $email);
            $pdo_izraz->bindParam(':id_korisnika', $id_korisnika);
            $pdo_izraz->execute();
            return true;
        }
        catch(PDOException $e)
        {
            echo "Greska: ";
            echo $e->getMessage();
            return false;
        }
    }

    public function dodajPrijavu($id_kandidata,$strucna_sprema,$radno_iskustvo,$CV,$id_oglasa)
    {
        try 
        {
            $sql = "INSERT INTO prijava(id_kandidata,strucna_sprema,radno_iskustvo,id_oglasa,CV) VALUES (:id_kandidata,:strucna_sprema,:radno_iskustvo,:id_oglasa,:CV)";
            
            $pdo_izraz = $this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':id_kandidata',$id_kandidata);
            $pdo_izraz->bindParam(':strucna_sprema',$strucna_sprema);
            $pdo_izraz->bindParam(':radno_iskustvo',$radno_iskustvo);
            $pdo_izraz->bindParam(':id_oglasa',$id_oglasa);
            $pdo_izraz->bindParam(':CV',$CV);
            $pdo_izraz->execute();
            return true;
        }
        catch(PDOException $e)
        {
            echo "Greska: ";
            echo $e->getMessage();
            return false;
        }
    }

    public function ukloniPrijavu($id, $id_oglasa)
    {
        try 
        {
            $sql = "DELETE FROM prijava WHERE id_kandidata = $id AND id_oglasa = $id_oglasa";
            $pdo_izraz = $this->dbh->exec($sql);
            return true; 
        }
        catch(PDOException $e)
        {
            echo "Greska: ";
            echo $e->getMessage();
            return false;
        }

    }

    public function stampajListuOglasa($id_grada=NULL,$id_oblast_rada=NULL)
    {
        try
        {
            
            $sql = "SELECT naziv_grada, o.* from oglas o join grad g on o.id_grada = g.id WHERE o.rok >= CURRENT_DATE() ORDER BY o.datum DESC";
            if(isset($id_grada) && isset($id_oblast_rada))
            {
                
                $sql="SELECT naziv_grada, o.* from oglas o join grad g on o.id_grada = g.id WHERE o.id_grada = '$id_grada' AND o.id_oblast_rada = '$id_oblast_rada' AND o.rok >= CURRENT_DATE() ORDER BY o.datum DESC";   
            }
            else if(isset($id_grada))
            {
                
                $sql="SELECT naziv_grada, o.* from oglas o join grad g on o.id_grada = g.id WHERE id_grada = '$id_grada' AND o.rok >= CURRENT_DATE() ORDER BY o.datum DESC";
            }
            else if (isset($id_oblast_rada))
            {
                $sql="SELECT naziv_grada, o.* from oglas o join grad g on o.id_grada = g.id WHERE id_oblast_rada = '$id_oblast_rada' AND o.rok >= CURRENT_DATE() ORDER BY o.datum DESC";
            }
            
            $pdo_izraz = $this->dbh->query($sql);
          
           if($pdo_izraz){
               return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            }
    }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }

    public function stampajOglas($id_oglasa)
    {
        try
        {
           
            $sql = "SELECT naziv_grada, o.* from oglas o join grad g on o.id_grada = g.id WHERE o.id = '$id_oglasa'";
            $pdo_izraz = $this->dbh->query($sql);
            return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
        }
        
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }

    //funkcije za poslodavca
    public function stampajMojeOglase($id_poslodavca)
    {
        try
        {
            
            $sql = "SELECT naziv_grada, o.* from oglas o join grad g on o.id_grada = g.id WHERE o.id_poslodavca = '$id_poslodavca' ORDER BY o.datum DESC";
            $pdo_izraz = $this->dbh->query($sql);
            if($pdo_izraz)
            {
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
               
            }
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
        
    }
    public function dodajOglas($pozicija,$id_grada,$potrebna_skolska_sprema,$id_oblast_rada,$opis_i_pogodnost,$id_poslodavca,$rok)    
    {   
        try {

            $sql1 = "SELECT firma from korisnik WHERE id = '$id_poslodavca'";
            $pdo_izraz1 = $this->dbh->query($sql1);
            
            if($pdo_izraz1 )
            {
                $firma = $pdo_izraz1->fetchALL(PDO::FETCH_ASSOC)[0]['firma'];
                $datum = date("Y-m-d");
                $sql = "INSERT INTO oglas(firma,id_grada,potrebna_skolska_sprema,pozicija,opis_i_pogodnost,id_oblast_rada,datum, id_poslodavca,rok ) VALUES (:firma,:id_grada,:potrebna_skolska_sprema,:pozicija,:opis_i_pogodnost,:id_oblast_rada,:datum,:id_poslodavca,:rok)";
                $pdo_izraz = $this->dbh->prepare($sql);
                //$pdo_izraz = $this->dbh->exec($sql);
                $pdo_izraz->bindParam(':firma',$firma);
                $pdo_izraz->bindParam(':id_grada', $id_grada);
                $pdo_izraz->bindParam(':potrebna_skolska_sprema', $potrebna_skolska_sprema);
                $pdo_izraz->bindParam(':pozicija', $pozicija);
                $pdo_izraz->bindParam(':opis_i_pogodnost', $opis_i_pogodnost);
                $pdo_izraz->bindParam(':id_oblast_rada', $id_oblast_rada);
                $pdo_izraz->bindParam(':datum', $datum);
                $pdo_izraz->bindParam('id_poslodavca', $id_poslodavca);
                $pdo_izraz->bindParam(':rok',$rok);
                $pdo_izraz->execute();
                if($pdo_izraz)
                {
                    return true;
                }
               /* var_dump($firma);
                var_dump($id_grada);
                var_dump($potrebna_skolska_sprema);
                var_dump($pozicija);
                var_dump($opis_i_pogodnost);
                var_dump($id_oblast_rada);
                var_dump($datum);
                var_dump($id_poslodavca);
                var_dump($rok);
                var_dump($pdo_izraz);
                */
            }
           
        }
        catch(PDOException $e){
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }    
    }

    public function obrisiOglas($id_oglasa)
    {
        try{
            $sql = "DELETE FROM oglas WHERE id = $id_oglasa";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e){
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }    
        
    }

    public function izmeniOglas($id_oglasa,$pozicija,$grad,$potrebna_skolska_sprema,$opis_i_pogodnost,$rok){
        try 
        {   
            $sql1 = "SELECT id from grad WHERE naziv_grada='$grad'";
            $pdo_izraz1 = $this->dbh->query($sql1);
            $id_grada = $pdo_izraz1->fetchALL(PDO::FETCH_ASSOC)[0]['id'];
            $sql="UPDATE oglas SET id_grada = :id_grada, potrebna_skolska_sprema = :potrebna_skolska_sprema, pozicija = :pozicija, opis_i_pogodnost = :opis_i_pogodnost, rok = :rok WHERE id = :id_oglasa ";
            $pdo_izraz=$this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':id_grada', $id_grada);
            $pdo_izraz->bindParam(':potrebna_skolska_sprema', $potrebna_skolska_sprema);
            $pdo_izraz->bindParam(':pozicija', $pozicija);
            $pdo_izraz->bindParam(':opis_i_pogodnost', $opis_i_pogodnost);
            $pdo_izraz->bindParam(':id_oglasa', $id_oglasa);
            $pdo_izraz->bindParam(':rok',$rok);
            $pdo_izraz->execute();
            return true;
        }        
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
    }
     
    public function listaPrijavljenih($id_oglasa){
        try 
        {
            $sql = "SELECT k.ime,k.prezime,k.email,k.pol,g.naziv_grada,p.strucna_sprema, p.radno_iskustvo,p.CV from korisnik k join grad g on k.id_grada=g.id join prijava p on k.id = p.id_kandidata WHERE p.id_oglasa = $id_oglasa";
            $pdo_izraz = $this->dbh->query($sql);
            if ($pdo_izraz){
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            };

            
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }

    public function proveriPrijavu($id_korisnika,$id_oglasa)
    {
        try
        {
            $sql = "SELECT * FROM prijava WHERE id_kandidata = $id_korisnika AND id_oglasa = $id_oglasa";
            $pdo_izraz = $this->dbh->query($sql);
            return(empty($pdo_izraz->fetchALL(PDO::FETCH_ASSOC)));
            //ako je prazno, prijava moze da se ubaci, ako vraca false ne moze
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }
    public function vidiKomentareIOcene($id_poslodavca)
    {
        try
        {
            $sql = "SELECT k.korisnicko_ime,ko.* FROM komentar_ocena ko join korisnik k on ko.id_kandidata=k.id WHERE id_poslodavca = '$id_poslodavca' ORDER BY ko.datum DESC";
            $pdo_izraz = $this->dbh->query($sql);
            if($pdo_izraz)
            {
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            }
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
        
        
    }

    //za kandidate
    public function dodajSacuvani($id_korisnika,$id_oglasa)
    {
        try 
        {
            $sql = "INSERT INTO sacuvani_oglasi(id_korisnika, id_oglasa) VALUES ('$id_korisnika', '$id_oglasa')";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
    }

    public function obrisiSacuvani($id_korisnika,$id_oglasa){
        try 
        {
            $sql = "DELETE FROM sacuvani_oglasi where id_oglasa = $id_oglasa AND id_korisnika = $id_korisnika";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }   
    }

    public function prikaziSacuvane($id_korisnika)
    {
        try 
        {
            $sql = "SELECT o.*,g.naziv_grada from oglas o join grad g on g.id = o.id_grada join sacuvani_oglasi s on s.id_oglasa = o.id WHERE s.id_korisnika = $id_korisnika AND o.rok >= CURRENT_DATE()";
            $pdo_izraz = $this->dbh->query($sql);
            if($pdo_izraz)
            {
                $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                return $niz;
            }    

        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        } 
    }

    public function proveriSacuvane($id_kandidata,$id_oglasa)
    {
        try
        {
            $sql = "SELECT * FROM sacuvani_oglasi WHERE id_korisnika = $id_kandidata AND id_oglasa = $id_oglasa";
            $pdo_izraz = $this->dbh->query($sql);
            return(empty($pdo_izraz->fetchALL(PDO::FETCH_ASSOC)));
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        } 
    }
    //administrator rola 3
    //kandidat rola 2
    //poslodavac rola 1
    public function stampajSveKandidate ()
    {
        try 
        {
            $sql = "SELECT * FROM korisnik where rola = 2";
            $pdo_izraz = $this->dbh->query($sql);
            $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            echo "<table cellpadding='5' border='1'>";
            echo "<tr><th>Korisničko ime</th><th>Grad</th><th>E-mail</th><th>Pol</th></tr>";
            foreach($niz as $kandidat)
            {
                echo "<tr><td>".$kandidat['korisnicko_ime']."</td>";
                $sql2="SELECT naziv from grad WHERE id=".$kandidat['id_grada'];
                $pdo_izraz2 = $this->dbh->query($sql2);
                $naziv = $pdo_izraz2->fetchALL(PDO::FETCH_ASSOC);
                echo "<td>".$naziv[0]['naziv']."</td>"; 
                echo "<td>".$kandidat['email']."</td>";
                echo "<td>".$kandidat['pol']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }

    }
    public function stampajSvePoslodavce ()
    {
        try 
        {
            $sql = "SELECT * FROM korisnik where rola = 1";
            $pdo_izraz = $this->dbh->query($sql);
            $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            echo "<table cellpadding='5' border='1'>";
            echo "<tr><th>Korisničko ime</th><th>Grad</th><th>E-mail</th><th>Pol</th><th>Firma</th></tr>";
            foreach($niz as $poslodavac)
            {
                echo "<tr><td>".$poslodavac['korisnicko_ime']."</td>";
                $sql2="SELECT naziv from grad WHERE id=".$poslodavac['id_grada'];
                $pdo_izraz2 = $this->dbh->query($sql2);
                $naziv = $pdo_izraz2->fetchALL(PDO::FETCH_ASSOC);
                echo "<td>".$naziv[0]['naziv']."</td>"; 
                echo "<td>".$poslodavac['email']."</td>";
                echo "<td>".$poslodavac['pol']."</td>";
                echo "<td>".$poslodavac['firma']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }

    }

    public function dodajKomentarIOcenu($id_kandidata, $id_poslodavca, $komentar, $ocena)
    {
        try 
        {
            $datum = date("Y-m-d");
            $sql = "INSERT INTO komentar_ocena(id_poslodavca, id_kandidata, komentar, ocena, datum) VALUES ('$id_poslodavca','$id_kandidata','$komentar','$ocena', '$datum')";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
    }

    public function ukloniKomentar($id, $id_poslodavca)
    {
        try 
        {
            $sql = "DELETE FROM komentar_ocena WHERE id_kandidata = $id AND id_poslodavca = $id_poslodavca";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
        
    }

  

    public function izmeniKorisnika($id_korisnika,$korisnicko_ime,$email,$ime,$prezime,$firma)
        {
            try 
        {   
            
            $sql="UPDATE korisnik SET korisnicko_ime = :korisnicko_ime, email = :email, ime = :ime, prezime = :prezime, firma = :firma WHERE id = :id_korisnika ";
            $pdo_izraz=$this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':id_korisnika', $id_korisnika);
            $pdo_izraz->bindParam(':korisnicko_ime', $korisnicko_ime);
            $pdo_izraz->bindParam(':email', $email);
            $pdo_izraz->bindParam(':firma', $firma);
            $pdo_izraz->bindParam(':ime',$ime);
            $pdo_izraz->bindParam(':prezime',$prezime);
            $pdo_izraz->execute();
            return true;
        }        
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
        }

    public function izbrisiKorisnika($idKorisnika)
        {
            try{
                $sql = "DELETE FROM korisnik WHERE id = $idKorisnika";
                $pdo_izraz = $this->dbh->exec($sql);
                $sql2 ="DELETE FROM oglas WHERE id_poslodavca = $idKorisnika";
                $pdo_izraz2 = $this->dbh->exec($sql2);
                return true;
            }
            catch(PDOException $e){
                echo "GRESKA: ";
                echo $e->getMessage();
                return false;
            }    
        }

    public function sviKorisnici()
        {
            try 
        {
            $sql = "SELECT * from korisnik";
            $pdo_izraz = $this->dbh->query($sql);
            if ($pdo_izraz){
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            };

            
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
        }
    
        public function listaKonkurisanih($id)
        {
            try
            {
                $sql = "SELECT o.*,g.naziv_grada FROM oglas o join grad g on o.id_grada = g.id join prijava p on o.id = p.id_oglasa WHERE p.id_kandidata = $id AND o.rok >= CURRENT_DATE() ORDER BY o.datum DESC";
                $pdo_izraz = $this->dbh->query($sql);
                if ($pdo_izraz){
                    return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
                }
            }
            catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
        }

    public function uzmiPoziciju($id_oglasa)
    {
        try 
        {
            $sql = "SELECT pozicija FROM oglas WHERE id = $id_oglasa";
            $pdo_izraz = $this->dbh->query($sql);
            if($pdo_izraz)
            {
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            }
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }

    }

    public function uzmiFirmu($id_poslodavca)
    {
        try 
        {
            $sql = "SELECT firma FROM korisnik WHERE id = $id_poslodavca";
            $pdo_izraz = $this->dbh->query($sql);
            if($pdo_izraz)
            {
                return $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            }
        }
        catch(PDOException $e)
        {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
        
    }
       
}
?>