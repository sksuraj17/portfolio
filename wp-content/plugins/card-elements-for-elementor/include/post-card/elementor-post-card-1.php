<!-- Start Post Card 1 -->  
<article class="grid-item column post-card-container">  
    <!-- Post-->
    <div class="post-module">
        <!-- Thumbnail-->
        <div class="thumbnail post-card-item_img"> 
            <?php
			if ($settings['show_meta_data'] == "yes") {
            if (in_array('date', $settings['meta_data'])) {
                ?>
                <div class="date post-card_date">
                    <div class="day post-card_date_color"><?php echo get_the_date('d M, Y'); ?></div> 
                </div>
            <?php }}
            ?> 
            <?php if (has_post_thumbnail()) { ?>
                <div class="post-card-image post-card_thumbnail">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($settings['post_image_size_size']); ?></a>
                </div>                 
            <?php } else {
                ?> 
                <?php if (isset($settings['show_title']) && $settings['show_title'] == 'yes') { ?>
                    <h3 class="thumb_title"> <?php the_title(); ?> </h3>
                <?php } ?>
                <?php
            }
            ?>  
        </div>
        <!-- Post Content-->
        <div class="post-content post-card-content-box">
            <div class="category post-card_category post-card_category_background">
                <?php echo post_card_posted_categories(); ?>
            </div>
            <?php
            if (isset($settings['show_title']) && $settings['show_title'] == 'yes') {
                $tag = $settings['title_tag'];
                ?>
                <<?php echo $tag; ?> class="title post-card_title post-card-alignment">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </<?php echo $tag; ?>> 
            <?php } ?>
            <?php
            if (isset($settings['show_excerpt']) && $settings['show_excerpt'] == 'yes') {
                if ($settings['excerpt_from'] == 'content') {
                    $content = get_the_content();
                } else if ($settings['excerpt_from'] == 'excerpt') {
                    $content = get_the_excerpt();
                } else {
                    $content = get_the_content();
                }
                if ($settings['show_read_more'] == "yes") {
                    $read_more = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="entry-read-more post-card_read-more">' . ' &nbsp;' . $settings['read_more_text'] . '</a>';
                } else {
                    $read_more = "";
                }
                ?> 
                <p class="description post-card_excerpt post-card-alignment">
                    <?php echo wp_trim_words($content, $settings['excerpt_length'], $read_more);
                    ?>
                </p>
            <?php } ?>          
            <div class="post-meta post-card_meta-data post-card-alignment">
                <?php
				if ($settings['show_meta_data'] == "yes") {
                if (in_array('author', $settings['meta_data'])) {
                    post_card_posted_by();
                }
                if (in_array('comments', $settings['meta_data'])) {
                    post_card_comment_count();
                }
                if (in_array('tags', $settings['meta_data'])) {
                    post_card_posted_tag();
                }
				}
                ?> 
            </div>
        </div>
    </div> 
</article>  
<!-- End Post Card -->