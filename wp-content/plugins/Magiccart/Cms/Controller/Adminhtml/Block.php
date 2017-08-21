<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 20:12:41
 * @@Modify Date: 2017-08-03 23:00:32
 * @@Function:
 */

namespace Magiccart\Cms\Controller\Adminhtml;

use Magiccart\Cms\Model\Block\Collection;

class Block extends Collection {
    public function __construct(){
        
    }
    
    /* Save data + Edit */
    public function saveBlock(){
        $error                  = array();
        $message                = '';
        $data                   = array();
        $data['message']        = '';
        $data['title']          = '';
        $data['content']        = '';
        $strError               = '';

        $value                  = get_option('magiccart_block', '');
        $value                  = json_decode($value, true);
    
        if($_GET['action'] == 'edit'){
            $text                   = $_GET['identifier'];
            $data['title']          = $value[$text]['name'];
            $data['content']        = $value[$text]['value'];
        }
    
        if(isset($_POST['submit'])){
            $title                  = $_POST['title'];
            $content                = $_POST['content'];
    
            $titleUS = $this->vn_str_key($_POST['title']);
    
            if(trim($title) == null){
                $error['title'] = __("Title is not empty !", 'alothemes');
            }else if(isset($value[$titleUS]) && $_GET['action'] != 'edit'){
                $error['title'] = __("Title already exists !", 'alothemes');
            }
            
            if(is_numeric($title)){
                $error['title'] = __("Title need at least 1 character !", 'alothemes');
            }
    
            if(trim($content) == null) $error['Content'] = __("Content is not empty !", 'alothemes');
    
            if(count($error) == 0){
                unset($value[$text]);
                $value[$titleUS] = array(
                    'name'      => $_POST['title'],
                    'value'     => $_POST['content'],
                    'status'    => 1
                );
                $value = json_encode($value);
                update_option('magiccart_block', $value);
                echo $value;
                $paged = max(1, $_GET['paged']);
                wp_redirect('?action=edit&page=' . $_GET['page'] . '&identifier=' . $titleUS . '&paged=' . $paged );
            }else{
                $strError = '';
                foreach($error as $key => $value){
                    $strError .= $key . ' : ' . $value . '</br>';
                }
                $message = "<div class='error'>{$strError}</div>";
            }
            $data['message']        = $message;
            $data['title']          = $_POST['title'];
            $data['content']        = $_POST['content'];
        }
        return $data;
    }
    
    /* edit status */
    public function editStatus(){
        $status = $_GET['status'];
        ($status == 'inactive' ) ? $status = 0 : $status = 1;
        $text   = $_GET['identifier'];
        $value  = get_option('magiccart_block', '');
        $value  = json_decode($value, true);
    
        if(isset($value[$text])) $value[$text]['status'] = $status;
        $value = json_encode($value);
        update_option('magiccart_block', $value);
        wp_redirect("?page=" . $_GET['page'] ."&module=cms&block=gird&model=collection&controller=block&view=gird" );
    }
    
    /* Delete */
    public function delete(){
        $text = $_GET['identifier'];
        $value = get_option('magiccart_block', '');
        $value  = json_decode($value, true);
    
        if(isset($value[$text])) unset($value[$text]);
        $value = json_encode($value);
        update_option('magiccart_block', $value);
        $value  = json_decode($value, true);
    
        wp_redirect("?page=" . $_GET['page']."&module=cms&block=gird&model=collection&controller=block&view=gird" );
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

