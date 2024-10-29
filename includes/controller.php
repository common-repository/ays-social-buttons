<?php
/* Shortcodes */
add_action( 'plugins_loaded', 'ays_sb_add_shortcodes' );
function ays_sb_add_shortcodes() {
	add_shortcode( 'ayssocial_buttons', 'ays_sb_shortcode' );	
	add_filter ('the_content', 'insertSocialButtons');
}

function insertSocialButtons($content) {
	wp_enqueue_style('ays-sb-style', AYS_SB_URL . '/css/style.css');
	$post_page_id = get_the_ID();
	$all_ids = AYS_Social_Buttons::get_all_data($post_page_id);
	foreach($all_ids as $sb_id)
	{
		$social_button = ays_sb( $sb_id->id );
		$code = $social_button->gen_code( $sb_id->id );
		$parameters = json_decode($social_button->params());		
		if($parameters->article_position == "top") {
			$content = $code.$content;
		} else {
			$content = $content.$code;
		}

	}
   return $content;
}

function ays_sb_shortcode( $atts, $content = null, $code = '' ) {
	if ( 'ayssocial_buttons' == $code ) {
		wp_enqueue_style('ays-sb-style', AYS_SB_URL . '/css/style.css');
		$atts = shortcode_atts( array(
			'id' => 0), $atts );

		$id = (int) $atts['id'];
		if ( $social_button = ays_sb( $id ) )
			$social_button = ays_sb( $id );
		} else {
				
		}

		if ( ! $social_button )
			return '[ayssocial_buttons 404 "Not Found"]';

	return $social_button->gen_code( $id );
}
?>