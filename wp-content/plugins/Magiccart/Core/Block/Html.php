<?php
namespace Magiccart\Core\Block;

class Html{
	
	public function __construct($options = null){
	}
	
	public function btn_media_script($button_id,$input_id){
		$script = "<script>
						jQuery(document).ready(function($){
							$('#{$button_id}').zendvnBtnMedia('{$input_id}');
						});
					</script>";
		return $script;
	}
	
	public function pTag($value = '', $attr = array(), $options = null){
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		return '<p ' . $strAttr .' >' . $value . '</p>';
	}
	
	public function label($value = '',$attr = array(), $options = null){
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		return '<label ' . $strAttr . ' >' . $value . ':</label>';
	}
	
	//Phần tử TEXTBOX
	public function textbox($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
		
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//Tạo phần tử HTML
		$html = '<input type="text" name="'. $name . '" ' . $strAttr . ' value="' . $value . '" />';
	
		return $html;
	}	
	
	//Phần tử FILEUPLOAD
	public function fileupload($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
		
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//Tạo phần tử HTML
		$html = '<input type="file" name="'. $name . '" ' . $strAttr . ' value="' . $value . '" />';
	
		return $html;
	}
	
	//Phần tử PASSWORD
	public function password($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
	
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
	
		//Tạo phần tử HTML
		$html = '<input type="password" name="'. $name . '" ' . $strAttr . ' value="' . $value . '" />';
	
		return $html;
	}
	
	//Phần tử HIDDEN
	public function hidden($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
		
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//Tạo phần tử HTML
		$html = '<input type="hidden" name="'. $name . '" ' . $strAttr . ' value="' . $value . '" />';
	
		return $html;
	}

	//Phần tử BUTTON - SUBMIT - RESET
	public function button($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
		
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//Dinh dang kieu nut
		if(!isset($options['type'])){
			$type = 'submit';
		}else{		
			$type = $options['type'];
		}
		
		//Tạo phần tử HTML
		$html = '<input type="' . $type .'" name="'. $name . '" ' . $strAttr . ' value="' . $value . '" />';
	
		return $html;
	}
	
	//Phần tử TEXTAREA
	public function textarea($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
		
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//Tạo phần tử HTML
		$html = '<textarea name="'. $name . '" ' . $strAttr . '/>' . $value . '</textarea>';
	
		return $html;
	}
	
	//Phần tử RADIO
	public function radio($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
	
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		
		//2. Kiểm tra giá trị của $value
		$strValue = $value;
		
		//3.Kiểm tra ký tự phân cách giữa các nút radio
		if(!isset($options['separator'])){
			$options['separator'] = ' ';
		}
		
		//4. Tạo các nút radio
		$html = '';
		$data = $options['data'];
		if(count($data)){
			foreach ($data as $key => $val){
				$checked = '';
				if(preg_match('/^(' . $strValue .')$/i', $key)){
					$checked = ' checked="checked" ';
				}				
				$html  .= '<input type="radio" name="' . $name . '" ' . $checked . ' value="' . $key . '"/>' 
						  . $val  . $options['separator'];
			}
		}
			
		return $html;
	}
	
	//Phần tử CHECKBOX
	public function checkbox($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
	
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//Kiểm tra xem có check hay không
		$checked = '';
		if(isset($options['current_value'])){
			if($options['current_value'] == $value){
				$checked = ' checked="checked" ';
			}
		}
		
		//Tạo phần tử HTML
		$html = '<input type="checkbox" name="'. $name . '" ' 
				. $strAttr . ' value="' . $value . '" ' . $checked  . ' />';
	
		return $html;
	}
		
	//Phần tử SELECTBOX
	public function selectbox($name = '', $value = '', $attr = array(), $options = null){
		$html = '';
	
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		//2. Kiểm tra giá trị của $value
		$strValue = '';
		if(is_array($value)){		
			$strValue = implode("|", $value);
		}else{
			$strValue = $value;
		}
		//echo $strValue;
		
		//3. Tạo value và label của <option>
		$strOption = '';
		$data = $options['data'];
		if(count($data)){
			foreach ($data as $key => $val){
				$selected = '';
				if(preg_match('/^(' . $strValue .')$/i', $key)){
					$selected = ' selected="selected" ';
				}
				$strOption .= '<option value="' . $key . '" ' . $selected . ' >' . $val . '</option>';
			}
		}
		
		//Tạo phần tử HTML
		$html = '<select name="'. $name . '" ' . $strAttr . ' >'
				. $strOption
				. '</select>';
		
		return $html;
	}
	
}

/* Button <<
 * $name 	: Tên của phần tử button
 * $attr 	: Các thuộc tính của phần tử button
 * 		   	  Id - style - width - class - value ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 * 			  [type]: button - submit - reset
 */

/* checkbox <<
 * $name 	: Tên của phần tử checkbox
 * $attr 	: Các thuộc tính của phần tử checkbox
 * 		   	  Id - style - width - class - value ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 * 			  [current_value]
 */
 
/* Fileupload <<
 * $name 	: Tên của phần tử Fileupload
 * $attr 	: Các thuộc tính của phần tử Fileupload
 * 		   	  Id - style - width - class - value ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 */
 
/* Hidden <<
 * $name 	: Tên của phần tử hidden
 * $attr 	: Các thuộc tính của phần tử hidden 
 * 		   	  Id - style - width - class - value ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 */
 
/* Password <<
 * $name 	: Tên của phần tử password
 * $attr 	: Các thuộc tính của phần tử password
 * 		   	  Id - style - width - class - value ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 */
 
/* Radio <<
 * $name 	: Tên của phần tử Radio
 * $attr 	: Các thuộc tính của phần tử Radio
 * 		   	  Id - style - width - class - value ...
 *
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 *  			  [data]: là phần tử sẽ chứa một mảng value và label của phần tử radio
 *  			  [separator]: Giá trị phân cách của các nút radio
 */
 
/* Selectbox <<
 * $name 	: Tên của phần tử Selectbox
 * $attr 	: Các thuộc tính của phần tử textbox
 * 		   	  Id - style - width - class - value ...
 *
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 *  			  [data]: là phần tử sẽ chứa một mảng value và label của <option>
 */
 
/* Textarea <<
 * $name 	: Tên của phần tử textarea
 * $attr 	: Các thuộc tính của phần tử textarea
 * 		   	  Id - style - width - class - value ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 */
 
/* Textboxx <<
 * $name 	: Tên của phần tử textboxx
 * $attr 	: Các thuộc tính của phần tử textbox
 * 		   	  Id - style - width - class ...
 * $options	: Các phần sẽ bổ xung khi phát sinh trường hợp mới
 */