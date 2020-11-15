<?php
/**
 * @package    mod_swiper_slider
 *
 * @author     alexander.klein@fact-werbeagentur.de
 * @copyright  Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://fact-werbeagentur.de
 */

defined('_JEXEC') or die;

$mod__sfx = '';

if($params->get('moduleclass_sfx') != null) {
	$mod__sfx .= ' ' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
}


function sanitizeFileName($fileName) {
	// Remove multiple spaces
	$fileName = preg_replace('/\s+/', ' ', $fileName);

	// Replace spaces with hyphens
	$fileName = preg_replace('/\s/', '-', $fileName);

	// Replace german characters
	$germanReplaceMap = [
		'ä' => 'ae',
		'Ä' => 'Ae',
		'ü' => 'ue',
		'Ü' => 'Ue',
		'ö' => 'oe',
		'Ö' => 'Oe',
		'ß' => 'ss',
	];
	$fileName = str_replace(array_keys($germanReplaceMap), $germanReplaceMap, $fileName);

	// Remove everything but "normal" characters
	$fileName = preg_replace("([^\w\s\d\-])", '', $fileName);

	// Remove multiple hyphens because of contract and project name connection
	$fileName = preg_replace('/-+/', '-', $fileName);

	// lower the string
	$fileName = strtolower($fileName);

	return $fileName;
}


// values
$swiper_id	 			= "moduleID__" . $module->id;
$database 				= JFactory::getDbo();
$document 				= JFactory::getDocument();


$document->addScript(JURI::base() . 'modules/mod_swiper_slider/assets/js/swiper-bundle.min.js');
$document->addStyleSheet(JURI::base() . 'modules/mod_swiper_slider/assets/css/swiper-bundle.min.css');


// settings
$captionclass			= $params->get('captionclass');
$heading_tag			= $params->get('heading_tag');
$link_btn_txt 			= $params->get('linkbtntxt');
$linkbtnclass			= $params->get('linkbtnclass');


# overlay
$overlay 				= $params->get('overlay');
if($overlay) {
	$overlay = ' swiper-overlay';
} else {
	$overlay = '';
}
$overlaycolor			= $params->get('overlaycolor');

# fullscreen
$fullscreen				= $params->get('fullscreen');
if($fullscreen) {
	$fullscreen = ' swiper-fullscreen';
} else {
	$fullscreen = '';
}

if($overlay == ' swiper-overlay') { 

$css	= <<<CSS
.swiper-container.swiper-overlay .swiper-slide::before {position:absolute;content:'';top:0;left:0;right:0;bottom:0;width:100%;height:100%;background-color:$overlaycolor}
CSS;

$document->addStyleDeclaration($css);

}


# parameter
$themeColor						= $params->get('themeColor');
$initialSlide					= $params->get('initialSlide');
$direction						= $params->get('direction');
$speed							= $params->get('speed');
$setWrapperSize					= $params->get('setWrapperSize');
$virtualTranslate				= $params->get('virtualTranslate');
$width							= $params->get('width');
$height							= $params->get('height');
$autoHeight						= $params->get('autoHeight');
$effect							= $params->get('effect');
$watchOverflow					= $params->get('watchOverflow');
$viewDirection					= $params->get('viewDirection');

# css scroll snap
$cssMode						= $params->get('cssMode');

# slides grid
$spaceBetween					= $params->get('spaceBetween');
$slidesPerView					= $params->get('slidesPerView');
$slidesPerColumn				= $params->get('slidesPerColumn');
$slidesPerColumnFill			= $params->get('slidesPerColumnFill');
$slidesPerGroup					= $params->get('slidesPerGroup');
$slidesPerGroupSkip				= $params->get('slidesPerGroupSkip');
$centeredSlides					= $params->get('centeredSlides');
$centeredSlidesBounds			= $params->get('centeredSlidesBounds');
$slidesOffsetBefore				= $params->get('slidesOffsetBefore');
$slidesOffsetAfter				= $params->get('slidesOffsetAfter');
$normalizeSlideIndex			= $params->get('normalizeSlideIndex');
$centerInsufficientSlides		= $params->get('centerInsufficientSlides');

# grab cursor
$grabCursor						= $params->get('grabCursor');

# clicks
$preventClicks					= $params->get('preventClicks');
$preventClicksPropagation		= $params->get('preventClicksPropagation');
$slideToClickedSlide			= $params->get('slideToClickedSlide');

# freemode
$freeMode						= $params->get('freeMode');
$freeModeMomentum				= $params->get('freeModeMomentum');
$freeModeMomentumRatio			= $params->get('freeModeMomentumRatio');
$freeModeMomentumVelocityRatio	= $params->get('freeModeMomentumVelocityRatio');
$freeModeMomentumBounce			= $params->get('freeModeMomentumBounce');
$freeModeMomentumBounceRatio	= $params->get('freeModeMomentumBounceRatio');
$freeModeMinimumVelocity		= $params->get('freeModeMinimumVelocity');	
$freeModeMinimumVelocity_output = str_replace(',','.',$freeModeMinimumVelocity);
$freeModeSticky					= $params->get('freeModeSticky');

# loop
$loop							= $params->get('loop');
$loopAdditionalSlides			= $params->get('loopAdditionalSlides');
$loopedSlides					= $params->get('loopedSlides');
$loopFillGroupWithBlank			= $params->get('loopFillGroupWithBlank');

