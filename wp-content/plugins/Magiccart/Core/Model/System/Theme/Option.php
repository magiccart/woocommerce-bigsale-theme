<?php
namespace Magiccart\Core\Model\System\Theme;

class Option{
	
	public function getName(){
		$fileStyle = array();
		$linkStyle 		= get_template_directory() . '/css/style';
		if (file_exists($linkStyle) && is_dir($linkStyle)) {
		    $fileStyle 		= scandir($linkStyle);
		}
		if(!$fileStyle) return;
		$opt = "";
		foreach ($fileStyle as $file) {
			$temp = explode('-', $file);
			if($temp[0] == 'style'){
				$name 	= str_replace('.css', '', $file);
				$name 	= str_replace('-', '_', $name);
				$opt 	= 'options_' . $name;
				break;
			}
		}

		$optionsName = get_option("theme_options", $opt);

		return $optionsName;
	}
	
	public function getOptions($key = ""){
		if(!$key){
			return $GLOBALS[$this->getName];
		}else{
			return $GLOBALS[$this->getName][$key];
		}
		
	}
}