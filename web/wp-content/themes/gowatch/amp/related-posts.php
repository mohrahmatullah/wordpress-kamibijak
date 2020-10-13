<?php
if ( ! is_single() ) {
    return;
}
 
global $post;

$options        = get_option( 'gowatch_options' );
$single_options = $options['single'];

if ( isset($single_options['related']) && 'y' !== $single_options['related'] ) {
    return;
}

$count          = $single_options['number_of_related_posts'];
$criteria       = $single_options['related_posts_selection_criteria'];

// Define arguments
$args = array(
    'post_type' => $post->post_type,
    'posts_per_page' => $count,
    'orderby' => 'rand',
    'post__not_in' => array ($post->ID),
);


// Check criteria
if ( $criteria === 'by_tags' ) {

    $tax = 'tag';
    $tag_id = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );

    if ( empty( $tag_id ) ) return;

    $args['tag__in'] = $tag_id;

} else if ( $criteria === 'by_categs' ) {

    $tax = 'category';
    $term_list = wp_get_post_terms( $post->ID, airkit_Compilator::get_tax( $post->post_type ), array( 'fields' => 'ids' ) );

    if ( is_wp_error( $term_list ) || empty( $term_list ) ){
        return;
    }

    $args['tax_query'] = array(
        'relation' => 'AND',
        array(
            'taxonomy' => airkit_Compilator::get_tax( $post->post_type ),
            'field'    => 'id',
            'terms'    => $term_list,
            'operator' => 'IN'
        )
    );
}
  
$related = get_posts( $args );

if ( $related ) {
?>
    <div class="amp-wp-meta amp-wp-tax-<?php echo esc_attr($tax); ?>">
        <h3><?php echo esc_html__('You May Also Like', 'gowatch'); ?></h3>
        <ul>
        <?php foreach( $related as $post) {
            setup_postdata( $post );
            ?>
            <li><a href="<?php echo esc_url( amp_get_permalink( get_the_id() ) ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
        <?php } ?>
        </ul>
    </div>
<?php

}

wp_reset_postdata();
?>