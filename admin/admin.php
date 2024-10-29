<?php

require_once AYS_SB_DIR . '/admin/admin-functions.php';
add_action( 'admin_menu', 'ays_admin_menu', 9 );

function ays_admin_menu() {
	add_object_page( __( 'AYS Social Buttons', 'ays-social-buttons' ),
		__( 'AYS Social Buttons', 'ays-social-buttons' ),
		'manage_options', 'ays-social-buttons-settings',
		'ays_sb_settings', '' );

	$edit = add_submenu_page( 'ays-social-buttons-settings',
		__( 'AYS Social Buttons', 'ays-social-buttons' ),
		__( 'AYS Social Buttons', 'ays-social-buttons' ),
		'manage_options', 'ays-social-buttons-settings',
		'ays_sb_settings' );

	add_action( 'load-' . $edit, 'ays_sb_load_admin' );

	$addnew = add_submenu_page( 'ays-social-buttons-settings',
		__( 'Add New Social Button', 'ays-social-buttons' ),
		__( 'Add New', 'ays-social-buttons' ),
		'manage_options', 'ays-sb-new',
		'ays_sb_add_new_page' );

	add_action( 'load-' . $addnew, 'ays_sb_load_admin' );
}

add_filter( 'set-screen-option', 'ays_sb_screen_options', 10, 3 );

function ays_sb_screen_options( $result, $option, $value ) {
	$ays_sb_screen = array(
		'ays_sb_per_page' );

	if ( in_array( $option, $ays_sb_screen ) )
		$result = $value;

	return $result;
}

function ays_sb_load_admin() {
	global $plugin_page;

	$action = ays_sb_current_action();

	if ( 'save' == $action ) {
		$id = $_POST['post_id'];

		if ( ! current_user_can( 'manage_options', $id ) )
			wp_die( __( 'You are not allowed to edit this item.', 'ays-social-buttons' ) );

		$id = ays_sb_save( $id );

		if(isset($_POST['ays-sb-save']))
		$query = array(
			'message' => ( -1 == $_POST['post_id'] ) ? 'created' : 'saved' );
		else
			$query = array(
			'message' => ( -1 == $_POST['post_id'] ) ? 'created' : 'saved',
			'sb' => $id,
			'action' => 'edit' );
		
		$redirect_to = add_query_arg( $query, menu_page_url( 'ays-social-buttons-settings', false ) );
		wp_safe_redirect( $redirect_to );
		exit();
	}
	
	if ( 'copy' == $action ) {
		$id = absint( $_REQUEST['sb'] );
		
		$query = array();
		if ( $social_button = ays_sb( $id ) ) {
			$social_button = $social_button->copy();
			$social_button->save();

			$query['message'] = 'created';
		}

		$redirect_to = add_query_arg( $query, menu_page_url( 'ays-social-buttons-settings', false ) );
		wp_safe_redirect( $redirect_to );
		exit();
	}

	if ( 'delete' == $action ) {

		$sbs = empty( $_POST['post_id'] )
			? (array) $_REQUEST['sb']
			: (array) $_POST['post_id'];

		$deleted = 0;

		foreach ( $sbs as $sb ) {
			$sb = AYS_Social_Buttons::get_instance( $sb );
			if ( empty( $sb ) )
				continue;

			$sb->delete();
			$deleted += 1;
		}

		$query = array();
		if ( ! empty( $deleted ) )
			$query['message'] = 'deleted';

		$redirect_to = add_query_arg( $query, menu_page_url( 'ays-social-buttons-settings', false ) );

		wp_safe_redirect( $redirect_to );
		exit();
	}

	$_GET['sb'] = isset( $_GET['sb'] ) ? $_GET['sb'] : '';
	$sb = null;

	if ( 'ays-sb-new' == $plugin_page) {
		$sb = AYS_Social_Buttons::get_template( array() );
	} elseif ( ! empty( $_GET['sb'] ) ) {
		$sb = AYS_Social_Buttons::get_instance( $_GET['sb'] );
	}

	$current_screen = get_current_screen();

	if ( ! class_exists( 'AYS_Social_Buttons_List_Table' ) ) {
		require_once AYS_SB_DIR . '/admin/includes/ays-socal-buttons-list-table.php';
	}

	if( $sb === NULL) {
		add_filter( 'manage_' . $current_screen->id . '_columns',
			array( 'AYS_Social_Buttons_List_Table', 'define_columns' ) );
		
		add_screen_option( 'per_page', array(
			'label' => __( 'Items', 'ays-social-buttons' ),
			'default' => 20,
			'option' => 'ays_sb_per_page' ) );
	}	
}

