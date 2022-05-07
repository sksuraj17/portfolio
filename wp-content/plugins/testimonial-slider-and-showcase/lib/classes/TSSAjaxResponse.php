<?php
if(!class_exists('TSSAjaxResponse')):
    class TSSAjaxResponse
    {

        function __construct()
        {
            add_action( 'wp_ajax_shortCodeList', array($this, 'shortCodeList'));
        }

        function shortCodeList(){
            $html = null;
            $scQ = new WP_Query( array('post_type' => TSSPro()->shortCodePT, 'order_by' => 'title', 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => -1) );
            if ( $scQ->have_posts() ) {

                $html .= "<div class='mce-pfp-container mce-form'>";
                $html .= "<div class='mce-pfp-container-body'>";
                $html .= '<label class="mce-widget mce-label" style="padding: 20px;font-weight: bold;" for="scid">Select Short code</label>';
                $html .= "<select name='id' id='scid' style='width: 150px;margin: 15px;'>";
                $html .= "<option value=''>Default</option>";
                while ( $scQ->have_posts() ) {
                    $scQ->the_post();
                    $html .="<option value='".get_the_ID()."'>".get_the_title()."</option>";
                }
                $html .= "</select>";
                $html .= "</div>";
                $html .= "</div>";
            }else{
                $html .= "<div>".__("No shortcode found.", 'tlp-portfolio')."</div>";
            }
            echo $html;
            die();
        }
    }


endif;
