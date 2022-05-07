jQuery(document).ready(function() {

 /* Move our focus widgets in the our focus panel */
    /* === Checkbox Multiple Control === */
    jQuery( '.customize-control-checkbox-multiple input[type="checkbox"]' ).on(
        'change',
        function() {
            checkbox_values = jQuery( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
                function() {
                    return this.value;
                }
            ).get().join( ',' );

            jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        }
    );

        // section sorting
    jQuery( "#sortable" ).sortable({ 
            placeholder: "ui-sortable-placeholder" 
    });

    jQuery( "#sortable" ).sortable({
        cursor: 'move',
        opacity: 0.65,
        stop: function ( event, ui){
        var data = jQuery(this).sortable('toArray');
            //  console.log(data); // This should print array of IDs, but returns empty string/array      
            jQuery( this ).parents( '.customize-control').find( 'input[type="hidden"]' ).val( data ).trigger( 'change' );
        }
    });
    
});