function ays_sb_settings() {
	if ( $sb = ays_sb_get_current() ) {
		$post_id = $sb->initial() ? -1 : $sb->id();
		
		require_once AYS_SB_DIR . '/admin/edit-social-buttons.php';
		return;
	}

	$list_table = new AYS_Social_Buttons_List_Table();
	$list_table->prepare_items();
	
?>
<div class="wrap">
	<h2>
		<?php
			echo esc_html( __( 'Social Buttons', 'ays-social-buttons' ) );
			echo ' <a href="' . esc_url( menu_page_url( 'ays-sb-new', false ) ) . '" class="add-new-h2">' . esc_html( __( 'Add New', 'ays-social-buttons' ) ) . '</a>';
			if ( ! empty( $_REQUEST['s'] ) ) {
				echo sprintf( '<span class="subtitle">'
					. __( 'Search results for &#8220;%s&#8221;', 'ays-social-buttons' )
					. '</span>', esc_html( $_REQUEST['s'] ) );
			}
		?>
	</h2>
	<?php do_action( 'ays_sb_admin_notices' ); ?>
	<form method="get" action="">
		<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
		<?php $list_table->search_box( __( 'Search Social Buttons', 'ays-social-buttons' ), 'ays-social-buttons' ); ?>
		<?php $list_table->display(); ?>
	</form>
</div>
<?php
}

function ays_sb_add_new_page() {
	if ( $sb = ays_sb_get_current() ) {
		$post_id = -1;
		require_once AYS_SB_DIR . '/admin/edit-social-buttons.php';
	}	
}

add_action( 'ays_sb_admin_notices', 'ays_sb_updated_message' );

function ays_sb_updated_message() {
	if ( empty( $_REQUEST['message'] ) )
		return;

	if ( 'created' == $_REQUEST['message'] )
		$updated_message = esc_html( __( 'Social Button created.', 'ays-social-buttons' ) );
	elseif ( 'saved' == $_REQUEST['message'] )
		$updated_message = esc_html( __( 'Social Button saved.', 'ays-social-buttons' ) );
	elseif ( 'deleted' == $_REQUEST['message'] )
		$updated_message = esc_html( __( 'Social Button deleted.', 'ays-social-buttons' ) );

	if ( empty( $updated_message ) )
		return;
	?>
	<div id="message" class="updated">
		<p><?php echo $updated_message; ?></p>
	</div>
	<?php
}

add_filter( 'plugin_action_links', 'ays_sb_action_links', 10, 2 );
function ays_sb_action_links( $links, $file ) {
	if ( $file != AYS_SB_BASENAME )
		return $links;

	$settings_link = '<a href="' . menu_page_url( 'ays-social-buttons-settings', false ) . '">'
		. esc_html( __( 'Settings', 'ays-social-buttons' ) ) . '</a>';

	array_unshift( $links, $settings_link );
	return $links;
}

add_action( 'admin_enqueue_scripts', 'ays_sb_admin_enqueue_scripts' );
function ays_sb_admin_enqueue_scripts( $hook_suffix ) {
	if ( false === strpos( $hook_suffix, 'ays-social-buttons' ) )
		return;

	wp_enqueue_style( 'ays-social-buttons-admin',
		AYS_SB_URL .'/admin/css/styles.css' ,
		array(), '', 'all' );

	wp_enqueue_script( 'ays-sb-admin-jquery',
		AYS_SB_URL .'/admin/js/jquery-ui.js' ,
		array( 'jquery' ), '', true );	
		
	wp_enqueue_script( 'ays-sb-admin',
		AYS_SB_URL .'/admin/js/ayssocial_buttons.js' ,
		array( 'jquery' ), '', true );		
}

add_action('init', 'ays_sb_shortcode_button_init');
function ays_sb_shortcode_button_init() {
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
        return;

    add_filter("mce_external_plugins", "ays_sb_register_tinymce_plugin"); 
    add_filter('mce_buttons', 'ays_sb_add_tinymce_button');
}

function ays_sb_register_tinymce_plugin($plugin_array) {
    $plugin_array['ays_sb_button_mce'] = AYS_SB_URL .'/admin/js/ays_sb_shortcode.js';
    return $plugin_array;
}

function ays_sb_add_tinymce_button($buttons) {
    $buttons[] = "ays_sb_button_mce";
    return $buttons;
}

function gen_ays_sb_shortcode_callback() { 
	$shortcode_data = AYS_Social_Buttons::get_shortcode_data();
	?>
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>AYS Social Buttons</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
			<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
			<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>

			<?php
				wp_print_scripts('jquery');
			?>
			<base target="_self">
		</head>
		<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr" class="forceColors">
			<div class="select-sb">
				<span style="font-size: 14px;">Insert Social Button</span>
				<span>
					<select id="ays-social-buttons" style="padding: 2px; height: 25px; font-size: 12px;">
					<?php foreach($shortcode_data as $data)
						echo '<option id="'.$data->id.'">'.$data->title.'</option>';
					?>
					</select>
				</span>
			</div>
			<div class="mceActionPanel">
				<input type="submit" id="insert" name="insert" value="Insert" onClick="sb_insert_shortcode();"/>
			</div>
        <script type="text/javascript">
			function sb_insert_shortcode() {
				var tagtext = '[ayssocial_buttons id="' + document.getElementById('ays-social-buttons')[document.getElementById('ays-social-buttons').selectedIndex].id + '"]';
				window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
				tinyMCEPopup.close();
			}
        </script>
      </body>
    </html>
    <?php
    die();
}

    add_action('wp_ajax_gen_ays_sb_shortcode', 'gen_ays_sb_shortcode_callback');
?>