<?php
/**
 * The template for displaying Footer Style 5
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */
?>
<div class="airkit_footer-style5">
	<div class="container">
		<div class="row">
			<div class="airkit_table-content">
				<div class="cell-item col-md-4 col-sm-4">
					<?php dynamic_sidebar( 'footer1' ) ?>
					<div class="footer-copyright">
						<?php echo airkit_PostMeta::copyright( array('columns' => 'copyright-text') ); ?>
					</div>
				</div>
				<div class="cell-item airkit_dark-bg col-md-8 col-sm-8">
					<?php dynamic_sidebar( 'footer2' ) ?>
				</div>
			</div>
		</div>
	</div>
</div>