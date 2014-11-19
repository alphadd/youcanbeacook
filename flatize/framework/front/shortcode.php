<?php

/*==========================================================================
Social link
==========================================================================*/
add_shortcode( 'pgl_social', 'pgl_shortcode_social' );
function pgl_shortcode_social( $atts,$content=null ){
	global $theme_option;
	if(isset($theme_option['social_order']) && isset($theme_option['social_order']['enabled']) && isset($theme_option['social_order']['enabled']['placebo'])) unset($theme_option['social_order']['enabled']['placebo']);
	ob_start();
?>
	<ul class="social-networks list-unstyled">
		<?php foreach ( $theme_option['social_order']['enabled'] as $key => $value): ?>
		<li>
			<a data-toggle="tooltip" data-original-title="<?php echo $value; ?>" href="<?php echo (isset($theme_option[$key])) ? esc_url( $theme_option[$key] ) : ''; ?>" target="_blank">
				<i class="fa <?php echo $key; ?>"></i>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
<?php
	return ob_get_clean();
}

/*==========================================================================
Language Selector (WPML)
==========================================================================*/

add_shortcode( 'pgl_language_swich' , 'pgl_wpml_language_swich' );
function pgl_wpml_language_swich($atts,$content=null){
	ob_start();
	if(class_exists('SitePress')){
		global $sitepress,$sitepress_settings;
		global $icl_language_switcher_preview;
		if ( $sitepress_settings[ 'icl_lang_sel_type' ] == 'list' || $icl_language_switcher_preview ) {
			global $icl_language_switcher;
			$icl_language_switcher->widget_list();
			if ( !$icl_language_switcher_preview ) {
				return '';
			}
		}

		$active_languages = $sitepress->get_ls_languages();
		if($active_languages) {
			/**
			 * @var $main_language bool|string
			 * @used_by menu/language-selector.php
			 */
			foreach ( $active_languages as $k => $al ) {
				if ( $al[ 'active' ] == 1 ) {
					$main_language = $al;
					unset( $active_languages[ $k ] );
					break;
				}
			}
			if(function_exists('wpml_home_url_ls_hide_check') && wpml_home_url_ls_hide_check()){
			    return;
			}

			global $w_this_lang;


			if($w_this_lang['code']=='all'){
			    $main_language['native_name'] = __('All languages', 'sitepress');
			}
			if(empty($main_language)){
			    $main_language['native_name'] = $w_this_lang['display_name'];
			    $main_language['translated_name'] = $w_this_lang['display_name'];
			    $main_language['language_code'] = $w_this_lang['code'];
			    if( $sitepress_settings['icl_lso_flags'] || $icl_language_switcher_preview){
			        $flag = $sitepress->get_flag($w_this_lang['code']);
			        if($flag->from_template){
			            $wp_upload_dir = wp_upload_dir();
			            $main_language['country_flag_url'] = $wp_upload_dir['baseurl'] . '/flags/' . $flag->flag;
			        }else{
			            $main_language['country_flag_url'] = ICL_PLUGIN_URL . '/res/flags/'.$flag->flag;
			        }
			    }
			}
			?>
			
			   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			            <?php if( $sitepress_settings['icl_lso_flags'] || $icl_language_switcher_preview):?>                
			            <img <?php if( !$sitepress_settings['icl_lso_flags'] ):?>style="display:none"<?php endif?> class="iclflag" src="<?php echo $main_language['country_flag_url'] ?>" alt="<?php echo $main_language['language_code'] ?>"  title="<?php echo $sitepress_settings['icl_lso_display_lang'] ? esc_attr($main_language['translated_name']) : esc_attr($main_language['native_name']) ; ?>" />
			            <b class="caret"></b>
			            &nbsp;<?php endif;
			                if($icl_language_switcher_preview){
			                    $lang_native = $main_language['native_name'];
			                    if($sitepress_settings['icl_lso_native_lang']){
			                        $lang_native_hidden = false;
			                    }else{
			                        $lang_native_hidden = true;
			                    }
			                    $lang_translated = $main_language['translated_name'];
			                    if($sitepress_settings['icl_lso_display_lang']){
			                        $lang_translated_hidden = false;
			                    }else{
			                        $lang_translated_hidden = true;
			                    }                            
			                }else{
			                    if($sitepress_settings['icl_lso_native_lang']){
			                        $lang_native = $main_language['native_name'];
			                    }else{
			                        $lang_native = false;
			                    }
			                    if($sitepress_settings['icl_lso_display_lang']){
			                        $lang_translated = $main_language['translated_name'];
			                    }else{
			                        $lang_translated = false;
			                    }
			                    
			                    $lang_native_hidden = false;
			                    $lang_translated_hidden = false;
			                    
			                }
			                echo icl_disp_language($lang_native, $lang_translated, $lang_native_hidden, $lang_translated_hidden);                
			            ?>
						</a>
			            <?php if(!empty($active_languages)): ?>
			                   
			            <ul class="dropdown-menu langs">
			                <?php $active_languages_ordered = $sitepress->order_languages($active_languages); ?>
			                <?php foreach($active_languages_ordered as $lang): ?>
			                <li class="icl-<?php echo $lang['language_code'] ?>">          
			                    <a href="<?php echo apply_filters('WPML_filter_link', $lang['url'], $lang)?>">
			                    <?php if( $sitepress_settings['icl_lso_flags'] || $icl_language_switcher_preview):?>                
			                    <img <?php if( !$sitepress_settings['icl_lso_flags'] ):?>style="display:none"<?php endif?> class="iclflag" src="<?php echo $lang['country_flag_url'] ?>" alt="<?php echo $lang['language_code'] ?>" title="<?php echo $sitepress_settings['icl_lso_display_lang'] ? esc_attr($lang['translated_name']) : esc_attr($lang['native_name']) ; ?>" />&nbsp;                    
			                    <?php endif; ?>
			                    <?php 
			                        if($icl_language_switcher_preview){
			                            $lang_native = $lang['native_name'];
			                            if($sitepress_settings['icl_lso_native_lang']){
			                                $lang_native_hidden = false;
			                            }else{
			                                $lang_native_hidden = true;
			                            }
			                            $lang_translated = $lang['translated_name'];
			                            if($sitepress_settings['icl_lso_display_lang']){
			                                $lang_translated_hidden = false;
			                            }else{
			                                $lang_translated_hidden = true;
			                            }                            
			                        }else{
			                            if($sitepress_settings['icl_lso_native_lang']){
			                                $lang_native = $lang['native_name'];
			                            }else{
			                                $lang_native = false;
			                            }
			                            if($sitepress_settings['icl_lso_display_lang']){
			                                $lang_translated = $lang['translated_name'];
			                            }else{
			                                $lang_translated = false;
			                            }
			                        }
			                        echo icl_disp_language($lang_native, $lang_translated, $lang_native_hidden, $lang_translated_hidden);
			                         ?>
			                    </a>
			                </li>
			                <?php endforeach; ?>
			            </ul> 
			            <?php endif; ?>
			<?php
		}
	}
	return ob_get_clean();
}