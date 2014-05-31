<?php
/**
 * De loop template
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @since		0.1
 * @version     0.3.1
 */
?>
<div id="wrapper-entry" class="wrapper-entry">

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	            <header>
	                <h1 class="entry-title"><?php the_title(); ?></h1>
	            </header>
	            
	            <?php if(is_single() || is_archive()) : ?>
	            	<?php get_template_part( 'partials/entry-meta' ); ?>
	            <?php endif; ?>
	            
	            <div class="entry-content">
	                <?php if (has_post_thumbnail( get_the_ID() ) ): ?>
	                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' ); ?>
	                    <img class="entry-featured" src="<?php echo $image[0]; ?>">
	                <?php endif; ?>
	                <?php the_content(); ?>
                    <hr>

                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup">
                        <form action="http://debordeauxspecialist.us8.list-manage1.com/subscribe/post?u=eecad2b2e7193b8f70f0ad384&amp;id=093181159b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <h2>Inschrijven voor onze nieuwsbrief</h2>
                            <div id="mce-responses" class="clear">
                                <div class="response" id="mce-error-response" style="display:none"></div>
                                <div class="response" id="mce-success-response" style="display:none"></div>
                            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div class="mc-field-group">
                                <label for="mce-EMAIL">E-mailadres<span class="asterisk">*</span>: </label>
                                <input type="email" value="" placeholder="naam@voorbeeld.nl" name="EMAIL" class="required email" id="mce-EMAIL">
                            </div>
                            <div class="mc-field-group">
                                <label for="mce-FNAME">Voornaam:</label>
                                <input type="text" value="" placeholder="Uw voornaam" name="FNAME" class="" id="mce-FNAME">
                            </div>
                            <div class="mc-field-group">
                                <label for="mce-LNAME">Achternaam:</label>
                                <input type="text" value="" placeholder="Uw achternaam" name="LNAME" class="" id="mce-LNAME">
                            </div>
                            <div class="indicates-required"><span class="asterisk">*</span> verplichte velden</div>
                            <div style="position: absolute; left: -5000px;"><input type="text" name="b_eecad2b2e7193b8f70f0ad384_093181159b" tabindex="-1" value=""></div>
                            <div class="clear"><input type="submit" value="Inschrijven" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                        </form>
                    </div>
                    <!--End mc_embed_signup-->
	            
	            <?php if(is_single()) : ?>
		
					<?php //wp_list_comments(array('style' => 'div')); ?>
				 	<?php //comments_template(); ?>
				 	
	            <?php endif; ?>
	            
			</article><!-- #post-ID -->
        <?php endwhile; ?>
    <?php endif; ?>
    
    <?php if(is_archive()) : ?>
   		<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
	<?php endif; ?>
	
</div><!-- #wrapper-entry -->