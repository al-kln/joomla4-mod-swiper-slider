<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Folder;

///////////////
// settings //
/////////////

# general
$caption__custom__class	= $params['captionclass'];
$heading__tag			= $params['heading_tag'];
$image__link__caption	= $params['linkbtntxt'];
$image__link__class		= $params['linkbtnclass'];


// caption class
$caption__class = 'swiper__caption';
if($caption__custom__class) {
	$caption__class .= ' ' . $caption__custom__class;
}

// caption inner class
$caption__inner__class = 'swiper__inner__caption';

// image plus class
$image__plus__class = 'slide__image__plus';

// image heading
$heading__class = 'slide__heading';

// image links
$image__menulink__class = 'swiper__link swiper__menu__link';
$image__customlink__class = 'swiper__link swiper__custom__link';
if($image__link__class) {
	$image__menulink__class .= ' ' . $image__link__class;
	$image__customlink__class .= ' ' . $image__link__class;
}

// copyright class
$image__copyright__class = 'swiper__image__copyright';


/////////////////
// components //
///////////////
$navigation__next__class = ' class="swiper-button-next';
if($params['navigation_type']) {
	$navigation__next__class .= ' swiper-custom-controls sw__nav__custom';
}
$navigation__next__class .= '"';
$navigation__next__id = ' id="sw__nav__nextID__' . $ID . '"';

$navigation__prev__class = ' class="swiper-button-prev';
if($params['navigation_type']) {
	$navigation__prev__class .= ' swiper-custom-controls sw__nav__custom';
}
$navigation__prev__class .= '"';
$navigation__prev__id = ' id="sw__nav__prevID__' . $ID . '"';

$navigation__next__icon = '';
$navigation__prev__icon = '';

if($params['navigation_type'] != '0') {
	if($params['navigation_type'] == '1' || $params['navigation_type'] == '3') {
		$navigation__next__icon = '<i class="' . $params['navigation_type_icon_next'] . '"></i>';
		$navigation__prev__icon = '<i class="' . $params['navigation_type_icon_prev'] . '"></i>';
	} elseif($params['navigation_type'] == '2') {
		$navigation__next__icon = '<i class="material-icons">' . $params['navigation_type_icon_next'] . '</i>';
		$navigation__prev__icon = '<i class="material-icons">' . $params['navigation_type_icon_prev'] . '</i>';
	}
}

$navigation__next__output = '<div' . $navigation__next__class . $navigation__next__id . '>' . $navigation__next__icon . '</div>';
$navigation__prev__output = '<div' . $navigation__prev__class . $navigation__prev__id . '>' . $navigation__prev__icon . '</div>';

// pagination
$pagination__class = ' class="swiper-pagination"';
$pagination__id = ' id="sw__pagiID__' . $ID . '"';		

$pagination__output = '<div' . $pagination__class . $pagination__id . '></div>';


// scrollbar
$scrollbar__class = ' class="swiper-scrollbar"';
$scrollbar__id = ' id="sw__scrollID__' . $ID . '"';		

$scrollbar__output = '<div' . $scrollbar__class . $scrollbar__id . '></div>';


/////////////
// images //
///////////
$images__folder     = Folder::files('images/' . $params['imagelist']);
$folderpath         = 'images/' . $params['imagelist'] . '/';


if($params['typeselect'] == '3') {
	$mod__class .= ' swiper-parallax';
}


if($params['thumbs']) {
	$mod__class .= ' swiper-has-thumbs';
}


# lazyLoad
$lazyLoadClass 					= '';
$lazyLoadIcon 					= '';
if($params['lazyload']) {
	$mod__class .= ' swiper-lazy-load';
	if($params['lazyload_theme'] == 1) {
		$lazyLoadIcon = '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
	} else {
		$lazyLoadIcon = '<div class="swiper-lazy-preloader"></div>';
	}
}


# overlay
$overlay 				= '';
$overlay__var 			= '';
if($params['overlay']) {
	$overlay .= ' swiper-overlay';
	$overlay__var .= '--swiper-overlay-color:' . $params['overlaycolor'] . ';';
}