# breakpoints
$breakpoints					= $params->get('breakpoints');
$breakpointInsert = '';
if(isset($breakpoints)) {
	foreach($breakpoints as $index => $breakpoint) {

		$viewport = $breakpoint->viewport;
		$viewportValues = $breakpoint->viewportValues;
		$breakpointInsert .= $viewport . ': {';

		foreach($viewportValues as $index => $viewportValue) {
			$viewportAttribute = $viewportValue->viewportAttribute;
			$viewportValue = $viewportValue->viewportValue;
			$breakpointInsert .= $viewportAttribute . ': ';
			$breakpointInsert .= $viewportValue . ',';
		}
		$breakpointInsert .= '},';

	}
}


# namespace
$containerModifierClass			= $params->get('containerModifierClass', 'swiper-container-');
$slideClass						= $params->get('slideClass', 'swiper-slide');
$slideActiveClass				= $params->get('slideActiveClass', 'swiper-slide-active');
$slideDuplicateActiveClass		= $params->get('slideDuplicateActiveClass', 'swiper-slide-duplicate-active');
$slideVisibleClass				= $params->get('slideVisibleClass', 'swiper-slide-visible');
$slideDuplicateClass			= $params->get('slideDuplicateClass', 'swiper-slide-duplicate');
$slideNextClass					= $params->get('slideNextClass', 'swiper-slide-next');
$slideDuplicateNextClass		= $params->get('slideDuplicateNextClass', 'swiper-slide-duplicate-next');
$slidePrevClass					= $params->get('slidePrevClass', 'swiper-slide-prev');
$slideDuplicatePrevClass		= $params->get('slideDuplicatePrevClass', 'swiper-slide-duplicate-prev');
$wrapperClass					= $params->get('wrapperClass', 'swiper-wrapper');



// images
$type_select 			= $params->get('typeselect'); 
$images 				= $params->get('images');
$nested					= $params->get('nested');


// if the images come from a folder
$folder = $params->get('imagelist');
if ($params->get('typeselect') == '1') {
    JLoader::register('JFolder', JPATH_LIBRARIES . '/joomla/filesystem/folder.php');
    if (!$folder) {
        return;
    }
    $images_folder = JFolder::files('images/' . $folder);
}

# parallax
$parallax_background 	= $params->get('parallax_background'); 
$parallax_copyright 	= $params->get('parallax_copyright'); 
$parallax_width			= $params->get('parallax_width');
$parallax_value 		= $params->get('parallax_value'); 
$parallax_slides 		= $params->get('parallax_slides');
if($type_select == '3') {
	$mod__sfx .= ' swiper-parallax';
}


// components
# navigation
$navigation						= $params->get('navigation');
$navigation_type				= $params->get('navigation_type');
$navigation_type_icon_prev		= $params->get('navigation_type_icon_prev');
$navigation_type_icon_next		= $params->get('navigation_type_icon_next');
$navigation_placement			= $params->get('navigation_placement');

# pagination
$pagination						= $params->get('pagination');
$pagination_type				= $params->get('pagination_type');
$pagination_dynamic 			= $params->get('pagination_dynamic');
$pagination_dynamic_main		= $params->get('pagination_dynamic_main');
$pagination_hideOnClick			= $params->get('pagination_hideOnClick');
$pagination_clickable			= $params->get('pagination_clickable');
$pagination_progressbarOpposite = $params->get('pagination_progressbarOpposite');
$pagination_bulletClass			= $params->get('pagination_bulletClass', 'swiper-pagination-bullet');
$pagination_bulletActiveClass	= $params->get('pagination_bulletActiveClass', 'swiper-pagination-bullet-active');

# scrollbar
$scrollbar						= $params->get('scrollbar');

# autoplay
$autoplay						= $params->get('autoplay');
$autoplay_delay					= $params->get('autoplay_delay');
$stopOnLastSlide				= $params->get('stopOnLastSlide');
$disableOnInteraction			= $params->get('disableOnInteraction');

# keyboard control
$keyboard_control				= $params->get('keyboard_control');
$keyboard_control_onlyInViewport= $params->get('keyboard_control_onlyInViewport');

# mousewheel control
$mousewheel_control				= $params->get('mousewheel_control');
$mousewheel_forceToAxis			= $params->get('mousewheel_forceToAxis');
$mousewheel_releaseOnEdges		= $params->get('mousewheel_releaseOnEdges');
$mousewheel_invert				= $params->get('mousewheel_invert');
$mousewheel_sensitivity			= $params->get('mousewheel_sensitivity');
$mousewheel_eventsTarget		= $params->get('mousewheel_eventsTarget');

# thumbs
$thumbs							= $params->get('thumbs');
$slideThumbActiveClass			= $params->get('slideThumbActiveClass', 'swiper-slide-thumb-active');
$thumbsContainerClass			= $params->get('thumbsContainerClass', 'swiper-container-thumbs');
$thumbs_spaceBetween			= $params->get('thumbs_spaceBetween');
$thumbs_slidesPerView			= $params->get('thumbs_slidesPerView');
$thumbs_loop					= $params->get('thumbs_loop');
$thumbs_freeMode				= $params->get('thumbs_freeMode');
$thumbs_loopedSlides			= $params->get('thumbs_loopedSlides');
$thumbs_centeredSlides			= $params->get('thumbs_centeredSlides');
$thumbs_slideToClickedSlide		= $params->get('thumbs_slideToClickedSlide');

