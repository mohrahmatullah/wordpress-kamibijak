<?php 
/**
 * Localized Variables:
 * $post_type       => Post type to retrieve.
 * $userdata        => WP User data object.
 * $dashboard_query => Contains posts query for displaying posts in dashboard .
 * $popular_query   => Contains most popular posts query.
 * $favorites_query => Contains posts query for displaying favorite posts.
 * $playlists_query => Contains posts query for displaying playlists.
 * $post_type_obj   => Post type object.
 * $post            => Global $post.
 * $pagenum         => Page numberr for pagination.
 * $is_my_profile   => bool, Tells whether users are viewing their profile, or someone else's profile.
 * $social_icons    => string, Contains HTML for user's social accounts.
 * $member_since    => string, Contains how much time ago user was registered.
 * $active_tab      => string, Contains name of tab that must be set to active.
 *
 */

/*
 * Configure options for posts listings.
 */

$home_active_tab      = ( 'home' == $active_tab )     ? 'active' : '';
$posts_active_tab     = ( 'posts' == $active_tab )     ? 'active' : '';
$favorites_active_tab = ( 'favorites' == $active_tab ) ? 'active' : '';
$settings_active_tab  = ( 'settings' == $active_tab )  ? 'active' : '';

$edit_profile = new TSZF_Edit_Profile();
$frontend_dashboard = new TSZF_Frontend_Dashboard();
$view_options = $frontend_dashboard->views_options();
$playlist_view_options = $frontend_dashboard->playlist_view_options();

/*
 * Get Sidebar options
 */
$airkit_sidebar = airkit_Compilator::build_sidebar( 'page', get_the_ID() );

?>

