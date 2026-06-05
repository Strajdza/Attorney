<?php
include "db.php"; // connect to your database

$message = ""; // feedback message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely get POST values
    $ime = $conn->real_escape_string($_POST['Ime'] ?? '');
    $prezime = $conn->real_escape_string($_POST['Prezime'] ?? '');
    $email = $conn->real_escape_string($_POST['E-mail'] ?? '');
    $telefon = $conn->real_escape_string($_POST['Telefon'] ?? '');
    $zahtev = $conn->real_escape_string($_POST['Poruka'] ?? '');

    // Insert into database
    $sql = "INSERT INTO podatci (Ime, Prezime, Email, Telefon, Zahtev) 
            VALUES ('$ime', '$prezime', '$email', '$telefon', '$zahtev')";

    if ($conn->query($sql) === TRUE) {
        // Successful submission
        $message = "<p style='color:green;'>Vaš zahtev je uspešno poslat!</p>";
    } else {
        $message = "<p style='color:red;'>Greška: " . $conn->error . "</p>";
    }

    // Redirect to the same page to prevent resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit; // Important! Stop the script after redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"defer></script>
</head>
<body>
  <div id="bg"></div>
    <nav id="navigacija">
        <a href="#mi">Naš tim</a>
        <a href="#usluge">Usluge</a>
        <a href="#kontakt" id="kraj">Kontaktirajte nas</a>
        <div class="dd">
          <p class="aktivan" class="tekstovi">SRB <img src="images.png" alt="srb" class="zastave"></p>
        <div class="ddm">
          <a href="engleski.php"><p class="tekstovi">ENG <img src="eng.jpg" class="zastave"></p></a>
        </div>
        </div>
    </nav>
    <section id="mi"class="pop-in">
      <h2>Naš tim</h2>
      <div id="glavni">
<div class="card">
  <div class="card-inner">
    <div class="card-front">
      <img src="Dule.jpeg" alt="img" srcset="">
    </div>
    <div class="card-back" >
      <p>Dušan Čubrić (rođen 1988. godine u Pančevu) diplomirao je 2016. godine na Pravni fakultet Univerziteta u Beogradu. Pravosudni ispit položio je 2020. godine, a u imenik advokata Advokatska komora Vojvodine upisan je 2021. godine.
Profesionalno iskustvo sticao je kao advokatski pripravnik u Kancelariji Jakovljević, pod mentorstvom advokata Stevana Jakovljevića. U advokatskoj praksi posebno se ističe u vođenju parničnih postupaka, građanskih i privrednih sporova, uključujući kompleksne i masovne tužbe.
Poseduje sertifikat za zastupanje maloletnih lica u krivičnim postupcima izdat od strane Advokatska komora Srbije.</p>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-inner">
    <div class="card-front">
      <img src="Veljko.jpeg" alt="img" srcset="">
    </div>
    <div class="card-back">
      <p>Veljko Gigić (rođen 1985. godine) diplomirao je 2010. godine na Pravni fakultet Univerziteta u Beogradu. Pravosudni ispit položio je 2017. godine, a advokaturom se bavi od 2018. godine.
Pripravnički staž obavio je u Kancelariji Jakovljević pod mentorstvom advokata Stevana Jakovljevića, gde je stekao značajno iskustvo u radu na krivičnim predmetima.
U advokatskoj praksi pretežno je usmeren na krivične postupke, pružajući odbranu i zastupanje u svim fazama postupka. Takođe zastupa klijente i u parničnim sporovima.
Poseduje sertifikat za zastupanje maloletnih lica u krivičnim postupcima izdat od strane Advokatska komora Srbije.</p>
    </div>
  </div>
</div>
</div>
<h2>Saradnici</h2>
<div class="card">
  <div class="card-inner">
    <div class="card-front">
      <img src="Filip.jpeg" alt="img" srcset="">
    </div>
    <div class="card-back" >
      <p>Filip Popović diplomirao je 2018. godine na Pravni fakultet Univerziteta u Beogradu, na pravosudno-upravnom smeru. Master studije iz oblasti krivičnog prava završio je 2020. godine na istom fakultetu.
Pravosudni i advokatski ispit položio je 2021. godine, nakon čega je upisan u imenik advokata Advokatska komora Vojvodine.
Radi kao advokat – saradnik u Advokatskoj kancelariji Čubrić Gigić, gde učestvuje u radu na krivičnim i parničnim postupcima.</p>
    </div>
  </div>
</div>
    </section>
    <section id="usluge"class="pop-in">
    <h1>USLUGE</h1>
    <div id="favor">
    <div id="opis">
      <div class="mucenje">
     <h1 class="uslg">Zašto izabrati Advokatsku kancelariju Čubrić Gigić?</h1>
     <p class="ispisi" id="Kanc">✔ Iskustvo stečeno u vodećoj advokatskoj praksi u Pančevu
<br>✔ Samostalno i stabilno poslovanje od 2021. godine
<br>✔ Specijalizovana stručnost za postupke prema maloletnicima
<br>✔ Strateški pristup i temeljna priprema svakog predmeta
<br>✔ Potpuna diskrecija i transparentna komunikacija
<br>✔ Posvećenost dugoročnoj zaštiti interesa klijenata
<br>Naš cilj nije samo zastupanje, već izgradnja odnosa poverenja i pružanje jasnih, realnih i pravno utemeljenih rešenja.
Naša misija
Pružanje pravne zaštite najvišeg profesionalnog standarda, uz individualan i odgovoran pristup svakom klijentu.
Naša vizija
Kontinuirani razvoj i pozicioniranje kancelarije među prepoznatljivim advokatskim kancelarijama u Pančevu i regionu, kroz doslednost, stručnost i profesionalni integritet.</p>
     </div>
      <div class="mucenje">
     <h1 class="uslg">O nama</h1>
     <p class="ispisi" id="onama">Advokatska kancelarija Čubrić Gigić iz Pančeva pruža sveobuhvatne pravne usluge fizičkim i pravnim licima, uz strateški i profesionalan pristup svakom predmetu.
