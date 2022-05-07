<?php $taxonomy_objects = TSSPro()->getAllTaxonomyObject(); ?>

<div class="wrap">
	<h2><?php _e( 'Taxonomy Ordering', 'testimonial-slider-showcase' ) ?></h2>
	<div class="rt-admin-wrap">
		<?php if ( ! function_exists( 'get_term_meta' ) ) { ?>
			<div class="update-message notice inline notice-error notice-alt"><p><?php _e( "Please update your wordpress to 4.4.0 or
				latest version to use taxonomy order functionality.", 'testimonial-slider-showcase' ); ?></p></div>
		<?php } ?>
		<div class="taxonomy-wrapper">
			<label><?php _e( "Select taxonomy", 'testimonial-slider-showcase' ) ?> </label>
			<select class="rt-select2" id="tss-taxonomy">
				<option value=""><?php _e( "Select one taxonomy", 'testimonial-slider-showcase' ) ?></option>
				<?php 
				if ( ! empty( $taxonomy_objects ) ) {
					foreach ( $taxonomy_objects as $taxonomy ) {
						echo "<option value='{$taxonomy->name}'>{$taxonomy->label}</option>";
					}
				}
				?>
			</select>
		</div>
		<div class="ordering-wrapper">
			<div id="term-wrapper">
				<p><?php _e( "No taxonomy selected", 'testimonial-slider-showcase' ) ?></p>
			</div>
		</div>
	</div>
</div>
