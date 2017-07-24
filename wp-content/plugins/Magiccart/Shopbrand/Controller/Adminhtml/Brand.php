<?php
namespace Magiccart\Shopbrand\Controller\Adminhtml;


class Brand {
    public function __construct(){
        
    }
    
    /* Save data + Edit */
    public function saveBrand(){
    	$data 		= array();
    	$action 	= $_GET['action'];
    	$key		= "";
    	
    	if($action == 'edit'){
    		$key    = $_GET['key'];
    		$brands = get_option('magiccart_brand', '');
            $brands = json_decode($brands, true);
    		$brand  = $brands[$key];
    		
    		$data['name'] 		= $brand['name'];
    		$data['url'] 		= $brand['url'];
    		$data['attrType'] 	= $brand['attr-type'];
    		$data['term'] 		= $brand['term'];
    		$data['img'] 		= $brand['img'];
    	}
    	if(isset($_POST['submit'])){
	        $name       = $_POST['name-brand'];
            $url        = $_POST['url-brand'];
            $attrType   = $_POST['type'];
            $term       = $_POST['term'];
            $img        = $_POST['img'];

	    	if(trim($name) != '' && trim($img)){
	    		$brands = get_option('magiccart_brand', '');
                $brands = json_decode($brands, true);
	    		 
                if(!is_array($brands)){
                    $brands = array();
                }

	    		$nameUs = $this->vn_str_key($name);
	    		
	    		if(array_key_exists($nameUs, $brands) && $action != 'edit'){
	    			$error = __("Name already exists !", 'alothemes');
	    			$data['error'] = "<div class='error'>{$error}</div>";
	    		}else{
                    echo $nameUs;
	    			$newBrand = array(
			    					$nameUs => array(
					    					'name' 		=> $name,
					    					'url'		=> $url,
					    					'attr-type'	=> $attrType,
					    					'term'		=> $term,
					    					'img'		=> $img,
			    							'status'	=> 1,
			    						)
		    					);
	    			if($action == 'edit'){
                        if(!array_key_exists($nameUs, $brands)){
                            unset($brands[$key]);
                        }
	    			}
	    			$brands = array_merge($brands, $newBrand);
                    $brands = json_encode($brands);
	    			update_option('magiccart_brand', $brands);
                    wp_redirect("?page=" . $_GET['page'] ."&modul=shopbrand&block=grid&view=gird" );
	    		}
	    		
	    	}else{
	    		$error = __("Name and Image is not empty !", 'alothemes');
	    		$data['error'] = "<div class='error'>{$error}</div>";
	    	}
    	}
    	
    	if(isset($data['error'])){
    		$data['name'] 		= $name;
    		$data['url'] 		= $url;
    		$data['attrType'] 	= $attrType;
    		$data['term'] 		= $term;
    		$data['img'] 		= $img;
    	}
    	return $data;
    }
    
    /* edit status */
    public function editStatus(){
    	$status = $_GET['status'];
    	$key    = $_GET['key'];
    	
    	($status == 'unpublish' ) ? $status = 0 : $status = 1;
    	
    	$brands  = get_option('magiccart_brand', '');
        $brands  = json_decode($brands, true);
    	
    	if(isset($brands[$key])) $brands[$key]['status'] = $status;

        $brands = json_encode($brands);
    	update_option('magiccart_brand', $brands);
    	wp_redirect("?page=" . $_GET['page'] ."&modul=shopbrand&block=grid&view=gird" );
    }
    
    /* Delete */
    public function delete(){
    	$key    = $_GET['key'];
    	$brands = get_option('magiccart_brand', '');
        $brands = json_decode($brands, true);
    	
    	if(isset($brands[$key])) unset($brands[$key]);
        $brands = json_encode($brands);
    	update_option('magiccart_brand', $brands);
    	wp_redirect("?page=" . $_GET['page']."&modul=shopbrand&block=grid&view=grid" );
    }
    
    /* VN => Us */
    private function vn_str_key ($str){
        $str = trim($str);
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
    
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $arr = explode(' ', $str);
        foreach($arr as $key => $value){
            if($value == ' '){
                unset($arr[$key]);
            }
        }
        
        $str = implode('-', $arr);
        
        return $str;
    }
}