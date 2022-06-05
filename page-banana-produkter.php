<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

get_header(); ?>

<!-- template til loopview -->
<template class="loopview">
        <article>
            <div class="img_box">
            	<img src="" alt="" class="billede" />
            </div>
			<div class="text_box">
            	<h2 class="produkt_titel"></h2>
            	<p class="beskrivelse"></p>
			</div>
        </article>
</template>


<div class="header_produkter">
   <img src="<?php echo get_stylesheet_directory_uri() ?>/billeder/hvid_boelge.png" alt="" class="baggrundsboelge">
<h1>VORES PRODUKTER</h1>
<p class="produkt_intro_tekst"> 
    <b>Mød de nyeste produkter i Banana familien. </b> Vi er glade for at kunne præsentere de nyeste produkter i den voksende Banana familie; vores 480 ml is-bæger samt verdensnyheden veganske ‘romkugler’ og det prisbelønnede Bananbrød der vandt produktprisen i kategorien konfekture i kokkekonkurrencen Sol Over Gudhjem 2021.</p>
  	<nav id="filtrering">
    	<button data-produkt="alle" class="valgt">Alle</button>
    </nav>
</div>



<div id="primary" class="content-area">
		<main id="main" class="site-main">
		</main>

		<!-- snippet fra Elementor -->
	<?php the_content(); ?>
</div>

<!-- javascript til loopview -->
<script>
	// Tjekker om DOM'en er loaded før siden vises
window.addEventListener("DOMContentLoaded", start);
function start() {
  console.log("start");

  // Definerer stien til json-array fra wordpress
  const url = "http://hoffmannlund.dk/kea/10_eksamen/banana_cph/wp-json/wp/v2/produkt";
  const catUrl = "http://hoffmannlund.dk/kea/10_eksamen/banana_cph/wp-json/wp/v2/categories";

  
  // definere globale variable
  const main = document.querySelector("main");
  const template = document.querySelector(".loopview").content;
  const article = document.querySelector("article");

  let produkter;
  let filter = "alle";
  let categories;

  // Henter json-data fra wordpress via fetch()
  async function hentData() {
    const respons = await fetch(url);
	  const catData = await fetch(catUrl);
    produkter = await respons.json();
	  categories = await catData.json();
    console.log("Produkter", produkter);
	  console.log("Kategorier", categories);
    visProdukter();
	  opretKnapper();
  }

  // for hver kategori oprettes der en knap
  function opretKnapper(){
	  categories.forEach(cat =>{
		document.querySelector("#filtrering").innerHTML += `<button class="filter" data-produkt="${cat.id}">${cat.name}</button>`
	  })

    addEventListenersToButtons();
  }

  // tilføjer en click-eventlistener til hver knap
  function addEventListenersToButtons(){
      document.querySelectorAll("#filtrering button").forEach(elm => {
      elm.addEventListener("click", filtrering);
    })
  };

  // sætter filter til det dataset der hører til den valgte knap 
  function filtrering(){
      filter = this.dataset.produkt;

      // ved klik på knap scroll'er siden ned til indholdet
      let mobil_viewport = window.matchMedia("(max-width: 600px)");
  if (mobil_viewport.matches) {
     window.scrollTo({
      top: 550,
      left: 550,
      behavior: 'smooth'
  });
  } else{
     window.scrollTo({
      top: 325,
      left: 325,
      behavior: 'smooth'
  });
  }
    visProdukter();
  }

  // loop'er gennem alle produkter i json-arrayet
  function visProdukter() {
    console.log("visProdukter");

    main.textContent = ""; // Her resetter vi DOM'en ved at tilføje en tom string

    // for hver produkt i arrayet, skal der tjekkes om de opfylder filter-kravet og derefter vises i DOM'en.
    produkter.forEach((produkt) => {
      
      if (filter == "alle" || produkt.categories.includes(parseInt(filter))) {

        // kloner template-article-elementet
        const klon = template.cloneNode(true);

        // indsætter billede, titel og beskrivelse af hvert produkt i hver deres article-element
        klon.querySelector(".billede").src = produkt.billede.guid;
        klon.querySelector(".produkt_titel").textContent = produkt.title.rendered;
        klon.querySelector(".beskrivelse").textContent = produkt.beskrivelse;

        // tilføjer klon-template-elementet til main-elementet (så det hele vises i DOM'en)
        main.appendChild(klon);
      }
    });
  }

  hentData();
}
</script>

<!-- css til loopview -->
<style>
  /* henter fonte fra google fonts vha. @import */
@import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap');

