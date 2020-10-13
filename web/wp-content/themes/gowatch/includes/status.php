<div class="airkit-system-status">
	<table class="widefat airkit-system-status-debug" cellspacing="0">
		<tbody>
			<tr>
				<td colspan="3" data-export-label="goWatch Versions">
					<span class="get-system-status"><a href="#" class="button-primary debug-report"><?php esc_attr_e( 'Get System Report', 'goWatch' ); ?></a><span class="system-report-msg"><?php esc_attr_e( 'Click the button to produce a report, then copy and paste into your support ticket.', 'goWatch' ); ?></span></span>

					<div id="debug-report" class="is-hidden">
						<textarea readonly="readonly"></textarea>
						<p class="submit">Please copy the information in the textarea above and send it to our support staff. This is hugely important so we can see where some problems can come from.</p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<h3 class="screen-reader-text"><?php esc_attr_e( 'WordPress Environment', 'goWatch' ); ?></h3>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3" data-export-label="WordPress Environment"><?php esc_attr_e( 'WordPress Environment', 'goWatch' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="40%" data-export-label="Home URL"><?php esc_attr_e( 'Home URL:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The URL of your site\'s homepage.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_url_raw( home_url() ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Site URL"><?php esc_attr_e( 'Site URL:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The root URL of your site.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_url_raw( site_url() ); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Content Path"><?php esc_attr_e( 'WP Content Path:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'System path of your wp-content directory.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo defined( 'WP_CONTENT_DIR' ) ? esc_html( WP_CONTENT_DIR ) : esc_html__( 'N/A', 'goWatch' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Path"><?php esc_attr_e( 'WP Path:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'System path of your WP root directory.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo defined( 'ABSPATH' ) ? esc_html( ABSPATH ) : esc_html__( 'N/A', 'goWatch' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Version"><?php esc_attr_e( 'WP Version:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of WordPress installed on your site.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php bloginfo( 'version' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Multisite"><?php esc_attr_e( 'WP Multisite:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo ( is_multisite() ) ? '&#10004;' : '&ndash;'; ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Memory Limit"><?php esc_attr_e( 'PHP Memory Limit:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td>
					<?php
					// Get the memory from PHP's configuration.
					$memory = ini_get( 'memory_limit' );
					// If we can't get it, fallback to WP_MEMORY_LIMIT.
					if ( ! $memory || -1 === $memory ) {
						$memory = wp_convert_hr_to_bytes( WP_MEMORY_LIMIT );
					}
					// Make sure the value is properly formatted in bytes.
					if ( ! is_numeric( $memory ) ) {
						$memory = wp_convert_hr_to_bytes( $memory );
					}
					?>
					<?php if ( $memory < 128000000 ) : ?>
						<mark class="error">
							<?php printf( __( '%1$s - We recommend setting memory to at least <strong>128MB</strong>. Please define memory limit in <strong>wp-config.php</strong> file. To learn how, see: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing memory allocated to PHP.</a>', 'goWatch' ), esc_attr( size_format( $memory ) ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ); // WPCS: XSS ok. ?>
						</mark>
					<?php else : ?>
						<mark class="yes">
							<?php echo esc_attr( size_format( $memory ) ); ?>
						</mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="WP Debug Mode"><?php esc_attr_e( 'WP Debug Mode:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td>
					<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
						<mark class="yes">&#10004;</mark>
					<?php else : ?>
						<mark class="no">&ndash;</mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Language"><?php esc_attr_e( 'Language:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The current language used by WordPress. Default = English', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_attr( get_locale() ) ?></td>
			</tr>
		</tbody>
	</table>

	<h3 class="screen-reader-text"><?php esc_attr_e( 'Server Environment', 'goWatch' ); ?></h3>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Server Environment"><?php esc_attr_e( 'Server Environment', 'goWatch' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="40%" data-export-label="Server Info"><?php esc_attr_e( 'Server Info:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Information about the web server that is currently hosting your site.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo isset( $_SERVER['SERVER_SOFTWARE'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) ) : esc_attr__( 'Unknown', 'goWatch' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Version"><?php esc_attr_e( 'PHP Version:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of PHP installed on your hosting server.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td>
					<?php
					$php_version = null;
					if ( defined( 'PHP_VERSION' ) ) {
						$php_version = PHP_VERSION;
					} elseif ( function_exists( 'phpversion' ) ) {
						$php_version = phpversion();
					}
					if ( null === $php_version ) {
						$message = esc_attr__( 'PHP Version could not be detected.', 'goWatch' );
					} else {
						if ( version_compare( $php_version, '7.0.0' ) >= 0 ) {
							$message = $php_version;
						} else {
							$message = sprintf( esc_attr__( '%1$s. WordPress recomendation: 7.0.0 or above. See %2$s for details.', 'goWatch' ), $php_version, '<a href="https://wordpress.org/about/requirements/" target="_blank">WordPress Requirements</a>' );
						}
					}
					echo $message; // WPCS: XSS ok.
					?>
				</td>
			</tr>
			<?php if ( function_exists( 'ini_get' ) ) : ?>
				<tr>
					<td data-export-label="PHP Post Max Size"><?php esc_attr_e( 'PHP Post Max Size:', 'goWatch' ); ?></td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest file size that can be contained in one post.', 'goWatch' ) . '">[?]</a>'; ?></td>
					<td><?php echo esc_attr( size_format( wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) ) ) ); ?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Time Limit"><?php esc_attr_e( 'PHP Time Limit:', 'goWatch' ); ?></td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'goWatch' ) . '">[?]</a>'; ?></td>
					<td>
						<?php
						$time_limit = ini_get( 'max_execution_time' );

						if ( 180 > $time_limit && 0 != $time_limit ) {
							echo '<mark class="error">' . sprintf( __( '%1$s - We recommend setting max execution time to at least 180.<br />See: <a href="%2$s" target="_blank" rel="noopener noreferrer">Increasing max execution to PHP</a>', 'goWatch' ), $time_limit, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>'; // WPCS: XSS ok.
						} else {
							echo '<mark class="yes">' . esc_attr( $time_limit ) . '</mark>';
						}
						?>
					</td>
				</tr>
				<tr>
					<td data-export-label="PHP Max Input Vars"><?php esc_attr_e( 'PHP Max Input Vars:', 'goWatch' ); ?></td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'goWatch' ) . '">[?]</a>'; ?></td>
					<?php
					$registered_navs = get_nav_menu_locations();
					$menu_items_count = array(
						'0' => '0',
					);
					foreach ( $registered_navs as $handle => $registered_nav ) {
						$menu = wp_get_nav_menu_object( $registered_nav );
						if ( $menu ) {
							$menu_items_count[] = $menu->count;
						}
					}

					$max_items = max( $menu_items_count );
					$required_input_vars = $max_items * 20;
					?>
					<td>
						<?php
						$max_input_vars = ini_get( 'max_input_vars' );
						$required_input_vars = $required_input_vars + ( 500 + 1000 );
						// 1000 = theme options
						if ( $max_input_vars < $required_input_vars ) {
							echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'goWatch' ), $max_input_vars, '<strong>' . $required_input_vars . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>'; // WPCS: XSS ok.
						} else {
							echo '<mark class="yes">' . esc_attr( $max_input_vars ) . '</mark>';
						}
						?>
					</td>
				</tr>
				<tr>
					<td data-export-label="SUHOSIN Installed"><?php esc_attr_e( 'SUHOSIN Installed:', 'goWatch' ); ?></td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself.
	If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'goWatch'  ) . '">[?]</a>'; ?></td>
					<td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
				</tr>
				<?php if ( extension_loaded( 'suhosin' ) ) :  ?>
					<tr>
						<td data-export-label="Suhosin Post Max Vars"><?php esc_attr_e( 'Suhosin Post Max Vars:', 'goWatch' ); ?></td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'goWatch' ) . '">[?]</a>'; ?></td>
						<?php
						$registered_navs = get_nav_menu_locations();
						$menu_items_count = array(
							'0' => '0',
						);
						foreach ( $registered_navs as $handle => $registered_nav ) {
							$menu = wp_get_nav_menu_object( $registered_nav );
							if ( $menu ) {
								$menu_items_count[] = $menu->count;
							}
						}

						$max_items = max( $menu_items_count );

						$required_input_vars = $max_items * 12;
						?>
						<td>
							<?php
							$max_input_vars = ini_get( 'suhosin.post.max_vars' );
							$required_input_vars = $required_input_vars + ( 500 + 1000 );

							if ( $max_input_vars < $required_input_vars ) {
								echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'goWatch' ), $max_input_vars, '<strong>' . ( $required_input_vars ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>'; // WPCS: XSS ok.
							} else {
								echo '<mark class="yes">' . esc_attr( $max_input_vars ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Suhosin Request Max Vars"><?php esc_attr_e( 'Suhosin Request Max Vars:', 'goWatch' ); ?></td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'goWatch' ) . '">[?]</a>'; ?></td>
						<?php
						$registered_navs = get_nav_menu_locations();
						$menu_items_count = array(
							'0' => '0',
						);
						foreach ( $registered_navs as $handle => $registered_nav ) {
							$menu = wp_get_nav_menu_object( $registered_nav );
							if ( $menu ) {
								$menu_items_count[] = $menu->count;
							}
						}

						$max_items = max( $menu_items_count );
						$required_input_vars = ini_get( 'suhosin.request.max_vars' );
						?>
						<td>
							<?php
							$max_input_vars = ini_get( 'suhosin.request.max_vars' );
							$required_input_vars = $required_input_vars + ( 500 + 1000 );

							if ( $max_input_vars < $required_input_vars ) {
								echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Increasing max input vars limit.</a>', 'goWatch' ), $max_input_vars, '<strong>' . ( $required_input_vars + ( 500 + 1000 ) ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>'; // WPCS: XSS ok.
							} else {
								echo '<mark class="yes">' . esc_attr( $max_input_vars ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Suhosin Post Max Value Length"><?php esc_attr_e( 'Suhosin Post Max Value Length:', 'goWatch' ); ?></td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Defines the maximum length of a variable that is registered through a POST request.', 'goWatch' ) . '">[?]</a>'; ?></td>
						<td><?php
							$suhosin_max_value_length = ini_get( 'suhosin.post.max_value_length' );
							$recommended_max_value_length = 2000000;

						if ( $suhosin_max_value_length < $recommended_max_value_length ) {
							echo '<mark class="error">' . sprintf( __( '%1$s - Recommended Value: %2$s.<br />Post Max Value Length limitation may prohibit the Theme Options data from being saved to your database. See: <a href="%3$s" target="_blank" rel="noopener noreferrer">Suhosin Configuration Info</a>.', 'goWatch' ), $suhosin_max_value_length, '<strong>' . $recommended_max_value_length . '</strong>', 'http://suhosin.org/stories/configuration.html' ) . '</mark>'; // WPCS: XSS ok.
						} else {
							echo '<mark class="yes">' . esc_attr( $suhosin_max_value_length ) . '</mark>';
						}
						?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
			<tr>
				<td data-export-label="ZipArchive"><?php esc_attr_e( 'ZipArchive:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo class_exists( 'ZipArchive' ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">ZipArchive is not installed on your server, but is required if you need to import demo content.</mark>'; ?></td>
			</tr>
			<tr>
				<td data-export-label="MySQL Version"><?php esc_attr_e( 'MySQL Version:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of MySQL installed on your hosting server.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td>
					<?php global $wpdb; ?>
					<?php echo esc_attr( $wpdb->db_version() ); ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Max Upload Size"><?php esc_attr_e( 'Max Upload Size:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest file size that can be uploaded to your WordPress installation.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo esc_attr( size_format( wp_max_upload_size() ) ); ?></td>
			</tr>
			<tr>
				<td data-export-label="DOMDocument"><?php esc_attr_e( 'DOMDocument:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'DOMDocument is required for the airkit Builder plugin to properly function.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td><?php echo class_exists( 'DOMDocument' ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">DOMDocument is not installed on your server, but is required if you need to use the airkit Page Builder.</mark>'; ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Remote Get"><?php esc_attr_e( 'WP Remote Get:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'This theme uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<?php $response = wp_safe_remote_get( 'https://build.envato.com/api/', array(
					'decompress' => false,
					'user-agent' => 'touchsize-remote-get-test',
				) ); ?>
				<td><?php echo ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">wp_remote_get() failed. Some theme features may not work. Please contact your hosting provider and make sure that https://build.envato.com/api/ is not blocked.</mark>'; ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Remote Post"><?php esc_attr_e( 'WP Remote Post:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'This theme uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<?php $response = wp_safe_remote_post( 'https://envato.com/', array(
					'decompress' => false,
					'user-agent' => 'touchsize-remote-get-test',
				) ); ?>
				<td><?php echo ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">wp_remote_post() failed. Some theme features may not work. Please contact your hosting provider and make sure that https://envato.com/ is not blocked.</mark>'; ?></td>
			</tr>
			<tr>
				<td data-export-label="GD Library"><?php esc_attr_e( 'GD Library:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'This theme uses this library to resize images and speed up your site\'s loading time', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td>
					<?php
					$info = esc_attr__( 'Not Installed', 'goWatch' );
					if ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
						$info = esc_attr__( 'Installed', 'goWatch' );
						$gd_info = gd_info();
						if ( isset( $gd_info['GD Version'] ) ) {
							$info = $gd_info['GD Version'];
						}
					}
					echo esc_attr( $info );
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Get Image Size"><?php esc_attr_e( 'PHP getimagesize:', 'goWatch' ); ?></td>
				<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'This theme uses this function to get information about the image sizes.', 'goWatch' ) . '">[?]</a>'; ?></td>
				<td>
					<?php
					$imagesize = esc_attr__( 'Not Available', 'goWatch' );
					if ( function_exists( 'getimagesize' ) ) {
						$imagesize = esc_attr__( 'Installed', 'goWatch' );
					}
					echo esc_attr( $imagesize );
					?>
				</td>
			</tr>
		</tbody>
	</table>

	<h3 class="screen-reader-text"><?php esc_attr_e( 'Active Plugins', 'goWatch' ); ?></h3>
	<?php
	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {
		$active_plugins = array_merge( $active_plugins, array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) );
	}
	?>
	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Active Plugins (<?php echo count( $active_plugins ); ?>)"><?php esc_attr_e( 'Active Plugins', 'goWatch' ); ?> (<?php echo count( $active_plugins ); ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php

			foreach ( $active_plugins as $plugin ) {

				$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
				$dirname        = dirname( $plugin );
				$version_string = '';
				$network_string = '';

				if ( ! empty( $plugin_data['Name'] ) ) {

					// Link the plugin name to the plugin url if available.
					if ( ! empty( $plugin_data['PluginURI'] ) ) {
						$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . __( 'Visit plugin homepage' , 'goWatch' ) . '">' . esc_html( $plugin_data['Name'] ) . '</a>';
					} else {
						$plugin_name = esc_html( $plugin_data['Name'] );
					}
					?>
					<tr>
						<td width="40%">
							<?php echo $plugin_name; // WPCS: XSS ok. ?>
						</td>
						<td class="help">&nbsp;</td>
						<td>
							<?php printf( esc_attr__( 'by %s', 'goWatch' ), '<a href="' . esc_url( $plugin_data['AuthorURI'] ) . '" target="_blank">' . esc_html( $plugin_data['AuthorName'] ) . '</a>' ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; // WPCS: XSS ok. ?>
						</td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
</div>