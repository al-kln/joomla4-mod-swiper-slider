<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$files__array = array();
$swiper__wrapper__class .= ' swiper__type__folder';
?>

<div class="<?php echo $swiper__wrapper__class; ?>">

    <?php 
    // store filenames in array to return unique images
    foreach ($images__folder as $image__prepare) {
        $file__meta = pathinfo($image__prepare);
        if(exif_imagetype($folderpath . $file__meta['filename'] . '.' . $file__meta['extension'])) {
            $files__array[] = $file__meta['filename'];
            $files__array = array_unique($files__array);
        }
    }

    $swiper__count = 1;
    foreach($files__array as $set__image) {
     

        // swiper slide class
        $swiper__slide__class = 'swiper-slide';
        $swiper__slide__class .= ' swiper__slideID__' . $swiper__count;
        if($params['ratio'] != 'ratio__auto') {
            $swiper__slide__class .= ' ratio ' . $params['ratio'];
        }
        
        // image src elm
        $image__src__elm = 'src';

        
        if (file_exists($folderpath . $set__image . '.webp')) {
            $image__src = $folderpath . $set__image . '.webp';
        } elseif (file_exists($folderpath . $set__image . '.WEBP')) {
            $image__src = $folderpath . $set__image . '.WEBP';
        } elseif (file_exists($folderpath . $set__image . '.jpg')) {
            $image__src = $folderpath . $set__image . '.jpg';
        } elseif (file_exists($folderpath . $set__image . '.JPG')) {
            $image__src = $folderpath . $set__image . '.JPG';
        } elseif (file_exists($folderpath . $set__image . '.jpeg')) {
            $image__src = $folderpath . $set__image . '.jpeg';
        } elseif (file_exists($folderpath . $set__image . '.JPEG')) {
            $image__src = $folderpath . $set__image . '.JPEG';
        } elseif(file_exists($folderpath . $set__image . '.png')) {
            $image__src = $folderpath . $set__image . '.png';
        } elseif (file_exists($folderpath . $set__image . '.PNG')) {
            $image__src = $folderpath . $set__image . '.PNG';
        } elseif(file_exists($folderpath . $set__image . '.gif')) {
            $image__src = $folderpath . $set__image . '.gif';
        } elseif (file_exists($folderpath . $set__image . '.GIF')) {
            $image__src = $folderpath . $set__image . '.GIF';
        }


        // image class
        $image__class = 'slider__image d-block w-100';

        // lazyload
        if($params['lazyload']) {
            $image__class .= ' swiper-lazy';
            $image__src__elm = 'data-src';
        }

        // image output
        $image__output = '<img class="';
        $image__output .= $image__class . '"';
        $image__output .= ' ' . $image__src__elm . '="';
        $image__output .= $image__src . '"';
        $image__output .= ' alt="' . $params['globalAltTag'] . '">';    
            

        ?>
            <div class="<?php echo $swiper__slide__class; ?>">
                <?php echo $image__output; ?>
            </div>

        <?php
        $swiper__count++;
    } ?>

</div>