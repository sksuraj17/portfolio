/** Shortcode Jquery **/
jQuery(document).ready(function ($){
	/** Slider Js **/
	if($('.slide_wrap').length > 0){
		$('.slide_wrap').slick({
			slidesToScroll: 1,
/*			slidesToShow: 2,
			autoplay: true,*/
			infinite: true,
		});
    }

	/** Toggle Js **/
    $('.ultra_toggle_title').click(function(){
        $(this).next('.ultra_toggle_content').slideToggle();
        $(this).toggleClass('active');
    });

	/** Tabs Js **/
	$('.ultra_tab_wrap').prepend('<div class="ultra_tab_group clearfix"></div>');
	$('.ultra_tab_wrap').each(function(){
		$(this).children('.ultra_tab').find('.tab-title').prependTo($(this).find('.ultra_tab_group'));
		$(this).children('.ultra_tab').wrapAll( "<div class='ultra_tab_content' />");
	});

	$('body').each(function(){
		$(this).find('.ultra_tab:first-child').show();
		$(this).find('.tab-title:first-child').addClass('active')
	});
	$('.ultra_tab').not(":first-child").hide();

	$('.ultra_tab_group .tab-title').click(function(){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		$(this).parent('.ultra_tab_group ').next('.ultra_tab_content').find('.ultra_tab').hide();
		var ap_id = $(this).attr('id');
		$(this).parent('.ultra_tab_group ').next('.ultra_tab_content').find('.'+ap_id).show();
	});
});