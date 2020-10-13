<?php

$options = airkit_Compilator::$options;
$options['is-view-article'] = true;

$posts_to_show =  ( isset($options['posts-limit']) && !empty($options['posts-limit']) ? intval($options['posts-limit']) : 999 );

$count = 0;

?>

<div class="ts-featured-area <?php echo airkit_var_sanitize( $options['style'], 'esc_attr' ); ?>">
	<div class="row">
	<?php 
		while ( $options['posts_query']->have_posts() ):

			$options['posts_query']->the_post();

			if( 'style-1' === $options['style'] ):

				$article_classes 	= array('item small-article');
				$figure_attributes 	= array();

				$article_atts['class'] = get_post_class( $article_classes );
				
				if( 0 === $count ):  ?>

				<div class="col-lg-8 col-md-7 col-sm-12 thumbnail-view">
					<article <?php post_class( array('over-image', 'airkit_view-article') ); ?> >
						<?php

							airkit_featured_image( $options, array( 'post_link' ) );
							airkit_entry_content( $options, array( 'excerpt' ) );

						?>
					</article>
				</div>
				<div class="small-articles-container col-lg-4 col-md-5 col-sm-12 vertical-scroll">

				<?php else: ?>

					<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

						<?php if( has_post_thumbnail( $post->ID ) ): ?>
							<figure <?php airkit_element_attributes( $figure_attributes, array_merge( $options, array('element' => 'figure', 'img_size' => 'gowatch_small' ) ), $post->ID ); ?>>
								<a href="<?php echo get_the_permalink(); ?>">
									<?php airkit_overlay_effect_type(); ?>
								</a>
							</figure>
						<?php endif; ?>

						<header>
							<?php
								echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'entry-categories' ) );
								echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h2') );
								echo airkit_PostMeta::the_meta( $post->ID, $options, array('author', 'views') );
								airkit_PostMeta::microdata( $options, true );
							?>
						</header>

					</article>

				<?php endif; ?>		

				<?php if( $posts_to_show - 1 === $count ): ?>
				</div><!-- ./small-articles-container -->
				<?php endif; ?>
			
			<?php 

			endif;//style-1 end.

			$count++;

		endwhile; 

	?>
	
	<?php 
	// Render Feat area style 2
	if( 'style-2' === $options['style'] ):
		/*
		 * This style inherits styles from thumbnail view. For small columns is used 'title below' style, 
		 *   for centered column is used 'title over' style.
		 */

		/* Get posts and sort them. First post should be displayed in center column */

		$query = new WP_Query( airkit_Compilator::query( $options ) );

		$first_col = $query->posts;
					unset( $first_col[0] );
					unset( $first_col[3] );
					unset( $first_col[4] );

		$last_col = $query->posts;
					unset( $last_col[0] );		
					unset( $last_col[1] );
					unset( $last_col[2] );

		$main = array();
		$main[0] = $query->posts[0];


		$posts = array_merge( $first_col, $main, $last_col );

		/* Loop count */

		$count = 0;

		foreach ( $posts as $post ):

			$article_classes = $article_atts = $figure_attributes = array();

			//if entering post #0 or post #3 (first or forth), open small column wrapper, use 'title below' style.
			if( $count == 0 || $count == 3 ) {
				echo '<div class="feat-area-column thumbnail-view col-lg-3 col-md-3">';
				$title_position = 'over-image';
			}
			// If entering post #2 (third, centered), open big columns for centered article, use 'title over' style.
			if( $count == 2 ) {
				echo '<div class="feat-area-main thumbnail-view col-lg-6 col-md-6">';
				$title_position = 'over-image';
			}

			$article_classes[] 	= $title_position;

			if ( !has_post_thumbnail( $post->ID ) ) {
				$article_classes[] = 'no-image';
			}

			//Show content on hover / always.
			if( 'over-image' === $title_position ) {
				if( isset( $options['content-hover'] ) ) {
					$article_classes[] = $options['content-hover'];
				}
			}

			$article_atts['class'] = get_post_class( $article_classes );
		?>

		<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

			<?php

				airkit_featured_image( $options, array( 'post_link' ) );
				airkit_entry_content( $options, array( 'excerpt' ) );

			?>

		</article>

			<?php 

			if( $count == 2 ) {
				echo '</div>';
			}

			if( $count == 1 || $count == 4 ) {
				echo '</div>';
			}


			$count++;
		endforeach;
	endif; 

	//Render Feat area style 3
	if( 'style-3' === $options['style'] ):

		$query = new WP_Query( airkit_Compilator::query( $options ) );

	?>

	<div class="col-sm-12 col-md-12 col-lg-12">

		<div class="feat-area-slider">
			<?php foreach ( $query->posts as $post ): ?>
				
				<article <?php post_class(); ?>>
					<figure class="image-holder">
						<?php echo get_the_post_thumbnail( $post->ID, 'gowatch_wide' ); ?>
						<a href="<?php echo get_the_permalink(); ?>" class="post-link"></a>
					</figure>

					<header>
						<div class="entry-content">
							<?php
								echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'entry-categories' ) );
								echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h2') );
								echo airkit_PostMeta::the_meta( $post->ID );
							?>
						</div>
					</header>
				</article>
				
			<?php endforeach; ?>
		</div>

		<div class="feat-area-thumbs">
		<?php
			foreach ( $query->posts as $post ):
				$figure_attributes = array();
		?>		
				
			<div class="thumb-item">
				<article <?php post_class(); ?>>
					<figure <?php airkit_element_attributes( $figure_attributes, array_merge( $options, array('element' => 'figure', 'img_size' => 'gowatch_grid' ) ), $post->ID ); ?>>
						<a href="<?php echo get_the_permalink(); ?>" class="post-link"></a>
					</figure>

					<header>
						<div class="entry-content">
							<?php
								echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'entry-categories' ) );
								echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h2') );
								echo airkit_PostMeta::date( $post->ID, array('wrap' => 'span') );
								airkit_PostMeta::microdata( $options, true, true );
							?>
						</div>
					</header>
					<span class="thumb-progress-bar"></span>
				</article>
			</div>
				
		<?php endforeach; ?>
		</div>

	</div>

	<?php endif; ?>

	</div>
</div>