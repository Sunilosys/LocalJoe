<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LjS3UploadHandler
 *
 * @author sunil_salunkhe
 */
require_once 'Zend/Service/Amazon/S3.php';

class LjS3UploadHandler {

    protected $options;

    function __construct($options = null) {
        $this->userId = 0;
        $this->userEmail = "";
        $user_dir = "";
        $amazon_S3_url = "";
        $original_image_object = "";
        $thumbnail_image_object = "";
        $lj_bucket_name = "";

        //Config file setting
        $amazonConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'amazon');

        $this->s3 = new Zend_Service_Amazon_S3($amazonConfig->accessKey,
                        $amazonConfig->secretKey);
        $this->permissions = array(Zend_Service_Amazon_S3::S3_ACL_HEADER
            => Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ, 'Cache-Control' => 'max-age=' . $amazonConfig->max_age);
        $this->original_image_name_format = $amazonConfig->original_image_name_format;
        $this->thumbnail_image_name_format = $amazonConfig->thumbnail_image_name_format;
        $this->profile_original_image_name_format = $amazonConfig->profile_original_image_name_format;
        $this->profile_thumbnail_image_name_format = $amazonConfig->profile_thumbnail_image_name_format;
        $this->profile_pic_extension = $amazonConfig->profile_pic_extension;
        $import_log_name_format = $amazonConfig->import_log_name_format;
        $export_log_name_format = $amazonConfig->export_log_name_format;
        $lj_bucket_name = $amazonConfig->lj_bucket_name;
        $amazon_S3_url = $amazonConfig->amazon_S3_url;
        $amazon_S3_access_url = $amazonConfig->amazon_S3_access_url;
        //Get user info
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            $this->userId = $userInfo['user_id'];
            $this->userEmail = $userInfo['email'];
            if ($this->userId != 0)
                $user_dir = $this->userId;
            else
                $user_dir = $this->userEmail;
        }
//        else {
//            return null;
//        }
        //Replace USER_ID from original image name format

        $original_image_object = str_replace('USER_ID', $user_dir, $this->original_image_name_format);

        //Replace USER_ID from thumbnails image name format
        $thumbnail_image_object = str_replace('USER_ID', $user_dir, $this->thumbnail_image_name_format);

        $profile_original_image_object = str_replace('USER_ID', $user_dir, $this->profile_original_image_name_format);

        //Replace USER_ID from thumbnails image name format
        $profile_thumbnail_image_object = str_replace('USER_ID', $user_dir, $this->profile_thumbnail_image_name_format);


        $this->options = array(
            'amazon_S3_url' => $amazon_S3_url,
            'amazon_S3_access_url' => $amazon_S3_access_url,
            'lj_bucket_name' => $lj_bucket_name,
            'original_image_object' => $original_image_object,
            'thumbnail_image_object' => $thumbnail_image_object,
            'profile_original_image_object' => $profile_original_image_object,
            'profile_thumbnail_image_object' => $profile_thumbnail_image_object,
            'import_log_name_format' => $import_log_name_format,
            'export_log_name_format' => $export_log_name_format,
            'temp_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/images/uploads',
            'param_name' => 'files',
            'action_url' => '/upload/index',
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
            'discard_aborted_uploads' => false,
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
                    'thumbnail_image_object' => $thumbnail_image_object,
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

            if (isset($imagesObj) && sizeof($imagesObj) > 0) {
                foreach ($imagesObj as $key => $value) {

                    if (isset($value['image_file']) && $value['image_file'] != "undefined") {
                        $file = new stdClass();
                        $file->image_id = $value['image_id'];
                        $file->name = $value['image_file'];
                        $file->size = $value['image_size'];
                        $file->coverClass = "";
//                    if (sizeof($fileArray) == 0)
//                         $file->coverClass = "cover";
                        if (isset($postImagesObj) && sizeof($postImagesObj) > 0) {
                            foreach ($postImagesObj as $key2 => $value2) {
                                if ($value2['image_id'] == $value['image_id']) {
                                    $file->checkClass = "selected";
                                    if ($value2['is_main_image'] == 1)
                                        $file->coverClass = "cover";
                                }
                            }
                        }
                        else {
                            $file->checkClass = "unselected";
                        }
                        $fileExtension = strtolower(substr(strrchr($value['image_file'], '.'), 1));
                        $fileName = $value['image_id'] . '.' . $fileExtension;
                        $imageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $fileName);
//                        if (!$this->s3->isObjectAvailable($imageObjName))
//                            continue;
                        $file->url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $imageObjName);
                        $file->caption = $value['image_title'];
                        $file->org_img_width = $value['org_img_width'];
                        $file->org_img_height = $value['org_img_height'];
                        foreach ($this->options['image_versions'] as $version => $options) {
                            $imageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $fileName);
                            $file->{$version . '_url'} = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $imageObjName);

                            $file->image_type = $version;

                            $file->image_type_width = $value['image_type_width'];
                            $file->image_type_height = $value['image_type_height'];
                            $file->image_type_size = $value['image_type_size'];
                        }
                        $this->set_file_delete_url($file);
                        $fileArray[] = $file;
                    }
                }
            }
            return array_values($fileArray);
        }
    }

    protected function create_scaled_image($newFileName, $original_url, $thumbnailImageObjName, $thumbnail_url, $options) {
        $file_path = $original_url;
        $new_file_path = $thumbnail_url;
        $tempFilePath = $this->options['temp_dir'] . '/' . $newFileName;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
                $options['max_width'] / $img_width, $options['max_height'] / $img_height
        );
