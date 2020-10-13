<?php
/**
 * The template for displaying Footer Style 2
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */
?>
<div class="airkit_footer-style2 airkit_dark-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-3">
				<?php dynamic_sidebar( 'footer1' ) ?>
			</div>
			<div class="col-md-3 col-sm-3">
				<?php dynamic_sidebar( 'footer2' ) ?>
			</div>
			<div class="col-md-3 col-sm-3">
				<?php dynamic_sidebar( 'footer3' ) ?>
			</div>
			<div class="col-md-3 col-sm-3">
				<?php dynamic_sidebar( 'footer4' ) ?>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<div class="row">
				<div class="airkit_table-content">
					<?php
						echo airkit_PostMeta::copyright( array('columns' => 'col-md-8 col-sm-8 cell-item') );
						echo airkit_Compilator::social_buttons_element( array('text-align' => 'right', 'style' => 'iconed', 'labels' => 'n', 'columns' => 'col-md-4 col-sm-4 cell-item') );
					?>
				</div>
			</div>
		</div>
	</div>
</div>