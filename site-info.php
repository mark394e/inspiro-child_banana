<?php
/**
 * Displays footer site info
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

?>
<div class="site-info">
<div class="footer1">
	<p class="footer_h">KONTAKTOPLYSNINGER</p>
	<p>CVR:</p>
	<p> <img src="billeder/telefon.png" alt="telefon">+45 61 69 45 46</p>
	<p> <img src="billeder/mail.png" alt="mail"> info@bananacph.com</p>
</div>
<div class="footer2">
	<img class="smikon" src="billeder/face.png" alt="facebook">
	<img class="smikon" src="billeder/insta.png" alt="instagram">
</div>
<div class="footer3">
	<img src="billeder/logo" alt="logo">
	<img src="billeder/bananalogo" alt="banana">
</div>
</div><!-- .site-info -->

<style>
.site-footer {
  background: #fed500;
  color: #482900;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
}

.footer1 {
	grid-column: 1/2;
}

.footer2 {
	grid-column: 2/3;
}

.footer3 {
	grid-column: 3/4;
}
</style>