//        if ($scale >= 1) {
//            if ($file_path !== $new_file_path) {
//                return copy($file_path, $new_file_path);
//            }
//            return true;
//        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($newFileName, '.'), 1))) {
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
                ) && $write_image($new_img, $tempFilePath, $image_quality);


        $this->s3->putObject($thumbnailImageObjName, file_get_contents($tempFilePath), $this->permissions);
        // Free up memory (imagedestroy does not delete files):
        unlink($tempFilePath);
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
//        if (is_int($this->options['max_number_of_files']) && (
//                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
//        ) {
//            return 'maxNumberOfFiles';
//        }
        return $error;
    }

    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' (' . $index . ')' . $ext;
    }

    protected function save_thumbnailInfo($imageId, $fileName, $fileSize, $width, $height) {

        $arImageTypeInfo = array(
            'image_id' => $imageId,
            'image_type_id' => 1,
            'image_file' => $fileName,
            'image_size' => $fileSize,
            'width' => $width,
            'height' => $height,
            'date_created' => date("Y-m-d H:i:s")
        );
        $imageTypeResult = $this->imageInfo->execute_service('Application_Service_CreateImageCopy', $arImageTypeInfo, false);
    }

    protected function save_fileInfo($fileName, $fileTitle, $fileSize, $width, $height) {
        $last_insert_image_id = -1;
        $userInfoNamespace = new Zend_Session_Namespace('UserInfo');
        if (isset($userInfoNamespace) && isset($userInfoNamespace->user_info)) {
            $userInfo = $userInfoNamespace->user_info;
            if ($userInfo['user_id'] != 0) {
                $arImageInfo = array(
                    'user_id' => $userInfo['user_id'],
                    'image_title' => $fileTitle,
                    'image_file' => $fileName,
                    'image_size' => $fileSize,
                    'width' => $width,
                    'height' => $height,
                    'date_created' => date("Y-m-d H:i:s")
                );
                $this->imageInfo = new Application_Service_LjSession();
                $last_insert_image_id = $this->imageInfo->execute_service('Application_Service_CreateImage', $arImageInfo, false);
            }
        }
        return $last_insert_image_id;
    }

    public function GetImageObjName($type, $fileName) {
        $imageObjName = "";
        if ($type == Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL)
            $imageObjName = str_replace('IMAGE_ID', rawurlencode($fileName), $this->options['original_image_object']);

        else if ($type == Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL)
            $imageObjName = str_replace('IMAGE_ID', rawurlencode($fileName), $this->options['thumbnail_image_object']);
        return $imageObjName;
    }

    public function GetProfileImageObjName($type, $fileExtension) {
        $imageObjName = "";
        if ($type == Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL)
            $imageObjName = $this->options['profile_original_image_object'] . $fileExtension;

        else if ($type == Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL)
            $imageObjName = $this->options['profile_thumbnail_image_object'] . $fileExtension;
        return $imageObjName;
    }

    public function GetImageAccessUrl($type, $imageObjName) {
        $imageUrl = "";
        $imageUrl = $this->options['amazon_S3_url'] . '/' . $imageObjName;
        //$imageUrl = $imageUrl . '?v=' . strtotime('now');
        return $imageUrl;
    }

    public function GetAmazonS3Url() {
        $amazonS3Url = "";
        $amazonS3Url = $this->options['amazon_S3_url'];

        return $amazonS3Url;
    }

    public function ReplaceS3URLWithCloudfrontURL($shortHtml) {
        $shortHtml = str_replace($this->options['amazon_S3_url'] . '/' . $this->options['lj_bucket_name'], $this->options['amazon_S3_access_url'], $shortHtml);


        return $shortHtml;
    }

    public function GetS3ImageUrl($userId, $type, $fileName, $imageId) {
        $imageUrl = "";
        $fileExtension = strtolower(substr(strrchr($fileName, '.'), 1));
        $newFileName = $imageId . '.' . $fileExtension;
        $imageObjName = "";

        $original_image_object = str_replace('USER_ID', $userId, $this->original_image_name_format);
        $thumbnail_image_object = str_replace('USER_ID', $userId, $this->thumbnail_image_name_format);

        if ($type == Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL)
            $imageObjName = str_replace('IMAGE_ID', $newFileName, $original_image_object);

        else if ($type == Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL)
            $imageObjName = str_replace('IMAGE_ID', $newFileName, $thumbnail_image_object);

        $imageObjName = str_replace($this->options['lj_bucket_name'], '', $imageObjName);
        $imageUrl = $this->options['amazon_S3_access_url'] . $imageObjName;
        //$imageUrl = $imageUrl . '?v=' . strtotime('now');

        return $imageUrl;
    }

    public function GetS3ImageUrlForHomePage($userId, $type, $fileName, $imageId) {
        $imageUrl = "";
        $fileExtension = strtolower(substr(strrchr($fileName, '.'), 1));
        $newFileName = $imageId . '.' . $fileExtension;
        $imageObjName = "";

        $original_image_object = str_replace('USER_ID', $userId, $this->original_image_name_format);
        $thumbnail_image_object = str_replace('USER_ID', $userId, $this->thumbnail_image_name_format);

        if ($type == Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL)
            $imageObjName = str_replace('IMAGE_ID', $newFileName, $original_image_object);

        else if ($type == Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL)
            $imageObjName = str_replace('IMAGE_ID', $newFileName, $thumbnail_image_object);
        $imageObjName = str_replace($this->options['lj_bucket_name'], '', $imageObjName);
        $imageUrl = $this->options['amazon_S3_access_url'] . $imageObjName;

        return $imageUrl;
    }

    public function GetS3ProfilePicUrl($userId) {
        $imageUrl = "";
        $profile_original_image_object = str_replace('USER_ID', $userId, $this->profile_original_image_name_format);
       
        $originalImageObjName = $profile_original_image_object . $this->profile_pic_extension;

        if ($this->s3->isObjectAvailable($originalImageObjName)) {

            $imageUrl = $this->options['amazon_S3_url'] . '/' . $originalImageObjName;
            $imageUrl = $imageUrl . '?v=' . strtotime('now');
        } else {
            $imageUrl = null;
        }
        return $imageUrl;
    }

    protected function handle_profile_pic_upload($method) {
        $file = new stdClass();
        $originalImageObjName = $this->GetProfileImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $this->profile_pic_extension);
        $thumbnailImageObjName = $this->GetProfileImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $this->profile_pic_extension);
        $file->url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $originalImageObjName);
        $file->thumbnail_url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $thumbnailImageObjName);
        clearstatcache();
        $newFileName = $this->userId . $this->profile_pic_extension;
        if ($method == 'UPLOAD') {
            $tmp = $_FILES['profilePicInput']['tmp_name'];
            $this->s3->putObject($originalImageObjName, fopen($tmp, 'r'), $this->permissions);
        }
        else
            $this->s3->putObject($originalImageObjName, file_get_contents('php://input'), $this->permissions);
        foreach ($this->options['image_versions'] as $version => $options) {
            $this->create_scaled_image($newFileName, $file->url, $thumbnailImageObjName, $file->thumbnail_url, $options);
        }
        return $file;
    }

    public function handle_import_log_upload($filePath, $importId) {
        $file = new stdClass();
        $newFileName = $importId . '.log';
        $importObjName = str_replace('IMPORT_ID', $newFileName, $this->options['import_log_name_format']);
        $file->url = $this->options['amazon_S3_url'] . '/' . $importObjName;

        clearstatcache();

        $tmp = $filePath;
        $this->s3->putObject($importObjName, fopen($tmp, 'r'), $this->permissions);
        return $file;
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        $file->caption = $file->name;
        $error = $this->has_error($uploaded_file, $file, $error);
        $originalImageObjName = null;
        $thumbnailImageObjName = null;
        $org_img_width = 0;
        $org_img_height = 0;
        $file->image_id = "";
        $newFileName = "";
        if (!$error && $file->name) {

            //Save file info in DB. 
            list($org_img_width, $org_img_height) = @getimagesize($uploaded_file);
            $file->org_img_width = $org_img_width;
            $file->org_img_height = $org_img_height;

            $imageId = $this->save_fileInfo($file->name, $file->name, $file->size, $file->org_img_width, $file->org_img_height);

            if ($imageId < 0) {

                //User is not yet logged in.   
                $originalImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $file->name);
                $thumbnailImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $file->name);
                $newFileName = $file->name;
            } else {
                //Logged in User

                $fileExtension = strtolower(substr(strrchr($file->name, '.'), 1));
                $newFileName = $imageId . '.' . $fileExtension;
                $originalImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $newFileName);
                $thumbnailImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $newFileName);
                $file->image_id = $imageId;
            }

            $file->url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $originalImageObjName);
            $file->thumbnail_url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $thumbnailImageObjName);

            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                $this->s3->putObject($originalImageObjName, fopen($uploaded_file, 'r'), $this->permissions);
            } else {
                // Non-multipart uploads (PUT method support)               
                $this->s3->putObject($originalImageObjName, fopen('php://input', 'r'), $this->permissions);
            }
            $metadata = $this->s3->getInfo($originalImageObjName);
            $file_size = $metadata['size'];
            $image_type_size = 0;
            $image_type_width = 0;
            $image_type_height = 0;
            $image_type = "";
            if ($file_size == $file->size) {
                //Create Scaled Image
                foreach ($this->options['image_versions'] as $version => $options) {
                    if ($this->create_scaled_image($newFileName, $file->url, $thumbnailImageObjName, $file->thumbnail_url, $options)) {

                        $metadata = $this->s3->getInfo($thumbnailImageObjName);
                        $image_type_size = $metadata['size'];
                        $image_type = $version;
                        list($image_type_width, $image_type_height) = @getimagesize($file->thumbnail_url);
                        if ($file->image_id != "")
                            $this->save_thumbnailInfo($file->image_id, $file->name, $image_type_size, $image_type_width, $image_type_height);
                    }
                }
            } else if ($this->options['discard_aborted_uploads']) {
                $file->error = 'abort';
            }
            $file->size = $file_size;
            $file->checkClass = "selected";



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

    public function get() {

        $info = $this->get_file_objects();
        header('Content-type: application/json');
        echo json_encode($info);
    }

    public function getProfilePic() {

        $info = $this->get_file_objects();
        header('Content-type: application/json');
        echo json_encode($info);
    }

    public function delete() {
        $originalImageObject = "";
        $thumbnailImageObject = "";
        $image_id = isset($_REQUEST['_imageId']) ? $_REQUEST['_imageId'] : null;
        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        if (isset($image_id) && $image_id != "") {
            $fileExtension = strtolower(substr(strrchr($file_name, '.'), 1));
            $fileNameOnS3 = $imageId . '.' . $fileExtension;
        } else {
            $fileNameOnS3 = $file_name;
        }
        $originalImageObject = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $fileNameOnS3);
        $this->s3->removeObject($originalImageObject);
        $thumbnailImageObject = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $fileNameOnS3);
        $this->s3->removeObject($thumbnailImageObject);

        if (isset($image_id) && $image_id != "") {
            $this->imageInfo = new Application_Service_LjSession();
            $arImageId = array(
                'image_id' => $image_id
            );
            $this->imageInfo->execute_service('Application_Service_DeletePostingImage', $arImageId, false);
            $this->imageInfo->execute_service('Application_Service_DeleteImageCopy', $arImageId, false);
            $this->imageInfo->execute_service('Application_Service_DeleteImage', $arImageId, false);
        }
        header('Content-type: application/json');
        echo json_encode(true);
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

    public function postProfilePic($method) {

        $info = array();
        $info = $this->handle_profile_pic_upload($method);
        header('Vary: Accept');
        $json = json_encode($info);

        if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        echo $json;
    }

    public function copy($fileName, $imageId) {
        $fileExtension = strtolower(substr(strrchr($fileName, '.'), 1));
        $newFileName = $imageId . '.' . $fileExtension;
        $originalImageObjNameOld = str_replace("USER_ID", $this->userEmail, $this->original_image_name_format);
        $originalImageObjNameOld = str_replace("IMAGE_ID", $fileName, $originalImageObjNameOld);

        $thumbnailImageObjNameOld = str_replace("USER_ID", $this->userEmail, $this->thumbnail_image_name_format);
        $thumbnailImageObjNameOld = str_replace("IMAGE_ID", $fileName, $thumbnailImageObjNameOld);

        $originalImageUrlOld = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $originalImageObjNameOld);
        $thumbnailImageUrlOld = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $thumbnailImageObjNameOld);

        $originalImageObjNameNew = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $newFileName);
        $thumbnailImageObjNameNew = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $newFileName);


        if ($this->s3->isObjectAvailable($originalImageObjNameOld)) {
            $this->s3->putObject($originalImageObjNameNew, file_get_contents($originalImageUrlOld), $this->permissions);
            //$this->s3->removeObject($originalImageObjNameOld);
        }
        if ($this->s3->isObjectAvailable($thumbnailImageObjNameOld)) {
            $this->s3->putObject($thumbnailImageObjNameNew, file_get_contents($thumbnailImageUrlOld), $this->permissions);
            //$this->s3->removeObject($thumbnailImageObjNameOld);
        }
    }
    
    public function copyImageFromMailbox($imageId, $image, $ext, $userId) {

        try {

            $newFileName = $imageId . '.' . $ext;
            $originalImageObjNameNew = str_replace("USER_ID", $userId, $this->original_image_name_format);
            $originalImageObjNameNew = str_replace("IMAGE_ID", $newFileName, $originalImageObjNameNew);

            $thumbnailImageObjNameNew = str_replace("USER_ID", $userId, $this->thumbnail_image_name_format);
            $thumbnailImageObjNameNew = str_replace("IMAGE_ID", $newFileName, $thumbnailImageObjNameNew);

            $this->s3->putObject($originalImageObjNameNew, $image, $this->permissions);
            $file = new stdClass();
            $file->url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $originalImageObjNameNew);
            $file->thumbnail_url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $thumbnailImageObjNameNew);


            foreach ($this->options['image_versions'] as $version => $options) {
                $this->create_scaled_image($newFileName, $file->url, $thumbnailImageObjNameNew, $file->thumbnail_url, $options);
            }
        } catch (Exception $ex) {
            $log = Zend_Registry::get('log');

            if (isset($log))
                $log->info($ex->getTrace());
        }
    }

    public function copyImageFromCL($imageUrl, $imageId, $userId) {
        $s3ImageUrl = null;
        try {
            $fileExtension = strtolower(substr(strrchr($imageUrl, '.'), 1));
            $newFileName = $imageId . '.' . $fileExtension;
            $originalImageObjNameNew = str_replace("USER_ID", $userId, $this->original_image_name_format);
            $originalImageObjNameNew = str_replace("IMAGE_ID", $newFileName, $originalImageObjNameNew);

            $thumbnailImageObjNameNew = str_replace("USER_ID", $userId, $this->thumbnail_image_name_format);
            $thumbnailImageObjNameNew = str_replace("IMAGE_ID", $newFileName, $thumbnailImageObjNameNew);

            $this->s3->putObject($originalImageObjNameNew, file_get_contents($imageUrl), $this->permissions);
            $this->s3->putObject($thumbnailImageObjNameNew, file_get_contents($imageUrl), $this->permissions);
            $this->sessionObj = new Application_Service_LjSession();
            $arImageUrl = array(
                'image_id' => $imageId,
                'image_url' => null
            );
            $ImageUrlUpdate = $this->sessionObj->execute_service('Application_Service_SetImageUrlNull', $arImageUrl, false);
            $s3ImageUrl = $this->options['amazon_S3_url'] . '/' . $thumbnailImageObjNameNew;
        } catch (Exception $ex) {
            $log = Zend_Registry::get('log');

            if (isset($log))
                $log->info($ex->getTrace());
        }
        return $s3ImageUrl;
    }

    public function save() {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'SAVE') {
            try {
                $newImage = file_get_contents($_REQUEST['newImage']);
                //fileName
                $fileName = $_REQUEST['fileName'];
                $imageId = $_REQUEST['imageId'];
                $originalImageObjName = "";
                $thumbnailImageObjName = "";
                if (isset($imageId) && $imageId != "") {
                    //Logged in User

                    $fileExtension = strtolower(substr(strrchr($fileName, '.'), 1));
                    $newFileName = $imageId . '.' . $fileExtension;
                    $originalImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $newFileName);
                    $thumbnailImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $newFileName);
                } else {

                    //User is not yet logged in.   
                    $originalImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $file->name);
                    $thumbnailImageObjName = $this->GetImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $file->name);
                    $newFileName = $fileName;
                }
                $original_url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $originalImageObjName);
                $thumbnail_url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $thumbnailImageObjName);
                $this->s3->putObject($originalImageObjName, $newImage, $this->permissions);

                foreach ($this->options['image_versions'] as $version => $options) {
                    $this->create_scaled_image($newFileName, $_REQUEST['newImage'], $thumbnailImageObjName, $thumbnail_url, $options);
                }
            } catch (Exception $Ex) {
                
            }
            exit;
        }
    }

    public function saveProfilePic() {

        try {
            $newImage = file_get_contents($_REQUEST['newImage']);

            $originalImageObjName = "";
            $thumbnailImageObjName = "";
            $originalImageObjName = $this->GetProfileImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $this->profile_pic_extension);
            $thumbnailImageObjName = $this->GetProfileImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $this->profile_pic_extension);
            $file->url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $originalImageObjName);
            $file->thumbnail_url = $this->GetImageAccessUrl(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $thumbnailImageObjName);
            clearstatcache();
            $newFileName = $this->userId . $this->profile_pic_extension;
            $this->s3->putObject($originalImageObjName, $newImage, $this->permissions);

            foreach ($this->options['image_versions'] as $version => $options) {
                $this->create_scaled_image($newFileName, $_REQUEST['newImage'], $thumbnailImageObjName, $file->thumbnail_url, $options);
            }
        } catch (Exception $Ex) {
            
        }
        exit;
    }

    public function deleteProfilePic() {

        try {

            $originalImageObjName = $this->GetProfileImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_ORIGINAL, $this->profile_pic_extension);
            $thumbnailImageObjName = $this->GetProfileImageObjName(Application_Model_LjConstants::$IMAGE_TYPE_THUMBNAIL, $this->profile_pic_extension);
            $this->s3->removeObject($originalImageObjName);

            $this->s3->removeObject($thumbnailImageObjName);
        } catch (Exception $Ex) {
            
        }
        exit;
    }

}

?>
