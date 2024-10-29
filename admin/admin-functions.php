<?php
function ays_sb_current_action() {
	if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] )
		return $_REQUEST['action'];

	if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] )
		return $_REQUEST['action2'];

	return false;
}

function ays_sb_save( $post_id = -1 ) {
	if ( -1 != $post_id ) {
		$social_button = ays_sb( $post_id );
	}

	if ( empty( $social_button ) ) {
		$social_button = AYS_Social_Buttons::get_template();
	}

	if ( isset( $_POST['title'] ) ) {
		$social_button->set_title( $_POST['title'] );
	}
	
	if ( isset( $_POST['type'] ) ) {
		$social_button->set_type( $_POST['type'] );
	}

	if ( isset( $_POST ) ) {
		$social_button->set_params( $_POST );
	}

	if ( isset( $_POST['unexcept_articles'] ) ) {
		$social_button->set_unexcept_articles( $_POST['unexcept_articles'] );
	}
	
	if ( isset( $_POST['article_type'] ) ) {
		$social_button->set_article_type( $_POST['article_type'] );
	}

	return $social_button->save();
}
?>