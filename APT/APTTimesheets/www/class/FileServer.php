<?php

namespace Phppot;

error_reporting(E_ALL);
ini_set("display_errors", 1);

//require_once '../vendor/autoload.php';
//require_once '../config.php';


//require_once './APT/APTTimesheets/www/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/vendor/autoload.php';

//require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/config.php';
//require_once '../config.php';
/*
 * Class serves to encapsulate the current Fileserver implementation from Cloudinary.
 *
 *
 *
 *
 */

class FileServer {

    public static function upload($file, $options = array()) {
        return \Cloudinary\Uploader::upload($file, $options);
    }

}


