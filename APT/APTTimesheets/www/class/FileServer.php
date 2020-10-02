<?php

namespace Phppot;


require_once '../vendor/autoload.php';
require_once '../config.php';

/*
 * Class serves to encapsulate the current Fileserver implementation from Cloudinary.
 *
 *
 */

class FileServer {

    public static function upload($file, $options = array()) {
        return \Cloudinary\Uploader::upload($file, $options);
    }

}


