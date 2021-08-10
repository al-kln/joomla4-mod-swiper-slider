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

$swiper__wrapper__class .= ' swiper__wrapper__thumbs';
?>

<div class="swiper__thumbs">
    <div <?php echo $swiper__thumbs__container; ?>>
        <div class="<?php echo $swiper__wrapper__class; ?>">

            <?php if ($slider__layout == '_images') { ?>

                <?php
                foreach($params['images'] as $index => $value) {
                
                    $image 					= $value->image;
                    $image__alt 			= $value->image_alt;
                    
                ?>
                    <div class="swiper-slide thumbs-swiper-slide">	
                        <img class="d-block w-100" src="<?php echo Uri::root() . $image; ?>" alt="<?php echo $image__alt; ?>">
                    </div>
                <?php } ?>

            <?php } elseif ($slider__layout == '_folder' ) { ?>

                <?php foreach ($images_folder as $image_single) : ?>
                    <div class="swiper-slide thumbs-swiper-slide">
                        <img class="w-100" src="<?php echo $folderpath . $image_single; ?>">
                    </div>
                <?php endforeach; ?>	

            <?php } ?>
        
        </div>
    </div>
</div>

<script>

    const thumbsSwiper<?php echo $scriptID; ?> = new Swiper ('#thumbs__<?php echo $swiper__id; ?>', {
        <?php if($params['slideThumbActiveClass'] != 'swiper-slide-thumb-active') { ?>
            slideThumbActiveClass: '<?php echo $params['slideThumbActiveClass']; ?>',
        <?php } ?>
        <?php if($params['thumbsContainerClass'] != 'swiper-container-thumbs') { ?>
            thumbsContainerClass: '<?php echo $params['thumbsContainerClass']; ?>',
        <?php } ?>
        <?php if($params['thumbs_spaceBetween'] != null) { ?>
            spaceBetween: <?php echo $params['thumbs_spaceBetween']; ?>,
        <?php } ?>
        <?php if($params['thumbs_slidesPerView'] != '1') { ?>
            slidesPerView: <?php if($params['thumbs_slidesPerView'] != 'auto') { echo $params['thumbs_slidesPerView']; } else { echo "'auto'"; } ?>,
        <?php } ?>
        <?php if($params['thumbs_loop']) { ?>
            loop: true,
        <?php } ?>
        <?php if($params['thumbs_freeMode']) { ?>
            freeMode: true,
        <?php } ?>
        <?php if($params['thumbs_loopedSlides'] != 'null') { ?>
            loopedSlides: <?php echo $params['thumbs_loopedSlides']; ?>,
        <?php } ?>
        <?php if($params['thumbs_centeredSlides']) { ?>
            centeredSlides: true,
        <?php } ?>
        <?php if($params['thumbs_slideToClickedSlide']) { ?>
            slideToClickedSlide: true,
        <?php } ?>
        watchOverflow: true,
    })

</script>

