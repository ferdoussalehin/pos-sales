<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload
{
  
    // To load this model
    // $this->fileupload->do_upload($upload_path = 'assets/images/profile/', $field_name = 'userfile');

    function do_upload($upload_path = null, $field_name = null) {
        if (empty($_FILES[$field_name]['name'])) {
            return null;
        } else {
            //-----------------------------
            $ci =& get_instance();
            $ci->load->helper('url');  

            // Image name with timestamp e,g image_34363636.jpg
            $file = $_FILES[$field_name]['name'];
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $ext = substr(strtolower(strrchr($file, '.')), 1);
            $image_name = $filename . '_' . strtotime(date("Y-m-d h:i:sa")); 
            $image_name = $image_name . '.' .$ext;

            $config = array();
            //set config 
            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'webp|gif|jpg|png|jpeg|ico|pdf|doc|docx',
                //'max_filename'  => 7,
                'overwrite'     => false,
                'maintain_ratio' => true,
                'encrypt_name'  => false,
                'remove_spaces' => true,
                'file_ext_tolower' => true,
                'file_name' => $image_name
            ]; 
             $ci->load->library('upload', $config);
             $ci->upload->initialize($config);

            if (!$ci->upload->do_upload($field_name)) {
                return false;
            } else {
                $file = $ci->upload->data();
                return $upload_path.$file['file_name'];
            }
        }
    }   

    public function do_resize($file_path = null, $width = null, $height = null) {

        $ci =& get_instance();
        $ci->load->library('image_lib');
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $file_path,
            'create_thumb'   => false,
            'maintain_ratio' => false,
            'width'          => $width,
            'height'         => $height,
        ]; 
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();
    }

}

