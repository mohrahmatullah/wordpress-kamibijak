<?php get_header(); ?>

<?php if ( 'y' == airkit_single_option( 'breadcrumbs' ) ) : ?>
	<div class="airkit_breadcrumbs breadcrumbs-single-post container">
		<?php echo airkit_breadcrumbs(); ?>
	</div>
<?php endif; ?>

<div id="main" class="airkit_single-main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
	<div class="container singular-container">
	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();
			get_template_part('templates/portfolio');
			
		}
	}
	?>
	</div> 
	<!-- /.singular-container -->
</div>

<?php 


get_footer(); 
// end.