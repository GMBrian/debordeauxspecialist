<?php
/**
 * Template part: Hero Unit
 */

global $post, $template;

?>

<?php if($template == 'maps') : ?>
	
	<div class="maps-filler">
		<div id="maps-container" class="maps-container"></div>
	</div>
	
<?php else: ?>

	<?php if(!is_user_logged_in()) : ?>
		<?php if(is_home() || is_front_page()) : ?>
			<?php $rows = get_field('rotatorobjecten', 'option'); ?>
			<div class="hero-unit align-center">
				<div class="hero-slider-background">
					<div id="hero-slider-backgroundimages" class="hero-slider-backgroundimages">
						<?php
							foreach($rows as $key => $row) :
								$number = $key + 1;
								echo '<img class="slider-backgroundimage-'.$number.'" src="'.$row['achtergrondafbeelding'].'">';
							endforeach;
						?>
					</div>
					<div class="hero-slider align-center">
			    		<div class="hero-slider-text">
			    			<ul id="hero-slider-content" class="hero-slider-content">
								<?php
									foreach($rows as $key => $row) :
										$number = $key + 1;
										echo '
											<li class="slider-content-'.$number.'">
												<h2>'.$row['afbeeldingstitel'].'</h2>
			            						<p>'.$row['kortetekst'].'</p>
											</li>';
									endforeach;
								?>
			    			</ul>
			    			<ul id="hero-slider-blocks" class="hero-slider-blocks">
								<?php
									foreach($rows as $key => $row) :
										$number = $key + 1;
										echo '<li class="hero-slider-block-'.$number.'"><a href=""><div class="hero-slider-click"></div></a></li>';
									endforeach;
								?>
			    			</ul>
			    		</div>
			    		<div id="hero-slider-images" class="hero-slider-images">
							<?php
								foreach($rows as $key => $row) :
									$number = $key + 1;
									echo '<img class="slider-image-'.$number.'" src="'.$row['hoofdafbeelding'].'">';
								endforeach;
							?>
			    		</div>
					</div><!-- .hero-slider.align-center -->
				</div><!-- .hero-slider-background -->
			</div><!-- .hero-unit.align-center -->
		<?php else : ?>
			<?php 
				$rand = rand(1, 5);
				$image_url = get_stylesheet_directory_uri().'/assets/images/img-slider-bg-small-'.$rand.'.png';
			?>
			<div class="hero-filler" style="background-image:url(<?php echo $image_url ?>);"></div>
		<?php endif; ?>
	<?php else : ?>
		<?php 
			$rand = rand(1, 5);
			$image_url = get_stylesheet_directory_uri().'/assets/images/img-slider-bg-small-'.$rand.'.png';
		?>
		<div class="hero-filler" style="background-image:url(<?php echo $image_url ?>);"></div>
	<?php endif; ?>
	
<?php endif; ?>