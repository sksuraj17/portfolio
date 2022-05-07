<?php
/**
 * Primary sidebar
 *
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
?>
<aside class="sidebar">
  <div class="widget">
    <?php
    if ( is_active_sidebar( 'primary-sidebar' ) ){
    dynamic_sidebar( 'primary-sidebar' );
  }
    ?>
  </div>
  <div class="widget">
    <?php
    if ( is_active_sidebar( 'secondary-sidebar' ) ){
    dynamic_sidebar( 'secondary-sidebar' );
  }
    ?>
  </div>  
</aside>