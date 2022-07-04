<?php

use API\Core\Utils\Logger;

function postUploadTask($images){

    Logger::log('postUploadTask ' . gettype($images));

    foreach ($images as $image) {
        makeThumb($image);
    }
}
function makeThumb($assetName)
{
    $wm_source  = APP_ASSET_BASE.'images/microPHPLogo_md.png';
    $base_path = APP_STORAGE_CACHED;

    $fInfo = finfo_open();
    $fileInfo = finfo_file($fInfo, APP_STORAGE_DOWNLOADS.$assetName, FILEINFO_MIME_TYPE);
    finfo_close($fInfo);

    $source_image = match ($fileInfo) {
        'image/gif' => imagecreatefromgif(APP_STORAGE_DOWNLOADS . $assetName),
        'image/png' => imagecreatefrompng(APP_STORAGE_DOWNLOADS . $assetName),
        'image/jpeg' => imagecreatefromjpeg(APP_STORAGE_DOWNLOADS . $assetName),
        default => null,
    };

    $source_imageX = imagesx($source_image);
    $source_imageY = imagesy($source_image);

    $watermark = imagecreatefrompng($wm_source);
    $wm_w = imagesx($watermark);
    $wm_h = imagesy($watermark);

    $wm_x = $source_imageX - $wm_w;
    $wm_y = $source_imageY - $wm_h;

    imagecopy($source_image, $watermark, $wm_x, $wm_y, 0, 0, $source_imageX, $source_imageY);

    $resize = imageResize($source_imageX, $source_imageY, 400);

    $dest_imageX = $resize['x'];
    $dest_imageY = $resize['y'];

    $dest_image = imagecreatetruecolor($dest_imageX, $dest_imageY);
    imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imageX, $dest_imageY, $source_imageX, $source_imageY);

    if(Imagejpeg($dest_image, $base_path.$assetName ,80)) {
        Logger::log('Image Saved....' . $assetName);
    }
}
function imageResize($width, $height, $target) : array
{
    $percentage=null;
    if ($width > $height) {
        $percentage = ($target / $width);
    } else {
        $percentage = ($target / $height);
    }
    $width = round(($width) * $percentage);
    $height = round(($height) * $percentage);
    return [
        'x'=>$width,
        'y'=>$height,
    ];
}


