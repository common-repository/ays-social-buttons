<?php
if ( ! defined( 'ABSPATH' ) )
	die( '-1' );

$type = ($sb->type()) ? $sb->type() : 'likebutton';
$params = json_decode($sb->params());
$all_articles = $sb->all_articles();

// selected languages for all types
$lang_likebutton=(isset($params->language)) ? $params->language: 'en_GB';
$lang_sharebutton=(isset($params->share_language)) ? $params->share_language: 'en_GB';
$lang_comment=(isset($params->comment_language)) ? $params->comment_language: 'en_GB';
$lang_twitterbutton=(isset($params->twitterbutton_language)) ? $params->twitterbutton_language: 'en';
$lang_google=(isset($params->google_language)) ? $params->google_language: 'en-GB';
$lang_linkedin=(isset($params->linkedin_language)) ? $params->linkedin_language: 'en_US';

$s_lang_likebutton=(isset($params->s_likebutton_language)) ? $params->s_likebutton_language: 'en_GB';
$s_lang_sharebutton=(isset($params->s_share_language)) ? $params->s_share_language: 'en_GB';
$s_lang_twitterbutton=(isset($params->s_twitterbutton_language)) ? $params->s_twitterbutton_language: 'en';
$s_lang_google=(isset($params->s_google_language)) ? $params->s_google_language: 'en-GB';
$s_lang_linkedin=(isset($params->s_linkedin_language)) ? $params->s_linkedin_language: 'en_US';

if(isset($params->unexcept_articles))
    $except_arr = explode("@@", trim($params->unexcept_articles,"@"));
else
    $except_arr = array();
