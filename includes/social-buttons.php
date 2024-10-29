<?php
class AYS_Social_Buttons {

	private static $current = null;
	private $id;
	private $title;
	private $type;
	private $author;
	private $sbdate;
	private $params;
	private $unexcept_articles;
	private $article_type;
	private $all_articles = array();
	
	public static function find( $args = '' ) {
		global $wpdb;
		$defaults = array(
			'orderby' => 'id',
			'order' => 'ASC' );

		$args = wp_parse_args( $args, $defaults );

		$where = array();
		if( isset( $args['s'] ) )
			$where[] = isset( $args['s'] ) ? ' title LIKE "%'.$args['s'].'%"' : '';
		if( isset( $args['author'] ) && $args['author'] != '' )
			$where[] = isset( $args['author'] ) ? ' author = '.(int)$args['author'] : '';
		
		$where = ( count( $where ) ? '  ' . implode( ' AND ', $where ) : '' );	
		if($where)
			$where = 'WHERE'.$where;
		$oderby = ' ORDER BY '.$args['orderby'].' '.$args['order'];

		$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ayssocial_buttons ".$where.$oderby , OBJECT);
       
		return $rows;
	}

	public static function get_current() {
		return self::$current;
	}

	public static function get_template( $args = '' ) {
		$defaults = array( 'title' => '', 'type' => '',  'params' => '');
		$args = wp_parse_args( $args, $defaults );

		$type = $args['type'];
		$title = $args['title'];
		$params = $args['params'];
		
		self::$current = $social_button = new self;
		$social_button->title =
			( $title ? $title : __( 'Untitled', 'ays-social-buttons' ) );
		$social_button->type = $type;
		$social_button->params = $params;
		$social_button->unexcept_articles ='';
		$social_button->article_type = '';	

		return $social_button;
	}

	public static function get_instance( $sb ) {
		global $wpdb;
		$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."ayssocial_buttons WHERE id=".(int)$sb, OBJECT);

		self::$current = $social_button = new self( $sb );
		$social_button->id = $row->id;
		$social_button->type = $row->type;
		$social_button->title = $row->title;
		$social_button->params = $row->params;
		$social_button->unexcept_articles = $row->unexcept_articles;
		$social_button->article_type = $row->article_type;
		
