<?php
get_header();
global $post;
$settings = get_option( TSSPro()->options['settings'] );
$field    = ( ! empty( $settings['field'] ) ? array_map( 'sanitize_text_field', $settings['field'] ) : array() );

while ( have_posts() ) : the_post();
	$designation = get_post_meta( get_the_ID(), 'tss_designation', true );
	$company     = get_post_meta( get_the_ID(), 'tss_company', true );
	$location    = get_post_meta( get_the_ID(), 'tss_location', true );
	$rating    = get_post_meta( get_the_ID(), 'tss_rating', true );
	$level       = array();
	$level[]     = "<span class='author-designation'>" . esc_html( $designation ) . "</span>";
	$level[]     = "<span class='item-company'>" . esc_html( $company ) . "</span>";
	$level[]     = "<span class='author-location'>" . esc_html( $location ) . "</span>";
	?>
    <div id="content" class="rt-container rt-testimonial-detail-wrapper">
        <div class="rt-row">
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'rt-single-testimonial-detail clearfix' ); ?>>
                <div class="rt-col-md-4 rt-col-sm-12 rt-col-xs-12 ">
                    <div class="testi-meta">
                        <div class="profile-img"><?php the_post_thumbnail( 'large' ); ?></div>
                        <h2><?php the_title(); ?></h2>
						<?php
						$html = '';
						if ( is_array( $settings['field'] ) && ! empty( $settings['field'] ) && in_array( 'rating', $settings['field'] ) ) {
							$html .= '<div class="rating-wrapper">';
							for ($i = 1; $i <= 5; $i++){
								$starClass= "filled";
								if( $i > $rating ){
									$starClass= "empty";
								}
								$html .= "<span data-star='$i' class='star-$i dashicons dashicons-star-{$starClass}' aria-hidden='true'></span>";
							}
							$html .= '</div>';
						}
						echo $html;

						if ( ! empty( $level ) ) {
							$level     = array_filter( $level );
							$levelList = implode( ', ', $level );
							echo '<h4 class="author-bio">' . $levelList . '</span></h4>';
						}
						?>
                    </div>
                </div>
                <div class="rt-col-md-8 rt-col-sm-12 rt-col-xs-12">
                    <div class="testimonial">
						<?php the_content(); ?>
                    </div>
					<?php
					$social_media = get_post_meta( $post->ID, 'tss_social_media', true );

					if ( is_array( $settings['field'] ) && in_array( 'social_media', $settings['field'] ) && ! empty( $social_media ) ) : ?>
                        <div class='author-social'>
							<?php foreach ( $social_media as $id => $url ) : ?>
                                <a href='<?php echo esc_url($url); ?>'><span class='dashicons dashicons-<?php echo esc_attr($id) ?>'></span></a>
							<?php endforeach; ?>
                        </div>
					<?php endif; ?>
					<?php if ( is_array( $settings['field'] ) && ! empty( $settings['field'] ) && in_array( 'social_share', $settings['field'] ) ) {
						echo TSSPro()->rtShare( $post->ID, $settings );
					} ?>
                </div>
            </article>
        </div>
    </div>
<?php endwhile;
get_footer();
