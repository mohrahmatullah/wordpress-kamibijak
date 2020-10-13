			<footer id="footer" data-role="footer" data-fullscreen="true">
				<?php echo airkit_Compilator::build_content( airkit_Compilator::get_head( 'footer' ) ); ?>
			</footer>
		</div>

	    <?php if ( airkit_option_value( 'general', 'enable_facebook_box' ) == 'y' ) : ?>
			<div class="ts-fb-modal modal fade" id="fbpageModal" tabindex="-1" role="dialog" aria-labelledby="fbpageModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span>
								<span class="sr-only"><?php esc_html_e('Close','gowatch') ?></span>
							</button>
							<h4 class="modal-title" id="fbpageModalLabel"><?php esc_html_e( 'facebook.','gowatch' ); ?></h4>
						</div>
						<div class="modal-body">
							<?php $airkit_face_name = airkit_option_value( 'general', 'facebook_name' ); ?>
							<div class="fb-page" data-href="<?php echo esc_url('https://facebook.com/' . $airkit_face_name) ?>" data-width="<?php echo ( wp_is_mobile() ? '300' : '500' ); ?>" data-height="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
								<div class="fb-xfbml-parse-ignore">
									<blockquote cite="<?php esc_url('https://facebook.com/' . $airkit_face_name) ?>">
										<a href="<?php esc_url('https://facebook.com/' . $airkit_face_name) ?>"><?php esc_html_e('Facebook', 'gowatch') ?></a>
									</blockquote>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<span class="already-liked">
								<?php echo esc_html__( 'I already liked it.', 'gowatch' ); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div id="fb-root"></div>
		<?php endif; ?>

		<?php if ( airkit_option_value( 'styles', 'scroll_to_top' ) == 'y' ) : ?>
			<button id="airkit_back-to-top">
				<i class="icon-up"></i>
				<span>
					<?php esc_html_e( 'Back to top', 'gowatch' ); ?>
				</span>
			</button>
		<?php endif; ?>

		<?php echo ( airkit_option_value( 'general', 'custom_javascript' ) != '' ? stripslashes( airkit_option_value( 'general', 'custom_javascript' )) : '' ); ?>
		<?php wp_footer(); ?>
	</body>
</html>
