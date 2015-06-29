<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application_Model_LjConstants
 *
 * @author sunil_salunkhe
 */
class Application_Model_LjConstants {

    public static $SUCCESS = 'success';
    public static $FAILURE = 'failure';
    //Post Status Constants
    public static $POST_STATUS_CREATED_ID = 1;
    public static $POST_STATUS_ACTIVE_ID = 2;
    public static $POST_STATUS_DELETED_ID = 3;
    public static $POST_STATUS_EXPIRED_ID = 4;
    public static $POST_STATUS_CREATED_STATUS = 'Created';
    public static $POST_STATUS_ACTIVE_STATUS = 'Active';
    public static $POST_STATUS_DELETED_STATUS = 'Deleted';
    public static $POST_STATUS_EXPIRED_STATUS = 'Expired';
    //Error Messages 
    public static $POST_DELETE_NOT_AUTHORIZED_MESSAGE = 'Only poster can delete the post.You are not authorizied to delete this post.';
    public static $ERROR_MESSAGE_UNEXPECTED = 'Unexpected error occurred. Please try again.';
    public static $POST_EDIT_NOT_AUTHORIZED_MESSAGE = 'Only poster can edit the post.You are not authorizied to edit this post.';
    public static $POST_REPOST_NOT_AUTHORIZED_MESSAGE = 'Only poster can repost the post.You are not authorizied to repost this post.';
    public static $POST_FLAG_DELETED_NOT_AUTHORIZED_MESSAGE = 'Only poster can flag posting for deletion.You are not authorizied to flag this post for deletion.';
    //Success messages
    public static $POST_DELETE_SUCCESS_MESSAGE = 'Your past has been successfully deleted.';
    public static $POST_EDIT_SUCCESS_MESSAGE = 'Your past has been successfully edited.';
    public static $POST_CREATE_SUCCESS_MESSAGE = 'Your past has been successfully created.';
    public static $POST_REPOST_SUCCESS_MESSAGE = 'Your past has been successfully reposted.';
    public static $POST_FLAG_DELETD_SUCCESS_MESSAGE = 'Your past has been successfully flaged for deletion.';
    //Image Upload
    public static $IMAGE_TYPE_ORIGINAL = 'original';
    public static $IMAGE_TYPE_THUMBNAIL = 'thumbnail';
    public static $DEFAULT_IMAGE_URL = '/images/category/category-name.png';
    public static $POST_ACTION_VIEW_ID = 1;
    public static $POST_ACTION_EMAIL_ID = 2;
    public static $POST_ACTION_SPAM_ID = 3;
    public static $POST_ACTION_FB_SHARE_ID = 4;
    public static $POST_ACTION_TWITTER_SHARE_ID = 5;
    public static $POST_ACTION_RESPONSE_ID = 6;
    public static $POST_ACTION_CREATE_ID = 7;
    public static $POST_ACTION_EDIT_ID = 8;
    public static $POST_ACTION_REPOST_ID = 9;
    public static $POST_ACTION_DELETE_ID = 10;
    public static $POST_ACTION_FAVORITE_ID = 11;
    public static $POST_ACTION_REMOVE_FAVORITE_ID = 11;
    public static $WELCOME_MESSAGE = 'Welcome to Local Joe. Your account has been activated.';

}

