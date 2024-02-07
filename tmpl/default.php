<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2024 Open Source Matters, Inc. All rights reserved.
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
$caption__class = 'swiperCaption swiper__caption';
$caption__class .= $caption__custom__class ? ' ' . $caption__custom__class : '';

// caption inner class
$caption__inner__class = 'captionInner swiper__inner__caption';

// image plus class
$image__plus__class = 'additionalMedia slide__image__plus';

// image heading
$heading__class = 'heading slide__heading';

// image links
$image__menulink__class = 'swiperLink swiper__link swiper__menu__link';
$image__customlink__class = 'swiperLink swiper__link swiper__custom__link';
$image__menulink__class .= $image__link__class ? ' ' . $image__link__class : '';
$image__customlink__class .= $image__link__class ? ' ' . $image__link__class : '';

// copyright class
$image__copyright__class = 'mediaCopyright swiper__image__copyright';


/////////////////
// components //
///////////////
$navigation__next__class = ' class="swBtnNext swiper-button-next';
$navigation__next__class .= $params['navigation_type'] ? ' swCustomControls swiper-custom-controls sw__nav__custom' : '';

$navigation__next__class .= '"';
$navigation__next__id = ' id="sw__nav__nextID__' . $ID . '"';

$navigation__prev__class = ' class="swBtnPrev swiper-button-prev';
$navigation__prev__class .= $params['navigation_type'] ? ' swCustomControls swiper-custom-controls sw__nav__custom' : '';

$navigation__prev__class .= '"';
$navigation__prev__id = ' id="sw__nav__prevID__' . $ID . '"';

$navigation__next__icon = '';
$navigation__prev__icon = '';

if ($params['navigation_type'] != '0') :
	if ($params['navigation_type'] == '1' || $params['navigation_type'] == '3') :
		if ($params['navigation_bootstrap_svg']) :
			$navigation__next__icon = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>';
			$navigation__prev__icon = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>';
		else :
			$navigation__next__icon = '<i class="' . $params['navigation_type_icon_next'] . '"></i>';
			$navigation__prev__icon = '<i class="' . $params['navigation_type_icon_prev'] . '"></i>';
		endif;
	elseif ($params['navigation_type'] == '2') :
		$navigation__next__icon = '<i class="material-icons">' . $params['navigation_type_icon_next'] . '</i>';
		$navigation__prev__icon = '<i class="material-icons">' . $params['navigation_type_icon_prev'] . '</i>';
	elseif ($params['navigation_type'] == '4') :
		$navigation__next__icon = $params['navigation_heroicon_next'];
		$navigation__prev__icon = $params['navigation_heroicon_prev'];
	endif;
endif;

$navigation__next__output = '<div' . $navigation__next__class . $navigation__next__id . '>' . $navigation__next__icon . '</div>';
$navigation__prev__output = '<div' . $navigation__prev__class . $navigation__prev__id . '>' . $navigation__prev__icon . '</div>';

// pagination
$pagination__class = ' class="swiperPagi swiper-pagination"';
$pagination__id = ' id="sw__pagiID__' . $ID . '"';		

$pagination__output = '<div' . $pagination__class . $pagination__id . '></div>';


// scrollbar
$scrollbar__class = ' class="swiperScrollbar swiper-scrollbar"';
$scrollbar__id = ' id="sw__scrollID__' . $ID . '"';		

$scrollbar__output = '<div' . $scrollbar__class . $scrollbar__id . '></div>';


/////////////
// images //
///////////
$images__folder     = Folder::files('images/' . $params['imagelist']);
$folderpath         = 'images/' . $params['imagelist'] . '/';

$modClass .= $params['typeselect'] == '3' ? ' swiperParallax swiper-parallax' : '';
$modClass .= $params['thumbs'] ? ' swiperHasThumbs swiper-has-thumbs' : '';


# lazyLoad
$lazyLoadClass 					= '';
$lazyLoadIcon 					= '';
if ($params['lazyload']) :
	$modClass .= ' swiper-lazy-load';
	if ($params['lazyload_theme'] == 1) :
		$lazyLoadIcon = '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
	else :
		$lazyLoadIcon = '<div class="swiper-lazy-preloader"></div>';
	endif;
