<?php

	class PGL_Shortcode_Video extends PGL_Shortcode_Base{

		public function __construct( ){
			$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
			$this->key = 'pgl_'.$this->name;
			add_shortcode( $this->key  ,  array($this,'render') );
			parent::__construct( );
		}

		/**
		 * $data format is object field of megamenu_widget record.
		 */
		public function getButton( $data=null ){
			$button = array(
				'icon'	 => 'video',
				'title' => $this->l( 'Video' ),
				'desc'  => $this->l( 'Embed Youtube/Vimeo Video' ),
				'name'  => $this->name
			);
			return $button;
		}

		public function getOptions( ){
		    $this->options[] = array(
		        'label' 	=> $this->l('Video Link'),
		        'id' 		=> 'link',
		        'type' 		=> 'embed',
		        'explain'	=> $this->l( 'Enter Vimeo Link or Youtube Here' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
	        $this->options[] = array(
		        'label' 	=> $this->l('Addition Class', 'flatize'),
		        'id' 		=> 'class',
		        'type' 		=> 'text',
		        'explain'	=> $this->l( 'Using to make own style' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
		}

		public function render( $atts ){
			$class = ($atts['class']!='')?" ".$atts['class']:"";
			$output='
				<div class="video-responsive'.$class.'">
					'.wp_oembed_get($atts["link"]).'
				</div>
			';
			return $output;
		}
	}
?>