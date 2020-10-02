<?php

require_once "./vendor/autoload.php";
require_once "./settings.php";

/**
 * Output an image in HTML along with provided caption and public_id
 *
 * @param        $img
 * @param array  $options
 * @param string $caption
 */
function show_image($img, $options = array(), $caption = '')
{
    $options['format'] = $img['format'];
    $transformation_url = cloudinary_url($img['public_id'], $options);

    echo '<div class="item">';
    echo '<div class="caption">' . $caption . '</div>';
    echo '<a href="' . $img['url'] . '" target="_blank">' . cl_image_tag($img['public_id'], $options) . '</a>';
    echo '<div class="public_id">' . $img['public_id'] . '</div>';

    echo '<div class="link"><a target="_blank" href="' . $transformation_url . '">' . $transformation_url . '</a></div>';
    echo '</div>';
}



$fromFileDir = $_FILES["fileToUpload"]["tmp_name"];

print_r($fromFileDir);

//$default_upload_options = array('tags' => 'basic_sample');
//
//$resultFromUpload = \Cloudinary\Uploader::upload($fromFileDir,
//    array_merge(
//        $default_upload_options,
//        array(
//            'public_id' => 'nature',
//        )
//    ));
//
//$encodedResults = json_encode($resultFromUpload);
//
//$decodedResults = json_decode($encodedResults, true);
//
//echo($decodedResults['asset_id']);
//
//
//show_image($resultFromUpload);













?>