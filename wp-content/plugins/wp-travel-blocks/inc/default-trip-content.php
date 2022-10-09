<?php
add_filter( 'default_content', 'wptravel_blocks_itineraries_default_content', 10, 2 );

function wptravel_blocks_itineraries_default_content( $content, $post ) {
	$default_trip_content = '<!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:group {"align":"full"} -->
	<div class="wp-block-group alignfull"><!-- wp:cover {"url":"https://apath2nowhere.files.wordpress.com/2021/12/alejandro-cartagena-b64b6-kawlw-unsplash.jpg","dimRatio":30,"focalPoint":{"x":"0.52","y":"0.76"},"minHeight":545,"minHeightUnit":"px","contentPosition":"center center","align":"full"} -->
	<div class="wp-block-cover alignfull has-background-dim-30 has-background-dim" style="min-height:545px"><img class="wp-block-cover__image-background" alt="" src="https://apath2nowhere.files.wordpress.com/2021/12/alejandro-cartagena-b64b6-kawlw-unsplash.jpg" style="object-position:52% 76%" data-object-fit="cover" data-object-position="52% 76%"/><div class="wp-block-cover__inner-container"><!-- wp:spacer {"height":30} -->
	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:wptravel/breadcrumb {"contentJustification":"center"} /-->

	<!-- wp:spacer {"height":30} -->
	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:group -->
	<div class="wp-block-group"><!-- wp:columns -->
	<div class="wp-block-columns"><!-- wp:column {"width":"25%"} -->
	<div class="wp-block-column" style="flex-basis:25%"></div>
	<!-- /wp:column -->

	<!-- wp:column {"width":"50%"} -->
	<div class="wp-block-column" style="flex-basis:50%"><!-- wp:post-title {"textAlign":"center"} /-->

	<!-- wp:wptravel/trip-price {"textAlign":"center"} /--></div>
	<!-- /wp:column -->

	<!-- wp:column {"width":"25%"} -->
	<div class="wp-block-column" style="flex-basis:25%"></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns --></div>
	<!-- /wp:group --></div></div>
	<!-- /wp:cover --></div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":30} -->
	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:group -->
	<div class="wp-block-group"><!-- wp:media-text {"align":"","mediaId":1515,"mediaLink":"https://apath2nowhere.files.wordpress.com/2021/12/denys-nevozhai-gunijiuucgy-unsplash.jpg","mediaType":"image","mediaSizeSlug":"full","imageFill":false,"style":{"color":{"background":"#f8f8f8"}}} -->
	<div class="wp-block-media-text is-stacked-on-mobile has-background" style="background-color:#f8f8f8"><figure class="wp-block-media-text__media"><img src="https://apath2nowhere.files.wordpress.com/2021/12/denys-nevozhai-gunijiuucgy-unsplash.jpg" alt="" class="wp-image-1515 size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:spacer {"height":50} -->
	<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:wptravel/trip-rating {"textAlign":"right"} /-->

	<!-- wp:spacer {"height":10} -->
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:wptravel/trip-code {"textAlign":"right"} /-->

	<!-- wp:post-excerpt /-->

	<!-- wp:buttons {"contentJustification":"right"} -->
	<div class="wp-block-buttons is-content-justification-right"><!-- wp:button {"className":"wp-travel-booknow-btn"} -->
	<div class="wp-block-button wp-travel-booknow-btn"><a class="wp-block-button__link" href="#booking"><strong>Book Now</strong></a></div>
	<!-- /wp:button --></div>
	<!-- /wp:buttons -->

	<!-- wp:spacer {"height":50} -->
	<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer --></div></div>
	<!-- /wp:media-text --></div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":20} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:group {"style":{"color":{"gradient":"linear-gradient(135deg,rgb(63,173,188) 0%,rgb(21,148,162) 48%,rgb(63,173,188) 83%,rgb(63,173,188) 99%)"}},"textColor":"white"} -->
	<div class="wp-block-group has-white-color has-text-color has-background" style="background:linear-gradient(135deg,rgb(63,173,188) 0%,rgb(21,148,162) 48%,rgb(63,173,188) 83%,rgb(63,173,188) 99%)"><!-- wp:wptravel/trip-facts /--></div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":20} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:wptravel/tabs {"align":"center"} /-->

	<!-- wp:spacer {"height":20} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:wptravel/map /-->

	<!-- wp:spacer {"height":20} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:group {"style":{"color":{"background":"#eef0f2","text":"#1c1c1c"}}} -->
	<div class="wp-block-group has-text-color has-background" style="background-color:#eef0f2;color:#1c1c1c"><!-- wp:spacer {"height":50} -->
	<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:columns -->
	<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
	<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph -->
	<p><strong>Trip Types</strong>:</p>
	<!-- /wp:paragraph -->

	<!-- wp:wptravel/trip-categories /--></div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center"} -->
	<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"textAlign":"center","level":4} -->
	<h4 class="has-text-align-center"><strong>Keywords</strong>:</h4>
	<!-- /wp:heading -->

	<!-- wp:wptravel/trip-categories {"textAlign":"center","tripTaxonomy":"travel_keywords"} /--></div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column"><!-- wp:heading {"textAlign":"right","level":4} -->
	<h4 class="has-text-align-right"><strong>Activities</strong></h4>
	<!-- /wp:heading -->

	<!-- wp:wptravel/trip-categories {"textAlign":"right","tripTaxonomy":"activity"} /--></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns --></div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":20} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:group -->
	<div class="wp-block-group"><!-- wp:heading {"align":"full"} -->
	<h2 class="alignfull"><strong>Related Trips</strong></h2>
	<!-- /wp:heading -->

	<!-- wp:wptravel/trips-list /--></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group -->';

	$settings               = wptravel_get_settings();
	$enable_gutenberg       = $settings['enable_gutenberg'];
	$enable_custom_template = $settings['enable_custom_template'];
	if ( 'itineraries' === $post->post_type && 'yes' === $enable_gutenberg && 'yes' === $enable_custom_template ) {
		$content = $default_trip_content;

		$selected_template = isset( $settings['selected_template'] ) ? $settings['selected_template'] : '';
		$template_content = '';
		if ( $selected_template ) {
			$template_content = get_post_field( 'post_content', $selected_template );
			if ( $template_content ) {
				$content = $template_content;
			}
		}
	}

	return $content;
}

