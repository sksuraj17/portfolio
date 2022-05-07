<?php
$level = array();
if(in_array( 'designation', $items ) && $designation) {
	$level[] = "<span class='author-designation'>".esc_html($designation)."</span>";
}
if(in_array( 'company', $items ) && $company) {
	$level[] = "<span class='item-company'>".esc_html($company)."</span>";
}
if(in_array( 'location', $items ) && $location) {
	$level[] = "<span class='author-location'>".esc_html($location)."</span>";
}
$html = null;
$html .= "<div class='{$grid} {$class}'>";
    $html .= '<div class="single-item-wrapper">';

			$html .= '<div class="tss-meta-info">';
			if(in_array( 'author_img', $items )) {
				$lazyLoader = $lazyLoad ? '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>' : '';
				$html .= $link && function_exists('rttsp') ? "<div class='profile-img-wrapper'><a href='{$pLink}'>{$img}{$lazyLoader}</a></div>" : "<div class='profile-img-wrapper'>{$img}{$lazyLoader}</div>";
			}
			$html .='</div>';
			if(in_array( 'rating', $items ) ) {
				$html .= '<div class="rating-wrapper">';
				for ($i = 1; $i <= 5; $i++){
					$starClass= "filled";
					if($i > $rating){
						$starClass= "empty";
					}
					$html .= "<span data-star='$i' class='star-$i dashicons dashicons-star-{$starClass}' aria-hidden='true'></span>";
				}
				$html .= '</div>';
			}
			if(in_array( 'author', $items ) && $author) {
				$html .= $link && function_exists('rttsp') ? "<h3 class='author-name'><a href='{$pLink}'>".esc_html($author)."</a></h3>" : "<h3 class='author-name'>".esc_html($author)."</h3>";
			}
			if(!empty($level)){
				$level = array_filter($level);
				$levelList = implode(', ', $level);
				$html .= '<h4 class="author-bio">'.$levelList.'</h4>';
			}
			if(in_array( 'social_media', $items ) && !empty($social_media) && function_exists('rttsp') ) {
				$html .= "<div class='author-social'>";
				foreach ($social_media as $id => $url){
					$html .= "<a href='{$url}' target='_blank'><span class='dashicons dashicons-{$id}'></span></a>";
				}
				$html .="</div>";
			}
            if(in_array('social_share', $items) && function_exists('rttsp') ){
                $html .= TSSPro()->rtShare($iID, $scMeta, $shareItems);;
            }

			$html .= '<div class="item-content-wrapper">';
				if(in_array( 'testimonial', $items ) && $testimonial) {
					$html .= "<div class='item-content'>{$testimonial}</div>";
				}
    		$html .= '</div>';
    $html .= '</div>';
$html .= '</div>';
echo $html;
