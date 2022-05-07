<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */ 
?>
<div class="clearfix"></div>
<section id="contact-info" data-center="background-position: 50% 0px;" data-top-bottom="background-position: 50% -100px;" class="plrx_enable"> 
      <div class="container">
      <div class="page-contact">
      <div class="contact-block">
        <ul class="contact-grid">
            <li class="contact-list">
            <?php if(get_theme_mod( 'portfoliolite_eml_txt_')!==''){?>
            <div class="contact-icon"><a href="<?php echo esc_url('mailto:' .sanitize_email(get_theme_mod( 'portfoliolite_eml_txt_'))); ?>"><i class="<?php echo esc_attr(get_theme_mod( 'portfoliolite_eml_icon_')); ?>"></i></a></div>
            <div class="contact-title"><a href="<?php echo esc_url('mailto:' .sanitize_email(get_theme_mod( 'portfoliolite_eml_txt_'))); ?>"><?php echo esc_html(get_theme_mod( 'portfoliolite_eml_txt_')); ?></a></div>
            <?php } ?>
            </li>
            <li class="contact-list">
            <?php if(get_theme_mod( 'portfoliolite_add_txt_')!==''){ ?>
            <div class="contact-icon"><a href="#"><i class="<?php echo esc_attr(get_theme_mod( 'portfoliolite_add_icon_')); ?>"></i></a></div>
            <div class="contact-title"><a href="#"><?php echo esc_html(get_theme_mod( 'portfoliolite_add_txt_')); ?></a></div>
            <?php }?>  
            </li>
            
            <li class="contact-list">

           <?php if(get_theme_mod( 'portfoliolite_mob_txt_')!==''){ ?>
            <div class="contact-icon"><a href="<?php echo esc_url('tel:'.get_theme_mod( 'portfoliolite_mob_txt_')); ?>"><i class="<?php echo esc_attr(get_theme_mod( 'portfoliolite_mob_icon_')); ?>"></i></a></div>
            <div class="contact-title"><a href="<?php echo esc_url('tel:'.get_theme_mod( 'portfoliolite_mob_txt_')); ?>"><?php echo esc_html(get_theme_mod( 'portfoliolite_mob_txt_'));  ?></a></div>
            <?php } ?>
            
          </li>
        </ul>

      </div>
    </div>  
   </div>
</section>
<div class="clearfix"></div>
<div class="company-detail">
  <div class="container">
<div class="arrow-up" id="back-to-top" ><a href=""></a></div>
<?php if(get_theme_mod( 'portfoliolite_thm_txt_')!=''){?>
 <div class="company-social"><a href="<?php echo esc_url(get_theme_mod( 'portfoliolite_thm_txt_link')); ?>"><?php echo esc_html(get_theme_mod( 'portfoliolite_thm_txt_')); ?></a>
<?php } else { ?>
 <div class="company-social"><a href="#"><?php esc_html_e('Portfolioline','portfoliolite'); ?></a>
 <?php } ?>   
    </div>
<div class="nav-footer">
<?php if(has_nav_menu('footer')){
  portfoliolite_secnd_menu();
} ?> 
</div>
</div>
</div>
<div class="clearfix"></div>
<?php get_sidebar('footer'); ?>
</div>
<div class="footer-copyright">
<div class="copyright-section">
  <?php if( get_theme_mod('copyright_textbox')!=''){?>						
<p><?php echo esc_html(get_theme_mod( 'copyright_textbox'));?></p>
<?php } else { ?>
  <p class="footer-copyright">&copy;
              <?php
              echo date_i18n(
                /* translators: Copyright date format, see https://www.php.net/date */
                _x( 'Y', 'copyright date format', 'portfoliolite' )
              );
              ?>
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
            <span class="powered-by-wordpress">
              <span><?php _e( 'Powered by', 'portfoliolite' ); ?></span>
              <a href="<?php echo esc_url( __( 'https://themehunk.com/', 'portfoliolite' ) ); ?>">
                <?php _e( 'Themehunk WordPress Theme', 'portfoliolite' ); ?>
              </a>
            </span>
  </p><!-- .footer-copyright -->
</div>
<?php } ?>
	</div>
<?php wp_footer(); ?>
</body>
</html>