# fullscreen
$fullscreen 			= '';
if($params['fullscreen']) {
	$fullscreen = ' swiper-fullscreen';
}


if($params['loadFiles'] != 'hide') {
	$document->addScript(Uri::base() . 'media/mod_swiper_slider/js/swiper-bundle.min.js', array('version' => 'auto', 'relative' => true));
	if($params['loadFiles'] == 'auto') {
		$document->addStyleSheet(Uri::base() . 'media/mod_swiper_slider/css/swiper-bundle.min.css', array('version' => 'auto', 'relative' => true));
	} elseif($params['loadFiles'] == 'vendor') {
		$document->addStyleSheet(Uri::base() . 'media/mod_swiper_slider/css/swiper-vendor-bundle.min.css', array('version' => 'auto', 'relative' => true));
	}
	if(
		$params['ratio'] != 'ratio__auto' ||
		$params['pagination_type'] == 'custom' ||
		$params['effect'] == 'cube' ||
		$params['effect'] == 'coverflow' ||
		$params['effect'] == 'flip' ||
		$params['fullscreen'] == ' swiper-fullscreen' ||
		$params['overlay'] ||
		$params['navigation_type'] != '0' ||
		$params['lazyload'] ||
		$params['type__select'] == '3'
	) {
		$document->addStyleSheet(Uri::base() . 'media/mod_swiper_slider/css/swiper.custom.css', array('version' => 'auto', 'relative' => true));
	}
}


if($params['effect'] == 'cube' || $params['effect'] == 'coverflow' || $params['effect'] == 'flip') {
	$slider__type = 'special';
} elseif($params['fullscreen'] == ' swiper-fullscreen') {
	$slider__type = 'fullscreen';
} else {
	$slider__type = 'normal';
}


// swiper body
$swiper__body = '';
$swiper__body .= 'class="swiper__body"';
$swiper__body .= ' id="swiper__elementID__' . $ID. '"';
$swiper__body .= ' style="--swiper-theme-color:' . $params['themeColor'] . ';';
$swiper__body .= $overlay__var;
$swiper__body .= '"';


// swiper container
$swiper__container = '';
$swiper__container .= 'class="swiper swiper-container' . $overlay . $fullscreen . $mod__class . '"';
$swiper__container .= ' id="' . $swiper__id . '"';
$swiper__container .= ' dir="' . $params['viewDirection'] . '"';

// swiper thumbs container
$swiper__thumbs__container = '';
$swiper__thumbs__container .= 'class="swiper swiper-container thumbs-swiper-container' . $overlay . $fullscreen . $mod__class . '"';
$swiper__thumbs__container .= ' id="thumbs__' . $swiper__id . '"';
$swiper__thumbs__container .= ' dir="' . $params['viewDirection'] . '"';

// swiper wrapper class
$swiper__wrapper__class = 'swiper-wrapper';



?>


<div <?php echo $swiper__body; ?>>
	<div <?php echo $swiper__container; ?>>
		<?php require ModuleHelper::getLayoutPath('mod_swiper_slider', $slider__layout); ?>

	<?php if($params['components_placement']) { ?>
		<?php // if the navigation placement is outside the siwper-container is closed at this point ?>
		</div>
	<?php } ?>

		<?php // navigation ?>
		<?php if($params['navigation']) { ?>
			<?php echo $navigation__next__output . $navigation__prev__output; ?>
		<?php } ?>

		<?php // pagination ?>
		<?php if($params['pagination'] || $params['pagination_dynamic'] && $params['scrollbar'] == '0') { ?>
			<?php echo $pagination__output; ?>
		<?php } ?>

		<?php // scrollbar ?>
		<?php if($params['scrollbar'] && $params['pagination'] == '0' && $params['pagination_dynamic'] == '0') { ?>
			<?php echo $scrollbar__output; ?>
		<?php } ?>

	<?php if(!$params['components_placement']) { ?>
		<?php // if the navigation placement is inside the siwper-container is closed at this point ?>
		</div>
	<?php } ?>
</div>


<?php if($params['thumbs']) { ?>
	<?php require ModuleHelper::getLayoutPath('mod_swiper_slider', '_thumbs'); ?>
<?php } ?>