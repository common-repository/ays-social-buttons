<?php
/*
Plugin Name: AYS Social Buttons
Version: 1.0.2
Author: AYS Pro
Author URI: 
Description: 
License: GPLv2 or later
*/

defined('AYS_DS') or define('AYS_DS', DIRECTORY_SEPARATOR);

define( 'AYS_SB_BASENAME', plugin_basename( __FILE__ ) );
define( 'AYS_SB_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'AYS_SB_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

require_once AYS_SB_DIR . '/settings.php';

function ayssocial_buttons_activation()
{
	global $wpdb;
	$ayssocial_buttons = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ayssocial_buttons` (
		`id`                int(11)         NOT NULL AUTO_INCREMENT,
		`author`            bigint(20)     	NOT NULL,
		`sbdate`            datetime    	NOT NULL,
		`title`             varchar(255)    NOT NULL,
		`type`              varchar(256)    NOT NULL,
		`params`            text            NOT NULL,
		`unexcept_articles` text			NOT NULL,
		`article_type`      varchar(256)    NOT NULL,
		PRIMARY KEY (`id`)
	) DEFAULT CHARSET=utf8;";
	$wpdb->query($ayssocial_buttons);
	
	$social_buttons_demos = array(
		array(
			'author' =>  '',
			'sbdate' =>  '',
			'title' =>  'Like Button',
			'type' => 'likebutton',
			'params' => '{"action":"save","post_id":"-1","id":"","type":"likebutton","title":"Untitled","render":"html5","layout":"standard","include_share":"1","width":"","verb":"like","colorscheme":"light","language":"en_GB","css":"","share_render":"html5","share_layout":"button","share_width":"","share_language":"en_GB","share_css":"\t\t\t\t\t\t\t\t","comment_render":"html5","comment_width":"","comment_number":"","comment_order":"social","comment_colorscheme":"light","comment_mobile":"0","comment_language":"en_GB","comment_css":"","twitterbutton_count":"horizontal","twitterbutton_size":"medium","twitterbutton_via":"","twitterbutton_text":"","twitterbutton_language":"en","twitterbutton_css":"","google_count":"bubble","google_size":"20","google_language":"en-GB","google_css":"","linkedin_count":"right","linkedin_language":"en_US","linkedin_css":"","vk_count":"round","vk_text":"Share","vk_language":"english","vk_css":"","s_likebutton_render":"html5","s_likebutton_layout":"standard","s_likebutton_include_share":"1","s_likebutton_width":"","s_likebutton_verb":"like","s_likebutton_colorscheme":"light","s_likebutton_language":"en_GB","s_likebutton_css":"","s_share_render":"html5","s_share_layout":"button","s_share_width":"","s_share_language":"en_GB","s_share_css":"","s_twitterbutton_count":"horizontal","s_twitterbutton_size":"medium","s_twitterbutton_via":"","s_twitterbutton_text":"","s_twitterbutton_language":"en","s_twitterbutton_css":"","s_google_count":"bubble","s_google_size":"20","s_google_language":"en-GB","s_google_css":"","s_linkedin_count":"right","s_linkedin_language":"en_US","s_linkedin_css":"","s_vk_count":"round","s_vk_text":"Share","s_vk_language":"english","s_vk_css":"","socials_horizontal":"left","socials_css":"","s_buttons_ordering":"","article_position":"top","article_type":"none","unexcept_articles":"","ays-sb-save":"Save"}',
			'unexcept_articles' => '',
			'article_type' => ''
			),
		array(
			'author' =>  '',
			'sbdate' =>  '',
			'title' =>   'Social buttons (horizontal position)',
			'type' => 'social_buttons',
			'params' => '{"action":"save","post_id":"4","id":"4","type":"social_buttons","title":"Social buttons horizontal position","render":"html5","layout":"standard","include_share":"1","width":"","verb":"like","colorscheme":"light","language":"en_GB","css":"","share_render":"html5","share_layout":"button","share_width":"","share_language":"en_GB","share_css":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t","comment_render":"html5","comment_width":"","comment_number":"","comment_order":"social","comment_colorscheme":"light","comment_mobile":"0","comment_language":"en_GB","comment_css":"","twitterbutton_count":"horizontal","twitterbutton_size":"medium","twitterbutton_via":"","twitterbutton_text":"","twitterbutton_language":"en","twitterbutton_css":"","google_count":"bubble","google_size":"20","google_language":"en-GB","google_css":"","linkedin_count":"right","linkedin_language":"en_US","linkedin_css":"","vk_count":"round","vk_text":"Share","vk_language":"english","vk_css":"","s_likebutton_render":"html5","s_likebutton_layout":"button_count","s_likebutton_include_share":"0","s_likebutton_width":"","s_likebutton_verb":"like","s_likebutton_colorscheme":"light","s_likebutton_language":"en_GB","s_likebutton_css":"position: relative;\\r\\ntop: -5px;","s_share_render":"html5","s_share_layout":"button","s_share_width":"","s_share_language":"en_GB","s_share_css":"position: relative;\\r\\ntop: -5px;","s_twitterbutton_count":"horizontal","s_twitterbutton_size":"medium","s_twitterbutton_via":"","s_twitterbutton_text":"","s_twitterbutton_language":"en","s_twitterbutton_css":"","s_google_count":"bubble","s_google_size":"20","s_google_language":"en-GB","s_google_css":"","s_linkedin_count":"right","s_linkedin_language":"en_US","s_linkedin_css":"","s_vk_count":"round","s_vk_text":"Share","s_vk_language":"english","s_vk_css":"","socials_horizontal":"right","socials_css":"","s_buttons_ordering":"likebutton-1,sharebutton-1,twitterbutton-1,google-1,linkedin-1,vk-1,","article_position":"bottom","article_type":"all","unexcept_articles":"","ays-sb-apply":"Apply"}',
			'unexcept_articles' => '',
			'article_type' => 'all'
			),
		array(
			'author' =>  '',
			'sbdate' =>  '',
			'title' =>   'Social Buttons (vertical position)',
			'type' => 'social_buttons',
			'params' => '{"action":"save","post_id":"3","id":"3","type":"social_buttons","title":"Social Buttons vertical position","ays-sb-apply":"Apply","render":"html5","layout":"standard","include_share":"1","width":"","verb":"like","colorscheme":"light","language":"en_GB","css":"","share_render":"html5","share_layout":"button","share_width":"","share_language":"en_GB","share_css":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t","comment_render":"html5","comment_width":"","comment_number":"","comment_order":"social","comment_colorscheme":"light","comment_mobile":"0","comment_language":"en_GB","comment_css":"","twitterbutton_count":"horizontal","twitterbutton_size":"medium","twitterbutton_via":"","twitterbutton_text":"","twitterbutton_language":"en","twitterbutton_css":"","google_count":"bubble","google_size":"20","google_language":"en-GB","google_css":"","linkedin_count":"right","linkedin_language":"en_US","linkedin_css":"","vk_count":"round","vk_text":"Share","vk_language":"english","vk_css":"","s_likebutton_render":"html5","s_likebutton_layout":"box_count","s_likebutton_include_share":"0","s_likebutton_width":"60px","s_likebutton_verb":"like","s_likebutton_colorscheme":"light","s_likebutton_language":"en_GB","s_likebutton_css":"display:block;\\r\\nposition: relative;\\r\\ntop: -5px;","s_share_render":"html5","s_share_layout":"button","s_share_width":"","s_share_language":"en_GB","s_share_css":"display:block;\\r\\nposition: relative;\\r\\ntop: -5px;","s_twitterbutton_count":"vertical","s_twitterbutton_size":"medium","s_twitterbutton_via":"","s_twitterbutton_text":"","s_twitterbutton_language":"en","s_twitterbutton_css":"display:block;","s_google_count":"vertical-bubble","s_google_size":"20","s_google_language":"en-GB","s_google_css":"display:block;","s_linkedin_count":"top","s_linkedin_language":"en_US","s_linkedin_css":"display:block;","s_vk_count":"round","s_vk_text":"Share","s_vk_language":"english","s_vk_css":"display:block;","socials_horizontal":"right","socials_css":"","s_buttons_ordering":"likebutton-0,sharebutton-1,twitterbutton-1,google-1,linkedin-1,vk-1,","article_position":"top","article_type":"none","unexcept_articles":""}',
			'unexcept_articles' => '',
			'article_type' => 'none'
			)	
	);
		
	foreach($social_buttons_demos as $social_buttons_demo)
	{
		$social_button = AYS_Social_Buttons::get_template( $social_buttons_demo );
		$social_button->save();
	}
}

register_activation_hook(__FILE__, 'ayssocial_buttons_activation');