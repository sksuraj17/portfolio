
<!--- tab first -->
<div class="theme_link">
    <h3><?php _e('1. Install Recommended Plugins','portfoliolite'); ?></h3>
    <p><?php _e('We highly Recommend to install Hunk Companion plugin to get all customization options in Portfoliolite theme. Also install recommended plugins available in recommended tab.','portfoliolite'); ?></p>

</div>
<div class="theme_link">
    <h3><?php _e('2. Setup Home Page','portfoliolite'); ?><!-- <php echo $theme_config['plugin_title']; ?> --></h3>
        <p><?php _e('To set up the HomePage in Portfoliolite theme, Just follow the below given Instructions.','portfoliolite'); ?> </p>
<p><?php _e('Go to Wp Dashboard > Pages > Add New > Create a Page using “Home Page Template” available in Page attribute.','portfoliolite'); ?> </p>
<p><?php _e('Now go to Settings > Reading > Your homepage displays > A static page (select below) and set that page as your homepage.','portfoliolite'); ?> </p>
     <p>
        <?php
		if($this->_check_homepage_setup()){
            $class = "activated";
            $btn_text = __("Home Page Activated",'portfoliolite');
            $Bstyle = "display:none;";
            $style = "display:inline-block;";
        }else{
            $class = "default-home";
             $btn_text = __("Set Home Page",'portfoliolite');
             $Bstyle = "display:inline-block;";
            $style = "display:none;";


        }
        ?>
        <button style="<?php echo $Bstyle; ?>"; class="button activate-now <?PHP echo $class; ?>"><?php _e($btn_text,'portfoliolite'); ?></button>

        <a style="<?php echo $style; ?>";  target="_blank" href="<?php echo get_home_url(); ?>" class="button alink button-primary"><?php _e('View Home Page','portfoliolite'); ?></a>
		
         </p>
		 	 
		 
    <p>
        <a target="_blank" href="https://themehunk.com/docs/portfoliolite-theme/#homepage-setting" class="button"><?php _e('Go to Doc','portfoliolite'); ?></a>
    </p>
</div>

<!--- tab third -->





<!--- tab second -->
<div class="theme_link">
    <h3><?php _e('3. Customize Your Website','portfoliolite'); ?><!-- <php echo $theme_config['plugin_title']; ?> --></h3>
    <p><?php _e('Portfoliolite theme support live customizer for home page set up. Everything visible at home page can be changed through customize panel','portfoliolite'); ?></p>
    <p>
    <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary"><?php _e("Start Customize","portfoliolite"); ?></a>
    </p>
</div>
<!--- tab third -->

  <div class="theme_link">
    <h3><?php _e("4. Customizer Links","portfoliolite"); ?></h3>
    <div class="card-content">
        <div class="columns">
                <div class="col">
                    <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>" class="components-button is-link"><?php _e("Upload Logo","portfoliolite"); ?></a>
                    <hr><a href="<?php echo admin_url('customize.php?autofocus[panel]=portfoliolite-panel-frontpage'); ?>" class="components-button is-link"><?php _e("FrontPage Section","portfoliolite"); ?></a><hr>
                    <a href="<?php echo admin_url('customize.php?autofocus[panel]=woocommerce'); ?>" class="components-button is-link"><?php _e("Woocommerce","portfoliolite"); ?></a><hr>

                </div>

               <div class="col">

                <a href="<?php echo admin_url('customize.php?autofocus[panel]=nav_menus'); ?>" class="components-button is-link"><?php _e("Menus","portfoliolite"); ?></a><hr>

                <a href="<?php echo admin_url('customize.php?autofocus[section]=custom_css'); ?>" class="components-button is-link"><?php _e("Additional CSS","portfoliolite"); ?></a>
                <hr>


                 <a href="<?php echo admin_url('customize.php?autofocus[panel]=widgets'); ?>" class="components-button is-link"><?php _e("Widgets","portfoliolite"); ?></a><hr>
            </div>

        </div>
    </div>

</div>
<!--- tab fourth -->