endif;


# overlay
$overlay 				= $params['overlay'] ? ' swiperOverlay swiper-overlay' : '';
$overlay__var 			= $params['overlay'] ? '--swiper-overlay-color:' . $params['overlaycolor'] . ';' : '';


# fullscreen
$fullscreen 			= $params['fullscreen'] ? ' swiperFullscreen swiper-fullscreen' : '';


if ($params['loadFiles'] != 'hide') :
	$wa->registerAndUseScript('swiper-bundle.min.js', 'media/mod_swiper_slider/js/swiper-bundle.min.js');
	if ($params['loadFiles'] == 'auto') :
		$wa->registerAndUseStyle('swiper-bundle.min.css', '/media/mod_swiper_slider/css/swiper-bundle.min.css');
	elseif ($params['loadFiles'] == 'vendor') :
		$wa->registerAndUseStyle('swiper-vendor-bundle.min.css', '/media/mod_swiper_slider/css/swiper-vendor-bundle.min.css');
	endif;
	if (
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
	) :
	$wa->registerAndUseStyle('swiper.custom.css', '/media/mod_swiper_slider/css/swiper.custom.css');
	endif;
endif;


if ($params['effect'] == 'cube' || $params['effect'] == 'coverflow' || $params['effect'] == 'flip') :
	$slider__type = 'special';
elseif ($params['fullscreen'] == ' swiper-fullscreen') :
	$slider__type = 'fullscreen';
else :
	$slider__type = 'normal';
endif;


// swiper body
$swiper__body = '';
$swiper__body .= 'class="modSwiper swiperBody"';
$swiper__body .= ' id="swiperElementID__' . $ID. '"';
$swiper__body .= ' style="--swiper-theme-color:' . $params['themeColor'] . ';';
$swiper__body .= $overlay__var;
$swiper__body .= '"';


// swiper container
$swiper__container = '';
$swiper__container .= 'class="swiper swiper-container' . $overlay . $fullscreen . $modClass . '"';
$swiper__container .= ' id="' . $swiper__id . '"';
$swiper__container .= ' dir="' . $params['viewDirection'] . '"';

// swiper thumbs container
$swiper__thumbs__container = '';
$swiper__thumbs__container .= 'class="swiper swiper-container thumbs-swiper-container' . $overlay . $fullscreen . $modClass . '"';
$swiper__thumbs__container .= ' id="thumbs__' . $swiper__id . '"';
$swiper__thumbs__container .= ' dir="' . $params['viewDirection'] . '"';

// swiper wrapper class
$swiper__wrapper__class = 'swiper-wrapper';

?>

<div <?php echo $swiper__body; ?>>
	<div <?php echo $swiper__container; ?>>
		<?php require ModuleHelper::getLayoutPath('mod_swiper_slider', $slider__layout); ?>

	<?php if ($params['components_placement']) : ?>
		<?php // if the navigation placement is outside the siwper-container is closed at this point ?>
		</div>
	<?php endif; ?>

		<?php // navigation ?>
		<?php if ($params['navigation']) : ?>
			<?php echo $navigation__next__output . $navigation__prev__output; ?>
		<?php endif; ?>

		<?php // pagination ?>
		<?php if ($params['pagination'] || $params['pagination_dynamic'] && $params['scrollbar'] == '0') : ?>
			<?php echo $pagination__output; ?>
		<?php endif; ?>

		<?php // scrollbar ?>
		<?php if ($params['scrollbar'] && $params['pagination'] == '0' && $params['pagination_dynamic'] == '0') : ?>
			<?php echo $scrollbar__output; ?>
		<?php endif; ?>

	<?php if (!$params['components_placement']) : ?>
		<?php // if the navigation placement is inside the siwper-container is closed at this point ?>
		</div>
	<?php endif; ?>
</div>

<?php if ($params['thumbs']) : ?>
	<?php require ModuleHelper::getLayoutPath('mod_swiper_slider', '_thumbs'); ?>
<?php endif; ?>