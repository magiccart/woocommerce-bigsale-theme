<?php
namespace Magiccart\Magicslider\Controller\Adminhtml;

use Magiccart\Magicslider\Model\Collection;

class Slider extends Collection {
    public function __construct(){
        
    }
    
    /* Save + Edit */
    public function saveGroupSlider(){
        $error                  = array();
        $message                = '';
        $data                   = array();
        $data['message']        = '';
        $data['group-slider']   = '';
        $strError               = '';
        $strImg                 = '';
        $groupKey               = '';

        $optionSlider                  = get_option('magiccart_slider', '');
        $optionSlider                  = json_decode($optionSlider, true);
        
        if(!is_array($optionSlider)) $optionSlider = array();

        if($_GET['action'] == 'edit'){
            $groupKey  = isset($_GET['group']) ? $_GET['group'] : '';
            $data['group']          = isset($optionSlider[$groupKey]['name']) ? $optionSlider[$groupKey]['name'] : $groupKey;
            $data['content']        = isset($optionSlider[$groupKey]['value']) ? $optionSlider[$groupKey]['value'] : array();
            $data['key-group']      = $groupKey;
        }
    
        if(isset($_POST['submit'])){
            $groupSlider       = $_POST['group-slider'];
            $groupSliderUS     = $this->vn_str_key($_POST['group-slider']);
            if(trim($groupSlider) == ''){
                $groupSlider        = "Group Slider " . rand(0, 999999);
                $groupSliderUS      = $this->vn_str_key($groupSlider);
                
            }else if(isset($optionSlider[$groupSliderUS]) && $_GET['action'] != 'edit'){
                $error['group-slider'] = __("Group already exists !", 'alothemes');
            }
            
            if(is_numeric($groupSlider)){
                $error['group-slider'] = __("Group need at least 1 character !", 'alothemes');
            }
            
            $ids        = $_POST['ids'];
            $imgSlide   = array();
            if(count($ids) > 0){
                $arrTitle   = $_POST['title'];
                $arrDes     = $_POST['im_description'];
                $arrSrc     = $_POST['img-src'];
                $arrHref    = $_POST['img-herf'];
                $arrStatus  = isset($_POST['show-img']) ? $_POST['show-img'] : array();

                foreach ($ids as $key => $value) {
                    $imgSlide[$key]['title']         = isset($arrTitle[$value]) ? $arrTitle[$value] : '';
                    $imgSlide[$key]['description']   = isset($arrDes[$value]) ? $arrDes[$value] : '';
                    $imgSlide[$key]['src']           = isset($arrSrc[$value]) ? $arrSrc[$value] : '';
                    $imgSlide[$key]['href']          = isset($arrHref[$value]) ? $arrHref[$value] : '';
                    $imgSlide[$key]['status']        = isset($arrStatus[$value]) ? 1 : 0;
                    $imgSlide[$key]['id']            = $value;
                }
            }
    
            if(count($error) == 0){
                $group = array(
                            $groupSliderUS => array(
                                        "name"      => $groupSlider,
                                        'value'     => $imgSlide,
                                        'key-group' => $groupSliderUS,
                                    )
                        );
                $optionSlider = array_merge($optionSlider, $group);
                if($_GET['action'] == 'edit'){
                    if($groupSliderUS != $groupKey){
                        unset($optionSlider[$groupKey]);
                    }
                }
                
                $optionSlider = json_encode($optionSlider);

                update_option('magiccart_slider', $optionSlider);
               $tmp = get_option('magiccart_slider');
              
                wp_redirect('?page=' . $_GET['page'] . '&action=edit&group=' . $groupSliderUS );
            }else{
                foreach($error as $key => $value){
                    $strError .=  $value . '</br>';
                }
                $message = "<div class='error'>{$strError}</div>";
            }
            $data['message']        = $message;
            $data['group']          = $groupSlider;
            $data['content']        = $imgSlide;
            $data['key-group']      = $groupSliderUS;
        }
        return $data;
    }
    
    /* Delete */
    public function deleteGroup(){
        $group = isset($_GET['group']) ? $_GET['group'] : '' ;
        if(! $group) return; 
        $page  = $_GET['page'];
        $optionSlider          = get_option('magiccart_slider', '');
        $optionSlider          = json_decode($optionSlider, true);
    
        if(isset($optionSlider[$group])) unset($optionSlider[$group]);
        $optionSlider = json_encode($optionSlider);
        update_option('magiccart_slider', $optionSlider);
    
        wp_redirect("?page=" . $page );
    }

    public function deleteItemGroup(){
        $group = isset($_GET['key-group']) ? $_GET['key-group'] : '';
        echo $item  = isset($_GET['group-item']) ? $_GET['group-item'] : '';

        if(! $group || ! $item ) return; 

        $page  = $_GET['page'];
        $optionSlider          = get_option('magiccart_slider', '');
        $optionSlider          = json_decode($optionSlider, true);
        if(isset($optionSlider[$group]['value'][$item])){
            unset($optionSlider[$group]['value'][$item]);
        } 
        $optionSlider = json_encode($optionSlider);
        
        update_option('magiccart_slider', $optionSlider);
    
        wp_redirect("?page=" . $page . "&action=edit&group=" . $group );
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