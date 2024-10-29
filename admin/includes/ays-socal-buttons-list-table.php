<?php
class AYS_Social_Buttons_List_Table extends WP_List_Table {

	public static function define_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'ays-social-buttons' ),
			'shortcode' => __( 'Shortcode', 'ays-social-buttons' ),
			'author' => __( 'Author', 'ays-social-buttons' ),
			'sbdate' => __( 'Date', 'ays-social-buttons' ),
			'id' => __( 'ID', 'ays-social-buttons' ) );

		return $columns;
	}
	function __construct() {
		parent::__construct();
	}
	function get_columns(){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'ays-social-buttons' ),
			'shortcode' => __( 'Shortcode', 'ays-social-buttons' ),
			'author' => __( 'Author', 'ays-social-buttons' ),
			'sbdate' => __( 'Date', 'ays-social-buttons' ),
			'id' => __( 'ID', 'ays-social-buttons' ) );

		return $columns;		
    }
	function prepare_items() {
		$current_screen = get_current_screen();
		$columns = $this->define_columns();
		$hidden = array();
		$sortable =  $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		if( ! empty( $_REQUEST['author']) )
			$args['author'] = $_REQUEST['author'];

		if ( ! empty( $_REQUEST['s'] ) )
			$args['s'] = $_REQUEST['s'];

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			if ( 'title' == $_REQUEST['orderby'] )
				$args['orderby'] = 'title';
			elseif ( 'author' == $_REQUEST['orderby'] )
				$args['orderby'] = 'author';
			elseif ( 'id' == $_REQUEST['orderby'] )
				$args['orderby'] = 'id';
		}

		if ( ! empty( $_REQUEST['order'] ) ) {
			if ( 'asc' == strtolower( $_REQUEST['order'] ) )
				$args['order'] = 'ASC';
			elseif ( 'desc' == strtolower( $_REQUEST['order'] ) )
				$args['order'] = 'DESC';
		}

		$this->items = AYS_Social_Buttons::find( $args );	
		$per_page = $this->get_items_per_page( 'ays_sb_per_page', 5 );
	
		$current_page = $this->get_pagenum();
		$total_items = count($this->items);
		$total_pages = ceil( $total_items / $per_page );

		$ays_nk_data = array_slice($this->items,(($current_page-1)*$per_page),$per_page);

		$this->set_pagination_args( array(
		'total_items' => $total_items,            
		'per_page'    => $per_page                    
		) );

		$this->items = $ays_nk_data;		
	}
	function get_sortable_columns() {
		$columns = array(
			'title' => array( 'title', true ),
			'author' => array( 'author', false ),
			'sbdate' => array( 'date', false ),
			'id' => array( 'id', false ) );

		return $columns;
	}

	function get_bulk_actions() {
		$actions = array(
			'delete' => __( 'Delete', 'ays-social-buttons' ) );

		return $actions;
	}

	function column_default( $item, $column_name ) {
		return '';
    }
	
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="sb[]" value="%1$s" />',
			$item->id );
	}

	function column_title( $item ) {
		$url = admin_url( 'admin.php?page=ays-social-buttons-settings&sb=' . absint( $item->id) );
		$edit_link = add_query_arg( array( 'action' => 'edit' ), $url );

		$actions = array(
			'edit' => '<a href="' . $edit_link . '">' . __( 'Edit', 'ays-social-buttons' ) . '</a>' );

		if ( current_user_can( 'manage_options', $item->id ) ) {
			$copy_link = wp_nonce_url(
				add_query_arg( array( 'action' => 'copy' ), $url ),
				'ays-copy-sb_' . absint( $item->id ) );

			$actions = array_merge( $actions, array(
				'copy' => '<a href="' . $copy_link . '">' . __( 'Duplicate', 'ays-social-buttons' ) . '</a>' ) );
		}

		$a = sprintf( '<a class="row-title" href="%1$s" title="%2$s">%3$s</a>',
			$edit_link,
			esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'ays-social-buttons' ),
				$item->title ) ),
			esc_html( $item->title ) );

		return '<strong>' . $a . '</strong> ' . $this->row_actions( $actions );
    }

	function column_shortcode( $item ) {
		$shortcodes = array(
			sprintf( '[ayssocial_buttons id="%1$d"]',
				(int)$item->id ) );

		$output = '';

		foreach ( $shortcodes as $shortcode ) {
			$output .= "\n" . '<input type="text"'
				. ' onfocus="this.select();" readonly="readonly"'
				. ' value="' . esc_attr( $shortcode ) . '"'
				. ' class="shortcode-in-list-table wp-ui-text-highlight code" />';
		}

		return trim( $output );
	}
	
	function column_author( $item ) {
		$user_info = get_userdata($item->author);

		return '<a href="admin.php?page=ays-social-buttons-settings&author='.$item->author.'">'.$user_info->display_name.'</a>';
    }

	function column_sbdate( $item ) {

		return $item->sbdate;
    }


	function column_id( $item ) {
		$ids = array((int)$item->id);
		return (int)$item->id;
	}
}
?>