/* Media query dekstop */
@media (min-width: 900px){
.produkt_intro_boks{
	display: grid;
	place-items: center;
}

.produkt_intro_tekst, .beskrivelse {
	max-width: 600px;
  color: #482900;
  font-family: 'Raleway', sans-serif;
}

.produkt_titel{
  color: #482900;
  font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-style: normal;
}

.produkt_intro_tekst{
  position: absolute;
top: 40%;
left: 29%;
margin-top: -80px;
}

.header_produkter{
  position: relative;
}

.baggrundsboelge{
  margin-top: -700px;
}

#filtrering{
  position: absolute;
  top: 55%;
  left: 15.5%;
  	display: flex;
	place-content: center;
	gap: 40px;
}

	main {
    /* display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); */
    display: flex;
    flex-direction: column;
    margin-top: -110px;
  }

 article {
	display: grid;
	width: 100vw;
	height: 400px;
	grid-template-columns: 500px 1fr;
	/* gap: 200px; */
}

  .img_box, .text_box{
    z-index: 1;
  }

  .text_box{
    padding-top: 40px;
  }

  /* .img_box{
    display: grid;
    place-content: center end;
  } */

  .billede{
    max-width: 300px;
  }

  .boelge{
    width: 100vw;
    height: 400px;
    position: absolute;
  }

  h1{
	  /* display: grid;
	  place-items: center; */
   font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-style: normal;
    color: #482900;
    position: absolute;
    top: 10%;
    left: 38%;
    margin-top: -35px;
  }


 #filtrering > button {
	background: url(http://hoffmannlund.dk/kea/10_eksamen/banana_cph/wp-content/themes/inspiro-child/billeder/knap_baggrund.png) no-repeat;
	width: 220px;
	height: 60px;
	padding: 0;
  border: none;
   transition: .2s ease-in-out 0s;
   font-family: 'Raleway', sans-serif;
}
#filtrering > button:hover{
  color: #482900;
  border: none;
  transform: scale(1.25);
  font-weight: 800;
}
}



/* media query tablet */
@media (max-width: 899px){
  .produkt_intro_boks{
	display: grid;
	place-items: center;
}

.produkt_intro_tekst, .beskrivelse {
  color: #482900;
  font-family: 'Raleway', sans-serif;
}

.produkt_titel{
  color: #482900;
  font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-style: normal;
}

.produkt_intro_tekst{
  position: absolute;
top: 40%;
left: 15%;
margin-top: -80px;
	max-width: 600px;
}

.header_produkter{
  position: relative;
}

.baggrundsboelge{
  margin-top: -175px;
}

#filtrering{
  position: absolute;
  top: 55%;
  display: flex;
	place-content: center;
	gap: 30px;
  flex-flow: wrap;
}

main {
  display: flex;
  flex-direction: column;
  margin-top: -70px; 
}

 article {
	display: grid;
	grid-template-columns: 380px 1fr;
  margin-bottom: 60px;
}

  .img_box, .text_box{
    z-index: 1;
    display: grid;
    place-content: center;
  }

  .text_box{
    padding-top: 40px;
    max-width: 380px;
  }


  .billede{
    max-width: 300px;
  }

  .boelge{
    width: 100vw;
    height: 400px;
    position: absolute;
  }

  h1{
	  /* display: grid;
	  place-items: center; */
   font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-style: normal;
    color: #482900;
    position: absolute;
    top: 10%;
    left: 30%;
    margin-top: -35px;
  }


 #filtrering > button {
	background: url(http://hoffmannlund.dk/kea/10_eksamen/banana_cph/wp-content/themes/inspiro-child/billeder/knap_baggrund.png) no-repeat;
	width: 220px;
	height: 60px;
	padding: 0;
  border: none;
   transition: .2s ease-in-out 0s;
   font-family: 'Raleway', sans-serif;
}
#filtrering > button:hover{
  color: #482900;
  border: none;
  transform: scale(1.25);
  font-weight: 800;
}
}

/* media query mobil */
@media (max-width: 600px){
.baggrundsboelge{
  margin-top: -75px;
}

h1{
	font-family: 'Permanent Marker', cursive;
	font-weight: 400;
	font-style: normal;
	color: #482900;
	position: absolute;
	margin-top: -270px;
	font-size: 2rem;
	left: 9%;
  top: auto;
}
.produkt_intro_tekst {
	position: absolute;
	font-size: 0.7rem;
	margin: -185px 20px;
  color: #482900;
  font-family: 'Raleway', sans-serif;
  top: auto;
  left: auto;
}

#filtrering {
	position: absolute;
	display: flex;
	flex-direction: column;
  left: 20%;
  gap: 10px;
  top: auto;
}

 #filtrering > button {
	background: url(http://hoffmannlund.dk/kea/10_eksamen/banana_cph/wp-content/themes/inspiro-child/billeder/knap_baggrund.png) no-repeat;
	width: 220px;
	height: 60px;
	padding: 0;
  border: none;
   transition: .2s ease-in-out 0s;
   font-family: 'Raleway', sans-serif;
}

main{
  margin-top: 270px;
}
article{
  display: flex;
  flex-direction: column;
  margin-bottom: 100px;
}

.img_box {
	order: 1;
	max-width: 250px;
	display: grid;
	place-self: center;
}

.produkt_titel{
  color: #482900;
  font-family: 'Permanent Marker', cursive;
    font-weight: 400;
    font-style: normal;
    display: grid;
    place-items: center;
}

.beskrivelse {
	color: #482900;
	font-family: 'Raleway', sans-serif;
	padding: 0 20px;
}

}


</style>


<?php
get_footer();
