<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

$swiper__wrapper__class .= ' swiper__type__images';
?>

<div class="<?php echo $swiper__wrapper__class; ?>">

    <?php
    $swiper__count = 1;

    foreach($params['images'] as $index => $value) {

        $image 					    = $value->image;
        $image__alt 			    = $value->image_alt;
        $image__copyright		    = $value->image_copyright;
        $image__plus 			    = $value->image_plus;
        $image__header 			    = $value->image_header;
        $image__cap 			    = $value->image_cap;
        $image__nolink 			    = $value->image_nolink;
        $image__link__href 		    = Route::_('&Itemid=' . $value->image_link);
        $image__customlink__href    = $value->image_customlink;
        $slide__autoplay			= $value->slide_autoplay;


        // swiper slide class
        $swiper__slide__class = 'swiper-slide';
        $swiper__slide__class .= ' swiper__slideID__' . $swiper__count;
        if($params['ratio'] != 'ratio__auto') {
            $swiper__slide__class .= ' ratio ' . $params['ratio'];
        }
        if($image__copyright) { 
            $swiper__slide__class .= ' copyright__figcaption';
        }

        // swiper slide data
        $swiper__slide__data = '';
        $alias = sanitizeFileName($image__header);
        if($params['autoplay'] && $slide__autoplay) {
            $swiper__slide__data .= ' data-swiper-autoplay="' . $slide__autoplay . '"';
        }
        if($params['hashNavigation']) {
            $swiper__slide__data .= ' data-hash="' . $alias . '"';
        } elseif($params['history']) {
            $swiper__slide__data .= ' data-history="' . $alias . '"';
        }


        // image src elm
        $image__src__elm = 'src';
        $background__src__elm = 'style="background-image:url(';

        // image src
        $image__src = Uri::root() . $image;

        // image class
        $image__class = 'slider__image d-block w-100';
        $background__class = 'slider__image slider__fullscreen__image';

        // lazyload
        if($params['lazyload']) {
            $image__class .= ' swiper-lazy';
            $background__class .= ' swiper-lazy';
            $image__src__elm = 'data-src';
            $background__src__elm = 'data-background="background-image:url(';
        }

        // image output
        $image__output = '<img class="';
        $image__output .= $image__class . '"';
        $image__output .= ' ' . $image__src__elm . '="';
        $image__output .= $image__src . '"';
        $image__output .= ' alt="' . $image__alt . '">';
                

        // background output
        $background__output = '<div class="';
        $background__output .= $background__class . '"';
        $background__output .= ' ' . $background__src__elm . $image__src . ')"';
        $background__output .= $image__src . '">';

    ?>


        <?php if($slider__type == 'special') { ?>
            <div class="swiper-slide" <?php echo $background__src__elm . $image__src . ')"' . $swiper__slide__data; ?>></div>        
        <?php } else { ?>
        
            <div class="<?php echo $swiper__slide__class; ?>"<?php echo $swiper__slide__data; ?>>	
                
                <?php if($slider__type == 'normal') { ?>
                    <?php echo $image__output; ?>
                    <?php echo $lazyLoadIcon; ?>
                <?php } elseif ($slider__type == 'fullscreen') { ?>
                    <?php echo $background__output; ?>                
                <?php } ?>

               
                <?php // caption ?>
                <?php if ($image__header || $image__plus || $image__cap || !$image__nolink) { ?>
                    <?php // caption begin ?>
                    <div class="<?php echo $caption__class; ?>">

                        <?php // image plus ?>
                       <?php if ($image__plus) { ?>
                           <img class="<?php echo $image__plus__class; ?>" src="<?php echo Uri::root() . $image__plus; ?>" alt="<?php echo $image__alt; ?>">
                       <?php } ?>
                       <?php // caption inner ?>
                       <?php if ($image__header || $image__cap) { ?>
                           <div class="<?php echo $caption__inner__class; ?>">
                               <?php // caption heading ?>
                               <?php if ($image__header) { ?>
                                   <<?php echo $heading__tag; ?> class="<?php echo $heading__class; ?>"><?php echo $image__header; ?></<?php echo $heading__tag; ?>>
                               <?php } ?>
                               <?php // caption text ?>
                               <?php if ($image__cap) { ?>
                                   <p><?php echo $image__cap; ?></p>
                               <?php } ?>
                           </div>
                       <?php } ?>
                       <?php // caption link ?>
                       <?php if (!$image__nolink) { ?>
                            <?php if ($image__customlink__href) { ?>
                                <a class="<?php echo $image__customlink__class; ?>" href="<?php echo $image__customlink; ?>"><?php echo $image__link__caption; ?></a>
                           <?php } else { ?>
                                <a class="<?php echo $image__menulink__class; ?>" href="<?php echo $image__link__href; ?>"><?php echo $image__link__caption; ?></a>
                           <?php } ?>
                        <?php } ?>
                   </div>
                <?php } ?>
                <?php // copyright ?>   
                <?php if($image__copyright) { ?>
                    <figcaption class="<?php echo $image__copyright__class; ?>">&copy;<?php echo $image__copyright; ?></figcaption>
                <?php } ?>
            </div>


            <?php if ($slider__type == 'fullscreen') { ?>
                </div>	
                <?php echo $lazyLoadIcon; ?>              
            <?php } ?>

        <?php } ?>
    
        <?php $swiper__count++; 
    }

    ?>
</div>