?>
<div class="wrap">
	<h2>
		<?php
			if ( $sb->initial() ) {
				echo esc_html( __( 'Add New Social Button', 'ays-social-buttons' ) );
			} else {
				echo esc_html( __( 'Edit Social Button', 'ays-social-buttons' ) );

				echo ' <a href="' . esc_url( menu_page_url( 'ays-sb-new', false ) ) . '" class="add-new-h2">' . esc_html( __( 'Add New', 'ays-social-buttons' ) ) . '</a>';
			}
		?>
	</h2>
	<p><label style="font-style: italic;color: red; font-weight: bolder; ">Assignment section will be available in PRO version.</label> <a target="_blank" href="http://ays-pro.com/index.php/wordpress/social-buttons">AYS-Pro</a></p>
	<?php do_action( 'ays_sb_admin_notices' ); ?>
	<br class="clear" />
	<?php if ( $sb ): ?>
	<form method="post" action="<?php echo esc_url( add_query_arg( array( 'sb' => $post_id ), menu_page_url( 'ays-social-buttons-settings', false ) ) ); ?>" id="wpcf7-admin-form-element"<?php do_action( 'wpcf7_post_edit_form_tag' ); ?>>
		<input type="hidden" id="hiddenaction" name="action" value="save" />
		<input type="hidden" id="post_id" name="post_id" value="<?php echo (int) $post_id; ?>" />
		<input type="hidden" name="id" value="<?php echo $sb->id(); ?>"/>
		<input type="hidden" name="type"  id="type" value="<?php echo $type; ?>">
		<div id="poststuff" class="metabox-holder">
			<div id="titlediv">
				<input type="text" id="title" name="title" size="80" value="<?php echo esc_attr( $sb->title() ); ?>" />
			</div>
			<ul id="top_menu">
				<li class="ays_active" id="buttons_item">
					<span>Socail Buttons</span>
				</li>
				<li class="ays_inactive" id="assignment_item">
					<span title="Will be available in PRO"> Assignment<font color="red">*</font></span>
				</li>
			</ul>
			<?php if ( current_user_can( 'manage_options', $post_id ) ) : ?>
			<div class="save-social-button">
				<input type="submit" class="button-primary" name="ays-sb-save" onclick="save_sb()" value="<?php echo esc_attr( __( 'Save', 'ays-social-buttons' ) ); ?>" />
				<input type="submit" class="button-primary" name="ays-sb-apply" onclick="save_sb()" value="<?php echo esc_attr( __( 'Apply', 'ays-social-buttons' ) ); ?>" />
			</div>
			<?php endif; ?>
			<!-- parameters section -->
			<div id="social_buttons_parameters">
				<!-- Button type section -->
				<div class='button_types_section'>
					<ul class='button_types_list'>
						<li class='button_type' ays_type='likebutton' id='likebutton'>
							Like Button
						</li>
						<li class='button_type' ays_type='sharebutton' id='sharebutton'>
							Share Button
						</li>
						<li class='button_type' ays_type='comment'  id='comment'>
							Comments box
						</li>
						<li class='button_type' ays_type='twitterbutton' id='twitterbutton'>
							Tweet button
						</li>
						<li class='button_type' ays_type='google' id='google'>
							Google + button
						</li>
						<li class='button_type' ays_type='linkedin' id='linkedin'>
							LinkedIn button
						</li>
						<li class='button_type' ays_type='vk' id='vk'>
							VK share button
						</li>
						<li class='button_type' ays_type='social_buttons'  id='social_buttons'>
							Social buttons
						</li>
					</ul>
				</div>
				<!-- Like button table -->
				<table class="adminlist table" id="likebutton_table">
					<tbody>		
					<!-- render -->
					<tr>
						<td class="col_key">
							<label for="render">Render:</label>
						</td>
						<td class="col_value">
							<select name="render" id="render">
								<option value="html5" <?php  if(isset($params->render) && $params->render=="html5") echo "selected='selected'"; ?> >HTML5</option>
								<option value="xfbml" <?php  if(isset($params->render) && $params->render=="xfbml") echo "selected='selected'"; ?> >XFBML</option>
								<option value="iframe" <?php  if(isset($params->render) && $params->render=="iframe") echo "selected='selected'"; ?> >IFRAME</option>
							</select>
						</td>
					</tr>
					<!-- layout -->
					<tr>
						<td class="col_key">
							<label for="layout">Layout:</label>
						</td>
						<td class="col_value">
							<select name="layout" id="layout">
								<option value="standard" <?php  if(isset($params->layout) && $params->layout=="standard") echo "selected='selected'"; ?> >Standard</option>
								<option value="box_count" <?php  if(isset($params->layout) && $params->layout=="box_count") echo "selected='selected'"; ?> >Box count</option>
								<option value="button_count" <?php  if(isset($params->layout) && $params->layout=="button_count") echo "selected='selected'"; ?> >Button count</option>
								<option value="button" <?php  if(isset($params->layout) && $params->layout=="button") echo "selected='selected'"; ?> >Button</option>
							</select>
						</td>
					</tr>				
					<!-- share button include -->
					<tr>
						<td class="col_key">
							<label>Include share button:</label>
						</td>
						<td class="col_value">
							<label for="include_share_1"  class="first_radio" ><input type="radio"  class="ays_radio" name="include_share" id="include_share_1"  value="1" <?php  if((isset($params->include_share) && $params->include_share=='1') || !isset($params->include_share)) echo "checked='checked'"; ?>/> Yes </label>
							<label for="include_share_0"><input type="radio" class="ays_radio" name="include_share" id="include_share_0"  value="0" <?php  if(isset($params->include_share) && $params->include_share=='0') echo "checked='checked'"; ?>/> No </label>
						</td>
					</tr>	
					<!-- width -->
					<tr>
						<td class="col_key">
							<label for="width">Width:</label>
						</td>
						<td class="col_value">
							<input type="text" name="width" id="width"  value="<?php  if(isset($params->width)) echo $params->width; ?>"/> 
						</td>
					</tr>	
					<!-- verb -->
					<tr>
						<td class="col_key">
							<label for="verb">Button verb:</label>
						</td>
						<td class="col_value">
							<select name="verb" id="verb">
								<option value="like" <?php  if(isset($params->verb) && $params->verb=="like") echo "selected='selected'"; ?> >Like</option>
								<option value="recommend" <?php  if(isset($params->verb) && $params->verb=="recommend") echo "selected='selected'"; ?> >Recommend</option>
							</select>
						</td>
					</tr>				
				   <!-- colorscheme -->
					<tr>
						<td class="col_key">
							<label for="colorscheme">Color scheme:</label>
						</td>
						<td class="col_value">
							<select name="colorscheme" id="colorscheme">
								<option value="light" <?php  if(isset($params->colorscheme) && $params->colorscheme=="light") echo "selected='selected'"; ?> >Light</option>
								<option value="dark" <?php  if(isset($params->colorscheme) && $params->colorscheme=="dark") echo "selected='selected'"; ?> >Dark</option>
							</select>
						</td>
					</tr>
					<!-- language -->
					<tr>
						<td class="col_key">
							<label for="language">Language:</label>
						</td>
						<td class="col_value">
							<select name="language" id="language">
								<option value="af_ZA">Afrikaans</option>
								<option value="ar_AR">Arabic</option>
								<option value="az_AZ">Azerbaijani</option>
								<option value="be_BY">Belarusian</option>
								<option value="bg_BG">Bulgarian</option>
								<option value="bn_IN">Bengali</option>
								<option value="bs_BA">Bosnian</option>
								<option value="ca_ES">Catalan</option>
								<option value="cs_CZ">Czech</option>
								<option value="cx_PH">Cebuano</option>
								<option value="cy_GB">Welsh</option>
								<option value="da_DK">Danish</option>
								<option value="de_DE">German</option>
								<option value="el_GR">Greek</option>
								<option value="en_GB">English (UK)</option>
								<option value="en_PI">English (Pirate)</option>
								<option value="en_UD">English (Upside Down)</option>
								<option value="en_US">English (US)</option>
								<option value="eo_EO">Esperanto</option>
								<option value="es_ES">Spanish (Spain)</option>
								<option value="es_LA">Spanish</option>
								<option value="et_EE">Estonian</option>
								<option value="eu_ES">Basque</option>
								<option value="fa_IR">Persian</option>
								<option value="fb_LT">Leet Speak</option>
								<option value="fi_FI">Finnish</option>
								<option value="fo_FO">Faroese</option>
								<option value="fr_CA">French (Canada)</option>
								<option value="fr_FR">French (France)</option>
								<option value="fy_NL">Frisian</option>
								<option value="ga_IE">Irish</option>
								<option value="gl_ES">Galician</option>
								<option value="gn_PY">Guarani</option>
								<option value="he_IL">Hebrew</option>
								<option value="hi_IN">Hindi</option>
								<option value="hr_HR">Croatian</option>
								<option value="hu_HU">Hungarian</option>
								<option value="hy_AM">Armenian</option>
								<option value="id_ID">Indonesian</option>
								<option value="is_IS">Icelandic</option>
								<option value="it_IT">Italian</option>
								<option value="ja_JP">Japanese</option>
								<option value="jv_ID">Javanese</option>
								<option value="ka_GE">Georgian</option>
								<option value="km_KH">Khmer</option>
								<option value="kn_IN">Kannada</option>
								<option value="ko_KR">Korean</option>
								<option value="ku_TR">Kurdish</option>
								<option value="la_VA">Latin</option>
								<option value="lt_LT">Lithuanian</option>
								<option value="lv_LV">Latvian</option>
								<option value="mk_MK">Macedonian</option>
								<option value="ml_IN">Malayalam</option>
								<option value="ms_MY">Malay</option>
								<option value="nb_NO">Norwegian (bokmal)</option>
								<option value="ne_NP">Nepali</option>
								<option value="nl_NL">Dutch</option>
								<option value="nn_NO">Norwegian (nynorsk)</option>
								<option value="pa_IN">Punjabi</option>
								<option value="pl_PL">Polish</option>
								<option value="ps_AF">Pashto</option>
								<option value="pt_BR">Portuguese (Brazil)</option>
								<option value="pt_PT">Portuguese (Portugal)</option>
								<option value="ro_RO">Romanian</option>
								<option value="ru_RU">Russian</option>
								<option value="si_LK">Sinhala</option>
								<option value="sk_SK">Slovak</option>
								<option value="sl_SI">Slovenian</option>
								<option value="sq_AL">Albanian</option>
								<option value="sr_RS">Serbian</option>
								<option value="sv_SE">Swedish</option>
								<option value="sw_KE">Swahili</option>
								<option value="ta_IN">Tamil</option>
								<option value="te_IN">Telugu</option>
								<option value="th_TH">Thai</option>
								<option value="tl_PH">Filipino</option>
								<option value="tr_TR">Turkish</option>
								<option value="uk_UA">Ukrainian</option>
								<option value="ur_PK">Urdu</option>
								<option value="vi_VN">Vietnamese</option>
								<option value="zh_CN">Simplified Chinese (China)</option>
								<option value="zh_HK">Traditional Chinese (Hong Kong)</option>
								<option value="zh_TW">Traditional Chinese (Taiwan)</option>
							</select>
						</td>
					</tr>
					<!-- Custom CSS -->
					<tr>
						<td class="col_key">
							<label for="css">Custom CSS:</label>
						</td>
						<td class="col_value">
							<textarea name="css" id="css"><?php if(isset($params->css)) echo $params->css; ?></textarea>
						</td>
					</tr>
					</tbody>
				</table>

				<!-- Share button table -->
				<table class="adminlist table" id="sharebutton_table">
					<tbody>
						<!-- share render -->
						<tr>
							<td class="col_key">
								<label for="share_render">
									Render:
								</label>
							</td>
							<td class="col_value">
								<select name="share_render" id="share_render">
									<option value="html5" <?php  if(isset($params->share_render) && $params->share_render=="html5") echo "selected='selected'"; ?>>HTML5
									</option>
									<option value="xfbml" <?php  if(isset($params->share_render) && $params->share_render=="xfbml") echo "selected='selected'"; ?>>XFBML
									</option>
								</select>
							</td>
						</tr>
						<!-- share layout -->
						<tr>
							<td class="col_key">
								<label for="share_layout">
									Layout:
								</label>
							</td>
							<td class="col_value">
								<select name="share_layout" id="share_layout">
									<option value="button" <?php  if(isset($params->share_layout) && $params->share_layout=="button") echo "selected='selected'"; ?> >Button
									</option>
									<option value="box_count" <?php  if(isset($params->share_layout) && $params->share_layout=="box_count") echo "selected='selected'"; ?> >Box count
									</option>
									<option value="button_count" <?php  if(isset($params->share_layout) && $params->share_layout=="button_count") echo "selected='selected'"; ?>>Button count
									</option>
									<option value="link" <?php  if(isset($params->share_layout) && $params->share_layout=="link") echo "selected='selected'"; ?>>Link
									</option>
									<option value="icon_link"  <?php  if(isset($params->share_layout) && $params->share_layout=="icon_link") echo "selected='selected'"; ?> >Icon and link
									</option>
									<option value="icon" <?php  if(isset($params->share_layout) && $params->share_layout=="icon") echo "selected='selected'"; ?>>Icon
									</option>
								</select>
							</td>
						</tr>
						<!-- share width -->
						<tr>
							<td class="col_key">
								<label for="share_width">
								Width:
								</label>
							</td>
							<td class="col_value">
								<input type="text" name="share_width" id="share_width"  value="<?php if(isset($params->share_width)) echo $params->share_width; ?>"/>
							</td>
						</tr>
						<!-- share language -->
						<tr>
							<td class="col_key">
								<label for="share_language">
									Language:
								</label>
							</td>
							<td class="col_value">
								<select name="share_language" id="share_language">
									<option value="af_ZA">Afrikaans</option>
									<option value="ar_AR">Arabic</option>
									<option value="az_AZ">Azerbaijani</option><option value="be_BY">Belarusian</option>
									<option value="bg_BG">Bulgarian</option>
									<option value="bn_IN">Bengali</option>
									<option value="bs_BA">Bosnian</option>
									<option value="ca_ES">Catalan</option>
									<option value="cs_CZ">Czech</option>
									<option value="cx_PH">Cebuano</option>
									<option value="cy_GB">Welsh</option>
									<option value="da_DK">Danish</option>
									<option value="de_DE">German</option>
									<option value="el_GR">Greek</option>
									<option value="en_GB">English (UK)</option>
									<option value="en_PI">English (Pirate)</option>
									<option value="en_UD">English (Upside Down)</option>
									<option value="en_US">English (US)</option>
									<option value="eo_EO">Esperanto</option>
									<option value="es_ES">Spanish (Spain)</option>
									<option value="es_LA">Spanish</option>
									<option value="et_EE">Estonian</option>
									<option value="eu_ES">Basque</option>
									<option value="fa_IR">Persian</option>
									<option value="fb_LT">Leet Speak</option>
									<option value="fi_FI">Finnish</option>
									<option value="fo_FO">Faroese</option>
									<option value="fr_CA">French (Canada)</option>
									<option value="fr_FR">French (France)</option>
									<option value="fy_NL">Frisian</option>
									<option value="ga_IE">Irish</option>
									<option value="gl_ES">Galician</option>
									<option value="gn_PY">Guarani</option>
									<option value="he_IL">Hebrew</option>
									<option value="hi_IN">Hindi</option>
									<option value="hr_HR">Croatian</option>
									<option value="hu_HU">Hungarian</option>
									<option value="hy_AM">Armenian</option>
									<option value="id_ID">Indonesian</option>
									<option value="is_IS">Icelandic</option>
									<option value="it_IT">Italian</option>
									<option value="ja_JP">Japanese</option>
									<option value="jv_ID">Javanese</option>
									<option value="ka_GE">Georgian</option>
									<option value="km_KH">Khmer</option>
									<option value="kn_IN">Kannada</option>
									<option value="ko_KR">Korean</option>
									<option value="ku_TR">Kurdish</option>
									<option value="la_VA">Latin</option>
									<option value="lt_LT">Lithuanian</option>
									<option value="lv_LV">Latvian</option>
									<option value="mk_MK">Macedonian</option>
									<option value="ml_IN">Malayalam</option>
									<option value="ms_MY">Malay</option>
									<option value="nb_NO">Norwegian (bokmal)</option>
									<option value="ne_NP">Nepali</option>
									<option value="nl_NL">Dutch</option>
									<option value="nn_NO">Norwegian (nynorsk)</option>
									<option value="pa_IN">Punjabi</option>
									<option value="pl_PL">Polish</option>
									<option value="ps_AF">Pashto</option>
									<option value="pt_BR">Portuguese (Brazil)</option>
									<option value="pt_PT">Portuguese (Portugal)</option>
									<option value="ro_RO">Romanian</option>
									<option value="ru_RU">Russian</option>
									<option value="si_LK">Sinhala</option>
									<option value="sk_SK">Slovak</option>
									<option value="sl_SI">Slovenian</option>
									<option value="sq_AL">Albanian</option>
									<option value="sr_RS">Serbian</option>
									<option value="sv_SE">Swedish</option>
									<option value="sw_KE">Swahili</option>
									<option value="ta_IN">Tamil</option>
									<option value="te_IN">Telugu</option>
									<option value="th_TH">Thai</option>
									<option value="tl_PH">Filipino</option>
									<option value="tr_TR">Turkish</option>
									<option value="uk_UA">Ukrainian</option>
									<option value="ur_PK">Urdu</option>
									<option value="vi_VN">Vietnamese</option>
									<option value="zh_CN">Simplified Chinese (China)</option>
									<option value="zh_HK">Traditional Chinese (Hong Kong)</option>
									<option value="zh_TW">Traditional Chinese (Taiwan)</option>
								</select>
							</td>
						</tr>
						<!-- share Custom CSS -->
						<tr>
							<td class="col_key">
								<label for="share_css">
									Custom CSS:
								</label>
							</td>
							<td class="col_value">
								<textarea name="share_css" id="share_css"><?php if(isset($params->share_css)) echo $params->share_css; ?>
								</textarea>
							</td>
						</tr>  
					</tbody>
				</table>
				
				<!-- Comment box table -->
				<table class="adminlist table" id="comment_table">
					<tbody>
						<!-- Comment render -->
						<tr>
							<td class="col_key">
								<label for="comment_render">Render:</label>
							</td>
							<td class="col_value">
								<select name="comment_render" id="comment_render">
									<option value="html5" <?php  if(isset($params->comment_render) && $params->comment_render=="html5") echo "selected='selected'"; ?> >HTML5</option>
									<option value="xfbml" <?php  if(isset($params->comment_render) && $params->comment_render=="xfbml") echo "selected='selected'"; ?> >XFBML</option>
								</select>
							</td>
						</tr>
						<!-- Comment width -->
						<tr>
							<td class="col_key">
								<label for="comment_width"> Width:</label>
							</td>
							<td class="col_value">
								<input type="text" name="comment_width" id="comment_width"  value="<?php if(isset($params->comment_width)) echo $params->comment_width; ?>"/> 
							</td>
						</tr>
						<!-- Comment number of posts -->
						<tr>
							<td class="col_key">
								<label for="comment_number"> Number of comments:</label>
							</td>
							<td class="col_value">
								<input type="text" name="comment_number" id="comment_number"  value="<?php if(isset($params->comment_number)) echo $params->comment_number; ?>"/> 
							</td>
						</tr>
						<!-- Comment order by -->
						<tr>
							<td class="col_key">
								<label for="comment_order">Order by:</label>
							</td>
							<td class="col_value">
								<select name="comment_order" id="comment_order">
									<option value="social" <?php  if(isset($params->comment_order) && $params->comment_order=="social") echo "selected='selected'"; ?> >Social</option>
									 
									<option value="reverse_time" <?php  if(isset($params->comment_order) && $params->comment_order=="reverse_time") echo "selected='selected'"; ?> >Reverse time</option>
									 
									<option value="time" <?php  if(isset($params->comment_order) && $params->comment_order=="time") echo "selected='selected'"; ?> >Time</option>
								</select>
							</td>
						</tr>
						<!-- Comment colorscheme -->
						<tr>
							<td class="col_key">
								<label for="comment_colorscheme">Color scheme:</label>
							</td>
							<td class="col_value">
								<select name="comment_colorscheme" id="comment_colorscheme">
									<option value="light" <?php  if(isset($params->comment_colorscheme) && $params->comment_colorscheme=="light") echo "selected='selected'"; ?> >Light</option>
									<option value="dark" <?php  if(isset($params->comment_colorscheme) && $params->comment_colorscheme=="dark") echo "selected='selected'"; ?> >Dark</option>
								</select>
							</td>
						</tr>
						<!-- Comment moblie -->
						<tr>
							<td class="col_key">
								<label>Show mobile-optimized version:</label>
							</td>
							<td class="col_value">
								<label for="comment_mobile_1" class="first_radio"><input type="radio"    class="ays_radio" name="comment_mobile" id="comment_mobile_1"  value="1" <?php  if(isset($params->comment_mobile) && $params->comment_mobile=='1') echo "checked='checked'"; ?>/> Yes </label>
								
								<label for="comment_mobile_0"><input type="radio" class="ays_radio" name="comment_mobile" id="comment_mobile_0"  value="0" <?php  if((isset($params->comment_mobile) && $params->comment_mobile=='0') || !isset($params->comment_mobile) ) echo "checked='checked'"; ?>/> No </label>
							</td>
						</tr>		
						<!-- Comment language -->
						<tr>
							<td class="col_key">
								<label for="comment_language">Language:</label>
							</td>
							<td class="col_value">
								<select name="comment_language" id="comment_language">
									<option value="af_ZA">Afrikaans</option>
									<option value="ar_AR">Arabic</option>
									<option value="az_AZ">Azerbaijani</option>
									<option value="be_BY">Belarusian</option>
									<option value="bg_BG">Bulgarian</option>
									<option value="bn_IN">Bengali</option>
									<option value="bs_BA">Bosnian</option>
									<option value="ca_ES">Catalan</option>
									<option value="cs_CZ">Czech</option>
									<option value="cx_PH">Cebuano</option>
									<option value="cy_GB">Welsh</option>
									<option value="da_DK">Danish</option>
									<option value="de_DE">German</option>
									<option value="el_GR">Greek</option>
									<option value="en_GB">English (UK)</option>
									<option value="en_PI">English (Pirate)</option>
									<option value="en_UD">English (Upside Down)</option>
									<option value="en_US">English (US)</option>
									<option value="eo_EO">Esperanto</option>
									<option value="es_ES">Spanish (Spain)</option>
									<option value="es_LA">Spanish</option>
									<option value="et_EE">Estonian</option>
									<option value="eu_ES">Basque</option>
									<option value="fa_IR">Persian</option>
									<option value="fb_LT">Leet Speak</option>
									<option value="fi_FI">Finnish</option>
									<option value="fo_FO">Faroese</option>
									<option value="fr_CA">French (Canada)</option>
									<option value="fr_FR">French (France)</option>
									<option value="fy_NL">Frisian</option>
									<option value="ga_IE">Irish</option>
									<option value="gl_ES">Galician</option>
									<option value="gn_PY">Guarani</option>
									<option value="he_IL">Hebrew</option>
									<option value="hi_IN">Hindi</option>
									<option value="hr_HR">Croatian</option>
									<option value="hu_HU">Hungarian</option>
									<option value="hy_AM">Armenian</option>
									<option value="id_ID">Indonesian</option>
									<option value="is_IS">Icelandic</option>
									<option value="it_IT">Italian</option>
									<option value="ja_JP">Japanese</option>
									<option value="jv_ID">Javanese</option>
									<option value="ka_GE">Georgian</option>
									<option value="km_KH">Khmer</option>
									<option value="kn_IN">Kannada</option>
									<option value="ko_KR">Korean</option>
									<option value="ku_TR">Kurdish</option>
									<option value="la_VA">Latin</option>
									<option value="lt_LT">Lithuanian</option>
									<option value="lv_LV">Latvian</option>
									<option value="mk_MK">Macedonian</option>
									<option value="ml_IN">Malayalam</option>
									<option value="ms_MY">Malay</option>
									<option value="nb_NO">Norwegian (bokmal)</option>
									<option value="ne_NP">Nepali</option>
									<option value="nl_NL">Dutch</option>
									<option value="nn_NO">Norwegian (nynorsk)</option>
									<option value="pa_IN">Punjabi</option>
									<option value="pl_PL">Polish</option>
									<option value="ps_AF">Pashto</option>
									<option value="pt_BR">Portuguese (Brazil)</option>
									<option value="pt_PT">Portuguese (Portugal)</option>
									<option value="ro_RO">Romanian</option>
									<option value="ru_RU">Russian</option>
									<option value="si_LK">Sinhala</option>
									<option value="sk_SK">Slovak</option>
									<option value="sl_SI">Slovenian</option>
									<option value="sq_AL">Albanian</option>
									<option value="sr_RS">Serbian</option>
									<option value="sv_SE">Swedish</option>
									<option value="sw_KE">Swahili</option>
									<option value="ta_IN">Tamil</option>
									<option value="te_IN">Telugu</option>
									<option value="th_TH">Thai</option>
									<option value="tl_PH">Filipino</option>
									<option value="tr_TR">Turkish</option>
									<option value="uk_UA">Ukrainian</option>
									<option value="ur_PK">Urdu</option>
									<option value="vi_VN">Vietnamese</option>
									<option value="zh_CN">Simplified Chinese (China)</option>
									<option value="zh_HK">Traditional Chinese (Hong Kong)</option>
									<option value="zh_TW">Traditional Chinese (Taiwan)</option>
								</select>
							</td>
						</tr>	
						<!-- Comment Custom CSS -->
						<tr>
							<td class="col_key">
								<label for="comment_css">Custom CSS:</label>
							</td>
							<td class="col_value">
								 <textarea name="comment_css" id="comment_css"><?php if(isset($params->comment_css)) echo $params->comment_css; ?></textarea>
							 </td>
						</tr>
					</tbody>
				</table>

				<!-- Twitter button table -->
				<table class="adminlist table" id="twitterbutton_table">
					<tbody>
						<!-- Twitter button count box -->
						<tr>
							<td class="col_key">
								<label for="twitterbutton_count">Positioning the count box:</label>
							</td>
							<td class="col_value">
								<select name="twitterbutton_count" id="twitterbutton_count">
									<option value="horizontal" <?php  if(isset($params->twitterbutton_count) && $params->twitterbutton_count=="horizontal") echo "selected='selected'"; ?> >Horizontal</option>
									<option value="vertical" <?php  if(isset($params->twitterbutton_count) && $params->twitterbutton_count=="vertical") echo "selected='selected'"; ?> >Vertical</option>
									<option value="none" <?php  if(isset($params->twitterbutton_count) && $params->twitterbutton_count=="none") echo "selected='selected'"; ?> >None</option>
								</select>
							</td>
						</tr>
						<!-- Twitter button size -->
						<tr>
							<td class="col_key">
								<label for="twitterbutton_size">Size:</label>
							</td>
							<td class="col_value">
								<select name="twitterbutton_size" id="twitterbutton_size">
									<option value="medium" <?php  if(isset($params->twitterbutton_size) && $params->twitterbutton_size=="medium") echo "selected='selected'"; ?> >Medium</option>
									<option value="large" <?php  if(isset($params->twitterbutton_size) && $params->twitterbutton_size=="large") echo "selected='selected'"; ?> >Large</option>	
								</select>
							</td>
						</tr>	
						<!-- Twitter screen name -->
						<tr>
							<td class="col_key">
								<label for="twitterbutton_via">Your Twitter screen name:</label>
							</td>
							<td class="col_value">
								<input type="text" name="twitterbutton_via" id="twitterbutton_via"  value="<?php if(isset($params->twitterbutton_via)) echo $params->twitterbutton_via; ?>"/> 
							</td>
						</tr>
						<!-- Twitter Tweet text -->
						<tr>
							<td class="col_key">
								<label for="twitterbutton_text">Tweet text:</label>
							</td>
							<td class="col_value">
								<input type="text" name="twitterbutton_text" id="twitterbutton_text"  value="<?php if(isset($params->twitterbutton_text)) echo $params->twitterbutton_text; ?>"/> 
							</td>
						</tr>
						<!-- Twitter button language -->
						<tr>
							<td class="col_key">
								<label for="twitterbutton_language">Language:</label>
							</td>
							<td class="col_value">
								<select name="twitterbutton_language" id="twitterbutton_language">
									<option value="fr">French - français</option>
									<option value="en">English</option>
									<option value="ar">Arabic - العربية</option>
									<option value="ja">Japanese - 日本語</option>
									<option value="es">Spanish - Español</option>
									<option value="de">German - Deutsch</option>
									<option value="it">Italian - Italiano</option>
									<option value="id">Indonesian - Bahasa Indonesia</option>
									<option value="pt">Portuguese - Português</option>
									<option value="ko">Korean - 한국어</option>
									<option value="tr">Turkish - Türkçe</option>
									<option value="ru">Russian - Русский</option>
									<option value="nl">Dutch - Nederlands</option>
									<option value="fil">Filipino - Filipino</option>
									<option value="msa">Malay - Bahasa Melayu</option>
									<option value="zh-tw">Traditional Chinese - 繁體中文</option>
									<option value="zh-cn">Simplified Chinese - 简体中文</option>
									<option value="hi">Hindi - हिन्दी</option>
									<option value="no">Norwegian - Norsk</option>
									<option value="sv">Swedish - Svenska</option>
									<option value="fi">Finnish - Suomi</option>
									<option value="da">Danish - Dansk</option>
									<option value="pl">Polish - Polski</option>
									<option value="hu">Hungarian - Magyar</option>
									<option value="fa">Farsi - فارسی</option>
									<option value="he">Hebrew - עִבְרִית</option>
									<option value="ur">Urdu - اردو</option>
									<option value="th">Thai - ภาษาไทย</option>
								</select>
							</td>
						</tr>		
						<!-- Twitter button Custom CSS -->
						<tr>
							<td class="col_key">
								<label for="twitterbutton_css">Custom CSS:</label>
							</td>
							<td class="col_value">
								<textarea name="twitterbutton_css" id="twitterbutton_css"><?php if(isset($params->twitterbutton_css)) echo $params->twitterbutton_css; ?></textarea>
							 </td>
						</tr>
					</tbody>
				</table>
				<!-- Google + button table -->
				<table class="adminlist table" id="google_table">
					<tbody>
						<!-- Google + button count box -->
						<tr>
							<td class="col_key">
								<label for="google_count">Positioning the count box:</label>
							</td>
							<td class="col_value">
								<select name="google_count" id="google_count">
									<option value="bubble" <?php  if(isset($params->google_count) && $params->google_count=="bubble") echo "selected='selected'"; ?> >Horizontal</option>
									<option value="vertical-bubble" <?php  if(isset($params->google_count) && $params->google_count=="vertical-bubble") echo "selected='selected'"; ?> >Vertical</option>
									<option value="none" <?php  if(isset($params->google_count) && $params->google_count=="none") echo "selected='selected'"; ?> >None</option>
								</select>
							</td>
						</tr>
						<!-- Google +  button size -->
						<tr>
							<td class="col_key">
								<label for="google_size">Size:</label>
							</td>
							<td class="col_value">
								<select name="google_size" id="google_size">
									<option value="20" <?php  if(isset($params->google_size) && $params->google_size=="20") echo "selected='selected'"; ?> >Medium</option>
									<option value="15" <?php  if(isset($params->google_size) && $params->google_size=="15") echo "selected='selected'"; ?> >Small</option>
									<option value="24" <?php  if(isset($params->google_size) && $params->google_size=="24") echo "selected='selected'"; ?> >Tall</option>
								</select>
							</td>
						</tr>		
						<!-- Google + language -->
						<tr>
							<td class="col_key">
								<label for="google_language">Language:</label>
							</td>
							<td class="col_value">
								<select name="google_language" id="google_language">
									<option value="af">Afrikaans</option>
									<option value="am">Amharic</option>
									<option value="ar">Arabic</option>
									<option value="eu">Basque</option>
									<option value="bn">Bengali</option>
									<option value="bg">Bulgarian</option>
									<option value="ca">Catalan</option>
									<option value="zh-HK">Chinese (Hong Kong)</option>
									<option value="zh-CN">Chinese (Simplified)</option>
									<option value="zh-TW">Chinese (Traditional)</option>
									<option value="">Croatian</option>
									<option value="cs">Czech</option>
									<option value="da">Danish</option>
									<option value="nl">Dutch</option>
									<option value="en-GB">English (UK)</option>
									<option value="en-US">English (US)</option>
									<option value="et">Estonian</option>
									<option value="fil">Filipino</option>
									<option value="fi">Finnish</option>
									<option value="fr">French</option>
									<option value="fr-CA">French (Canadian)</option>
									<option value="gl">Galician</option>
									<option value="de">German</option>
									<option value="el">Greek</option>
									<option value="gu">Gujarati</option>
									<option value="iw">Hebrew</option>
									<option value="hi">Hindi</option>
									<option value="hu">Hungarian</option>
									<option value="is">Icelandic</option>
									<option value="id">Indonesian</option>
									<option value="it">Italian</option>
									<option value="ja">Japanese</option>
									<option value="kn">Kannada</option>
									<option value="ko">Korean</option>
									<option value="lv">Latvian</option>
									<option value="lt">Lithuanian</option>
									<option value="ms">Malay</option>
									<option value="ml">Malayalam</option>
									<option value="mr">Marathi</option>
									<option value="no">Norwegian</option>
									<option value="fa">Persian</option>
									<option value="pl">Polish</option>
									<option value="pt-BR">Portuguese (Brazil)</option>
									<option value="pt-PT">Portuguese (Portugal)</option>
									<option value="ro">Romanian</option>
									<option value="ru">Russian</option>
									<option value="sr">Serbian</option>
									<option value="sk">Slovak</option>
									<option value="sl">Slovenian</option>
									<option value="es">Spanish</option>
									<option value="es-419">Spanish (Latin America)</option>
									<option value="sw">Swahili</option>
									<option value="sv">Swedish</option>
									<option value="ta">Tamil</option>
									<option value="te">Telugu</option>
									<option value="th">Thai</option>
									<option value="tr">Turkish</option>
									<option value="uk">Ukrainian</option>
									<option value="ur">Urdu</option>
									<option value="vi">Vietnamese</option>
									<option value="zu">Zulu</option>
								</select>
							</td>
						</tr>
						<!-- Google + Custom CSS -->
						<tr>
							<td class="col_key">
								<label for="google_css">Custom CSS:</label>
							</td>
							<td class="col_value">
								 <textarea name="google_css" id="google_css"><?php if(isset($params->google_css)) echo $params->google_css; ?></textarea>
							 </td>
						</tr>
					</tbody>
				</table>
				<!-- LikedIn  button table -->
				<table class="adminlist table" id="linkedin_table">
					<tbody>
						<!-- LikedIn button count box -->
						<tr>
							<td class="col_key">
								<label for="linkedin_count">Positioning the count box:</label>
							</td>
							<td class="col_value">
								<select name="linkedin_count" id="linkedin_count">
									<option value="right" <?php  if(isset($params->linkedin_count) && $params->linkedin_count=="right") echo "selected='selected'"; ?> >Horizontal</option>
									<option value="top" <?php  if(isset($params->linkedin_count) && $params->linkedin_count=="top") echo "selected='selected'"; ?> >Vertical</option>
									<option value="none" <?php  if(isset($params->linkedin_count) && $params->linkedin_count=="none") echo "selected='selected'"; ?> >None</option>
								</select>
							</td>
						</tr>		
						<!-- LikedIn language -->
						<tr>
							<td class="col_key">
								<label for="linkedin_language">Language:</label>
							</td>
							<td class="col_value">
								<select name="linkedin_language" id="linkedin_language">
									<option value="en_US">English</option>
									<option value="ar_AE">Arabic</option>
									<option value="zh-CN">Chinese - Simplified</option>
									<option value="zh-TW">Chinese - Traditional</option>
									<option value="cs_CZ">Czech</option>
									<option value="da_DK">Danish</option>
									<option value="nl_NL">Dutch</option>
									<option value="fr_FR">French</option>
									<option value="de_DE">German</option>
									<option value="in_ID">Indonesian</option>
									<option value="it_IT">Italian</option>
									<option value="ja_JP">Japanese</option>
									<option value="ko_KR">Korean</option>
									<option value="ms_MY">Malay</option>
									<option value="no_NO">Norwegian</option>
									<option value="pl_PL">Polish</option>
									<option value="pt_BR">Portuguese</option>
									<option value="ro_RO">Romanian</option>
									<option value="ru_RU">Russian</option>  
									<option value="es_ES">Spanish</option>
									<option value="sv_SE">Swedish</option>
									<option value="tl_PH">Tagalog</option>
									<option value="th-TH">Thai</option>
									<option value="tr_TR">Turkish</option>
								</select>
							</td>
						</tr>
						<!-- LikedIn Custom CSS -->
						<tr>
							<td class="col_key">
								<label for="linkedin_css">Custom CSS:</label>
							</td>
							<td class="col_value">
								<textarea name="linkedin_css" id="linkedin_css"><?php if(isset($params->linkedin_css)) echo $params->linkedin_css; ?></textarea>
							 </td>
						</tr>
					</tbody>
				</table>
				<!-- VK share  button table -->
				<table class="adminlist table" id="vk_table">
					<tbody>
						<!-- VK share button count box -->
						<tr>
							<td class="col_key">
								<label for="vk_count">Style:</label>
							</td>
							<td class="col_value">
								<select name="vk_count" id="vk_count">
									<option value="round" <?php  if(isset($params->vk_count) && $params->vk_count=="round") echo "selected='selected'"; ?> >Button</option>
									<option value="round_nocount" <?php  if(isset($params->vk_count) && $params->vk_count=="round_nocount") echo "selected='selected'"; ?> >Button without a Counter</option>
									<option value="link" <?php  if(isset($params->vk_count) && $params->vk_count=="link") echo "selected='selected'"; ?> >	Link</option>
									<option value="link_noicon" <?php  if(isset($params->vk_count) && $params->vk_count=="link_noicon") echo "selected='selected'"; ?> >	Link without an Icon</option>
									<option value="custom" <?php  if(isset($params->vk_count) && $params->vk_count=="custom") echo "selected='selected'"; ?> >	Icon</option>
								</select>
							</td>
						</tr>
						<!--  VK share button text -->
						<tr>
							<td class="col_key">
								<label for="vk_text">Text:</label>
							</td>
							<td class="col_value">
								<input type="text" name="vk_text" id="vk_text"  value="<?php if(isset($params->vk_text) && $params->vk_text!='') echo $params->vk_text; else echo 'Share'; ?>"/> 
							</td>
						</tr>
						<!-- VK share button language -->
						<tr>
							<td class="col_key">
								<label for="vk_language">Language:</label>
							</td>
							<td class="col_value">
								<select name="vk_language" id="vk_language">
									<option value="english" <?php  if(isset($params->vk_language) && $params->vk_language=="english") echo "selected='selected'"; ?> >English</option>
									<option value="russian" <?php  if(isset($params->vk_language) && $params->vk_language=="russian") echo "selected='selected'"; ?> >Russian</option>
								</select>
							</td>
						</tr>
						<!-- VK share button Custom CSS -->
						<tr>
							<td class="col_key">
								<label for="vk_css">Custom CSS:</label>
							</td>
							<td class="col_value">
								<textarea name="vk_css" id="vk_css"><?php if(isset($params->vk_css)) echo $params->vk_css; ?></textarea>
							 </td>
						</tr>
					</tbody>
				</table>
				<!-- Social buttons table -->
				<table class="adminlist table" id="social_buttons_table" cellspacing="10">
					<tbody>
						<!-- Social buttons icons -->
						<tr id="social_buttons_area">	 
							<!-- Social Like Button table -->
							<td class="button_area" id = "likebutton_params" active="1" but="likebutton" >
								<p class="active_icon">
								<span class="social_show_1"  onclick="activate('likebutton',1);" id="likebutton_social_show">Show</span>
								<span class="social_hide_0"  onclick="activate('likebutton',0);" id="likebutton_social_hide">Hide</span>
								</p>
								<table id="likebutton_social_table">
									<tr>
										<td colspan="2" class="col_key">
											Like Button
										</td>
									</tr>
								   <!-- render -->
									<tr>
										<td class="col_key">
											<label for="s_likebutton_render">Render:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_likebutton_render" id="s_likebutton_render">
												<option value="html5" <?php  if(isset($params->s_likebutton_render) && $params->s_likebutton_render=="html5") echo "selected='selected'"; ?> >HTML5</option>
												<option value="xfbml" <?php  if(isset($params->s_likebutton_render) && $params->s_likebutton_render=="xfbml") echo "selected='selected'"; ?> >XFBML</option>
												<option value="iframe" <?php  if(isset($params->s_likebutton_render) && $params->s_likebutton_render=="iframe") echo "selected='selected'"; ?> >IFRAME</option>
											</select>
										</td>
									</tr>
									<!-- layout -->
									<tr>
										<td class="col_key">
											<label for="s_likebutton_layout">Layout:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_likebutton_layout" id="s_likebutton_layout">
												<option value="box_count" <?php  if(isset($params->s_likebutton_layout) && $params->s_likebutton_layout=="box_count") echo "selected='selected'"; ?> >Box count</option>
												 <option value="button_count" <?php  if(isset($params->s_likebutton_layout) && $params->s_likebutton_layout=="button_count") echo "selected='selected'"; ?> >Button count</option>
												<option value="button" <?php  if(isset($params->s_likebutton_layout) && $params->s_likebutton_layout=="button") echo "selected='selected'"; ?> >Button</option>
											</select>
										</td>
									</tr>
									<!-- share button include -->
									<tr>
										<td class="col_key">
											<label>Include share button:</label>
										</td>
									</tr> 
									<tr>
										<td class="col_value">
											<label for="s_likebutton_include_share_1"  class="first_radio" ><input type="radio"  class="ays_radio" name="s_likebutton_include_share" id="s_likebutton_include_share_1"  value="1" <?php  if((isset($params->s_likebutton_include_share) && $params->s_likebutton_include_share=='1') || !isset($params->s_likebutton_include_share)) echo "checked='checked'"; ?>/> Yes </label>
											<label for="s_likebutton_include_share_0"><input type="radio" class="ays_radio" name="s_likebutton_include_share" id="s_likebutton_include_share_0"  value="0" <?php  if(isset($params->s_likebutton_include_share) && $params->s_likebutton_include_share=='0') echo "checked='checked'"; ?>/> No </label>
										</td>
									</tr>		
									<!-- width -->
									<tr>
										<td class="col_key">
											<label for="s_likebutton_width">Width:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<input type="text" name="s_likebutton_width" id="s_likebutton_width"  value="<?php  if(isset($params->s_likebutton_width)) echo $params->s_likebutton_width; ?>"/> 
										</td>
									</tr>
									<!-- verb -->
									<tr>
										<td class="col_key">
											<label for="s_likebutton_verb">Button verb:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_likebutton_verb" id="s_likebutton_verb">
												 <option value="like" <?php  if(isset($params->s_likebutton_verb) && $params->s_likebutton_verb=="like") echo "selected='selected'"; ?> >Like</option>
												 <option value="recommend" <?php  if(isset($params->s_likebutton_verb) && $params->s_likebutton_verb=="recommend") echo "selected='selected'"; ?> >Recommend</option>
											</select>
										</td>
									</tr>	
								   <!-- colorscheme -->
									<tr>
										<td class="col_key">
											<label for="s_likebutton_colorscheme">Color scheme:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_likebutton_colorscheme" id="s_likebutton_colorscheme">
												<option value="light" <?php  if(isset($params->s_likebutton_colorscheme) && $params->s_likebutton_colorscheme=="light") echo "selected='selected'"; ?> >Light</option>
												<option value="dark" <?php  if(isset($params->s_likebutton_colorscheme) && $params->s_likebutton_colorscheme=="dark") echo "selected='selected'"; ?> >Dark</option>
											</select>
										</td>
									</tr>
									<!-- language -->
									<tr>
										<td class="col_key_title">
											<label for="s_likebutton_language">Language:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_likebutton_language" id="s_likebutton_language">
												<option value="af_ZA">Afrikaans</option>
												<option value="ar_AR">Arabic</option>
												<option value="az_AZ">Azerbaijani</option>
												<option value="be_BY">Belarusian</option>
												<option value="bg_BG">Bulgarian</option>
												<option value="bn_IN">Bengali</option>
												<option value="bs_BA">Bosnian</option>
												<option value="ca_ES">Catalan</option>
												<option value="cs_CZ">Czech</option>
												<option value="cx_PH">Cebuano</option>
												<option value="cy_GB">Welsh</option>
												<option value="da_DK">Danish</option>
												<option value="de_DE">German</option>
												<option value="el_GR">Greek</option>
												<option value="en_GB">English (UK)</option>
												<option value="en_PI">English (Pirate)</option>
												<option value="en_UD">English (Upside Down)</option>
												<option value="en_US">English (US)</option>
												<option value="eo_EO">Esperanto</option>
												<option value="es_ES">Spanish (Spain)</option>
												<option value="es_LA">Spanish</option>
												<option value="et_EE">Estonian</option>
												<option value="eu_ES">Basque</option>
												<option value="fa_IR">Persian</option>
												<option value="fb_LT">Leet Speak</option>
												<option value="fi_FI">Finnish</option>
												<option value="fo_FO">Faroese</option>
												<option value="fr_CA">French (Canada)</option>
												<option value="fr_FR">French (France)</option>
												<option value="fy_NL">Frisian</option>
												<option value="ga_IE">Irish</option>
												<option value="gl_ES">Galician</option>
												<option value="gn_PY">Guarani</option>
												<option value="he_IL">Hebrew</option>
												<option value="hi_IN">Hindi</option>
												<option value="hr_HR">Croatian</option>
												<option value="hu_HU">Hungarian</option>
												<option value="hy_AM">Armenian</option>
												<option value="id_ID">Indonesian</option>
												<option value="is_IS">Icelandic</option>
												<option value="it_IT">Italian</option>
												<option value="ja_JP">Japanese</option>
												<option value="jv_ID">Javanese</option>
												<option value="ka_GE">Georgian</option>
												<option value="km_KH">Khmer</option>
												<option value="kn_IN">Kannada</option>
												<option value="ko_KR">Korean</option>
												<option value="ku_TR">Kurdish</option>
												<option value="la_VA">Latin</option>
												<option value="lt_LT">Lithuanian</option>
												<option value="lv_LV">Latvian</option>
												<option value="mk_MK">Macedonian</option>
												<option value="ml_IN">Malayalam</option>
												<option value="ms_MY">Malay</option>
												<option value="nb_NO">Norwegian (bokmal)</option>
												<option value="ne_NP">Nepali</option>
												<option value="nl_NL">Dutch</option>
												<option value="nn_NO">Norwegian (nynorsk)</option>
												<option value="pa_IN">Punjabi</option>
												<option value="pl_PL">Polish</option>
												<option value="ps_AF">Pashto</option>
												<option value="pt_BR">Portuguese (Brazil)</option>
												<option value="pt_PT">Portuguese (Portugal)</option>
												<option value="ro_RO">Romanian</option>
												<option value="ru_RU">Russian</option>
												<option value="si_LK">Sinhala</option>
												<option value="sk_SK">Slovak</option>
												<option value="sl_SI">Slovenian</option>
												<option value="sq_AL">Albanian</option>
												<option value="sr_RS">Serbian</option>
												<option value="sv_SE">Swedish</option>
												<option value="sw_KE">Swahili</option>
												<option value="ta_IN">Tamil</option>
												<option value="te_IN">Telugu</option>
												<option value="th_TH">Thai</option>
												<option value="tl_PH">Filipino</option>
												<option value="tr_TR">Turkish</option>
												<option value="uk_UA">Ukrainian</option>
												<option value="ur_PK">Urdu</option>
												<option value="vi_VN">Vietnamese</option>
												<option value="zh_CN">Simplified Chinese (China)</option>
												<option value="zh_HK">Traditional Chinese (Hong Kong)</option>
												<option value="zh_TW">Traditional Chinese (Taiwan)</option>
											</select>
										</td>
									</tr>
									<!--  Custom CSS -->
									<tr>
										<td class="col_key">
											<label for="s_likebutton_css">Custom CSS:</label>
										</td>
									<tr>
									</tr>
										<td class="col_value">
											 <textarea name="s_likebutton_css" id="s_likebutton_css"><?php if(isset($params->s_likebutton_css)) echo $params->s_likebutton_css; ?></textarea>
										 </td>
									</tr>	   
								</table>
							</td>
							<!-- Social Share Button table -->
							<td class="button_area" id = "sharebutton_params" active="1" but="sharebutton">
								<p class="active_icon">
									<span class="social_show_1"  onclick="activate('sharebutton',1);" id="sharebutton_social_show">Show</span>
									<span class="social_hide_0"  onclick="activate('sharebutton',0);" id="sharebutton_social_hide">Hide</span>
								</p>
								<table id="sharebutton_social_table">
									<tr>
										<td colspan="2" class="col_key">
											 Share Button
										</td>
									</tr>
									<!-- share render -->
									<tr>
										<td class="col_key">
											<label for="s_share_render">Render:</label>
										</td>
										</tr> <tr><td class="col_value">
											<select name="s_share_render" id="s_share_render">
												<option value="html5" <?php  if(isset($params->s_share_render) && $params->s_share_render=="html5") echo "selected='selected'"; ?> >HTML5</option>
												<option value="xfbml" <?php  if(isset($params->s_share_render) && $params->s_share_render=="xfbml") echo "selected='selected'"; ?> >XFBML</option>
											</select>
										</td>
									</tr>
									<!-- share layout -->
									<tr>
										<td class="col_key">
											<label for="s_share_layout">Layout:</label>
										</td>
										</tr> <tr><td class="col_value">
											<select name="s_share_layout" id="s_share_layout">
												<option value="button" <?php  if(isset($params->s_share_layout) && $params->s_share_layout=="button") echo "selected='selected'"; ?> >Button</option>
												<option value="box_count" <?php  if(isset($params->s_share_layout) && $params->s_share_layout=="box_count") echo "selected='selected'"; ?> >Box count</option>
												<option value="button_count" <?php  if(isset($params->s_share_layout) && $params->s_share_layout=="button_count") echo "selected='selected'"; ?> >Button count</option>
												<option value="link" <?php  if(isset($params->s_share_layout) && $params->s_share_layout=="link") echo "selected='selected'"; ?> >Link</option>
												<option value="icon_link" <?php  if(isset($params->s_share_layout) && $params->s_share_layout=="icon_link") echo "selected='selected'"; ?> >Icon and link</option>
												<option value="icon" <?php  if(isset($params->s_share_layout) && $params->s_share_layout=="icon") echo "selected='selected'"; ?> >Icon</option>
											</select>
										</td>
									</tr>
									<!-- share width -->
									<tr>
										<td class="col_key">
											<label for="s_share_width"> Width:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<input type="text" name="s_share_width" id="s_share_width"  value="<?php if(isset($params->s_share_width)) echo $params->s_share_width; ?>"/> 
										</td>
									</tr>
									<!-- share language -->
									<tr>
										<td class="col_key">
											<label for="s_share_language">Language:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_share_language" id="s_share_language">
												<option value="af_ZA">Afrikaans</option>
												<option value="ar_AR">Arabic</option>
												<option value="az_AZ">Azerbaijani</option>
												<option value="be_BY">Belarusian</option>
												<option value="bg_BG">Bulgarian</option>
												<option value="bn_IN">Bengali</option>
												<option value="bs_BA">Bosnian</option>
												<option value="ca_ES">Catalan</option>
												<option value="cs_CZ">Czech</option>
												<option value="cx_PH">Cebuano</option>
												<option value="cy_GB">Welsh</option>
												<option value="da_DK">Danish</option>
												<option value="de_DE">German</option>
												<option value="el_GR">Greek</option>
												<option value="en_GB">English (UK)</option>
												<option value="en_PI">English (Pirate)</option>
												<option value="en_UD">English (Upside Down)</option>
												<option value="en_US">English (US)</option>
												<option value="eo_EO">Esperanto</option>
												<option value="es_ES">Spanish (Spain)</option>
												<option value="es_LA">Spanish</option>
												<option value="et_EE">Estonian</option>
												<option value="eu_ES">Basque</option>
												<option value="fa_IR">Persian</option>
												<option value="fb_LT">Leet Speak</option>
												<option value="fi_FI">Finnish</option>
												<option value="fo_FO">Faroese</option>
												<option value="fr_CA">French (Canada)</option>
												<option value="fr_FR">French (France)</option>
												<option value="fy_NL">Frisian</option>
												<option value="ga_IE">Irish</option>
												<option value="gl_ES">Galician</option>
												<option value="gn_PY">Guarani</option>
												<option value="he_IL">Hebrew</option>
												<option value="hi_IN">Hindi</option>
												<option value="hr_HR">Croatian</option>
												<option value="hu_HU">Hungarian</option>
												<option value="hy_AM">Armenian</option>
												<option value="id_ID">Indonesian</option>
												<option value="is_IS">Icelandic</option>
												<option value="it_IT">Italian</option>
												<option value="ja_JP">Japanese</option>
												<option value="jv_ID">Javanese</option>
												<option value="ka_GE">Georgian</option>
												<option value="km_KH">Khmer</option>
												<option value="kn_IN">Kannada</option>
												<option value="ko_KR">Korean</option>
												<option value="ku_TR">Kurdish</option>
												<option value="la_VA">Latin</option>
												<option value="lt_LT">Lithuanian</option>
												<option value="lv_LV">Latvian</option>
												<option value="mk_MK">Macedonian</option>
												<option value="ml_IN">Malayalam</option>
												<option value="ms_MY">Malay</option>
												<option value="nb_NO">Norwegian (bokmal)</option>
												<option value="ne_NP">Nepali</option>
												<option value="nl_NL">Dutch</option>
												<option value="nn_NO">Norwegian (nynorsk)</option>
												<option value="pa_IN">Punjabi</option>
												<option value="pl_PL">Polish</option>
												<option value="ps_AF">Pashto</option>
												<option value="pt_BR">Portuguese (Brazil)</option>
												<option value="pt_PT">Portuguese (Portugal)</option>
												<option value="ro_RO">Romanian</option>
												<option value="ru_RU">Russian</option>
												<option value="si_LK">Sinhala</option>
												<option value="sk_SK">Slovak</option>
												<option value="sl_SI">Slovenian</option>
												<option value="sq_AL">Albanian</option>
												<option value="sr_RS">Serbian</option>
												<option value="sv_SE">Swedish</option>
												<option value="sw_KE">Swahili</option>
												<option value="ta_IN">Tamil</option>
												<option value="te_IN">Telugu</option>
												<option value="th_TH">Thai</option>
												<option value="tl_PH">Filipino</option>
												<option value="tr_TR">Turkish</option>
												<option value="uk_UA">Ukrainian</option>
												<option value="ur_PK">Urdu</option>
												<option value="vi_VN">Vietnamese</option>
												<option value="zh_CN">Simplified Chinese (China)</option>
												<option value="zh_HK">Traditional Chinese (Hong Kong)</option>
												<option value="zh_TW">Traditional Chinese (Taiwan)</option>
											</select>
										</td>
									</tr>	
									<!-- share Custom CSS -->
									<tr>
										<td class="col_key">
											<label for="s_share_css">Custom CSS:</label>
										</td>
									<tr>
									</tr>	
										<td class="col_value">
											<textarea name="s_share_css" id="s_share_css"><?php if(isset($params->s_share_css)) echo $params->s_share_css; ?></textarea>
										 </td>
									</tr>   
								</table>
							</td>
							<!-- Social Tweet Button table -->
							<td class="button_area" id = "twitterbutton_params"  active="1"   but="twitterbutton">
								<p class="active_icon">
									<span class="social_show_1"  onclick="activate('twitterbutton',1);" id="twitterbutton_social_show">Show</span>
									<span class="social_hide_0"  onclick="activate('twitterbutton',0);" id="twitterbutton_social_hide">Hide</span>
								</p>
								<table  id="twitterbutton_social_table">
									<tr>
										<td colspan="2" class="col_key">
											Tweet button
										</td>
								   </tr>
									<!-- Twitter button count box -->
									<tr>
										<td class="col_key">
											<label for="s_twitterbutton_count">Positioning the count box:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_twitterbutton_count" id="s_twitterbutton_count">
												<option value="horizontal" <?php  if(isset($params->s_twitterbutton_count) && $params->s_twitterbutton_count=="horizontal") echo "selected='selected'"; ?> >Horizontal</option>
												<option value="vertical" <?php  if(isset($params->s_twitterbutton_count) && $params->s_twitterbutton_count=="vertical") echo "selected='selected'"; ?> >Vertical</option>
												<option value="none" <?php  if(isset($params->s_twitterbutton_count) && $params->s_twitterbutton_count=="none") echo "selected='selected'"; ?> >None</option>
											</select>
										</td>
									</tr>		
									<!-- Twitter button size -->
									<tr>
										<td class="col_key">
											<label for="s_twitterbutton_size">Size:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_twitterbutton_size" id="s_twitterbutton_size">
												<option value="medium" <?php  if(isset($params->s_twitterbutton_size) && $params->s_twitterbutton_size=="medium") echo "selected='selected'"; ?> >Medium</option>
												<option value="large" <?php  if(isset($params->s_twitterbutton_size) && $params->s_twitterbutton_size=="large") echo "selected='selected'"; ?> >Large</option>		
											</select>
										</td>
									</tr>
									<!-- Twitter screen name -->
									<tr>
										<td class="col_key">
											<label for="s_twitterbutton_via">Your Twitter screen name:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<input type="text" name="s_twitterbutton_via" id="s_twitterbutton_via"  value="<?php if(isset($params->s_twitterbutton_via)) echo $params->s_twitterbutton_via; ?>"/> 		
										</td>
									</tr>
									<!-- Twitter Tweet text -->
									<tr>
										<td class="col_key">
											<label for="s_twitterbutton_text">Tweet text:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<input type="text" name="s_twitterbutton_text" id="s_twitterbutton_text"  value="<?php if(isset($params->s_twitterbutton_text)) echo $params->s_twitterbutton_text; ?>"/> 
										</td>
									</tr>
									<!-- Twitter button language -->
									<tr>
										<td class="col_key">
											<label for="s_twitterbutton_language">Language:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_twitterbutton_language" id="s_twitterbutton_language">
												<option value="fr">French - français</option>
												<option value="en">English</option>
												<option value="ar">Arabic - العربية</option>
												<option value="ja">Japanese - 日本語</option>
												<option value="es">Spanish - Español</option>
												<option value="de">German - Deutsch</option>
												<option value="it">Italian - Italiano</option>
												<option value="id">Indonesian - Bahasa Indonesia</option>
												<option value="pt">Portuguese - Português</option>
												<option value="ko">Korean - 한국어</option>
												<option value="tr">Turkish - Türkçe</option>
												<option value="ru">Russian - Русский</option>
												<option value="nl">Dutch - Nederlands</option>
												<option value="fil">Filipino - Filipino</option>
												<option value="msa">Malay - Bahasa Melayu</option>
												<option value="zh-tw">Traditional Chinese - 繁體中文</option>
												<option value="zh-cn">Simplified Chinese - 简体中文</option>
												<option value="hi">Hindi - हिन्दी</option>
												<option value="no">Norwegian - Norsk</option>
												<option value="sv">Swedish - Svenska</option>
												<option value="fi">Finnish - Suomi</option>
												<option value="da">Danish - Dansk</option>
												<option value="pl">Polish - Polski</option>
												<option value="hu">Hungarian - Magyar</option>
												<option value="fa">Farsi - فارسی</option>
												<option value="he">Hebrew - עִבְרִית</option>
												<option value="ur">Urdu - اردو</option>
												<option value="th">Thai - ภาษาไทย</option>
											</select>
										</td>
									</tr>
									<!-- Twitter button Custom CSS -->
									<tr>
										<td class="col_key">
											<label for="s_twitterbutton_css">Custom CSS:</label>
										</td>
									<tr>
									</tr>
										<td class="col_value">
											<textarea name="s_twitterbutton_css" id="s_twitterbutton_css"><?php if(isset($params->s_twitterbutton_css)) echo $params->s_twitterbutton_css; ?></textarea>
										 </td>
									</tr>
								</table>
							</td>	
							<!-- Social Google + Button table -->
							<td class="button_area" id = "google_params"  active="1"   but="google">
								<p class="active_icon">
									<span class="social_show_1"  onclick="activate('google',1);" id="google_social_show">Show</span>
									<span class="social_hide_0"  onclick="activate('google',0);" id="google_social_hide">Hide</span>
								</p>
								<table id="google_social_table">
									<tr>
										<td colspan="2" class="col_key">
											Google + button
										</td>
									</tr>							
									<!-- Google + button count box -->
									<tr>
										<td class="col_key">
											<label for="s_google_count">Positioning the count box:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_google_count" id="s_google_count">
												<option value="bubble" <?php  if(isset($params->s_google_count) && $params->s_google_count=="bubble") echo "selected='selected'"; ?> >Horizontal</option>
												<option value="vertical-bubble" <?php  if(isset($params->s_google_count) && $params->s_google_count=="vertical-bubble") echo "selected='selected'"; ?> >Vertical</option>
												<option value="none" <?php  if(isset($params->s_google_count) && $params->s_google_count=="none") echo "selected='selected'"; ?> >None</option>
											</select>
										</td>
									</tr>
									<!-- Google +  button size -->
									<tr>
										<td class="col_key">
											<label for="s_google_size">Size:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_google_size" id="s_google_size">
												<option value="20" <?php  if(isset($params->s_google_size) && $params->s_google_size=="20") echo "selected='selected'"; ?> >Medium</option>
												<option value="15" <?php  if(isset($params->s_google_size) && $params->s_google_size=="15") echo "selected='selected'"; ?> >Small</option>
												<option value="24" <?php  if(isset($params->s_google_size) && $params->s_google_size=="24") echo "selected='selected'"; ?> >Tall</option>
											</select>
										</td>
									</tr>	
									<!-- Google + language -->
									<tr>
										<td class="col_key">
											<label for="s_google_language">Language:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_google_language" id="s_google_language">
												<option value="af">Afrikaans</option>
												<option value="am">Amharic</option>
												<option value="ar">Arabic</option>
												<option value="eu">Basque</option>
												<option value="bn">Bengali</option>
												<option value="bg">Bulgarian</option>
												<option value="ca">Catalan</option>
												<option value="zh-HK">Chinese (Hong Kong)</option>
												<option value="zh-CN">Chinese (Simplified)</option>
												<option value="zh-TW">Chinese (Traditional)</option>
												<option value="">Croatian</option>
												<option value="cs">Czech</option>
												<option value="da">Danish</option>
												<option value="nl">Dutch</option>
												<option value="en-GB">English (UK)</option>
												<option value="en-US">English (US)</option>
												<option value="et">Estonian</option>
												<option value="fil">Filipino</option>
												<option value="fi">Finnish</option>
												<option value="fr">French</option>
												<option value="fr-CA">French (Canadian)</option>
												<option value="gl">Galician</option>
												<option value="de">German</option>
												<option value="el">Greek</option>
												<option value="gu">Gujarati</option>
												<option value="iw">Hebrew</option>
												<option value="hi">Hindi</option>
												<option value="hu">Hungarian</option>
												<option value="is">Icelandic</option>
												<option value="id">Indonesian</option>
												<option value="it">Italian</option>
												<option value="ja">Japanese</option>
												<option value="kn">Kannada</option>
												<option value="ko">Korean</option>
												<option value="lv">Latvian</option>
												<option value="lt">Lithuanian</option>
												<option value="ms">Malay</option>
												<option value="ml">Malayalam</option>
												<option value="mr">Marathi</option>
												<option value="no">Norwegian</option>
												<option value="fa">Persian</option>
												<option value="pl">Polish</option>
												<option value="pt-BR">Portuguese (Brazil)</option>
												<option value="pt-PT">Portuguese (Portugal)</option>
												<option value="ro">Romanian</option>
												<option value="ru">Russian</option>
												<option value="sr">Serbian</option>
												<option value="sk">Slovak</option>
												<option value="sl">Slovenian</option>
												<option value="es">Spanish</option>
												<option value="es-419">Spanish (Latin America)</option>
												<option value="sw">Swahili</option>
												<option value="sv">Swedish</option>
												<option value="ta">Tamil</option>
												<option value="te">Telugu</option>
												<option value="th">Thai</option>
												<option value="tr">Turkish</option>
												<option value="uk">Ukrainian</option>
												<option value="ur">Urdu</option>
												<option value="vi">Vietnamese</option>
												<option value="zu">Zulu</option>
											</select>
										</td>
									</tr>			
									<!-- Google +  Custom CSS -->
									<tr>
										<td class="col_key">
											<label for="s_google_css">Custom CSS:</label>
										</td>
									<tr>
									</tr>
										<td class="col_value">
											<textarea name="s_google_css" id="s_google_css"><?php if(isset($params->s_google_css)) echo $params->s_google_css; ?></textarea>
										 </td>
									</tr>
								</table>
							</td>
							<!-- Social LinkedIn Button table -->
							<td class="button_area" id = "linkedin_params"  active="1"   but="linkedin">
								<p class="active_icon">
									<span class="social_show_1"  onclick="activate('linkedin',1);" id="linkedin_social_show">Show</span>
									<span class="social_hide_0"  onclick="activate('linkedin',0);" id="linkedin_social_hide">Hide</span>
								</p>
								<table  id="linkedin_social_table">
									<tr>
										<td colspan="2" class="col_key">
											LinkedIn button
										</td>
								   </tr>									
									<!-- LikedIn button count box -->
									<tr>
										<td class="col_key">
											<label for="s_linkedin_count">Positioning the count box:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_linkedin_count" id="s_linkedin_count">
												<option value="right" <?php  if(isset($params->s_linkedin_count) && $params->s_linkedin_count=="right") echo "selected='selected'"; ?> >Horizontal</option>
												<option value="top" <?php  if(isset($params->s_linkedin_count) && $params->s_linkedin_count=="top") echo "selected='selected'"; ?> >Vertical</option>
												<option value="none" <?php  if(isset($params->s_linkedin_count) && $params->s_linkedin_count=="none") echo "selected='selected'"; ?> >None</option>
											</select>
										</td>
									</tr>			
									<!-- LikedIn language -->
									<tr>
										<td class="col_key">
											<label for="s_linkedin_language">Language:</label>
										</td>	
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_linkedin_language" id="s_linkedin_language">
												<option value="en_US">English</option>
												<option value="ar_AE">Arabic</option>
												<option value="zh-CN">Chinese - Simplified</option>
												<option value="zh-TW">Chinese - Traditional</option>
												<option value="cs_CZ">Czech</option>
												<option value="da_DK">Danish</option>
												<option value="nl_NL">Dutch</option>
												<option value="fr_FR">French</option>
												<option value="de_DE">German</option>
												<option value="in_ID">Indonesian</option>
												<option value="it_IT">Italian</option>
												<option value="ja_JP">Japanese</option>
												<option value="ko_KR">Korean</option>
												<option value="ms_MY">Malay</option>
												<option value="no_NO">Norwegian</option>
												<option value="pl_PL">Polish</option>
												<option value="pt_BR">Portuguese</option>
												<option value="ro_RO">Romanian</option>
												<option value="ru_RU">Russian</option>  
												<option value="es_ES">Spanish</option>
												<option value="sv_SE">Swedish</option>
												<option value="tl_PH">Tagalog</option>
												<option value="th-TH">Thai</option>
												<option value="tr_TR">Turkish</option>
											</select>
										</td>
									</tr>
									<!-- LikedIn  Custom CSS -->
									<tr>
										<td class="col_key">
											<label for="s_linkedin_css">Custom CSS:</label>
										</td>
									<tr>
									</tr>
										<td class="col_value">
											<textarea name="s_linkedin_css" id="s_linkedin_css"><?php if(isset($params->s_linkedin_css)) echo $params->s_linkedin_css; ?></textarea>
										 </td>
									</tr>
								</table>
							</td>				
							<!-- Social VK share Button table -->
							<td class="button_area" id = "vk_params"  active="1"   but="vk">
								<p class="active_icon">
									<span class="social_show_1"  onclick="activate('vk',1);" id="vk_social_show">Show</span>
									<span class="social_hide_0"  onclick="activate('vk',0);" id="vk_social_hide">Hide</span>
								</p>
								<table id="vk_social_table">
									<tr>
										<td colspan="2" class="col_key">
											VK share button
										</td>
									</tr>								
									<!-- VK share button count box -->
									<tr>
										<td class="col_key">
											<label for="s_vk_count">Style:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_vk_count" id="s_vk_count">
												<option value="round" <?php  if(isset($params->s_vk_count) && $params->s_vk_count=="round") echo "selected='selected'"; ?> >Button</option>
												<option value="round_nocount" <?php  if(isset($params->s_vk_count) && $params->s_vk_count=="round_nocount") echo "selected='selected'"; ?> >Button without a Counter</option>
												<option value="link" <?php  if(isset($params->s_vk_count) && $params->s_vk_count=="link") echo "selected='selected'"; ?> >	Link</option>
												<option value="link_noicon" <?php  if(isset($params->s_vk_count) && $params->s_vk_count=="link_noicon") echo "selected='selected'"; ?> >	Link without an Icon</option>
												<option value="custom" <?php  if(isset($params->s_vk_count) && $params->s_vk_count=="custom") echo "selected='selected'"; ?> >	Icon</option>
											</select>
										</td>
									</tr>
									<!--  VK share button text -->
									<tr>
										<td class="col_key">
											<label for="s_vk_text">Text:</label>
										</td>
									</tr>
									<tr>										
										<td class="col_value">
											<input type="text" name="s_vk_text" id="s_vk_text"  value="<?php if(isset($params->s_vk_text) && $params->s_vk_text!='') echo $params->s_vk_text; else echo 'Share'; ?>"/> 
										</td>
									</tr>		
									<!-- VK share button language -->
									<tr>
										<td class="col_key">
											<label for="s_vk_language">Language:</label>
										</td>
									</tr>
									<tr>
										<td class="col_value">
											<select name="s_vk_language" id="s_vk_language">
												<option value="english" <?php  if(isset($params->s_vk_language) && $params->s_vk_language=="english") echo "selected='selected'"; ?> >English</option>
												<option value="russian" <?php  if(isset($params->s_vk_language) && $params->s_vk_language=="russian") echo "selected='selected'"; ?> >Russian</option>
											</select>
										</td>
									</tr>
									<!-- VK share button Custom CSS -->
									<tr>
										<td class="col_key">
											<label for="s_vk_css">Custom CSS:</label>
										</td>
									<tr>
									</tr>
										<td class="col_value">
											<textarea name="s_vk_css" id="s_vk_css"><?php if(isset($params->s_vk_css)) echo $params->s_vk_css; ?></textarea>
										 </td>
									</tr>											   
								</table>
							</td>				
						</tr>
						<!-- Socails global parameters -->
						<tr>
							<td colspan="6">
								<table class="social_global_section">
									<!-- Socails Horizontal position -->
									<tr>
										<td class="col_key_global">
											<label for="socials_horizontal">Horizontal position:</label>
										</td>
										<td class="col_value_global">
											<select name="socials_horizontal" id="socials_horizontal">
												<option value="left" <?php  if(isset($params->socials_horizontal) && $params->socials_horizontal=="left") echo "selected='selected'"; ?> >Left</option>
												<option value="right" <?php  if(isset($params->socials_horizontal) && $params->socials_horizontal=="right") echo "selected='selected'"; ?> >Right</option>
											</select>
										</td>
									</tr>
									<!-- Socails Custom CSS -->
									<tr>
										<td class="col_key_global">
											<label for="socials_css">Custom CSS:</label>
										</td>
										<td class="col_value_global">
											 <textarea name="socials_css" id="socials_css"><?php if(isset($params->socials_css)) echo $params->socials_css; ?></textarea>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<input type="hidden" name="s_buttons_ordering" id="s_buttons_ordering" value="<?php if(isset($params->s_buttons_ordering)) echo $params->s_buttons_ordering; ?>">
					</tbody>
					<!-- End of Social buttons table -->
				</table>
			</div>
			<!--Assignment section -->
			<div id="social_buttons_assignment" style="position: relative;">
			<div style="position: absolute;background-color: black; opacity: 0.1;width: 100%;height: 100%;">
				
			</div>
				<!--Assignment table -->
					<?php 
						$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
						if (strpos($actual_link, 'ays-sb-new') !== false) {
					?>
					<table class="article_table">
						<tr>
							<td class="col_key_ass">
								<label for="article_positions">Position in post/page:</label>
							</td>
							<td class="col_value">
								<select name="article_position" id="article_positions">
									<option value="top" <?php  if(isset($params->article_position) && $params->article_position=="top") echo "selected='selected'"; ?> >Top </option>
									<option value="bottom" <?php  if(isset($params->article_position) && $params->article_position=="bottom") echo "selected='selected'"; ?> >Bottom</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col_key_ass">
								<label for="article_types">Choose post/page:</label>
							</td>
							<td class="col_value">
								<select name="article_type" id="article_types">
									<option value="none" <?php  if(isset($params->article_type) && $params->article_type=="none") echo "selected='selected'"; ?> >No posts/pages </option>
									<option value="all" <?php  if(isset($params->article_type) && $params->article_type=="all") echo "selected='selected'"; ?> >On all posts/pages</option>
									<option value="except" <?php  if(isset($params->article_type) && $params->article_type=="except") echo "selected='selected'"; ?> selected>	On all posts/pages except those selected</option>
								</select>
							</td>
						</tr>
						<tr id="article_selection_tr">
							<td class="col_key_ass">
								<label for="article_selections">Post/Page selection:</label>
							</td>
							<td class="col_value">
								<ul class="article_selection_list" id="article_selection_lists"> 
									<?php 
										if(empty($all_articles))
										{
											echo "<p style='color:red'>You dont choose posts/pages yet</p>";
										}
										else
										{ 

											foreach($all_articles as $article)						   
											{
												$checked=((in_array($article->id,$except_arr)) || empty($except_arr)) ? "" : "checked='checked'";
												echo "<li><label for='select_article_".$article->id."'><input type='checkbox' class='select_article' ".$checked." value='".$article->id."' id='select_article_".$article->id."'>".$article->title."</label></li>";
											}						
										}
									?>
								</ul>
							</td>
						</tr>
					</table>
					<?php 
					}
					else{
					?>
					<table class="article_table">
						<tr>
							<td class="col_key_ass">
								<label for="article_positions">Position in post/page:</label>
							</td>
							<td class="col_value">
								<select name="article_position" id="article_positions">
									<option value="top" <?php  if(isset($params->article_position) && $params->article_position=="top") echo "selected='selected'"; ?> >Top </option>
									<option value="bottom" <?php  if(isset($params->article_position) && $params->article_position=="bottom") echo "selected='selected'"; ?> >Bottom</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col_key_ass">
								<label for="article_types">Choose post/page:</label>
							</td>
							<td class="col_value">
								<select name="article_type" id="article_types">
									<option value="none">No posts/pages </option>
									<option value="all">On all posts/pages</option>
									<option value="except" selected>On all posts/pages except those selected</option>
								</select>
							</td>
						</tr>
						<tr id="article_selection_tr">
							<td class="col_key_ass">
								<label for="article_selections">Post/Page selection:</label>
							</td>
							<td class="col_value">
								<ul class="article_selection_list" id="article_selection_lists"> 
									<?php 
										if(empty($all_articles))
										{
											echo "<p style='color:red'>You dont choose posts/pages yet</p>";
										}
										else
										{ 
											$params->article_type = "except";
											$ays_counter = 1;
											foreach($all_articles as $article)						   
											{
												$checked=((in_array($article->id,$except_arr)) || empty($except_arr)) ? "" : "checked='checked'";
												if($ays_counter==1){
													echo "<li><label for='select_article_".$article->id."'><input type='checkbox' class='select_article' ".$checked." value='".$article->id."' id='select_article_".$article->id."'>".$article->title."</label></li>";
												}
												else{
													echo "<li><label for='select_article_".$article->id."'><input type='checkbox' class='select_article'  value='".$article->id."' id='select_article_".$article->id."'>".$article->title."</label></li>";													
												}
												$ays_counter++;
											}						
										}
									?>
								</ul>
							</td>
						</tr>
					</table>
					<?php
					}
					?>					
				<input type="hidden" name="unexcept_articles" id="unexcept_articles" >
				<!--End of Assignment  section -->
			</div>
			<?php if ( current_user_can( 'manage_options', $post_id ) ) : ?>
			<div class="save-social-button">
				<input type="submit" class="button-primary" name="ays-sb-save" onclick="save_sb()" value="<?php echo esc_attr( __( 'Save', 'ays-social-buttons' ) ); ?>" />
				<input type="submit" class="button-primary" name="ays-sb-apply" onclick="save_sb()" value="<?php echo esc_attr( __( 'Apply', 'ays-social-buttons' ) ); ?>" />
			</div>
			<?php endif; ?>
		</div>
	</form>
	<?php endif; ?>
