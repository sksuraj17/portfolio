<?php
namespace Elementor;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Tiled Posts Widget
 */
class Wpopea_Tiled_Posts extends Widget_Base {
    
    /**
	 * Retrieve tiled posts widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'wpopea-tiled-posts';
    }

    /**
	 * Retrieve tiled posts widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Tiled Posts', 'wpopea' );
    }

    /**
	 * Retrieve the list of categories the tiled posts widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'opstore-elements' ];
    }

    /**
	 * Retrieve tiled posts widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_style_depends() {
        return [
          'tiled-post',
        ];
    }

    /**
	 * Register tiled posts widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Settings
         */
        $this->start_controls_section(
            'section_post_settings',
            [
                'label'             => __( 'Settings', 'wpopea' ),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'             => __( 'Layout', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'layout-1'       => __( 'Layout 1', 'wpopea' ),
                   'layout-2'       => __( 'Layout 2', 'wpopea' ),
                   'layout-3'       => __( 'Layout 3', 'wpopea' ),
                   'layout-4'       => __( 'Layout 4', 'wpopea' ),
                   'layout-5'       => __( 'Layout 5', 'wpopea' ),
                ],
                'default'           => 'layout-1',
            ]
        );

		$this->add_control(
			'content_vertical_position',
			[
				'label'             => __( 'Content Position', 'wpopea' ),
				'type'              => Controls_Manager::CHOOSE,
				'label_block'       => false,
				'options'           => [
					'top'       => [
						'title' => __( 'Top', 'wpopea' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle'    => [
						'title' => __( 'Middle', 'wpopea' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'    => [
						'title' => __( 'Bottom', 'wpopea' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'           => 'bottom',
			]
		);
        
        $this->add_control(
            'post_title',
            [
                'label'             => __( 'Post Title', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'post_excerpt',
            [
                'label'             => __( 'Post Excerpt', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'no',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'excerpt_length',
            [
                'label'             => __( 'Excerpt Length', 'wpopea' ),
                'type'              => Controls_Manager::NUMBER,
                'default'           => 20,
                'min'               => 0,
                'max'               => 58,
                'step'              => 1,
                'condition'         => [
                    'post_excerpt'  => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'read_more',
            [
                'label'             => __( 'Read More', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'no',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'content_vertical_position'  => 'top'
                ]
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'             => __( 'Read More Text', 'wpopea' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => __( 'Read More', 'wpopea' ),
                'condition'         => [
                    'read_more'     => 'yes'
                ]
            ]
        );
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'              => 'image_size',
				'label'             => __( 'Image Size', 'wpopea' ),
				'default'           => 'medium_large',
			]
		);

        $this->end_controls_section();

        /**
         * Content Tab: Query
         */
        $this->start_controls_section(
            'section_post_query',
            [
                'label'             => __( 'Query', 'wpopea' ),
            ]
        );

		$this->add_control(
            'post_type',
            [
                'label'             => __( 'Post Type', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => wpopea_get_post_types(),
                'default'           => 'post',

            ]
        );

        $this->add_control(
            'categories',
            [
                'label'             => __( 'Categories', 'wpopea' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => get_post_type_categories('category'),
                'condition'         => [
                    'post_type' => 'post'
                ]
            ]
        );

        $this->add_control(
            'authors',
            [
                'label'             => __( 'Authors', 'wpopea' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => wpopea_get_auhtors(),
            ]
        );

        $this->add_control(
            'tags',
            [
                'label'             => __( 'Tags', 'wpopea' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => wpopea_get_tags(),
            ]
        );

        $this->add_control(
            'exclude_posts',
            [
                'label'             => __( 'Exclude Posts', 'wpopea' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => wpopea_get_posts(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label'             => __( 'Order', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'DESC'           => __( 'Descending', 'wpopea' ),
                   'ASC'       => __( 'Ascending', 'wpopea' ),
                ],
                'default'           => 'DESC',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'             => __( 'Order By', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => get_post_orderby_options(),
                'default'           => 'date',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'             => __( 'Offset', 'wpopea' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => '',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Post Meta
         */
        $this->start_controls_section(
            'section_post_meta',
            [
                'label'             => __( 'Post Meta', 'wpopea' ),
            ]
        );
        
        $this->add_control(
            'post_meta',
            [
                'label'             => __( 'Post Meta', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
            ]
        );

        $this->add_control(
            'post_meta_divider',
            [
                'label'             => __( 'Post Meta Divider', 'wpopea' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => '-',
				'selectors'         => [
					'{{WRAPPER}} .wpopea-tiled-posts-meta > span:not(:last-child):after' => 'content: "{{UNIT}}";',
				],
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'post_author',
            [
                'label'             => __( 'Post Author', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'post_category',
            [
                'label'             => __( 'Post Category', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'post_date',
            [
                'label'             => __( 'Post Date', 'wpopea' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'wpopea' ),
                'label_off'         => __( 'No', 'wpopea' ),
                'return_value'      => 'yes',
                'condition'         => [
                    'post_meta'     => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
        
        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'section_post_content_style',
            [
                'label'             => __( 'Content', 'wpopea' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
			
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'post_content_bg',
                'label'             => __( 'Post Content Background', 'wpopea' ),
                'types'             => [ 'classic', 'gradient' ],
                'selector'          => '{{WRAPPER}} .wpopea-tiled-post-content',
            ]
        );

		$this->add_control(
			'post_content_padding',
			[
				'label'             => __( 'Padding', 'wpopea' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', 'em', '%' ],
				'selectors'         => [
					'{{WRAPPER}} .wpopea-tiled-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Title
         */
        $this->start_controls_section(
            'section_title_style',
            [
                'label'             => __( 'Title', 'wpopea' ),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'post_title'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'             => __( 'Text Color', 'wpopea' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .wpopea-tiled-post-title' => 'color: {{VALUE}}',
                ],
                'condition'         => [
                    'post_title'  => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'title_typography',
                'label'             => __( 'Typography', 'wpopea' ),
                'scheme'            => Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .wpopea-tiled-post-title',
                'condition'         => [
                    'post_title'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'             => __( 'Margin Bottom', 'wpopea' ),
                'type'              => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .wpopea-tiled-post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'post_title'  => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Post Category
         */
        $this->start_controls_section(
            'section_cat_style',
            [
                'label'             => __( 'Post Category', 'wpopea' ),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'post_category'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'category_style',
            [
                'label'             => __( 'Category Style', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'style-1'       => __( 'Style 1', 'wpopea' ),
                   'style-2'       => __( 'Style 2', 'wpopea' ),
                ],
                'default'           => 'style-1',
                'condition'         => [
                    'post_category'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'cat_bg_color',
            [
                'label'             => __( 'Background Color', 'wpopea' ),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .wpopea-post-categories-style-2 span' => 'background: {{VALUE}}',
                ],
                'condition'         => [
                    'post_category'     => 'yes',
                    'category_style'    => 'style-2'
                ]
            ]
        );

        $this->add_control(
            'cat_text_color',
            [
                'label'             => __( 'Text Color', 'wpopea' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .wpopea-post-categories' => 'color: {{VALUE}}',
                ],
                'condition'         => [
                    'post_category'  => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'cat_typography',
                'label'             => __( 'Typography', 'wpopea' ),
                'scheme'            => Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .wpopea-post-categories',
                'condition'         => [
                    'post_category'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'cat_margin_bottom',
            [
                'label'             => __( 'Margin Bottom', 'wpopea' ),
                'type'              => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .wpopea-post-categories' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'post_category'  => 'yes'
                ]
            ]
        );

		$this->add_control(
			'cat_padding',
			[
				'label'             => __( 'Padding', 'wpopea' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', 'em', '%' ],
				'selectors'         => [
					'{{WRAPPER}} .wpopea-post-categories-style-2 span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'         => [
                    'post_category'     => 'yes',
                    'category_style'    => 'style-2'
                ]
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Post Meta
         */
        $this->start_controls_section(
            'section_meta_style',
            [
                'label'             => __( 'Post Meta', 'wpopea' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta_text_color',
            [
                'label'             => __( 'Text Color', 'wpopea' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .wpopea-tiled-posts-meta' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'meta_typography',
                'label'             => __( 'Typography', 'wpopea' ),
                'scheme'            => Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .wpopea-tiled-posts-meta',
            ]
        );

        $this->end_controls_section();

    }

    /**
	 * Render tiled posts widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings();
        
        $this->add_render_attribute( 'tiled-posts', 'class', 'wpopea-tiled-posts clearfix' );
        
        if ( $settings['layout'] ) {
            $this->add_render_attribute( 'tiled-posts', 'class', 'wpopea-tiled-posts-' . $settings['layout'] );
        }
        
        $this->add_render_attribute( 'post-content', 'class', 'wpopea-tiled-post-content' );
        
        if ( $settings['content_vertical_position'] ) {
            $this->add_render_attribute( 'post-content', 'class', 'wpopea-tiled-post-content-' . $settings['content_vertical_position'] );
        }
        
        $this->add_render_attribute( 'post-categories', 'class', 'wpopea-post-categories' );
        
        if ( $settings['category_style'] ) {
            $this->add_render_attribute( 'post-categories', 'class', 'wpopea-post-categories-' . $settings['category_style'] );
        }
        ?>
        <div <?php echo $this->get_render_attribute_string( 'tiled-posts' ); ?>>
            <?php
                $wpopea_post_position = 1;
        
                $wpopea_layout = $settings['layout'];
        
                if ( $wpopea_layout == 'layout-1' ) {
                    $wpopea_posts_count = '4';
                }
                elseif ( $wpopea_layout == 'layout-2' || $wpopea_layout == 'layout-3' ) {
                    $wpopea_posts_count = '3';
                }
                elseif ( $wpopea_layout == 'layout-4' || $wpopea_layout == 'layout-5' ) {
                    $wpopea_posts_count = '5';
                }
                else {
                    $wpopea_posts_count = '3';
                }

                // Post Authors
                $wpopea_tiled_post_author = '';
                $wpopea_tiled_post_authors = $settings['authors'];
                if ( !empty( $wpopea_tiled_post_authors) ) {
                    $wpopea_tiled_post_author = implode( ",", $wpopea_tiled_post_authors );
                }

                // Post Categories
                $wpopea_tiled_post_cat = '';
                $wpopea_tiled_post_cats = $settings['categories'];
                if ( !empty( $wpopea_tiled_post_cats) ) {
                    $wpopea_tiled_post_cat = implode( ",", $wpopea_tiled_post_cats );
                }
        
                // Query Arguments
                $args = array(
                    'post_status'           => array( 'publish' ),
                    'post_type'             => $settings['post_type'],
                    'post__in'              => '',
                    'cat'                   => $wpopea_tiled_post_cat,
                    'author'                => $wpopea_tiled_post_author,
                    'tag__in'               => $settings['tags'],
                    'orderby'               => $settings['orderby'],
                    'order'                 => $settings['order'],
                    'post__not_in'          => $settings['exclude_posts'],
                    'offset'                => $settings['offset'],
                    'ignore_sticky_posts'   => 1,
                    'showposts'             => $wpopea_posts_count
                );
                $featured_posts = new \WP_Query( $args );


                if ( $featured_posts->have_posts() ) : while ($featured_posts->have_posts()) : $featured_posts->the_post();
                    if ( $wpopea_layout == 'layout-1' || $wpopea_layout == 'layout-2' || $wpopea_layout == 'layout-3' || $wpopea_layout == 'layout-4' ) {
                        if ( $wpopea_post_position == 2 ) { ?><div class="wpopea-tiles-posts-right"><?php }
                    }

                    if ( has_post_thumbnail() ) {
                        $image_id = get_post_thumbnail_id( get_the_ID() );
                        $wpopea_thumb_url = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
                    } else {
                        $wpopea_thumb_url = '';
                    }
                    ?>
                    <div class="wpopea-tiled-post wpopea-tiled-post-<?php echo intval( $wpopea_post_position ); ?>">
                            <div class="wpopea-tiled-post-bg" <?php if ( $wpopea_thumb_url ) { echo "style='background-image:url(".esc_url( $wpopea_thumb_url ).")'"; } ?>>
                                
                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                        </a>
                            </div>
                        <div <?php echo $this->get_render_attribute_string( 'post-content' ); ?>>
                            <?php if ( $settings['post_meta'] == 'yes' ) { ?>
                                <?php if ( $settings['post_category'] == 'yes' ) { ?>
                                    <div <?php echo $this->get_render_attribute_string( 'post-categories' ); ?>>
                                        <span>
                                            <?php
                                                $category = get_the_category();
                                                if ( $category ) {
                                                    echo esc_attr( $category[0]->name );
                                                }
                                            ?>
                                        </span>
                                    </div><!--.wpopea-post-categories-->
                                <?php } ?>
                            <?php } ?>
                            <?php if ( $settings['post_title'] == 'yes' ) { ?>
                                <h2 class="wpopea-tiled-post-title">
                                    <?php the_title(); ?>
                                </h2>
                            <?php } ?>
                            <?php if ( $settings['post_meta'] == 'yes' ) { ?>
                                <div class="wpopea-tiled-posts-meta">
                                    <?php if ( $settings['post_author'] == 'yes' ) { ?>
                                        <span class="wpopea-post-author">
                                            <div class="author-img">
                                                <?php echo get_avatar( get_the_author_meta('ID'), 50 ); ?>
                                            </div>
                                            <div class="author-name"><?php echo get_the_author(); ?></div>
                                        </span>
                                    <?php } ?>
                                    <?php if ( $settings['post_date'] == 'yes' ) { ?>
                                            <?php
                                                $wpopea_time_string = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
                                                    esc_attr( get_the_date( 'c' ) ),
                                                    get_the_date()
                                                );

                                                printf( '<span class="wpopea-post-date"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                                                    __( 'Posted on', 'wpopea' ),
                                                    $wpopea_time_string
                                                );
                                            ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div><!--.post-inner-->
                        <?php if ( $wpopea_layout == 'style-2') { ?>
                            <span class="read-story heading">
                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php _e( 'Read Story', 'wpopea' ); ?>
                            </span>
                        <?php } ?>
                    </div>
                    <?php
                    if ( $wpopea_layout == 'layout-1' ) {
                        if ( $wpopea_post_position == 4 ) { ?></div><?php }
                    }
                    elseif ( $wpopea_layout == 'layout-2' || $wpopea_layout == 'layout-3' ) {
                        if ( $wpopea_post_position == 3 ) { ?></div><?php }
                    }
                    if ( $wpopea_layout == 'layout-4' ) {
                        if ( $wpopea_post_position == 5 ) { ?></div><?php }
                    }
                $wpopea_post_position++; endwhile; endif; wp_reset_query();
        ?>
        </div><!--.slider-->
        <?php
    }

    /**
	 * Render tiled posts widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Wpopea_Tiled_Posts() );