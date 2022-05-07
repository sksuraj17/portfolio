<?php
namespace Elementor;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Wpop_Single_Post extends Widget_Base {

    public function get_name() {
        return 'wpop-single-post';
    }
    
    public function get_title() {
        return __( 'Single Post', 'wpopea' );
    }

    public function get_icon() {
        return 'wpop-icon eicon-posts-group';
    }

    public function get_categories() {
        return [ 'opstore-elements' ];
    }

    public function get_style_depends() {
        return [
          'single-post',
        ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'single_post_content',
            [
                'label' => __( 'Single Post', 'wpopea' ),
            ]
        );
            $this->add_control(
                'post_style',
                [
                    'label' => esc_html__( 'Style', 'wpopea' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1' => esc_html__( 'Style One', 'wpopea' ),
                        '2' => esc_html__( 'Style Two', 'wpopea' ),
                        '3' => esc_html__( 'Style Three', 'wpopea' ),
                        '4' => esc_html__( 'Style Four', 'wpopea' ),
                    ],
                ]
            );

            $this->add_control(
                'post_name',
                [
                    'label' => esc_html__( 'Post Name', 'wpopea' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => wpopea_get_posts(),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'single_post_additional',
            [
                'label' => __( 'Additional Option', 'wpopea' ),
            ]
        );
            
            $this->add_control(
                'show_title',
                [
                    'label' => esc_html__( 'Title', 'wpopea' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_category',
                [
                    'label' => esc_html__( 'Category', 'wpopea' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_author',
                [
                    'label' => esc_html__( 'Author', 'wpopea' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_date',
                [
                    'label' => esc_html__( 'Date', 'wpopea' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

        $this->end_controls_section();

        // Style Title tab section
        $this->start_controls_section(
            'single_post_title_style_section',
            [
                'label' => __( 'Title', 'wpopea' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_title'=>'yes',
                ]
            ]
        );
            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .content h2 a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', 'wpopea' ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wpop-single-post .content h2',
                ]
            );

            $this->add_responsive_control(
                'title_margin',
                [
                    'label' => __( 'Margin', 'wpopea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .content h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_padding',
                [
                    'label' => __( 'Padding', 'wpopea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_align',
                [
                    'label' => __( 'Alignment', 'wpopea' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'wpopea' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'wpopea' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'wpopea' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'wpopea' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .content h2' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style Category tab section
        $this->start_controls_section(
            'single_post_category_style_section',
            [
                'label' => __( 'Category', 'wpopea' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_category'=>'yes',
                ]
            ]
        );
            $this->add_control(
                'category_color',
                [
                    'label' => __( 'Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .post-category a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'category_typography',
                    'label' => __( 'Typography', 'wpopea' ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wpop-single-post .post-category a',
                ]
            );

            $this->add_responsive_control(
                'category_margin',
                [
                    'label' => __( 'Margin', 'wpopea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .post-category a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'category_padding',
                [
                    'label' => __( 'Padding', 'wpopea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wpop-single-post .post-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'category_background',
                    'label' => __( 'Background', 'wpopea' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .wpop-single-post .post-category a',
                ]
            );

        $this->end_controls_section();

        // Style Date tab section
        $this->start_controls_section(
            'single_post_date_style_section',
            [
                'label' => __( 'Date', 'wpopea' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_date'=>'yes',
                ]
            ]
        );
            $this->add_control(
                'date_color',
                [
                    'label' => __( 'Color', 'wpopea' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'date_typography',
                    'label' => __( 'Typography', 'wpopea' ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-post .post-content .content .meta',
                ]
            );

            $this->add_responsive_control(
                'date_margin',
                [
                    'label' => __( 'Margin', 'wpopea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'date_padding',
                [
                    'label' => __( 'Padding', 'wpopea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'date_align',
                [
                    'label' => __( 'Alignment', 'wpopea' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'wpopea' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'wpopea' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'wpopea' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'wpopea' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'left',
                ]
            );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'wpop_single_post_attr', 'class', 'wpop-single-post wpop-single-post-style-'.$settings['post_style'] );


        $get_post_name = $settings['post_name'];
        if( $get_post_name >= 1 ) { 
            $posts_ids = implode(', ', $get_post_name); 
        } else { $posts_ids = ''; }
        $post_names = explode(',', $posts_ids);

        $args = array(
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
        );
        if ( "0" != $get_post_name ) {
            $args['post__in'] = $post_names;
        }
        $single_post = new \WP_Query( $args );

        ?>
            <?php
                if( $single_post->have_posts() ):
                    while( $single_post->have_posts() ): $single_post->the_post();
            ?>
                <div <?php echo $this->get_render_attribute_string( 'wpop_single_post_attr' ); ?>>
                    <div class="thumb">
                        <a href="<?php the_permalink();?>"><?php the_post_thumbnail( 'full' ); ?></a>
                    </div>
                    <div class="content">
                        <?php if($settings['show_category'] == 'yes' ):
							do_action( 'shapemag_post_cat_or_tag_lists' );
                        endif; if($settings['show_title'] == 'yes' ):?>
                            <h2><a href="<?php the_permalink();?>"><?php echo wp_trim_words( get_the_title(), 5, '' ); ?></a></h2>
                        <?php endif; if( $settings['show_author'] == 'yes' || $settings['show_date'] == 'yes'):?>
                            <ul class="meta">
                                <?php if( $settings['show_author'] == 'yes' ):?>
                                    <li><i class="fa fa-user-circle"></i><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author();?></a></li>
                                <?php endif; if($settings['show_date'] == 'yes' ):?>
                                    <li><i class="fa fa-clock-o"></i><?php the_time(esc_html__('d F Y','wpopea'));?></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif;?>
                    </div>
                </div>

            <?php endwhile; wp_reset_postdata(); endif; ?>

        <?php

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Wpop_Single_Post() );