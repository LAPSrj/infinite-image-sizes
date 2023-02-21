<?php
/*
	Plugin Name: Infinite Image Sizes
	Description: Resizes images to specific sizes on the fly.
	Version: 1.0
	Author: Leandro Amorim
	Author URI: https://github.com/LAPSrj
    Text Domain: iis
    Domain Path: /languages
*/

function iis_check_size($image, $attachment_id, $size, $icon){
    if($image && !$icon && is_array($size)){
        return iis_resize_image($image, $attachment_id, $size);
    }else{
        return $image;
    }
}
add_filter('wp_get_attachment_image_src', 'iis_check_size', 99, 4);

function iis_resize_image($source_image, $attachment_id, $size){
    $filepath = iis_get_final_file_path($attachment_id, $size);

    if(file_exists($filepath['path'])){
        return iis_updated_image_array($filepath['url'], $size);
    }

    $image = wp_get_image_editor($filepath['origin']);
    if ( ! is_wp_error( $image ) ) {
        $image->resize($size[0], $size[1], true);
        $image->save( $filepath['path'] );
        return iis_updated_image_array($filepath['url'], $size);
        return $source_image;
    }else{
        return $source_image;
    }
}

function iis_get_final_file_path($attachment_id, $size){
    $meta = wp_get_attachment_metadata($attachment_id);
    $upload_dir = wp_upload_dir();
    $file = pathinfo($upload_dir['basedir'] . '/' . $meta['file']);
    $filename = $file['filename'] . '-' . $size[0] . 'x' . $size[1] . '.' . $file['extension'];

    $info = array(
        'origin' => $upload_dir['basedir'] . '/' . $meta['file'],
        'path' => $upload_dir['path'] . '/' . $filename,
        'url' => $upload_dir['url'] . '/' . $filename,
    );
    return $info;
}

function iis_updated_image_array($file, $size){
    return array(
        $file,
        $size[0],
        $size[1],
        1
    );
}