Kancelariju su 2021. godine osnovali advokati Dušan Čubrić i Veljko Gigić, nakon višegodišnjeg profesionalnog iskustva stečenog u advokatstskoj  kancelariji Jakovljević iz  Pančeva Uz advokatskog saradnika Filipa Popovića, kancelarija danas posluje samostalno, sa jasno definisanim standardima rada, visokim nivoom odgovornosti i potpunom posvećenošću zaštiti prava i interesa klijenata.
Naš rad zasniva se na preciznoj pravnoj analizi, pažljivo postavljenoj strategiji postupka i doslednom zastupanju pred sudovima i drugim nadležnim organima.
Krivični postupci
Kancelarija pruža stručnu odbranu i zastupanje u svim fazama krivičnih postupaka — od predistražne faze i istrage, do glavnog pretresa i postupaka po redovnim i vanrednim pravnim lekovima.</p>
      </div>
      <div class="mucenje">
     <h1 class="uslg">Zastupamo:</h1>
     <p class="ispisi" id="zastup">-Okrivljena lica
<br>-Oštećene u krivičnim postupcima
<br>-Lica u postupcima po sporazumu
<br>-Stranke u postupcima po žalbama i vanrednim pravnim sredstvima
<br>-Posebno ističemo stručnost u postupcima prema maloletnicima. Advokati kancelarije poseduju poseban sertifikat za zastupanje maloletnih lica izdat od strane Advokatska komora Srbije, što predstavlja dodatnu potvrdu profesionalne osposobljenosti za vođenje ovih specifičnih i osetljivih postupaka.
<br>-U svakom krivičnom postupku pristupamo odlučno, diskretno i strateški, imajući u vidu težinu situacije i značaj pravovremene pravne zaštite.
<br>-Parnični postupci
<br>-U oblasti parničnih postupaka zastupamo klijente pred nadležnim sudovima u različitim vrstama građanskih sporova.
<br>-Naše usluge obuhvataju zastupanje u postupcima koji se odnose na:
<br>-Naknadu štete
<br>-Imovinsko-pravne sporove
<br>-Ugovorne sporove
<br>-Sporove iz radnih odnosa
<br>-Porodične sporove
<br>-Nasledne sporove
<br>-Svaki parnični postupak vodimo uz detaljnu procenu rizika, jasnu strategiju i fokus na ostvarenje najpovoljnijeg pravnog i ekonomskog
ishoda za klijenta.</p>
     </div>
  </div>
  <p id="bord"></p>
  <div id="both"class="pop-in">
    <h2>Zadovoljni klijenti</h2>
    <div id="clients">
      <p id="text">Gold Print doo</p>
      <p id="text2">Agrojorga doo</p>
      </div>
    <div id=krugovi>
      <p class="krug" id="izabran"></p>
      <p class="krug" ></p>
      <p class="krug"></p>
      <p class="krug"></p>
</div>
    </div>
</div>
    </section>
    <H1 class="pop-in">KONTAKTIRAJTE NAS</H1>
    <section id="kontakt"class="pop-in">
  
      <div id="contact"> 
        <div id="message"><p id="opomena"></p><button id="ok">OK</button></div>
        <form  id="contactForm"method="POST" action="">
      <p class="naslov">Pošaljite nam mejl</p>
      <div id="IiP" class="inputi">
      <input type="text" name="Ime" placeholder="Ime" id="ime" class="inp" required>
      <input type="text" name="Prezime" placeholder="Prezime" id="prezime" class="inp" required>
      </div>
      <div id="inf" class="inputi">
      <input type="text" name="E-mail" placeholder="E-mail" id="mail" class="inp" required>
      <input type="text" name="Telefon" placeholder="Broj Telefona" id="tel" class="inp" required>
      </div>
      <input type="text" name="Poruka" placeholder="Zahtev" id="poruka" required>
      <div></div>
      <input type="submit" value="Posalji" name="submit" id="dugme">
      </form>
      <div id="formMessage"></div>
      </div>
      <h1 id="or">ILI</h1>
      <div id="brojevi">
      <p class="naslov">Pozovite na Telefon</p>
      <p class="brojevi">Dušan Čubrić: +381 64 2675145</p>
      <p class="brojevi">Veljko Gigić: +381 62 8465330</p>
      <p class="brojevi">Filip Popović: +381 65 2011097</p>
      </div>
    </section>
    <footer>
      <div id=rand> 
        <p>|</p>
      </div>
      <div id="foot"> 
        <div id='bt'></div>
        <div id="inside">
          <div id="stvr">
      <p>Vojvode Radomira Putnika 1/6</p>
      <p>adv.cubric@gmail.com</p>
      </div>
    
<iframe 
src="https://www.google.com/maps?q=44.86989657374835,20.6414541364839&z=17&output=embed"
width="200" 
height="150" 
style="border:0;" 
allowfullscreen="" 
loading="lazy" 
referrerpolicy="no-referrer-when-downgrade">
</iframe>
<p> © 2026 Kancelarija Čubrić Gigić. Sva prava zadržana.</p>
</div>
      <div id='bb'></div>
      </div>
    </footer>
</body>
</html>