if($thumbs) {
	$mod__sfx .= ' swiper-has-thumbs';
}

# lazy load
$lazyload						= $params->get('lazyload');
$lazyload_theme					= $params->get('lazyload_theme');
$lazyLoadClass 					= '';
$lazyLoadIcon 					= '';
if($lazyload) {
	$mod__sfx .= ' swiper-lazy-load';
	if($lazyload_theme == 1) {
		$lazyLoadIcon = '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
	} else {
		$lazyLoadIcon = '<div class="swiper-lazy-preloader"></div>';
	}
}

# hash navigation
$hashNavigation					= $params->get('hashNavigation');
$watchState						= $params->get('watchState');
$replaceState					= $params->get('replaceState');

# history navigation
$history						= $params->get('history');
$history_replaceState			= $params->get('history_replaceState');
$key							= $params->get('key');


if($pagination_type == 'custom' || $effect == 'cube' || $effect == 'coverflow' || $effect == 'flip' || $fullscreen == ' swiper-fullscreen' || $navigation_type != '0' || $lazyload || $type_select == '3') {
	$document->addStyleSheet(JURI::base() . '/modules/mod_swiper_slider/assets/css/swiper.custom.css');
}

?>

<div class="swiper__body" id="swiper__elementID__<?php echo $module->id; ?>" style="--swiper-theme-color:<?php echo $themeColor; ?>;">

	<div class="swiper-container<?php echo $overlay . $fullscreen . $mod__sfx; ?>" id="<?php echo $swiper_id; ?>" dir="<?php echo $viewDirection; ?>">


	<?php if ($type_select == '0') { ?>

		<div class="swiper-wrapper">
			<?php

				$j = 1;

				foreach($images as $index=>$value) {

					$image 					= $value->image;

					$image_alt 				= $value->image_alt;
					$image_copyright		= $value->image_copyright;
					$image_plus 			= $value->image_plus;
					$image_header 			= $value->image_header;
					$image_cap 				= $value->image_cap;
					$image_nolink 			= $value->image_nolink;
					$image_link 			= $value->image_link;
					$image_customlink 		= $value->image_customlink;
					$slide_autoplay			= $value->slide_autoplay;

					$menuvalue = $image_link;

					$sql = $database->getQuery(true);
					$sql->select('link')->from('#__menu')->where('id = "' . $menuvalue . '"');
					$database->setQuery($sql);
					$menuItem = $database->loadResult();
				
					$link = JRoute::_($menuItem.'&Itemid='.$menuvalue);

					
					$alias = sanitizeFileName($image_header);
					if($hashNavigation) {
						$hash_history = ' data-hash="' . $alias . '"';
					} elseif($history) {
						$hash_history = ' data-history="' . $alias . '"';
					} else {
						$hash_history = '';
					}


				?>

					<?php if($effect == 'cube' || $effect == 'coverflow' || $effect == 'flip') { ?>
						<div class="swiper-slide" style="background-image:url(<?php echo JURI::root() . $image; ?>)"<?php echo $hash_history; ?>></div>
					<?php } elseif($fullscreen == ' swiper-fullscreen') { ?>
						<div <?php if($lazyload) { ?>class="swiper-slide swiper-lazy<?php if($image_copyright) { echo ' copyright-figcaption'; } ?>" data-background="background-image:url(<?php echo JURI::root() . $image; ?>)"<?php } else { ?>class="swiper-slide<?php if($image_copyright) { echo ' copyright-figcaption'; } ?>" style="background-image:url(<?php echo JURI::root() . $image; ?>)"<?php } ?>>
							<?php if ($image_header || $image_plus || $image_cap) { ?>
								<div class="slide-caption<?php if($captionclass != null) { echo ' ' . $captionclass; } ?>">
									<?php if ($image_plus) { ?>
										<img class="img-plus" src="<?php echo JURI::root() . $image_plus; ?>" alt="<?php echo $image_alt; ?>">
									<?php } ?>
									<?php if ($image_header || $image_cap) { ?>
										<div class="slide-caption-inner">
											<?php if ($image_header) { ?>
												<<?php echo $heading_tag; ?> class="slide-caption-heading"><?php echo $image_header; ?></<?php echo $heading_tag; ?>>
											<?php } ?>
											<?php if ($image_cap) { ?>
												<p><?php echo $image_cap; ?></p>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if ($image_nolink == '0') {
										if ($image_customlink != null) { ?>
											<a class="mehrinfo customlink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo JURI::root(). $image_customlink; ?>"><?php echo $link_btn_txt; ?></a>
										<?php } else { ?>
											<a class="mehrinfo menulink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo $link; ?>"><?php echo $link_btn_txt; ?></a>
										<?php }
									} ?>
								</div>
							<?php } ?>
							<?php if($image_copyright) { ?>
								<figcaption>&copy;<?php echo $image_copyright; ?></figcaption>
							<?php } ?>
						</div>	
						<?php echo $lazyLoadIcon; ?>		
					<?php } else { ?>
						<div class="swiper-slide<?php if($image_copyright) { echo ' copyright-figcaption'; } ?>"<?php if($autoplay && $slide_autoplay != null) { ?>  data-swiper-autoplay="<?php echo $slide_autoplay; ?>"<?php } ?><?php echo $hash_history; ?>>	
							<img <?php if($lazyload) { ?>class="d-block w-100 swiper-lazy" data-src="<?php echo JURI::root() . $image; ?>"<?php } else { ?>class="d-block w-100" src="<?php echo JURI::root() . $image; ?>"<?php } ?> alt="<?php echo $image_alt; ?>">
							<?php echo $lazyLoadIcon; ?>
							<?php if ($image_header || $image_plus || $image_cap) { ?>
								<div class="slide-caption<?php if($captionclass != null) { echo ' ' . $captionclass; } ?>">
									<?php if ($image_plus) { ?>
										<img class="img-plus" src="<?php echo JURI::root() . $image_plus; ?>" alt="<?php echo $image_alt; ?>">
									<?php } ?>
									<?php if ($image_header || $image_cap) { ?>
										<div class="slide-caption-inner">
											<?php if ($image_header) { ?>
												<<?php echo $heading_tag; ?> class="slide-caption-heading"><?php echo $image_header; ?></<?php echo $heading_tag; ?>>
											<?php } ?>
											<?php if ($image_cap) { ?>
												<p><?php echo $image_cap; ?></p>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if ($image_nolink == '0') {
										if ($image_customlink != null) { ?>
											<a class="mehrinfo customlink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo JURI::root(). $image_customlink; ?>"><?php echo $link_btn_txt; ?></a>
										<?php } else { ?>
											<a class="mehrinfo menulink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo $link; ?>"><?php echo $link_btn_txt; ?></a>
										<?php }
									} ?>
								</div>
							<?php } ?>
							<?php if($image_copyright) { ?>
								<figcaption>&copy;<?php echo $image_copyright; ?></figcaption>
							<?php } ?>
						</div>
					<?php } ?>
				
					<?php $j++; 
				}
			?>
		</div>



	<?php } elseif ($type_select == '1' ) {
		$folderpath = 'images/' . $folder . '/'; ?>

			<div class="swiper-wrapper">

				<?php 
					$k = 0;
				?>

				<?php foreach ($images_folder as $image_single) : ?>
					<div class="swiper-slide">
						<img class="w-100" src="<?php echo $folderpath . $image_single; ?>">
					</div>

					<?php $k++ ?>

				<?php endforeach; ?>	

			</div>

	<?php } elseif($type_select == '2') { ?>
		
		<div class="swiper-wrapper">

			<?php 
				$n = 1;

				foreach($nested as $index=>$value) {

					$nested_images			= $value->nested_images;

				?>

					<div class="swiper-slide">
						<div class="swiper-container swiper-container-<?php echo $n; ?>">
							<div class="swiper-wrapper">

							<?php
							foreach($nested_images as $index=>$value) {

								$nested_image 				= $value->nested_image;
								$nested_image_alt 			= $value->nested_image_alt;
								$nested_image_copyright		= $value->nested_image_copyright;
								$nested_image_plus 			= $value->nested_image_plus;
								$nested_image_header 		= $value->nested_image_header;
								$nested_image_cap 			= $value->nested_image_cap;
								$nested_image_nolink 		= $value->nested_image_nolink;
								$nested_image_link 			= $value->nested_image_link;
								$nested_image_customlink 	= $value->nested_image_customlink;

								$nested_menuvalue = $nested_image_link;

								$nested_sql = $database->getQuery(true);
								$nested_sql->select('link')->from('#__menu')->where('id = "' . $nested_menuvalue . '"');
								$database->setQuery($nested_sql);
								$nested_menuItem = $database->loadResult();
							
								$nested_link = JRoute::_($nested_menuItem.'&Itemid='.$nested_menuvalue);

							?>

								<?php if($effect == 'cube' || $effect == 'coverflow' || $effect == 'flip') { ?>
									<div class="swiper-slide" style="background-image:url(<?php echo JURI::root() . $nested_image; ?>)"></div>
								<?php } elseif($fullscreen == ' swiper-fullscreen') { ?>
									<div class="swiper-slide<?php if($nested_image_copyright) { echo ' copyright-figcaption'; } ?>" style="background-image:url(<?php echo JURI::root() . $nested_image; ?>)">
										<?php if ($nested_image_header || $image_plus || $nested_nested_image_cap) { ?>
											<div class="slide-caption<?php if($captionclass != null) { echo ' ' . $captionclass; } ?>">
												<?php if ($nested_image_plus) { ?>
													<img class="img-plus" src="<?php echo JURI::root() . $nested_image_plus; ?>" alt="<?php echo $nested_image_alt; ?>">
												<?php } ?>
												<?php if ($image_header) { ?>
													<<?php echo $heading_tag; ?>><?php echo $nested_image_header; ?></<?php echo $heading_tag; ?>>
												<?php } ?>
												<?php if ($nested_image_cap) { ?>
													<p><?php echo $nested_image_cap; ?></p>
												<?php } ?>
												<?php if ($nested_image_nolink == '0') {
													if ($nested_image_customlink != null) { ?>
														<a class="mehrinfo customlink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo JURI::root(). $nested_image_customlink; ?>"><?php echo $link_btn_txt; ?></a>
													<?php } else { ?>
														<a class="mehrinfo menulink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo $nested_link; ?>"><?php echo $link_btn_txt; ?></a>
													<?php }
												} ?>
											</div>
										<?php } ?>
										<?php if($nested_image_copyright) { ?>
											<figcaption>&copy;<?php echo $nested_image_copyright; ?></figcaption>
										<?php } ?>
									</div>			
								<?php } else { ?>
									<div class="swiper-slide<?php if($nested_image_copyright) { echo ' copyright-figcaption'; } ?>"<?php if($autoplay && $slide_autoplay != null) { ?>  data-swiper-autoplay="<?php echo $slide_autoplay; ?>"<?php }?>>	
										<img class="d-block w-100" src="<?php echo JURI::root() . $nested_image; ?>" alt="<?php echo $nested_image_alt; ?>">
										<?php if ($nested_image_header || $nested_image_plus || $nested_image_cap) { ?>
											<div class="slide-caption<?php if($captionclass != null) { echo ' ' . $captionclass; } ?>">
												<?php if ($nested_image_plus) { ?>
													<img class="img-plus" src="<?php echo JURI::root() . $nested_image_plus; ?>" alt="<?php echo $nested_image_alt; ?>">
												<?php } ?>
												<?php if ($nested_image_header) { ?>
													<<?php echo $heading_tag; ?>><?php echo $nested_image_header; ?></<?php echo $heading_tag; ?>>
												<?php } ?>
												<?php if ($nested_image_cap) { ?>
													<p><?php echo $nested_image_cap; ?></p>
												<?php } ?>
												<?php if ($nested_image_nolink == '0') {
													if ($nested_image_customlink != null) { ?>
														<a class="mehrinfo customlink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo JURI::root(). $nested_image_customlink; ?>"><?php echo $link_btn_txt; ?></a>
													<?php } else { ?>
														<a class="mehrinfo menulink<?php if($captionclass != null) { echo ' ' . $linkbtnclass; } ?>" href="<?php echo $nested_link; ?>"><?php echo $link_btn_txt; ?></a>
													<?php }
												} ?>
											</div>
										<?php } ?>
										<?php if($nested_image_copyright) { ?>
											<figcaption>&copy;<?php echo $nested_image_copyright; ?></figcaption>
										<?php } ?>
									</div>
								<?php } ?>

							<?php } ?>
				

							</div>
						</div>
					</div>

				<?php $n++ ?>

			<?php } ?>

		</div>


	<?php } elseif($type_select == '3') { ?>	

		<div class="parallax-bg" style="background-image:url(<?php echo JURI::root() . $parallax_background; ?>);width:<?php echo $parallax_width; ?>%;" data-swiper-parallax="<?php echo $parallax_value; ?>"></div>
		<?php if($parallax_copyright) { ?>
			<span class="parallax-copyright"><?php echo $parallax_copyright; ?></span>
		<?php } ?>
	
		<div class="swiper-wrapper">
			<?php
			foreach($parallax_slides as $index => $value) {
				$prlx_header		= $value->prlx_header;
				$prlx_subtitle		= $value->prlx_subtitle;
				$prlx_text			= $value->prlx_text;
			?>
		
			<div class="swiper-slide">
				<?php # Each slide has parallax title ?>
				<<?php echo $heading_tag; ?> class="prlx-header" data-swiper-parallax="-100"><?php echo $prlx_header; ?></<?php echo $heading_tag; ?>>
				<?php # Parallax subtitle ?>
				<div class="prlx-subtitle" data-swiper-parallax="-200"><?php echo $prlx_subtitle; ?></div>
				<?php # And parallax text with custom transition duration ?>
				<div class="prlx-text" data-swiper-parallax="-300" data-swiper-parallax-duration="600">
					<p><?php echo $prlx_text; ?></p>
				</div>
			</div>

			<?php } ?>
		</div>

	<?php } ?>

	<?php if($navigation_placement) { ?>
		<?php // if the navigation placement is outside the siwper-container is closed at this point ?>
		</div>
	<?php } ?>

	<?php if($navigation) { ?>
		<div class="swiper-button-next<?php if($navigation_type != '0') { echo ' swiper-custom-controls'; }?>" id="swiper-next-<?php echo $module->id; ?>">
			<?php if($navigation_type != '0') { ?>
				<?php if($navigation_type == '1') { ?>
					<i class="<?php echo $navigation_type_icon_next; ?>"></i>
				<?php } elseif($navigation_type == '2') { ?>
					<i class="material-icons"><?php echo $navigation_type_icon_next; ?></i>
				<?php } else { ?>
					<span class="bi-swiper bi-swiper-next"></span>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="swiper-button-prev<?php if($navigation_type != '0') { echo ' swiper-custom-controls'; }?>" id="swiper-prev-<?php echo $module->id; ?>">
			<?php if($navigation_type != '0') { ?>
				<?php if($navigation_type == '1') { ?>
					<i class="<?php echo $navigation_type_icon_prev; ?>"></i>
				<?php } elseif($navigation_type == '2') { ?>
					<i class="material-icons"><?php echo $navigation_type_icon_prev; ?></i>
				<?php } else { ?>
					<span class="bi-swiper bi-swiper-prev"></span>
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>


	<?php if($pagination || $pagination_dynamic && $scrollbar == '0') { ?>
		<div class="swiper-pagination" id="swiper-pagination-<?php echo $module->id; ?>"></div>
	<?php } ?>

	<?php if($scrollbar && $pagination == '0' && $pagination_dynamic == '0') { ?>
		<div class="swiper-scrollbar" id="swiper-scrollbar-<?php echo $module->id; ?>"></div>
	<?php } ?>


	<?php if(!$navigation_placement) { ?>
		<?php // if the navigation placement is inside the siwper-container is closed at this point ?>
		</div>
	<?php } ?>



	<?php if($thumbs) { ?>

		<div class="swiper-container thumbs-swiper-container" id="thumbs__<?php echo $swiper_id; ?>">
			<div class="swiper-wrapper">
		
				<?php if ($type_select == '0') { ?>

					<?php
					foreach($images as $index=>$value) {
					
						$image 					= $value->image;
						$image_alt 				= $value->image_alt;
						
					?>
						<div class="swiper-slide thumbs-swiper-slide">	
							<img class="d-block w-100" src="<?php echo JURI::root() . $image; ?>" alt="<?php echo $image_alt; ?>">
						</div>
					<?php } ?>

				<?php } elseif ($type_select == '1' ) { ?>

					<?php foreach ($images_folder as $image_single) : ?>
						<div class="swiper-slide thumbs-swiper-slide">
							<img class="w-100" src="<?php echo $folderpath . $image_single; ?>">
						</div>

					<?php endforeach; ?>	

				<?php } ?>
			
			</div>

		</div>


		<script>

			var thumbsSwiper = new Swiper ('#thumbs__<?php echo $swiper_id; ?>', {
				<?php if($slideThumbActiveClass != 'swiper-slide-thumb-active') { ?>
					slideThumbActiveClass: '<?php echo $slideThumbActiveClass; ?>',
				<?php } ?>
				<?php if($thumbsContainerClass != 'swiper-container-thumbs') { ?>
					thumbsContainerClass: '<?php echo $thumbsContainerClass; ?>',
				<?php } ?>
				<?php if($thumbs_spaceBetween != null) { ?>
					spaceBetween: <?php echo $thumbs_spaceBetween; ?>,
				<?php } ?>
				<?php if($thumbs_slidesPerView != '1') { ?>
					slidesPerView: <?php if($thumbs_slidesPerView != 'auto') { echo $thumbs_slidesPerView; } else { echo "'auto'"; } ?>,
				<?php } ?>
				<?php if($thumbs_loop) { ?>
					loop: true,
				<?php } ?>
				<?php if($thumbs_freeMode) { ?>
					freeMode: true,
				<?php } ?>
				<?php if($thumbs_loopedSlides != 'null') { ?>
					loopedSlides: <?php echo $thumbs_loopedSlides; ?>,
				<?php } ?>
				<?php if($thumbs_centeredSlides) { ?>
					centeredSlides: true,
				<?php } ?>
				<?php if($thumbs_slideToClickedSlide) { ?>
					slideToClickedSlide: true,
				<?php } ?>
				watchOverflow: true,
			})

		</script>

	<?php } ?>

	
</div>


<script>
	var mySwiper = new Swiper ('#<?php echo $swiper_id; ?>', {
	
	<?php if($initialSlide != 0) { ?>
		initialSlide: <?php echo $initialSlide; ?>,
	<?php } ?>
	<?php if($direction != 'horizontal') { ?>
		direction: '<?php echo $direction; ?>',
	<?php } ?>
	<?php if($speed != 300) { ?>
		speed: <?php echo $speed; ?>,
	<?php } ?>
	<?php if($setWrapperSize && $effect != 'cube') { ?>
		setWrapperSize: true,
	<?php } ?>
	<?php if($virtualTranslate) { ?>
		virtualTranslate: true,
	<?php } ?>
	<?php if($width != null) { ?>
		width: <?php echo $width; ?>,
	<?php } ?>
	<?php if($height != null) { ?>
		height: <?php echo $height; ?>,
	<?php } ?>
	<?php if($autoHeight) { ?>
		autoHeight: true,	
	<?php } ?>
	<?php if($effect != 'slide') { ?>
		effect: '<?php echo $effect; ?>',
	<?php } ?> 
	<?php if($effect == 'cube') { ?>
		grabCursor: true,
		cubeEffect: {
			shadow: true,
			slideShadows: true,
			shadowOffset: 20,
			shadowScale: 0.94,
		},
	<?php } ?>
	<?php if($effect == 'coverflow') { ?>
		grabCursor: true,
		centeredSlides: true,
		slidesPerView: 'auto',
		coverflowEffect: {
			rotate: 50,
			stretch: 0,
			depth: 100,
			modifier: 1,
			slideShadows : true,
		},
	<?php } ?>
	<?php if($effect == 'flip') { ?>
		grabCursor: true,
	<?php } ?>
	<?php if($watchOverflow) { ?>
		watchOverflow: true,
	<?php } ?>
	<?php if($cssMode) { ?>
		cssMode: true,
	<?php } ?>
	<?php if($spaceBetween != null) { ?>
		spaceBetween: <?php echo $spaceBetween; ?>,
	<?php } ?>
	<?php if($slidesPerView != '1') { ?>
		slidesPerView: <?php if($slidesPerView != 'auto') { echo $slidesPerView; } else { echo "'auto'"; } ?>,
	<?php } ?>
	<?php if($slidesPerColumn != '1') { ?>
		slidesPerColumn: <?php echo $slidesPerColumn; ?>,
	<?php } ?>
	<?php if($slidesPerGroup != '1') { ?>
		slidesPerGroup: <?php echo $slidesPerGroup; ?>,
	<?php } ?>
	<?php if($slidesPerGroupSkip != '0') { ?>
		slidesPerGroupSkip: <?php echo $slidesPerGroupSkip; ?>,
	<?php } ?>
	<?php if($centeredSlides) { ?>
		centeredSlides: true,
	<?php } ?>
	<?php if($centeredSlidesBounds) { ?>
		centeredSlidesBounds: true,
	<?php } ?>
	<?php if($slidesOffsetBefore != '0') { ?>
		slidesOffsetBefore: <?php echo $slidesOffsetBefore; ?>,
	<?php } ?>
	<?php if($slidesOffsetAfter != '0') { ?>
		slidesOffsetAfter: <?php echo $slidesOffsetAfter; ?>,
	<?php } ?>
	<?php if(!$normalizeSlideIndex) { ?>
		normalizeSlideIndex: false,
	<?php } ?>
	<?php if($centerInsufficientSlides) { ?>
		centerInsufficientSlides: true,
	<?php } ?>
	<?php if($grabCursor) { ?>
		grabCursor: true,
	<?php } ?>
	<?php if(!$preventClicks) { ?>
		preventClicks: false,
	<?php } ?>
	<?php if(!$preventClicksPropagation) { ?>
		preventClicksPropagation: false,
	<?php } ?>
	<?php if($slideToClickedSlide) { ?>
		slideToClickedSlide: true,
	<?php } ?>
	<?php if($freeMode) { ?>
		freeMode: true,
	<?php } ?>
	<?php if(!$freeModeMomentum) { ?>
		freeModeMomentum: false,
	<?php } ?>
	<?php if($freeModeMomentumRatio != '1') { ?>
		freeModeMomentumRatio: <?php echo $freeModeMomentumRatio; ?>,
	<?php } ?>
	<?php if($freeModeMomentumVelocityRatio != '1') { ?>
		freeModeMomentumVelocityRatio: <?php echo $freeModeMomentumVelocityRatio; ?>,
	<?php } ?>
	<?php if(!$freeModeMomentumBounce) { ?>
		freeModeMomentumBounce: false,
	<?php } ?>
	<?php if($freeModeMomentumBounceRatio != '1') { ?>
		freeModeMomentumBounceRatio: <?php echo $freeModeMomentumBounceRatio; ?>,
	<?php } ?>
	<?php if($freeModeMinimumVelocity_output != '0.02') { ?>
		freeModeMinimumVelocity: <?php echo $freeModeMinimumVelocity_output; ?>,
	<?php } ?>
	<?php if($freeModeSticky) { ?>
		freeModeSticky: true,
	<?php } ?>
	<?php if($loop) { ?>
		loop: true,
	<?php } ?>
	<?php if($loopAdditionalSlides != '0') { ?>
		loopAdditionalSlides: <?php echo $loopAdditionalSlides; ?>,
	<?php } ?>
	<?php if($loopedSlides != 'null') { ?>
		loopedSlides: <?php echo $loopedSlides; ?>,
	<?php } ?>
	<?php if($loopFillGroupWithBlank) { ?>
		loopFillGroupWithBlank: true,
	<?php } ?>
	<?php if($breakpoints != null) { ?>
		breakpoints: {<?php echo $breakpointInsert; ?>},
	<?php } ?>
	<?php if($containerModifierClass != 'swiper-container-') { ?>
		containerModifierClass: '<?php echo $containerModifierClass; ?>',
	<?php } ?>
	<?php if($slideClass != 'swiper-slide') { ?>
		slideClass: '<?php echo $slideClass; ?>',
	<?php } ?>
	<?php if($slideActiveClass != 'swiper-slide-active') { ?>
		slideActiveClass: '<?php echo $slideActiveClass; ?>',
	<?php } ?>
	<?php if($slideDuplicateActiveClass != 'swiper-slide-duplicate-active') { ?>
		slideDuplicateActiveClass: '<?php echo $slideDuplicateActiveClass; ?>',
	<?php } ?>
	<?php if($slideVisibleClass != 'swiper-slide-visible') { ?>
		slideVisibleClass: '<?php echo $slideVisibleClass; ?>',
	<?php } ?>
	<?php if($slideDuplicateClass != 'swiper-slide-duplicate') { ?>
		slideDuplicateClass: '<?php echo $slideDuplicateClass; ?>',
	<?php } ?>
	<?php if($slideNextClass != 'swiper-slide-next') { ?>
		slideNextClass: '<?php echo $slideNextClass; ?>',
	<?php } ?>
	<?php if($slideDuplicateNextClass != 'swiper-slide-duplicate-next') { ?>
		slideDuplicateNextClass: '<?php echo $slideDuplicateNextClass; ?>',
	<?php } ?>
	<?php if($slidePrevClass != 'swiper-slide-prev') { ?>
		slidePrevClass: '<?php echo $slidePrevClass; ?>',
	<?php } ?>
	<?php if($slideDuplicatePrevClass != 'swiper-slide-duplicate-prev') { ?>
		slideDuplicatePrevClass: '<?php echo $slideDuplicatePrevClass; ?>',
	<?php } ?>
	<?php if($wrapperClass != 'swiper-wrapper') { ?>
		wrapperClass: '<?php echo $wrapperClass; ?>',
	<?php } ?>	
	<?php if($type_select == '3') { ?>
		parallax: true,
	<?php } ?>
	<?php if($navigation) { ?>
		navigation: {
			nextEl: '#swiper-next-<?php echo $module->id; ?>',
			prevEl: '#swiper-prev-<?php echo $module->id; ?>',
		},
	<?php } ?>
	<?php if($pagination) { ?>
		pagination: {
			el: '#swiper-pagination-<?php echo $module->id; ?>',
			<?php if($pagination_dynamic) { ?>
				dynamicBullets: true,
			<?php } ?>
			
			<?php if($pagination_type == 'custom') { ?>
				clickable: true,
				renderBullet: function (index, className) {
					return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			<?php } else { ?>
				type: "<?php echo $pagination_type; ?>",
			<?php } ?>
			<?php if($pagination_dynamic && $pagination_dynamic_main != '1') { ?>
				dynamicMainBullets: <?php echo $pagination_dynamic_main; ?>,
			<?php } ?>
			<?php if(!$pagination_hideOnClick) { ?>
				hideOnClick: false,
			<?php } ?>
			<?php if($pagination_clickable) { ?>
				clickable: true,
			<?php } ?>
			<?php if($pagination_progressbarOpposite) { ?>
				progressbarOpposite: true,
			<?php } ?>
			<?php if($pagination_bulletClass != 'swiper-pagination-bullet') { ?>
				bulletClass: '<?php echo $pagination_bulletClass; ?>',
			<?php } ?>
			<?php if($pagination_bulletActiveClass != 'swiper-pagination-bullet-active') { ?>
				bulletActiveClass: '<?php echo $pagination_bulletActiveClass; ?>',
			<?php } ?>
		},
	<?php } ?>
	<?php if($scrollbar) { ?>
		scrollbar: {
			el: '#swiper-scrollbar-<?php echo $module->id; ?>',
			hide: true,
		},
	<?php } ?>
	<?php if($autoplay) { ?>
		autoplay: {
			delay: <?php echo $autoplay_delay; ?>,
			<?php if($stopOnLastSlide) { ?>
				stopOnLastSlide: true,
			<?php } ?>
			<?php if(!$disableOnInteraction) { ?>
				disableOnInteraction: false,
			<?php } ?>
		},
	<?php } ?>
	<?php if($keyboard_control) { ?>
		keyboard: {
			enabled: true,
			<?php if(!$keyboard_control_onlyInViewport) { ?>
				onlyInViewport: false,
			<?php } ?>
		},
	<?php } ?>
	<?php if($mousewheel_control) { ?>
		mousewheel: {
			<?php if($mousewheel_forceToAxis) { ?>
				forceToAxis: true,
			<?php } ?>
			<?php if($mousewheel_releaseOnEdges) { ?>
				releaseOnEdges: true,
			<?php } ?>
			<?php if($mousewheel_invert) { ?>
				invert: true,
			<?php } ?>
			<?php if($mousewheel_sensitivity != '1') { ?>
				sensitivity: <?php echo $mousewheel_sensitivity; ?>,
			<?php } ?>
			<?php if($mousewheel_eventsTarget != 'container') { ?>
				eventsTarget: '<?php echo $mousewheel_eventsTarget; ?>',
			<?php } ?>
		},
	<?php } ?>
	<?php if($lazyload) { ?>
		preloadImages: false,
		lazy: true,
	<?php } ?>
	<?php if($hashNavigation && !$watchState && !$replaceState) { ?>
		hashNavigation: true,
	<?php } elseif($hashNavigation) { ?>
		hashNavigation: {
			<?php if($watchState) { ?>
				watchState: true,
			<?php } ?>
			<?php if($replaceState) { ?>
				replaceState: true,
			<?php } ?>
		},
	<?php } ?>
	<?php if($history && !$history_replaceState && $key != 'slides') { ?>
		history: true,
	<?php } elseif($history) { ?>
			history: {
			<?php if($history_replaceState) { ?>
				replaceState: true,
			<?php } ?>
			<?php if($key != 'slides') { ?>
				key: '<?php echo $key; ?>',
			<?php } ?>
		},
	<?php } ?>
	})

	<?php if($thumbs) { ?>
		mySwiper.controller.control = thumbsSwiper;
		thumbsSwiper.controller.control = mySwiper;
	<?php } ?>

	<?php if($type_select == '2') {
		$script_count = 1;
		foreach($nested as $index=>$value) {
			$nested_spaceBetween	= $value->nested_spaceBetween;
			$nested_slidesPerView	= $value->nested_slidesPerView;
			$nested_direction		= $value->nested_direction;
		?>

			var mySwiper = new Swiper ('.swiper-container-<?php echo $script_count; ?>', {
				spaceBetween: <?php echo $nested_spaceBetween; ?>,
				slidesPerView: <?php echo $nested_slidesPerView; ?>,
				direction: '<?php echo $nested_direction; ?>'
			})

			<?php $script_count++; ?>
		<?php } ?>

	<?php } ?>



</script>
