<?php

	class PGL_Shortcode_Image extends PGL_Shortcode_Base{

		public function __construct( ){
			// add hook to convert shortcode to html.
			$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
			$this->key = 'pgl_'.$this->name;
			$this->excludedMegamenu = true;
			add_shortcode( $this->key  ,  array($this,'render') );
			parent::__construct( );
		}
		
		public function getButton( $data=null ){
			$button = array(
				'icon'	 => 'image',
				'title' => $this->l( 'Single Image' ),
				'desc'  => $this->l( 'Display Banner Image Or Ads Banner' ),
				'name'  => $this->name
			);

			return $button;
		}

		public function getOptions( ){
		    $this->options[] = array(
		        'label' 	=> __('Image Link', 'flatize'),
		        'id' 		=> 'link',
		        'type' 		=> 'editor',
		        'explain'	=> __( 'Put Your Image Link Here', 'flatize' ),
		        'default'	=> '',
		        'hint'		=> '',
		        );

		    $this->options[] = array(
		        'label' 	=> __('Addition Class', 'flatize'),
		        'id' 		=> 'class',
		        'type' 		=> 'text',
		        'explain'	=> __( 'Using to make own style', 'flatize' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
		}

		public function render( $attrs, $content="" ){
			return '<div>'.$attrs['style'].'</div>';
		}
	}
?>