</div>
<script>
	var type = "<?php echo $type; ?>";
	var article_selection_type = "<?php if(isset($params->article_type)) echo $params->article_type; else echo "none";?>";
	
	// sorting first time				
	function sortByorder(buttons)
	{
		if(buttons!='0')
		{
			var but_array = buttons.split(",");
			var actives = new Array(); 
			var buttons = new Array(); 
			var button_active = '';
			for(var i=0; i<but_array.length;i++)
			{
				button_active = but_array[i].split("-");
				actives[button_active[0]] = button_active[1];
				buttons[i] = button_active[0];
			
				if(button_active[1] == 0)	  
				{
					jQuery("#"+button_active[0]+"_social_table").attr("active",0);
					jQuery("#"+button_active[0]+"_social_table").css("opacity","0.2");
					jQuery("#"+button_active[0]+"_params").attr("active","0");
					jQuery("#"+button_active[0]+"_social_show").attr("class","social_show_0");
					jQuery("#"+button_active[0]+"_social_hide").attr("class","social_hide_1");
				}
			}
			   
			var List = jQuery('#social_buttons_area');
			var listItems = List.children('td').get();
	 
			listItems.sort(function(a,b){
				var compA = jQuery.inArray(jQuery(a).attr("but"), buttons);
				var compB = jQuery.inArray(jQuery(b).attr("but"), buttons);
				return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
			});
			jQuery(List).append(listItems);
		}
	}

	// Assignment in articles select change
	function art_change(type)
	{
		if(type == "except")
			jQuery("#article_selection_tr").show("10");
		else
			jQuery("#article_selection_tr").hide("10");
	}
	
	jQuery( document ).ready(function() {
		// selected type css first time
		jQuery("#"+type).css("background-color", "white");
		jQuery("#"+type).css("color", "rgb(116, 116, 116)");
		jQuery('#'+type+'_table').show(300); 
		
		select_language([
		"<?php echo $lang_likebutton;?>",
		"<?php echo $lang_sharebutton;?>",
		"<?php echo $lang_comment;?>",
		"<?php echo $lang_twitterbutton;?>",
		"<?php echo $lang_google;?>",
		"<?php echo $lang_linkedin;?>",
		"<?php echo $s_lang_likebutton;?>",
		"<?php echo $s_lang_sharebutton;?>",
		"<?php echo $s_lang_twitterbutton;?>",
		"<?php echo $s_lang_google;?>",
		"<?php echo $s_lang_linkedin;?>"
		]);
	});
	
	sortByorder("<?php if(isset($params->s_buttons_ordering) && $params->s_buttons_ordering!='') echo trim($params->s_buttons_ordering,","); else echo '0'; ?>");
	art_change(article_selection_type);
</script>