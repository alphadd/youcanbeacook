<?php

class PGL_Megamenu_Offcanvas extends Walker_Nav_Menu {

	protected $megaConfig = array();

	protected $isLiveEdit = false;

	protected $widgets = array();

	protected $currentMegaconfig = null;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */

	public function __construct() {

		$this->_editStringCol = ' data-colwidth="%s" data-class="%s" ' ;
		$a = get_option( "PGL_MEGAMENU_DATA" ) ;
		if( $a ) {
			$this->megaConfig =  unserialize( $a );
		}

		$this->isLiveEdit = is_admin();
	}

	
    /**
     * start_lvl function.
     *
     * @access public
     * @param mixed &$output
     * @param mixed $depth
     * @return void
     */
   public  function start_lvl(  &$output, $depth = 0, $args = array(), $megaconfig=null ) {
		$indent = str_repeat( "\t", $depth );
		
		$output	   .= "\n$indent<ul class=\"uk-nav-sub\">\n";
	}


	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl( &$output, $depth = 0, $args = array(),$megaConfig=null ) {

		$megaCols ='';
		$megaRows = '';
		if( isset($megaConfig) && isset($megaConfig->rows) ){
			if( isset($megaConfig->rows[0]->cols) ){
				unset($megaConfig->rows[0]->cols[0]);
				foreach( $megaConfig->rows[0]->cols as $col ){

					$colclass = isset($col->colclass)?$col->colclass:'';
			 		$megaCols .= '<div class="pgl-col col-md-'.$col->colwidth.' '.$colclass.'" '.$this->getColumnDataConfig( $col ).'> <div class="pgl-col-inner">';
			 			$megaCols .= $this->renderWidgetsInCol( $col );
				 	$megaCols .= '</div></div>';
				}
				unset( $megaConfig->rows[0] );
			}

			if( $megaConfig->rows ){
				foreach( $megaConfig->rows as $row ){
					$megaRows .= '<div class="row">';
						foreach( $row->cols as $col ){
							$colclass = isset($col->colclass)?$col->colclass:'';
							 $megaRows .= '<div class="pgl-col col-md-'.$col->colwidth.' '.$colclass.'" '.$this->getColumnDataConfig( $col ).'> <div class="pgl-col-inner">';
							 	$megaRows .= $this->renderWidgetsInCol( $col );
							 $megaRows .= '</div></div>';
						}
					$megaRows .= '</div>';
				}
			}
		}
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
		$this->currentMegaconfig = null;
	}

	/**
	 * start_el function.
	 *
	 * @access public
	 * @param mixed &$output
	 * @param mixed $item
	 * @param int $depth (default: 0)
	 * @param array $args (default: array())
	 * @param int $id (default: 0)
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item->megaconfig = new stdClass();
		$hasChilds = $args->has_children;

		$custom_configs = apply_filters( 'pgl_menu_custom_configs' ,array() );

		if( isset($this->megaConfig[$item->ID]) ){
			$item->megaconfig = $this->megaConfig[$item->ID];
			$args->has_children = true;
		}

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		//echo $depth;
		$li_attributes = '';
		$class_names = $value = '';

		$classes = array();


		$classes[] = ($item->current || $item->current_item_ancestor) ? 'uk-active' : '';
		$classes[] = 'menu-item-' . $item->ID;
		foreach ($custom_configs as  $custom_config) {
			if($custom_config['type']=='class'){
				$classes[] = $item->$custom_config['value'];
			}
		}
		//$classes[] = $item->additionclass;
		if(  $args->has_children){
			$classes[] = 'uk-parent';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;


		if( isset($item->megaconfig->rows) && $item->megaconfig->rows && !$hasChilds ){
		 	$item_output .= $this->genMegaMenuByConfig( $item , $depth );
		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * display_element function.
	 *
	 * @access public
	 * @param mixed $element
	 * @param mixed &$children_elements
	 * @param mixed $max_depth
	 * @param int $depth (default: 0)
	 * @param mixed $args
	 * @param mixed &$output
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );

		$cb_args = array_merge( array(&$output, $element, $depth), $args);

		call_user_func_array(array(&$this, 'start_el'), $cb_args);


		$id = $element->$id_field;

		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {


			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					$cb_args = array_merge( array(&$output, $depth), $args);
					if( isset($this->megaConfig[$element->ID]) ){
						array_push( $cb_args, $this->megaConfig[$element->ID]);

					}


					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}

				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			$cb_args = array_merge( array(&$output, $depth), $args);

			if( isset($this->megaConfig[$element->ID]) ){
				array_push( $cb_args, $this->megaConfig[$element->ID]);
			}

			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}

	/**
	 * display_element function.
	 *
	 * @access public
	 * @param stdClass $col
	 * @return String $output
	 */
	protected function getColumnDataConfig( $col ){
		$output = '';
		if( is_object($col) && $this->isLiveEdit ){
			$vars = get_object_vars($col);
			foreach( $vars as $key => $var ){
				$output .= ' data-'.$key.'="'.$var . '" ' ;
			}
		}
		return $output;
	}
	
	/**
	 * render megamenu contentn by configation.
	 *
	 * @access protected
	 * @param stdClass $col
	 * @return String $output
	 */
	protected function genMegaMenuByConfig( $menu , $level  ){

		$attrw = '';
		$output = '';
			
			
		$output .= '<ul class="uk-nav-sub"><li>';

		foreach( $menu->megaconfig->rows  as $row ){
			foreach( $row->cols as $col ){
				$output .= $this->renderWidgetsInCol( $col );
			}
		}
		unset($colclass);
		$output .= '<li></ul>';

		return $output;
	}

	/**
	 * render list of  widgets for column.
	 *
	 * @access protected
	 * @param stdClass $col
	 * @return String $output
	 */
	protected function renderWidgetsInCol( $col ){
		 if( is_object($col) && isset($col->widgets)  ){
		 	$widgets = $col->widgets;
		 	$widgets = explode( '|wid-', '|'.$widgets );
			if( !empty($widgets) ){
				$dwidgets = PGL_Megamenu_Widget::getInstance()->loadWidgets();
				$shortcode =   PGL_Shortcodes::getInstance();
				unset( $widgets[0] );
				$output = '';
				foreach( $widgets as $wid ){
					$o = $dwidgets->getWidgetById( $wid );

					if( $o && isset($o->type) && $o->type=='submenu' ){
						ob_start();
						$nav_menu = ! empty( $o->params['menu'] ) ? wp_get_nav_menu_object( $o->params['menu'] ) : false;
						if ( !$nav_menu )
							return;

						if($o->params['title']!=''){
							echo '<h5>'.$o->params['title'].'</h5>';
						}

						$args = array(	'menu' => $nav_menu ,
							            'menu_class' => 'mega-sub-menu',
							            'container_class' => 'pgl-widget',
						            );
						wp_nav_menu($args);

						$output .= ob_get_clean();
					}
				}
				return $output;
			}
		 }
	}
}
