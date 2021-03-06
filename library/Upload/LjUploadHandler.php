<?php

/*
 * jQuery File Upload Plugin PHP Class 5.9
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

class LjUploadHandler {

    protected $options;

    function __construct($options = null) {
        $userId = 0;
        $userEmail = "";
        $user_dir = "";
        $original_upload_dir = "";
        $original_upload_url = "";
        $thumbnails_upload_dir = "";
        $thumbnails_upload_url = "";
        $fullUrl = "";
        $publicDir = "";
        //Get user info
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $userId = $userInfo['user_id'];
            $userEmail = $userInfo['email'];
            if ($userId != 0)
                $user_dir = $userId;
            else
                $user_dir = $userEmail;
        }
        else {
            return null;
        }
        //read imageupload config
        $imageUploadConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'imageupload');
        if (isset($imageUploadConfig)) {
            if ($imageUploadConfig->store == "localhost") {
                $fullUrl = $this->getFullUrl();
                $publicDir = dirname($_SERVER['SCRIPT_FILENAME']);
            } else {
                $fullUrl = $imageUploadConfig->image_store_url;
                $publicDir = $imageUploadConfig->image_store_path;
            }

            $user_path = $publicDir . '/' .
                    $imageUploadConfig->image_upload_dir . '/' .
                    $user_dir;

            $original_upload_dir = $publicDir . '/' .
                    $imageUploadConfig->image_upload_dir . '/' .
                    $user_dir . '/' .
                    $imageUploadConfig->original_image_dir . '/';

            $original_upload_url = $fullUrl . '/' .
                    $imageUploadConfig->image_upload_dir . '/' .
                    $user_dir . '/' .
                    $imageUploadConfig->original_image_dir . '/';


            $thumbnails_upload_dir = $publicDir . '/' .
                    $imageUploadConfig->image_upload_dir . '/' .
                    $user_dir . '/' .
                    $imageUploadConfig->thumbnails_image_dir . '/';
            ;
            $thumbnails_upload_url = $fullUrl . '/' .
                    $imageUploadConfig->image_upload_dir . '/' .
                    $user_dir . '/' .
                    $imageUploadConfig->thumbnails_image_dir . '/';

            if (!file_exists($user_path)) {
                $oldumask = umask(0);
                mkdir($user_path, 0777);
                mkdir($original_upload_dir, 0777);
                mkdir($thumbnails_upload_dir, 0777);
                umask($oldumask);
            }
        } else {
            $oldumask = umask(0);
            if (!file_exists($original_upload_dir))
                mkdir($original_upload_dir, 0777);
            if (!file_exists($thumbnails_upload_dir))
                mkdir($thumbnails_upload_dir, 0777);
            umask($oldumask);
        }

        $this->options = array(
            'upload_dir' => $original_upload_dir,
            'upload_url' => $original_upload_url,
            'action_url' => '/upload/index',
            'param_name' => 'files',
            // Set the following option to 'POST', if your server does not support
            // DELETE requests. This is a parameter sent to the client:
            'delete_type' => 'DELETE',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            'max_number_of_files' => null,
            // Set the following option to false to enable resumable uploads:
            'discard_aborted_uploads' => true,
            // Set to true to rotate images based on EXIF meta data, if available:
            'orient_image' => false,
            'image_versions' => array(
                // Uncomment the following version to restrict the size of
                // uploaded images. You can also add additional versions with
                // their own upload directories:
                /*
                  'large' => array(
                  'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/',
                  'upload_url' => $this->getFullUrl().'/files/',
                  'max_width' => 1920,
                  'max_height' => 1200,
                  'jpeg_quality' => 95
                  ),
                 */
                'thumbnail' => array(
                    'upload_dir' => $thumbnails_upload_dir,
                    'upload_url' => $thumbnails_upload_url,
                    'max_width' => 150,
                    'max_height' => 150
                )
            )
        );
        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
    }

    protected function getFullUrl() {
        return
                (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') .
                (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
                (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                        (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
                        $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
                substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    protected function set_file_delete_url($file) {
        $file->delete_url = $this->options['action_url']
                . '?file=' . rawurlencode($file->name);
        $file->delete_type = $this->options['delete_type'];
        if ($file->delete_type !== 'DELETE') {
            $file->delete_url .= '&_method=DELETE';
        }
        if (isset($file->image_id))
            $file->delete_url .= '&_imageId=' . $file->image_id;
    }

    public function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'] . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->image_id = null;
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'] . rawurlencode($file->name);
            $file->caption = $file_name;
            list($img_width, $img_height) = @getimagesize($file_path);
            $file->org_img_width = $img_width;
             $file->org_img_height = $img_height;
            $file->checkClass = "unselected";           
            foreach ($this->options['image_versions'] as $version => $options) {
                if (is_file($options['upload_dir'] . $file_name)) {
                    $file->{$version . '_url'} = $options['upload_url']
                            . rawurlencode($file->name);
                    list($img_width, $img_height) = @getimagesize($options['upload_dir'] . $file_name);
                    $file->image_type = $version;
                    $file->image_type_width = $img_width;
                    $file->image_type_height = $img_height;
                    $file->image_type_size = filesize($options['upload_dir'] . $file_name);
                }
            }
            $this->set_file_delete_url($file);
            return $file;
        }
        return null;
    }
    
    public function get_file_full_path($file_name)
    {
        $file_path = $this->options['upload_dir'] . $file_name;
        return $file_path;
    }

    protected function get_file_objects() {
        $userInfo = null;
        $this->userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($this->userInfoNamespace) && isset($this->userInfoNamespace->user_info))
            $userInfo = $this->userInfoNamespace->user_info;

        if (isset($userInfo) && $userInfo['user_id'] != 0) { //get image info from database
            $this->imageInfo = new Application_Service_LjSession();
            $fileArray = array();
            $imagesObj = $this->imageInfo->execute_service('Application_Service_GetImages', $userInfo['user_id'], false);
            $postImagesObj = null;
            if (isset($_REQUEST['postingId']))
               $postImagesObj = $this->imageInfo->execute_service('Application_Service_GetPostingImages', $_REQUEST['postingId'], false);
           
            if (isset($imagesObj))
            {
            foreach ($imagesObj as $key => $value) {
                $file_path = $this->options['upload_dir'] . $value->image_file;
                if (is_file($file_path)) {
                    $file = new stdClass();
                    $file->image_id = $value->image_id;
                    $file->name = $value->image_file;
                    $file->size = $value->image_size;
                    $file->coverClass = "";
//                    if (sizeof($fileArray) == 0)
//                         $file->coverClass = "cover";
                    if (isset($postImagesObj)) {
                            foreach ($postImagesObj as $key2 => $value2) {
                                if ($value2['image_id'] == $value->image_id) {
                                    $file->checkClass = "selected";
                                    if ($value2['is_main_image'] == 1)
                                        $file->coverClass = "cover";
                                }
                            }
                        }
                        else {
                            $file->checkClass = "unselected";
                        }
                    $file->url = $this->options['upload_url'] . rawurlencode($value->image_file);
                    $file->caption = $value->image_title;
                    list($img_width, $img_height) = @getimagesize($file_path);
                    $file->org_img_width = $img_width;
                    $file->org_img_height = $img_height;
                    foreach ($this->options['image_versions'] as $version => $options) {
                        if (is_file($options['upload_dir'] . $value->image_file)) {
                            $file->{$version . '_url'} = $options['upload_url']
                                    . rawurlencode($value->image_file);
                            $file->image_type = $version;
                            list($img_width, $img_height) = @getimagesize($options['upload_dir'] . $value->image_file);
                            $file->image_type_width = $img_width;
                            $file->image_type_height = $img_height;
                            $file->image_type_size = filesize($options['upload_dir'] . $value->image_file);
                        }
                    }
                    $this->set_file_delete_url($file);
                    $fileArray[] = $file;
                }
            }
            }
            return array_values($fileArray);
        }
        else //Scan the directory and get images        
            return array_values(array_filter(array_map(
                                            array($this, 'get_file_object'), scandir($this->options['upload_dir'])
                                    )));
    }

    protected function create_scaled_image($file_name, $options) {
        $file_path = $this->options['upload_dir'] . $file_name;
        $new_file_path = $options['upload_dir'] . $file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
                $options['max_width'] / $img_width, $options['max_height'] / $img_height
        );
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                        $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                        $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }
        $success = $src_img && @imagecopyresampled(
                        $new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height
                ) && $write_image($new_img, $new_file_path, $image_quality);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }

    protected function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
        ) {
            return 'maxFileSize';
        }
        if ($this->options['min_file_size'] &&
                $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
        ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }

    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' (' . $index . ')' . $ext;
    }

    protected function upcount_name($name) {
        return preg_replace_callback(
                        '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/', array($this, 'upcount_name_callback'), $name, 1
        );
    }

    protected function trim_file_name($name, $type) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
                preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.' . $matches[1];
        }
        if ($this->options['discard_aborted_uploads']) {
            while (is_file($this->options['upload_dir'] . $file_name)) {
                $file_name = $this->upcount_name($file_name);
            }
        }
        return $file_name;
    }

    protected function orient_image($file_path) {
        $exif = exif_read_data($file_path);
        $orientation = intval(@$exif['Orientation']);
        if (!in_array($orientation, array(3, 6, 8))) {
            return false;
        }
        $image = @imagecreatefromjpeg($file_path);
        switch ($orientation) {
            case 3:
                $image = @imagerotate($image, 180, 0);
                break;
            case 6:
                $image = @imagerotate($image, 270, 0);
                break;
            case 8:
                $image = @imagerotate($image, 90, 0);
                break;
            default:
                return false;
        }
        $success = imagejpeg($image, $file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($image);
        return $success;
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        $file->caption = $file->name;
        $error = $this->has_error($uploaded_file, $file, $error);
        if (!$error && $file->name) {
            $file_path = $this->options['upload_dir'] . $file->name;
            $append_file = !$this->options['discard_aborted_uploads'] &&
                    is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                            $file_path, fopen($uploaded_file, 'r'), FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                        $file_path, fopen('php://input', 'r'), $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = filesize($file_path);
            $image_type_size = 0;
            $image_type_width = 0;
            $image_type_height = 0;
            $org_img_width = 0;
            $org_img_height = 0;
            $image_type = "";
            if ($file_size === $file->size) {
                if ($this->options['orient_image']) {
                    $this->orient_image($file_path);
                }
                $file->url = $this->options['upload_url'] . rawurlencode($file->name);
                foreach ($this->options['image_versions'] as $version => $options) {
                    if ($this->create_scaled_image($file->name, $options)) {
                        if ($this->options['upload_dir'] !== $options['upload_dir']) {
                            $file->{$version . '_url'} = $options['upload_url']
                                    . rawurlencode($file->name);
                            $image_type_size = filesize($options['upload_dir'] . $file->name);
                            list($img_width, $img_height) = @getimagesize($options['upload_dir'] . $file->name);
                            $image_type_width = $img_width;
                            $image_type_height = $img_height;
                            $image_type = $version;
                        } else {
                            clearstatcache();
                            $file_size = filesize($file_path);
                        }
                    }
                }
            } else if ($this->options['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }
            $file->size = $file_size;
            $file->checkClass = "selected";
            $file->image_id = null;
            list($org_img_width, $org_img_height) = @getimagesize($file_path);
            $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
            if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
                $userInfo = $userInfoNamespace->user_info;
                if ($userInfo['user_id'] != 0) {
                    $arImageInfo = array(
                        'user_id' => $userInfo['user_id'],
                        'image_title' => $file->name,
                        'image_file' => $file->name,
                        'width' => $org_img_width,
                        'height' => $org_img_height,
                        'image_size' => $file->size,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                    $this->imageInfo = new Application_Service_LjSession();
                    $last_insert_image_id = $this->imageInfo->execute_service('Application_Service_CreateImage', $arImageInfo, false);
                    $file->image_id = $last_insert_image_id;
                    $arImageTypeInfo = array(
                        'image_id' => $last_insert_image_id,
                        'image_type_id' => 1,
                        'image_file' => $file->name,
                        'width' => $image_type_width,
                        'height' => $image_type_height,
                        'image_size' => $image_type_size,
                        'date_created' => date("Y-m-d H:i:s")
                    );
                    $imageTypeResult = $this->imageInfo->execute_service('Application_Service_CreateImageCopy', $arImageTypeInfo, false);
                }
            }
            $file->org_img_width = $org_img_width;
            $file->org_img_height = $org_img_height;
            $file->image_type_width = $image_type_width;
            $file->image_type_height = $image_type_height;
            $file->image_type_size = $image_type_size;
            $file->image_type = $image_type;
            $this->set_file_delete_url($file);
        } else {
            $file->error = $error;
        }
        return $file;
    }

    public function get() {
        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }

    public function save() {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'SAVE') {
            try {
                $newImage = file_get_contents($_REQUEST['newImage']);
                //Thumbnails
                $thumbnails = $_REQUEST['oldImage'];
                //Original Image
                $orgImage = str_replace('thumbnails', 'original', $thumbnails);
                //fileName
                $fileName = $_REQUEST['fileName'];
                $file_path = $this->options['upload_dir'] . $fileName;
                file_put_contents($file_path, $newImage);
               foreach ($this->options['image_versions'] as $version => $options) {
                    $this->create_scaled_image($fileName, $options); 
               }
            } catch (Exception $Ex) {
               
            }
            exit;
        }
    }
    public function post() {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->delete();
        }
        $upload = isset($_FILES[$this->options['param_name']]) ?
                $_FILES[$this->options['param_name']] : null;
        $info = array();
        if ($upload && is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {

                $info[] = $this->handle_file_upload(
                        $upload['tmp_name'][$index], isset($_SERVER['HTTP_X_FILE_NAME']) ?
                                $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index], isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                                $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index], isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                                $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index], $upload['error'][$index]
                );
            }
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            $info[] = $this->handle_file_upload(
                    isset($upload['tmp_name']) ? $upload['tmp_name'] : null, isset($_SERVER['HTTP_X_FILE_NAME']) ?
                            $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
                                    isset($upload['name']) : null), isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                            $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
                                    isset($upload['size']) : null), isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                            $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
                                    isset($upload['type']) : null), isset($upload['error']) ? $upload['error'] : null
            );
        }
        header('Vary: Accept');
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
                stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: ' . sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo $json;
    }

    public function delete() {
        $image_id = isset($_REQUEST['_imageId']) ? $_REQUEST['_imageId'] : null;
        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        $file_path = $this->options['upload_dir'] . $file_name;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            foreach ($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'] . $file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
            if (isset($image_id) && $image_id != "") {
                $this->imageInfo = new Application_Service_LjSession();
                $arImageId = array(
                    'image_id' => $image_id
                );
                $deleteImage = $this->imageInfo->execute_service('Application_Service_DeletePostingImage', $arImageId, false);
                $deleteImageCopy = $this->imageInfo->execute_service('Application_Service_DeleteImageCopy', $arImageId, false);
                $deletePostImage = $this->imageInfo->execute_service('Application_Service_DeleteImage', $arImageId, false);
            }
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }

}
