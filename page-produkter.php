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

<template class="loopview">
        <article>
            <div class="img_box">
            	<img src="" alt="" class="billede" />
            </div>
			<div class="text_box">
            	<h2 class="produkt_titel"></h2>
            	<p class="ingredienser"></p>
            	<p class="pris"></p>
			</div>
        </article>
</template>

	<nav class="nav">
    	<button data-influencer="alle" class="valgt">Alle</button>
    	<button data-influencer="Is">Is</button>
        <button data-influencer="Kager">Kager</button>
        <button data-influencer="Topping">Topping</button>
    </nav>

<div id="primary" class="content-area">
		<main id="main" class="site-main">
		</main><!-- #main -->
	<?php the_content(); ?>
</div><!-- #primary -->

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
  const popup = document.querySelector("#popup");
  const article = document.querySelector("article");
  const lukKnap = document.querySelector("#luk");

  
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
	// opretKnapper();
  }

  // loop'er gennem alle projekter i json-arrayet
  function visProdukter() {
    console.log("visProdukter");

    main.textContent = ""; // Her resetter jeg DOM'en ved at tilføje en tom string

    // for hver projekt i arrayet, skal der tjekkes om de opfylder filter-kravet og derefter vises i DOM'en.
    produkter.forEach((produkt) => {
      if (filter == "alle" || produkt.categories.includes(parseInt(filter))) {
        const klon = template.cloneNode(true);
        klon.querySelector(".billede").src = produkt.billede.guid;
        klon.querySelector(".produkt_titel").textContent = produkt.title.rendered;
        klon.querySelector(".ingredienser").textContent = "Ingredienser: " + produkt.ingredienser;
        klon.querySelector(".pris").textContent = produkt.pris + " kr.";

        // tilføjer eventlistner til hvert article-element og lytter efter klik på artiklerne. 
        // Ved klik sendes man videre til single-projekt.php
        // klon
        //   .querySelector("article")
        //   .addEventListener("click", () => visDetaljer(produkt));

        // tilføjer klon-template-elementet til main-elementet (så det hele vises i DOM'en)
        main.appendChild(klon);
      }
    });
  }

  hentData();
}
	</script>

<style>
	main {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 45px;
    margin-top: 40px;
  }

  article{
	  display: flex;
	  flex-direction: column;
	  justify-content: space-between;
  }
</style>


<?php
get_footer();
