let klijenti=["Gold Print doo","Agrojorga doo","Marela doo","Brodico doo"];
const krugovi = document.querySelectorAll(".krug");
const tekst = document.querySelector("#text");
const tekst2 = document.querySelector("#text2");
const elements = document.querySelectorAll('.pop-in');
const usluge = document.querySelectorAll('.uslg');
const tekstovi = document.querySelectorAll('.ispisi')
const bord = document.querySelector('#bord')
const opis = document.querySelector('#opis')
const izabran = document.querySelector('#izabran')
const ime = document.getElementById("ime");
const prezime = document.getElementById("prezime");
const email = document.getElementById("mail");
const telefon = document.getElementById("tel");
const zahtev = document.getElementById("poruka");
const dugme = document.getElementById("dugme")
const opomena = document.querySelector("#opomena");
const message = document.querySelector("#message");
const form = document.querySelector("#contactForm");
const ok = document.querySelector("#ok");
let j=0;
let i=0;
let obj=j+1;
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    } else {
      entry.target.classList.remove('visible');
    }
  });
}, { threshold: 0.1 });

elements.forEach(el => observer.observe(el));

krugovi.forEach((element, index) => {
    element.dataset.index = index;
});
krugovi.forEach(elements=> {
    elements.onclick=()=>{
        tekst.innerHTML=klijenti[elements.dataset.index];
        krugovi.forEach(el => el.id = "");
        elements.id="izabran"
       i=0;
       j=elements.dataset.index;
    }
    
});
setInterval(() => {
  tekst.style.transition="0s";
  tekst2.style.transition="0s";
  tekst.style.transform="translateX(0%)";
    tekst.style.opacity=1;
    tekst2.style.opacity=0;
    tekst2.style.transform="translateX(50%)";

  i++;
  if(i==5){
    i=0;
    if(j<3)
    obj=j+1;
    else
    obj=0;
    j++;
    if(j==klijenti.length){
      j=0;
    }
    krugovi.forEach(el => el.id = "");
    krugovi.forEach(element => {
      if(element.dataset.index==j)
        element.id="izabran";
  
    });
    tekst2.innerHTML=klijenti[obj];
    tekst.style.transform="translateX(-50%)";
    tekst.style.opacity=0;
    tekst.style.transition="0.5s";
    tekst2.style.transform="translateX(0%)";
    tekst2.style.opacity=1;
    tekst2.style.transition="0.5s";
    setTimeout(()=>{
      tekst.innerHTML=tekst2.innerHTML;
    },500)
}
   
}, 1000);
usluge.forEach(element => {
  element.addEventListener("click", function () {
    const tekst = this.nextElementSibling;
    tekst.classList.toggle("open");
   tekstovi.forEach(el => {
    if(el!=tekst){
  el.classList.remove("open");
  el.style.height=0;
    }
});


    if (tekst.classList.contains("open")) {
      tekst.style.height = tekst.scrollHeight + "px";
      tekst.style.opacity = "1";
      
    } else {
      tekst.style.height = "0px";
      tekst.style.opacity = "0";
    }
bord.style.height=opis.height;
  });
});
form.addEventListener("submit", function(e){
    e.preventDefault();

    if (!ime.value.trim() || !prezime.value.trim() || !email.value.trim() || !telefon.value.trim() || !zahtev.value.trim()) {
        opomena.innerHTML = "Popunite sva polja";
        message.style.display = "flex";
        form.style.filter = "blur(5px)";
        return;
    }

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        opomena.innerHTML = "Zahtev uspešno poslat!";
        message.style.display = "flex";
        form.style.filter = "blur(5px)";
        form.reset();
    })
    .catch(err => console.error(err));
});
ok.onclick=()=>{
  message.style.display="none";
  form.style.filter = "blur(0px)";
}
