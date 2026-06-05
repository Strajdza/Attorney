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
        $message = "<p style='color:green;'>Your request has been successfully sent!</p>";
    } else {
        $message = "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Law Office Čubrić Gigić</title>
<link rel="stylesheet" href="css/style.css">
<script src="js/script.js" defer></script>
</head>

<body>

<div id="bg"></div>

<nav id="navigacija">
<a href="#mi">Our Team</a>
<a href="#usluge">Services</a>
<a href="#kontakt" id="kraj">Contact Us</a>

<div class="dd">
          <p class="aktivan" class="tekstovi">ENG <img src="eng.jpg" alt="eng" class="zastave"></p>
        <div class="ddm">
          <a href="index.php"><p class="tekstovi">SRB <img src="images.png" class="zastave"></p></a>
        </div>
        </div>
</nav>


<section id="mi" class="pop-in">

<h2>Our Team</h2>

<div id="glavni">

<div class="card">
<div class="card-inner">
<div class="card-front">
<img src="Dule.jpeg">
</div>

<div class="card-back">
<p>
Dušan Čubrić (born 1988 in Pančevo) graduated in 2016 from the Faculty of Law at the University of Belgrade. 
He passed the Bar Exam in 2020 and was entered into the register of attorneys of the Bar Association of Vojvodina in 2021.

He gained professional experience as a trainee lawyer at the Jakovljević Law Office under the mentorship of attorney Stevan Jakovljević. 
In his legal practice he particularly stands out in conducting litigation procedures, civil and commercial disputes, including complex and mass lawsuits.

He holds a certificate for representing minors in criminal proceedings issued by the Bar Association of Serbia.
</p>
</div>
</div>
</div>


<div class="card">
<div class="card-inner">
<div class="card-front">
<img src="Veljko.jpeg">
</div>

<div class="card-back">
<p>
Veljko Gigić (born 1985) graduated in 2010 from the Faculty of Law at the University of Belgrade. 
He passed the Bar Exam in 2017 and has been practicing law since 2018.

He completed his legal internship at the Jakovljević Law Office under attorney Stevan Jakovljević, 
where he gained significant experience in criminal cases.

In his legal practice he mainly focuses on criminal proceedings, providing defense and representation in all stages of the procedure. 
He also represents clients in civil litigation.

He holds a certificate for representing minors in criminal proceedings issued by the Bar Association of Serbia.
</p>
</div>
</div>
</div>

</div>


<h2>Associates</h2>

<div class="card">
<div class="card-inner">
<div class="card-front">
<img src="Filip.jpeg">
</div>

<div class="card-back">
<p>
Filip Popović graduated in 2018 from the Faculty of Law at the University of Belgrade in the judicial-administrative program. 
He completed his Master's studies in criminal law in 2020 at the same faculty.

He passed the judicial and bar exams in 2021, after which he was entered into the register of attorneys of the Bar Association of Vojvodina.

He works as an associate lawyer at the Čubrić Gigić Law Office where he participates in criminal and civil proceedings.
</p>
</div>
</div>
</div>

</section>



<section id="usluge" class="pop-in">

<h1>SERVICES</h1>

<div id="favor">
<div id="opis">

<div class="mucenje">

<h1 class="uslg">Why choose the Čubrić Gigić Law Office?</h1>

<p class="ispisi" id="Kanc">

✔ Experience gained in a leading law practice in Pančevo  
<br>✔ Independent and stable practice since 2021  
<br>✔ Specialized expertise in cases involving minors  
<br>✔ Strategic approach and thorough preparation for every case  
<br>✔ Complete discretion and transparent communication  
<br>✔ Dedication to the long-term protection of clients' interests  

Our goal is not only representation but building trust and providing clear, realistic and legally grounded solutions.

<b>Our Mission</b>  
Providing legal protection of the highest professional standard with an individual and responsible approach to every client.

<b>Our Vision</b>  
Continuous development and positioning of the office among recognized law offices in Pančevo and the region through consistency, expertise and professional integrity.
</p>

</div>



<div class="mucenje">

<h1 class="uslg">About Us</h1>

<p class="ispisi" id="onama">

The Čubrić Gigić Law Office from Pančevo provides comprehensive legal services to individuals and legal entities, with a strategic and professional approach to every case.

The office was founded in 2021 by attorneys Dušan Čubrić and Veljko Gigić after years of professional experience gained at the Jakovljević Law Office in Pančevo.

Together with associate attorney Filip Popović, the office operates independently today with clearly defined standards of work, a high level of responsibility and complete dedication to protecting the rights and interests of clients.

Our work is based on precise legal analysis, carefully planned strategy and consistent representation before courts and other authorities.

<b>Criminal Proceedings</b>  
The office provides professional defense and representation in all stages of criminal proceedings — from the investigation phase to trial and appeals.
</p>

</div>



<div class="mucenje">

<h1 class="uslg">We Represent:</h1>

<p class="ispisi" id="zastup">

- Defendants  
<br>- Victims in criminal proceedings  
<br>- Parties in plea agreement procedures  
<br>- Clients in appeal and extraordinary legal remedies  

<br>We particularly highlight our expertise in cases involving minors. The attorneys of the office hold a special certificate issued by the Bar Association of Serbia for representing minors.

<br>In every criminal case we approach matters decisively, discreetly and strategically.

<br><br><b>Civil Litigation</b>

<br>In civil litigation we represent clients before competent courts in various types of civil disputes.

<br>Our services include representation in disputes related to:

<br>- Compensation for damages  
<br>- Property disputes  
<br>- Contract disputes  
<br>- Employment disputes  
<br>- Family disputes  
<br>- Inheritance disputes  

<br>Every case is handled with a detailed risk assessment, clear strategy and focus on achieving the most favorable legal and economic outcome for the client.
</p>

</div>

</div>


<p id="bord"></p>


<div id="both" class="pop-in">

<h2>Satisfied Clients</h2>

<div id="clients">
<p id="text">Gold Print doo</p>
<p id="text2">Agrojorga doo</p>
</div>

<div id="krugovi">
<p class="krug" id="izabran"></p>
<p class="krug"></p>
<p class="krug"></p>
<p class="krug"></p>
</div>

</div>

</div>

</section>




<h1 class="pop-in">CONTACT US</h1>

<section id="kontakt" class="pop-in">

<div id="contact">

<div id="message">
<p id="opomena"></p>
<button id="ok">OK</button>
</div>

<form id="contactForm" method="POST" action="">

<p class="naslov">Send us an email</p>

<div id="IiP" class="inputi">
<input type="text" name="Ime" placeholder="First Name" id="ime" class="inp" required>
<input type="text" name="Prezime" placeholder="Last Name" id="prezime" class="inp" required>
</div>

<div id="inf" class="inputi">
<input type="text" name="E-mail" placeholder="E-mail" id="mail" class="inp" required>
<input type="text" name="Telefon" placeholder="Phone Number" id="tel" class="inp" required>
</div>

<input type="text" name="Poruka" placeholder="Message" id="poruka" required>

<div></div>

<input type="submit" value="Send" name="submit" id="dugme">

</form>

<div id="formMessage"></div>

</div>


<h1 id="or">OR</h1>

<div id="brojevi">

<p class="naslov">Call us</p>

<p class="brojevi">Dušan Čubrić: +381 64 2675145</p>
<p class="brojevi">Veljko Gigić: +381 62 8465330</p>
<p class="brojevi">Filip Popović: +381 65 2011097</p>

</div>

</section>




<footer>

<div id="rand">
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
loading="lazy">
</iframe>
<p> © 2026 Law Office Čubrić Gigić. All rights reserved.</p>
</div>
<div id='bb'></div>

</div>

</footer>

</body>
</html>