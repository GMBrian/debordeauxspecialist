<?php
/**
 * De 404 template
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @version     1.0
 */
?>

<?php get_header(); ?>

<div id="wrapper-entry" class="wrapper-entry">

	<article id="post-404" <?php post_class(); ?>>
		<header>
			<h1>Error 404 - Pagina niet gevonden</h1>
		</header>

		<div class="entry-content">
			<p>Oeps, we konden de pagina die u vroeg niet vinden.</p>
			<p><strong>Een mogelijke reden kan zijn:</strong></p>
			<ul>
				<li>De link of bladwijzer die u heeft gebruikt bestaat niet meer</li>
				<li>U heeft een typfout gemaakt bij het invoeren van het internetadres</li>
			</ul>
			<p><strong>U kunt een van de volgende dingen proberen.</strong></p>
			<ul>
				<li>Klik op vernieuwen aan de bovenkant van uw internetverkenner (F5)</li>
				<li>Gebruik het hoofdmenu van deze website om de pagina te vinden die u zocht</li>
				<li>Ga naar de <a href="<?php echo home_url(); ?>">homepage</a> van deze website om de pagina te vinden die u zocht</li>
				<li>Klik op de ‘ga terug’-knop&nbsp;aan de bovenkant van uw internetverkenner om terug te gaan naar waar u vandaag kwam</li>
			</ul>

		</div>

	</article><!-- #post-ID -->

</div><!-- #wrapper-entry -->

<?php get_template_part( 'sidebar', 'right' ); ?>

<?php get_footer(); ?>