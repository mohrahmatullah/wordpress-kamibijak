<?php
/**
 * The template for displaying Footer Style 4
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */
?>
<div class="airkit_footer-style4 text-center container">
	<div class="inner-footer">
		<?php dynamic_sidebar( 'footer1' ) ?>
		<div class="text-center">
			<?php echo airkit_Compilator::social_buttons_element( array( 'labels' => 'n', 'text-align' => 'center', 'style' => 'iconed' ) ); ?>
		</div>
		<div class="footer-copyright">
			<div class="row">
				<?php echo airkit_PostMeta::copyright(array('columns' => 'col-md-12 copyright-text')); ?>
			</div>
		</div>
	</div>
</div>