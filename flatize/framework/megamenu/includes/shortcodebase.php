<?php

abstract class PGL_Shortcode_Base{

	protected $name;
	protected $options = array();
	protected $key;
	protected $is_content='';
	protected $excludedMegamenu = false;
	private $params;

	public function __construct( ){
		$this->setInputContent();
		$this->params =  PGL_Params::getInstance();
	}

	public function getName(){
		return $this->name;
	}

	public function getButton( $data=null ){
		return array( 'title' => '' , 'desc'=>'' );
	}

	public function isExcludedMenu(){
		return $this->excludedMegamenu;
	}

	protected function setInputContent(){
		foreach ($this->options as $option) {
			if(isset($option['content']) && $option['content']==true){
				$this->is_content = $option['id'];
				break;
			}
		}
	}

	/**
	 *
	 */
	public function makeCode( $inputs ){
		$string = '['.$this->key;
			foreach ($inputs as $key => $input) {
				if($key!=$this->is_content){
					if($input!=''){
						$string .= ' '.$key.'=\''.$this->checkInputValue($input).'\'';
					}
				}
			}
		$string.= ']';
		if($this->is_content!=''){
			$string.=$inputs[$this->is_content];
		}
		$string.= ' [/'.$this->key.'] ';
		return $string;
	}

	private function checkInputValue( $string ){
		$array = array (
	        '\''        => '&#39;',
	        '"'        => '&#34;'
	    );
	    $string = strtr($string, $array);
	    return $string;
	}

	public function getAttrs( $atts=array() ){
		 return shortcode_atts(
            array(
            'class' => '',
        ), $atts );
	}

	public function renderForm($type='',$id=0){
		$this->getOptions();
		$name = $this->setValueInput($id);
		$default = array(
			'default' => '',
			'hint'   => ''
		);
	?>
		<form id="pgl-shortcode-form" role="form">
			<div class="form-group">
				<label for="shortcode_name">Name:</label>
				<input value="<?php echo $name; ?>" class="form-control" type="text" id="shortcode_name" name="shortcode_name">
			</div>
	<?php
		foreach($this->options as $option){

			$option = array_merge( $default, $option );
			$explain = '';

			if( $option['explain'] ){
				$explain = '<em class="explain">'.$option['explain'].'</em>';
			}
			if(is_array($option['default'])){
				var_dump($option['default']);
			}else{
				if( !trim($option['default']) ){
			 		$option['default'] = $option['hint'];
			 	}
			}
		 	
		 	$this->params->getParam($option);
		 }
	?>
			<span class="spinner spinner-button" style="float:left;"></span>
			<button type="button" class="btn btn-primary pgl-button-save"><?php echo $this->l('Save'); ?></button>
			<button type="button" class="btn btn-default pgl-button-back"><?php echo $this->l('Back to list'); ?></button>
			<input type="hidden" name="shortcodetype" value="<?php echo $type; ?>">
			<input type="hidden" name="shortcodeid" value="<?php echo $id; ?>">
		</form>
	<?php
	}

	private function setValueInput($id=0){
		$name ='';
		if($id==0){
			for($i=0;$i<count($this->options);$i++){
				if(!isset($this->options[$i]['default'])){
					$this->options[$i]['default']='';
				}
			}
		}else{
			$obj = PGL_Megamenu_Widget::getInstance();
			$values = $obj->getWidgetById($id);
			if( is_array($values->params) ){
				foreach ($values->params as $key => $value) {
					for($i=0;$i<count($this->options);$i++){
						if($this->options[$i]['id']==$key){
							if(is_array($value)){
								$value = implode(',',$value);
							}
							$this->options[$i]['default']=$value;
							break;
						}
					}
				}
			}
			$name=$values->name;
		}
		return $name;
	}

	public function l( $text ){
		return __( $text, 'flatize' );
	}

	/**
	 * this method check overriding layout path in current template
	 */
	public function render( $atts ){
		$tpl_default = PGL_MEGAMENU_TEMPLATE.'/'.$this->name.'.php';
		ob_start();
		if( is_file($tpl_default) )
			require($tpl_default);
		return ob_get_clean();
	}
}