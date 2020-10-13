<div class="tszf-user-loggedin">

	<span class="tszf-user-avatar">
		<?php echo airkit_get_avatar( $user->ID ); ?>
	</span>

	<ul>
		<li><?php printf( __( 'Hello %s', 'gowatch' ), $user->display_name ); ?></li>
	</ul>

	<?php printf( __( 'You are currently logged in! %s?', 'gowatch' ), wp_loginout( '', false ) ) ?>
</div>