		return $social_button;
	}
	
	public static function get_shortcode_data( ) {
		global $wpdb;
		$q = "SELECT id, title FROM ".$wpdb->prefix."ayssocial_buttons";

		return $wpdb->get_results($q);
	}
	
	public static function get_all_data( $post_page_id ) {
		global $wpdb;
		$q = "SELECT id FROM ".$wpdb->prefix."ayssocial_buttons where `unexcept_articles` LIKE '%@@".$post_page_id."@@%' OR `article_type`='all'";

		return $wpdb->get_results($q);
	}

	public function initial() {
		return empty( $this->id );
	}

	public function id() {
		return $this->id;
	}

	public function params() {
		return $this->params;
	}
	
	public function title() {
		return $this->title;
	}
	
	public function author() {
		return $this->author;
	}
	
	public function sbdate() {
		return $this->sbdate;
	}
	
	public function type() {
		return $this->type;
	}
	
	public function all_articles() {
		global $wpdb;
		$q = "SELECT ID as id, post_title as title FROM $wpdb->posts WHERE post_status = 'publish'";
		$q .= "ORDER BY post_date DESC";
		return $wpdb->get_results($q);
	}
	
	public function set_title( $title ) {
		$title = trim( $title );
		if ( '' === $title ) {
			$title = __( 'Untitled', 'ays-social-buttons' );
		}

		$this->title = $title;
	}
	
	public function set_type( $type ) {
		$this->type = $type;
	}
	
	public function set_params( $params ) {
		$this->params = json_encode($params);
	}
	
	public function set_unexcept_articles( $unexcept_articles ) {
		$this->unexcept_articles = $unexcept_articles;
	}
	
	public function set_article_type( $article_type ) {
		$this->article_type = $article_type;
	}

	/* message */
	public function message( $status, $filter = true ) {
		$messages = $this->prop( 'messages' );
		$message = isset( $messages[$status] ) ? $messages[$status] : '';

		return $message;
	}
	
	/* save */
	public function save() {
		global $wpdb;
		if ( $this->initial() ) {
			$wpdb->insert($wpdb->prefix."ayssocial_buttons", 
				array( 
					'author' => get_current_user_id(),
					'sbdate' => current_time( 'mysql', 1 ),
					'title' => $this->title,	
					'type' => $this->type,
					'params' => $this->params,
					'unexcept_articles' => $this->unexcept_articles,
					'article_type' => $this->article_type
					),
				array( 
					'%s',	
					'%s',
					'%s',	
					'%s',	
					'%s',
					'%s',	
					'%s'
					)
			);
			$this->id = mysql_insert_id();
		} else {
			$wpdb->update( 
				$wpdb->prefix."ayssocial_buttons", 
				array( 
					'title' => $this->title,	
					'type' => $this->type,
					'params' => $this->params,
					'unexcept_articles' => $this->unexcept_articles,
					'article_type' => $this->article_type
				), 
				array( 'ID' => $this->id ), 
				array( 
					'%s',	
					'%s',
					'%s',	
					'%s',	
					'%s'
				), 
				array( '%d' ) 
			);
		}

		return $this->id;
	}
	
	/* copy */
	public function copy() {
		$new = new self;
		$new->title = $this->title . '_copy';
		$new->type = $this->type;
		$new->params = $this->params;
		$new->unexcept_articles = $this->unexcept_articles;
		$new->article_type = $this->article_type;
		return $new;
	}

	/* delete */
	public function delete() {
		if ( $this->initial() )
			return;

		global $wpdb;

		$query = "DELETE FROM ".$wpdb->prefix."ayssocial_buttons WHERE id = ".$this->id;
		$wpdb->query($query);
		$this->id = 0;
	}
	
	public function gen_code( $id ) {
		$social_button = ays_sb( $id );
		$params = json_decode($social_button->params);
		$type = $params->type;

		$href = get_site_url();
		switch($type)
		{ 
			// like button code
			case "likebutton":
				$code = "<div style='display:inline-block;".$params->css."'> <div id='fb-root'></div>
					<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = '//connect.facebook.net/".$params->language."/sdk.js#xfbml=1&version=v2.0';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>";
				switch($params->render)
				{
					case "html5":
						$code .= '<div class="fb-like" data-href="'.$href.'" data-width="'.$params->width.'" data-layout="'.$params->layout.'" data-action="'.$params->verb.'" data-share="'.$params->include_share.'" data-colorscheme="'.$params->colorscheme.'"></div></div> ';
					break;
					
					case "xfbml":
						$code .= '<fb:like href="'.$href.'"  width="'.$params->width.'" layout="'.$params->layout.'" action="'.$params->verb.'"  share="'.$params->include_share.'"   colorscheme="'.$params->colorscheme.'"></fb:like></div>';
						 
					break;
					
					case "iframe":
						$encode_href = urlencode($href);
						$code .= '<iframe src="//www.facebook.com/plugins/like.php?href='.$encode_href.'&amp;width='.$params->width.'&amp;layout='.$params->layout.'&amp;action='.$params->verb.'&amp;share=true&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$params->width.'px;" allowTransparency="true"></iframe> </div> ';
					break;
				
				}
		   
			break;
		   
			// share button code   
			case "sharebutton":
				$code = "<div style='display:inline-block;".$params->share_css."'><div id='fb-root'></div>
					<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = '//connect.facebook.net/".$params->share_language."/sdk.js#xfbml=1&version=v2.0';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>";
				switch($params->share_render)
				{
					case "html5":
						$code.= ' <div class="fb-share-button" data-href="'.$href.'" data-width="'.$params->share_width.'" data-layout="'.$params->share_layout.'"></div></div>';
					break;
					
					case "xfbml":
						$code.= '<fb:share-button href="'.$href.'" width="'.$params->share_width.'" layout="'.$params->share_layout.'"></fb:share-button></div>';
						 
					break;
				}
						  
			break;
		
			// comment box code   
			case "comment":
				$code="<div style='display:inline-block;".$params->comment_css."'><div id='fb-root'></div>
				<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = '//connect.facebook.net/".$params->comment_language."/sdk.js#xfbml=1&version=v2.0';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>";
				switch($params->render)
				{
					case "html5":
						$code.= '<div class="fb-comments" data-href="'.$href.'" data-width="'.$params->comment_width.'" data-numposts="'.$params->comment_number.'" data-colorscheme="'.$params->comment_colorscheme.'"  data-order-by="'.$params->comment_order.'" data-mobile="'.$params->comment_mobile.'"></div></div>';
					break;
							
					case "xfbml":
						$code.= '<fb:comments href="'.$href.'" width="'.$params->comment_width.'"  numposts="'.$params->comment_number.'" colorscheme="'.$params->comment_colorscheme.'" order_by="'.$params->comment_order.'" mobile="'.$params->comment_mobile.'"></fb:comments></div>';
						 
					break;
				}
		   
			break;
		   
			// Twitter button code   
			case "twitterbutton":
				$code = '<div style="display:inline-block;'.$params->twitterbutton_css.'">
					<a class="twitter-share-button"  data-via="'.$params->twitterbutton_via.'" data-text="'.$params->twitterbutton_text.'" data-count="'.$params->twitterbutton_count.'" data-size="'.$params->twitterbutton_size.'" data-lang="'.$params->twitterbutton_language.'">Tweet</a>
					<script type="text/javascript">
						window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
					</script>
				</div>';
		   break;
		   
			// Google + button code   
		   case "google":
				if($params->google_count=="vertical-bubble")
					$params->google_size="60";
				$code='<div style="display:inline-block;'.$params->google_css.'">
					<script src="https://apis.google.com/js/platform.js" async defer>
						{lang: "'.$params->google_language.'"}
					</script>
				<div class="g-plus" data-action="share"  data-height="'.$params->google_size.'" data-annotation="'.$params->google_count.'" ></div></div>';
										
		   break;
		   
		   // LinkedIn button code   
		   case "linkedin":
				$code='<div style="display:inline-block;'.$params->linkedin_css.'">
				<script src="//platform.linkedin.com/in.js" type="text/javascript">
					lang: '.$params->linkedin_language.'
				</script>
				<script type="IN/Share" data-counter="'.$params->linkedin_count.'"></script></div>';
											
		   break;
			 
			// VK shar button code   
			case "vk":
				$vk_lang=($params->vk_language=='english')? ", eng:1" : "";
				if($params->vk_count=="custom") {
					$code='<div style="display:inline-block;'.$params->vk_css.'"><script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
					<script type="text/javascript"><!--
						document.write(VK.Share.button(false,{type: "custom", text: "<img src=\"http://vk.com/images/share_32_eng.png\" width=\"32\" height=\"32\" />"'.$vk_lang.'}));-->
					</script></div>';
				} else {
					$code='<div style="display:inline-block;'.$params->vk_css.'"><script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
					<script type="text/javascript"><!--
						document.write(VK.Share.button(false,{type: "'.$params->vk_count.'", text: "'.$params->vk_text.'"'.$vk_lang.'}));--></script></div>';
				}				 
				 
			break;
		   
			// Social buttons code   
			case "social_buttons":
				$all_buttons_arr = explode(",",trim($params->s_buttons_ordering,","));
				$active_buttons_arr = Array();
				// get active buttons codes
				foreach($all_buttons_arr as $each_button)
				{
					$is_active=explode("-",$each_button);
					if($is_active[1]=='1') {
						$active_buttons_arr[] = $this->get_social_code($is_active[0],$params);
					}
				}
				$code="<div class='ays-sb' align='".$params->socials_horizontal."' style='clear:both;".$params->socials_css."' >".implode(" ",$active_buttons_arr)."</div>";
				
			break;
			
		   	default:
				$code = '';
			break;

		}
		
        return $code;
	}	
	
	// socail buttons code generator
	public function get_social_code($type, $params) {
		$href = get_site_url();
	
		switch($type)
		{
			// social like button code   
			case 'likebutton':
				$s_code="<div style='display:inline-block;".$params->s_likebutton_css."'><div id='fb-root'></div>
					<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = '//connect.facebook.net/".$params->s_likebutton_language."/sdk.js#xfbml=1&version=v2.0';
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>";
				switch($params->s_likebutton_render)
				{
					case "html5":
						$s_code.= ' <div class="fb-like" data-href="'.$href.'" data-width="'.$params->s_likebutton_width.'" data-layout="'.$params->s_likebutton_layout.'" data-action="'.$params->s_likebutton_verb.'" data-share="'.$params->s_likebutton_include_share.'" data-colorscheme="'.$params->s_likebutton_colorscheme.'"></div></div> ';
					break;
					
					case "xfbml":
						$s_code.= '<fb:like href="'.$href.'"  width="'.$params->s_likebutton_width.'" layout="'.$params->s_likebutton_layout.'" action="'.$params->s_likebutton_verb.'"  share="'.$params->s_likebutton_include_share.'"   colorscheme="'.$params->s_likebutton_colorscheme.'"></fb:like></div>';
						 
					break;
					
					case "iframe":
						$encode_href=urlencode($href);
						$s_code.= '<iframe src="//www.facebook.com/plugins/like.php?href='.$encode_href.'&amp;width='.$params->s_likebutton_width.'&amp;layout='.$params->s_likebutton_layout.'&amp;action='.$params->s_likebutton_verb.'&amp;share=true&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$params->s_likebutton_width.'px;" allowTransparency="true"></iframe></div>  ';
					break;
				}
					
			break;	
			
			// social share button code   
			case "sharebutton":
					$s_code="<div style='display:inline-block;".$params->s_share_css."'><div id='fb-root'></div>
						<script>(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = '//connect.facebook.net/".$params->s_share_language."/sdk.js#xfbml=1&version=v2.0';
							fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>";
					switch($params->s_share_render)
					{
						case "html5":
							$s_code.= ' <div class="fb-share-button" data-href="'.$href.'" data-width="'.$params->s_share_width.'" data-layout="'.$params->s_share_layout.'"></div></div>';
						break;
						
						case "xfbml":
							$s_code.= '<fb:share-button href="'.$href.'" width="'.$params->s_share_width.'" layout="'.$params->s_share_layout.'"></fb:share-button></div>';
							 
						break;
					}
			break;
		   
			// Social Twitter button code   
			case "twitterbutton":
				$s_code='<div style="display:inline-block;'.$params->s_twitterbutton_css.'">
					<a class="twitter-share-button" data-via="'.$params->s_twitterbutton_via.'" data-text="'.$params->s_twitterbutton_text.'" data-count="'.$params->s_twitterbutton_count.'" data-size	="'.$params->s_twitterbutton_size.'" data-lang="'.$params->s_twitterbutton_language.'">Tweet</a>
					<script type="text/javascript">
						window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
					</script></div>';

				break;
		   
			// Social Google + button code   
			case "google":
					if($params->s_google_count=="vertical-bubble")
						$params->s_google_size="60";
					$s_code = '<div style="display:inline-block;'.$params->s_google_css.'">
					<script src="https://apis.google.com/js/platform.js" async defer>
						{lang: "'.$params->s_google_language.'"}
					</script>
					<div class="g-plus" data-action="share"  data-height="'.$params->s_google_size.'" data-annotation="'.$params->s_google_count.'" ></div></div>';
					
			break;
		   
			// Social LinkedIn button code   
			case "linkedin":
				$s_code='<div style="display:inline-block;'.$params->s_linkedin_css.'">
				<script src="//platform.linkedin.com/in.js" type="text/javascript">
					lang: '.$params->s_linkedin_language.'
				</script>
				<script type="IN/Share" data-counter="'.$params->s_linkedin_count.'"></script></div>';
											
			break;
			 
			// Social VK shar button code   
			case "vk":
				$s_vk_lang = ($params->s_vk_language=='english')? ", eng:1" : "";
				if($params->s_vk_count=="custom") {
					$s_code='<div style="display:inline-block;'.$params->s_vk_css.'"><script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
					<script type="text/javascript"><!--
						document.write(VK.Share.button(false,{type: "custom", text: "<img src=\"http://vk.com/images/share_32_eng.png\" width=\"32\" height=\"32\" />"'.$s_vk_lang.'}));--></script></div>';
				} else {
					$s_code='<div style="display:inline-block;'.$params->s_vk_css.'"><script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
					<script type="text/javascript"><!--
						document.write(VK.Share.button(false,{type: "'.$params->s_vk_count.'", text: "'.$params->s_vk_text.'"'.$s_vk_lang.'}));--></script>
					</div>';
				}				 
				  
			break;
	   
		}
		return  $s_code;
	}
}

function ays_sb_get_current()
{
	if ( $current = AYS_Social_Buttons::get_current() )
	{
		return $current;
	}
}

function ays_sb( $id ) 
{
	return AYS_Social_Buttons::get_instance( $id );
}

?>