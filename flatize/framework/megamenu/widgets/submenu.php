<?php
class PGL_Shortcode_Submenu extends PGL_Shortcode_Base{

	public function __construct( ){
		// add hook to convert shortcode to html.
		$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
		$this->key = 'pgl_'.$this->name;

		add_shortcode( $this->key  ,  array($this,'render') );

		parent::__construct( );
	}
	
	public function getButton( $data=null ){
		$button = array(
			'icon'	 => 'content',
			'title' => $this->l( 'Sub Menu' ),
			'desc'  => $this->l( 'Display Submenu' ),
			'name'  => $this->name
		);
		return $button;
	}

	public function getOptions( ){
	    $this->options[] = array(
	        'label' 	=> __('Title', 'flatize'),
	        'id' 		=> 'title',
	        'type' 		=> 'input',
	        'explain'	=> __( 'Put Title Here', 'flatize' ),
	        'default'	=> '',
	        'hint'		=> '',
        );

        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
        $option = array();
        foreach ($menus as $menu) {
        	$option[$menu->term_id]=$menu->name;
        }

        $this->options[] = array(
	        'label' 	=> __('Menu', 'flatize'),
	        'id' 		=> 'menu',
	        'type' 		=> 'select',
	        'explain'	=> __( 'Select Menu', 'flatize' ),
	        'default'	=> '',
	        'options' 	=> $option,
	        'hint'		=> '',
        );

        $this->options[] = array(
	        'label' 	=> __('Addition Class', 'flatize'),
	        'id' 		=> 'class',
	        'type' 		=> 'input',
	        'explain'	=> __( 'Using to make own style', 'flatize' ),
	        'default'	=> '',
	        'hint'		=> '',
        );
	}
}