<div class="tszf-author" itemscope itemtype="https://schema.org/ProfilePage">
    <?php $frontend_dashboard->user_cover(); ?>
    <div class="tszf-author-inside">
        <div class="container">
            <div class="inner-container">
                <div class="tszf-author-body">
                    <div class="tszf-user-image"><?php $frontend_dashboard->user_avatar(); ?></div>
                    <div class="tszf-user-name">
                        <h4 itemprop="name"><?php echo esc_attr($userdata->display_name) ?></h4>
                        <ul class="social"><?php echo airkit_var_sanitize( $social_icons, 'the_kses' ); ?></ul>
                    </div>
                </div><div class="tszf-author-tabs">
                    <ul class="nav">
                        <?php foreach ($frontend_dashboard->profile_tabs as $key => $tab): ?>
                            <?php if ( 'settings' != $key ): ?>
                                <li class="<?php echo esc_attr($tab['class']); ?>">
                                    <a href="<?php echo esc_url($tab['url']); ?>"><?php echo airkit_var_sanitize($tab['title'], 'the_kses'); ?></a>
                                </li>
                            <?php else: ?>
                                <?php if ( $is_my_profile ): ?>
                                    <li class="<?php echo esc_attr($tab['class']); ?>">
                                        <a href="<?php echo esc_url($tab['url']); ?>"><?php echo airkit_var_sanitize($tab['title'], 'the_kses'); ?></a>
                                    </li>
                                <?php endif ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tszf-author-content">
        <div class="container">
            <div class="row">
                <?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' );  ?>
                <div class="<?php echo esc_attr( $airkit_sidebar['content_class'] ); ?> ">
                    <div class="tab-content">
                        <?php foreach ($frontend_dashboard->profile_tabs as $key => $tab): ?>

                            <div class="tab-pane <?php echo esc_attr($tab['class']); ?>" id="<?php echo esc_attr($key) ?>">
                                <?php if ( 'home' == $key ): ?>
                                    <h3 class="tszf-section-title"><?php echo esc_html__('Most popular', 'gowatch'); ?></h3>
                                    <div class="row">
                                        <?php
                                            if ( is_object($popular_query) ) {
                                                echo airkit_Compilator::view_articles( $view_options, $popular_query );
                                            }
                                        ?>
                                    </div>
                                    <h3 class="tszf-section-title"><?php echo esc_html__('Latest posts', 'gowatch'); ?></h3>
                                    <div class="row">
                                        <?php
                                            if ( is_object($dashboard_query) ) {
                                                echo airkit_Compilator::view_articles( $view_options, $dashboard_query );
                                            }
                                        ?>
                                    </div>
                                    <h3 class="tszf-section-title"><?php echo esc_html__('Favorites', 'gowatch'); ?></h3>
                                    <div class="row">
                                        <?php
                                            if ( is_object($favorites_query) ) {
                                                echo airkit_Compilator::view_articles( $view_options, $favorites_query );
                                            }
                                        ?>
                                    </div>
                                    <h3 class="tszf-section-title"><?php echo esc_html__('Created playlists', 'gowatch'); ?></h3>
                                    <div class="row">
                                        <?php
                                            if ( is_object($playlists_query) ) {
                                                echo airkit_Compilator::playlists( $playlist_view_options, $playlists_query );
                                            }
                                        ?>
                                    </div>

                                <?php elseif ( 'posts' == $key ): ?>

                                    <?php $frontend_dashboard->sortby(); ?>

                                    <div class="row">
                                        <?php
                                            if ( is_object($dashboard_query) ) {
                                                $view_options = $frontend_dashboard->views_options(array('pagination' => 'load-more'));
                                                echo airkit_Compilator::view_articles( $view_options, $dashboard_query );
                                            }
                                        ?>
                                    </div>

                                <?php elseif ( 'favorites' == $key ): ?>

                                    <?php $frontend_dashboard->sortby(); ?>
                                    
                                    <div class="row">
                                        <?php
                                            if ( is_object($favorites_query) ) {
                                                $view_options = $frontend_dashboard->views_options(array('pagination' => 'load-more'));
                                                echo airkit_Compilator::view_articles( $view_options, $favorites_query );
                                            }
                                        ?>
                                    </div>

                                <?php elseif ( 'playlists' == $key ): ?>

                                    <?php $frontend_dashboard->sortby(array('most_popular', 'top_rated')); ?>
                                    
                                    <div class="row">
                                        <?php
                                            if ( is_object($playlists_query) ) {
                                                $view_options = $frontend_dashboard->views_options(array('pagination' => 'load-more'));
                                                echo airkit_Compilator::playlists( $playlist_view_options, $playlists_query );
                                            }
                                        ?>
                                    </div>

                                <?php elseif ( 'about' == $key ): ?>

                                    <div class="cols-by-2 row">
                                        <div class="col-md-4"><span class="author-label"><?php esc_html_e('Description', 'gowatch'); ?></span></div>
                                        <div class="col-md-8"><p class="author-description" itemprop="about"><?php echo airkit_var_sanitize( $userdata->description, 'the_kses' ); ?></p></div>
                                        <div class="col-md-4"><span class="author-label"><?php esc_html_e('Stats', 'gowatch'); ?></span></div>
                                        <div class="col-md-8">
                                            <ul class="author-stats">
                                                <li>
                                                    <span><?php esc_html_e('Uploaded posts', 'gowatch') ?></span>
                                                    <strong><?php echo esc_html($dashboard_query->found_posts); ?></strong>
                                                </li>
                                                <li>
                                                    <span><?php esc_html_e('Total views', 'gowatch') ?></span>
                                                    <strong><?php echo esc_html($frontend_dashboard->get_total_posts_views()); ?></strong>
                                                </li>
                                                <li>
                                                    <span><?php esc_html_e('Favorites', 'gowatch') ?></span>
                                                    <strong><?php echo esc_html($favorites_query->found_posts); ?></strong>
                                                </li>
                                                <li>
                                                    <span><?php esc_html_e('Playlists', 'gowatch') ?></span>
                                                    <strong><?php echo esc_html($playlists_query->found_posts); ?></strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                <?php elseif ( 'settings' == $key && $is_my_profile ): ?>

                                    <?php echo airkit_var_sanitize( $edit_profile->build(), 'true' ); ?>

                                <?php endif ?>
                            </div>

                        <?php endforeach ?>
                    </div>
                </div>
                <?php echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' ); ?>
            </div>
        </div>
    </div>
</div><!-- .author -->

<?php if( $post_type_obj ) { do_action( 'tszf_dashboard_top', $userdata->ID, $post_type_obj ); } ?>


