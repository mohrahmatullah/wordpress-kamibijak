<?php

/* Team view template below */
###########

// Get the options
$options = airkit_Compilator::$options;
$item = $options['item'];

$el_classes = $article_classes = array();

if ( 'y' === $item['featured'] ) {

	$article_classes[] = 'featured';

}

$price = @$item['price'] . ' / ' . @$item['period'];

$el_classes[] = airkit_Compilator::get_column_class( $options['per-row'] );
$article_classes[] = airkit_Compilator::child_effect( $item );

$features = explode("\n", $item['items']);

?>
<div class="<?php echo implode( ' ', $el_classes ); ?>">
	<article class="pricing-item <?php echo implode( ' ', $article_classes ); ?>  ">
	 	<figure>
	 		
		 	<figcaption>
		 		<h4 class="entry-title"> <?php echo airkit_var_sanitize( $item['title'], 'esc_attr' ); ?> </h4>

		 		<div class="item-price">
		 			<?php echo airkit_var_sanitize( $price, 'esc_attr' ); ?>		
		 		</div>
		 	</figcaption>

	 	</figure>
	 	<header>
	 		<div class="entry-excerpt">
	 			<?php echo airkit_var_sanitize( @$item['description'], 'the_kses' ); ?>
	 		</div>
	 		<ul class="pricing-items">
				<?php
					foreach ( $features as $feature ) {
						echo '<li><span>' . $feature . '</span></li>';
					}
				?> 			
	 		</ul>
	 		<a href="<?php echo @$item['button-url']; ?>" class="read-more"><?php echo @$item['button-text']; ?></a>
	 	</header>
	</article>
 </div>
