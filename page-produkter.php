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
            <h2 class="projekt_titel"></h2>
            <p class="teaser_tekst"></p>
            <p class="verdensmaal"></p>
          </article>
      </template>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
<?php the_content(); ?>
		</main><!-- #main -->

 <style>
	 
	 </style>

<?php
get_footer();
