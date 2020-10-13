<?php get_header(); ?>
<div id="main">
	<div id="primary" class="container">
		<div class="row content-block">
			<div class="col-lg-12">
				<h1 class="title-404"><i class="icon-attention"></i><?php esc_html_e('Ooops!', 'gowatch');?></h1>
				<div class="nothing-message"><?php esc_html_e('Error 404. We didn\'t find anything. Try searching!', 'gowatch');?></div>
				<div class="search-404">
					<?php echo airkit_Compilator::searchbox_element( array( 'style' => 'input' ) ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
