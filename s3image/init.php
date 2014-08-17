<?php defined('SYSPATH') or die('No direct access');

Route::set('amazon_s3image','s3/images'/*,array('image'=>'.+')*/)
    ->defaults(array(
        'controller' => 's3image',
        'action' => 'index',
    ));