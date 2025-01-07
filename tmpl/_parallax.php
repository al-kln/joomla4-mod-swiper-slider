<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2025 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$swiper__wrapper__class .= ' swiperTypeParallax swiper__type__parallax';

// parallax element
$parallax__class = 'class="parallax-bg"';

$parallax__style = ' style="background-image:url(';
$parallax__style .= Uri::root() . $params['parallax_background'];
$parallax__style .= ');width:';
$parallax__style .= $params['parallax_width'];
$parallax__style .= '%;"';

$parallax__data = ' data-swiper-parallax="' . $params['parallax_value'] . '"';


?>


<div <?php echo $parallax__class . $parallax__style . $parallax__data; ?>></div>
<?php if ($params['parallax_copyright']) : ?>
    <span class="parallax-copyright"><?php echo $params['parallax_copyright']; ?></span>
<?php endif; ?>

<div class="<?php echo $swiper__wrapper__class; ?>">
    <?php
    foreach ($params['parallax_slides'] as $index => $value) :
        $prlx__header		    = $value->prlx_header;
        $prlx__subtitle		    = $value->prlx_subtitle;
        $prlx__text			    = $value->prlx_text;

        $prlx__header__value      = $value->prlx_header_value;
        $prlx__subtitle__value    = $value->prlx_subtitle_value;
        $prlx__text__value        = $value->prlx_text_value;


        // prlx header output
        $prlx__header__output = '<';
        $prlx__header__output .= $params['heading_tag'];
        $prlx__header__output .= ' class="prlx-header"';
        $prlx__header__output .= ' data-swiper-parallax="';
        $prlx__header__output .= $prlx__header__value;
        $prlx__header__output .= '">';
        $prlx__header__output .= $prlx__header;
        $prlx__header__output .= '</';
        $prlx__header__output .= $params['heading_tag'];
        $prlx__header__output .= '>';


        // prlx subtitle output
        $prlx__subtitle__output = '<div';
        $prlx__subtitle__output .= ' class="prlx-subtitle"';
        $prlx__subtitle__output .= ' data-swiper-parallax="';
        $prlx__subtitle__output .= $prlx__subtitle__value;
        $prlx__subtitle__output .= '">';
        $prlx__subtitle__output .= $prlx__subtitle;
        $prlx__subtitle__output .= '</div>';


        // prlx text output
        $prlx__text__output = '<div';
        $prlx__text__output .= ' class="prlx-text"';
        $prlx__text__output .= ' data-swiper-parallax="';
        $prlx__text__output .= $prlx__text__value;
        $prlx__text__output .= '"><p>';
        $prlx__text__output .= $prlx__text;
        $prlx__text__output .= '</p></div>';
        

    ?>

    <div class="swiper-slide">
        <?php if ($prlx__header) :
            echo $prlx__header__output; 
        endif; ?>
        <?php if ($prlx__subtitle) :
            echo $prlx__subtitle__output; 
        endif; ?>
        <?php if ($prlx__text) :
            echo $prlx__text__output; 
        endif; ?>
    </div>

    <?php endforeach; ?>
</div>

