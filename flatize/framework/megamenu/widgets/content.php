<?php

	class PGL_Shortcode_Content extends PGL_Shortcode_Base{

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
				'title' => $this->l( 'Text Content' ),
				'desc'  => $this->l( 'Supported with WYSWYG Editor' ),
				'name'  => $this->name
			);
			return $button;
		}

		public function getOptions( ){
		    $this->options[] = array(
		        'label' 	=> __('Content', 'flatize'),
		        'id' 		=> 'content',
		        'type' 		=> 'textarea',
		        'explain'	=> __( 'Put Content Here', 'flatize' ),
		        'default'	=> '',
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
?>