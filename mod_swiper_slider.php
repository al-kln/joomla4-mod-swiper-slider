<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\Swiper\Site\Helper\SwiperHelper;
use Joomla\CMS\Factory;

$params 				= SwiperHelper::getParams($params);

$swiper__id	 			= 'moduleID__' . $module->id;
$ID						= $module->id;
$scriptID				= rand(100, 1000);
$database 				= Factory::getDBO();
$document 				= Factory::getDocument();

$mod__class = ' ';
$modSFX = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
if($modSFX) {
    $mod__class .= ' ' . $modSFX;
}

if (!function_exists('sanitizeFileName')) {
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
}

switch ($params['typeselect']) {
	case '0':
		$slider__layout = '_images';
		break;
	case '1':
		$slider__layout = '_folder';
		break;
	case '2':
		$slider__layout = '_nested';
		break;
	case '3':
		$slider__layout = '_parallax';
		break;
}

require ModuleHelper::getLayoutPath('mod_swiper_slider', $params->get('layout', 'default'));
?>

<?php // init swiper ?>
<script>
	const Swiper<?php echo $scriptID; ?> = new Swiper ('#<?php echo $swiper__id; ?>', {
	<?php if($params['initialSlide'] != 0) { ?>
		initialSlide: <?php echo $params['initialSlide']; ?>,
	<?php } ?>
	<?php if($params['direction'] != 'horizontal') { ?>
		direction: '<?php echo $params['direction']; ?>',
	<?php } ?>
	<?php if($params['speed'] != 300) { ?>
		speed: <?php echo $params['speed']; ?>,
	<?php } ?>
	<?php if($params['setWrapperSize'] && $params['effect'] != 'cube') { ?>
		setWrapperSize: true,
	<?php } ?>
	<?php if($params['virtualTranslate']) { ?>
		virtualTranslate: true,
	<?php } ?>
	<?php if($params['width'] != null) { ?>
		width: <?php echo $params['width']; ?>,
	<?php } ?>
	<?php if($params['height'] != null) { ?>
		height: <?php echo $params['height']; ?>,
	<?php } ?>
	<?php if($params['autoHeight']) { ?>
		autoHeight: true,	
	<?php } ?>
	<?php if($params['effect'] != 'slide') { ?>
		effect: '<?php echo $params['effect']; ?>',
	<?php } ?> 
	<?php if($params['effect'] == 'fade' && $params['crossFade']) { ?>
		fadeEffect: {
			crossFade: true
		},
	<?php } ?>
	<?php if($params['effect'] == 'cube') { ?>
		grabCursor: true,
		cubeEffect: {
			shadow: true,
			slideShadows: true,
			shadowOffset: 20,
			shadowScale: 0.94,
		},
	<?php } ?>
	<?php if($params['effect'] == 'coverflow') { ?>
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
	<?php if($params['effect'] == 'flip') { ?>
		grabCursor: true,
	<?php } ?>
	<?php if($params['watchOverflow']) { ?>
		watchOverflow: true,
	<?php } ?>
	<?php if(!$params['allowSlideNext']) { ?>
		allowSlideNext: false,
	<?php } ?>
	<?php if(!$params['allowSlidePrev']) { ?>
		allowSlidePrev: false,
	<?php } ?>
	<?php if(!$params['allowTouchMove']) { ?>
		allowTouchMove: false,
	<?php } ?>
	<?php if($params['breakpointsBase'] != 'window') { ?>
		breakpointsBase: 'container',
	<?php } ?>
	<?php if(!$params['followFinger']) { ?>
		followFinger: false,
	<?php } ?>
	<?php if(!$params['init']) { ?>
		init: false,
	<?php } ?>
	<?php if($params['observeParents']) { ?>
		observeParents: true,
	<?php } ?>
	<?php if($params['observeSlideChildren']) { ?>
		observeSlideChildren: true,
	<?php } ?>
	<?php if($params['observer']) { ?>
		observer: true,
	<?php } ?>
	<?php if(!$params['passiveListeners']) { ?>
		passiveListeners: false,
	<?php } ?>
	<?php if(!$params['preloadImages']) { ?>
		preloadImages: false,
	<?php } ?>
	<?php if($params['preventInteractionOnTransition']) { ?>
		preventInteractionOnTransition: true,
	<?php } ?>
	<?php if(!$params['shortSwipes']) { ?>
		shortSwipes: false,
	<?php } ?>
	<?php if(!$params['simulateTouch']) { ?>
		simulateTouch: false,
	<?php } ?>
	<?php if($params['touchEventsTarget'] != 'container') { ?>
		touchEventsTarget: 'wrapper',
	<?php } ?>
	<?php if(!$params['updateOnImagesReady']) { ?>
		updateOnImagesReady: false,
	<?php } ?>
	<?php if(!$params['updateOnWindowResize']) { ?>
		updateOnWindowResize: false,
	<?php } ?>
	<?php if($params['url']) { ?>
		url: '<?php echo $params['url']; ?>',
	<?php } ?>
	<?php if($params['userAgent']) { ?>
		userAgent: '<?php echo $params['userAgent']; ?>',
	<?php } ?>
	<?php if($params['createElements']) { ?>
		createElements: true,
	<?php } ?>
	<?php if($params['cssMode']) { ?>
		cssMode: true,
	<?php } ?>
	<?php if($params['grabCursor']) { ?>
		grabCursor: true,
	<?php } ?>
	<?php if($params['spaceBetween'] != null) { ?>
		spaceBetween: <?php echo $params['spaceBetween']; ?>,
	<?php } ?>
	<?php if($params['slidesPerView'] != '1') { ?>
		slidesPerView: <?php if($params['slidesPerView'] != 'auto') { echo $params['slidesPerView']; } else { echo "'auto'"; } ?>,
	<?php } ?>
	<?php if($params['slidesPerColumn'] != '1') { ?>
		slidesPerColumn: <?php echo $params['slidesPerColumn']; ?>,
	<?php } ?>
	<?php if($params['slidesPerGroup'] != '1') { ?>
		slidesPerGroup: <?php echo $params['slidesPerGroup']; ?>,
	<?php } ?>
	<?php if($params['slidesPerGroupSkip'] != '0') { ?>
		slidesPerGroupSkip: <?php echo $params['slidesPerGroupSkip']; ?>,
	<?php } ?>
	<?php if($params['centeredSlides']) { ?>
		centeredSlides: true,
	<?php } ?>
	<?php if($params['centeredSlidesBounds']) { ?>
		centeredSlidesBounds: true,
	<?php } ?>
	<?php if($params['slidesOffsetBefore'] != '0') { ?>
		slidesOffsetBefore: <?php echo $params['slidesOffsetBefore']; ?>,
	<?php } ?>
	<?php if($params['slidesOffsetAfter'] != '0') { ?>
		slidesOffsetAfter: <?php echo $params['slidesOffsetAfter']; ?>,
	<?php } ?>
	<?php if(!$params['normalizeSlideIndex']) { ?>
		normalizeSlideIndex: false,
	<?php } ?>
	<?php if($params['centerInsufficientSlides']) { ?>
		centerInsufficientSlides: true,
	<?php } ?>
	<?php if(!$params['preventClicks']) { ?>
		preventClicks: false,
	<?php } ?>
	<?php if(!$params['preventClicksPropagation']) { ?>
		preventClicksPropagation: false,
	<?php } ?>
	<?php if($params['slideToClickedSlide']) { ?>
		slideToClickedSlide: true,
	<?php } ?>
	<?php if($params['freeMode']) { ?>
		freeMode: true,
	<?php } ?>
	<?php if(!$params['freeModeMomentum']) { ?>
		freeModeMomentum: false,
	<?php } ?>
	<?php if($params['freeModeMomentumRatio'] != '1') { ?>
		freeModeMomentumRatio: <?php echo $params['freeModeMomentumRatio']; ?>,
	<?php } ?>
	<?php if($params['freeModeMomentumVelocityRatio'] != '1') { ?>
		freeModeMomentumVelocityRatio: <?php echo $params['freeModeMomentumVelocityRatio']; ?>,
	<?php } ?>
	<?php if(!$params['freeModeMomentumBounce']) { ?>
		freeModeMomentumBounce: false,
	<?php } ?>
	<?php if($params['freeModeMomentumBounceRatio'] != '1') { ?>
		freeModeMomentumBounceRatio: <?php echo $params['freeModeMomentumBounceRatio']; ?>,
	<?php } ?>
	<?php if($params['freeModeMinimumVelocity'] != '0,02') { ?>
		freeModeMinimumVelocity: <?php echo str_replace(',' , '.' , $params['freeModeMinimumVelocity']); ?>,
	<?php } ?>
	<?php if($params['freeModeSticky']) { ?>
		freeModeSticky: true,
	<?php } ?>
	<?php if($params['loop']) { ?>
		loop: true,
	<?php } ?>
	<?php if($params['loopAdditionalSlides'] != '0') { ?>
		loopAdditionalSlides: <?php echo $params['loopAdditionalSlides']; ?>,
	<?php } ?>
	<?php if($params['loopedSlides'] != 'null') { ?>
		loopedSlides: <?php echo $params['loopedSlides']; ?>,
	<?php } ?>
	<?php if($params['loopFillGroupWithBlank']) { ?>
		loopFillGroupWithBlank: true,
	<?php } ?>

	<?php 

		//breakpoints subform

		$breakpointInsert = '';
		if(isset($params['breakpoints'])) {
			foreach($params['breakpoints'] as $index => $breakpoint) {
				$viewport = $breakpoint->viewport;
				$viewportValues = $breakpoint->viewportValues;
				$breakpointInsert .= $viewport . ': {';
				foreach($viewportValues as $index => $viewportBreakpoints) {

					$viewportAttribute = $viewportBreakpoints->viewportAttribute;
					$breaktpointDirection = $viewportBreakpoints->breaktpointDirection;
					if($viewportBreakpoints->breaktpointLoop) {
						$breaktpointLoop = 'true';
					} else {
						$breaktpointLoop = 'false';	
					}
					$viewportValue = $viewportBreakpoints->viewportValue;
					$breakpointInsert .= $viewportAttribute . ': ';
					if($viewportAttribute == 'direction') {
						$breakpointInsert .= '"' . $breaktpointDirection . '",';
					} elseif($viewportAttribute == 'loop') {
						$breakpointInsert .= $breaktpointLoop . ',';
					} else {
						$breakpointInsert .= $viewportValue . ',';
					}
				}
				$breakpointInsert .= '},';
			}
		}

	?>


	<?php if($params['breakpoints'] != null) { ?>
		breakpoints: {<?php echo $breakpointInsert; ?>},
	<?php } ?>

	<?php if($params['containerModifierClass'] != 'swiper-container-') { ?>
		containerModifierClass: '<?php echo $params['containerModifierClass']; ?>',
	<?php } ?>
	<?php if($params['slideClass'] != 'swiper-slide') { ?>
		slideClass: '<?php echo $params['slideClass']; ?>',
	<?php } ?>
	<?php if($params['slideActiveClass'] != 'swiper-slide-active') { ?>
		slideActiveClass: '<?php echo $params['slideActiveClass']; ?>',
	<?php } ?>
	<?php if($params['slideDuplicateActiveClass'] != 'swiper-slide-duplicate-active') { ?>
		slideDuplicateActiveClass: '<?php echo $params['slideDuplicateActiveClass']; ?>',
	<?php } ?>
	<?php if($params['slideVisibleClass'] != 'swiper-slide-visible') { ?>
		slideVisibleClass: '<?php echo $params['slideVisibleClass']; ?>',
	<?php } ?>
	<?php if($params['slideDuplicateClass'] != 'swiper-slide-duplicate') { ?>
		slideDuplicateClass: '<?php echo $params['slideDuplicateClass']; ?>',
	<?php } ?>
	<?php if($params['slideNextClass'] != 'swiper-slide-next') { ?>
		slideNextClass: '<?php echo $params['slideNextClass']; ?>',
	<?php } ?>
	<?php if($params['slideDuplicateNextClass'] != 'swiper-slide-duplicate-next') { ?>
		slideDuplicateNextClass: '<?php echo $params['slideDuplicateNextClass']; ?>',
	<?php } ?>
	<?php if($params['slidePrevClass'] != 'swiper-slide-prev') { ?>
		slidePrevClass: '<?php echo $params['slidePrevClass']; ?>',
	<?php } ?>
	<?php if($params['slideDuplicatePrevClass'] != 'swiper-slide-duplicate-prev') { ?>
		slideDuplicatePrevClass: '<?php echo $params['slideDuplicatePrevClass']; ?>',
	<?php } ?>
	<?php if($params['wrapperClass'] != 'swiper-wrapper') { ?>
		wrapperClass: '<?php echo $params['wrapperClass']; ?>',
	<?php } ?>	
	<?php if($params['typeselect'] == '3') { ?>
		parallax: true,
	<?php } ?>
	<?php if($params['navigation']) { ?>
		navigation: {
			nextEl: '#sw__nav__nextID__<?php echo $ID; ?>',
			prevEl: '#sw__nav__prevID__<?php echo $ID; ?>',
		},
	<?php } ?>
	<?php if($params['pagination']) { ?>
		pagination: {
			el: '#sw__pagiID__<?php echo $ID; ?>',
			<?php if($params['pagination_dynamic']) { ?>
				dynamicBullets: true,
			<?php } ?>
			
			<?php if($params['pagination_type'] == 'custom') { ?>
				clickable: true,
				renderBullet: function (index, className) {
					return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			<?php } else { ?>
				type: "<?php echo $params['pagination_type']; ?>",
			<?php } ?>
			<?php if($params['pagination_dynamic'] && $params['pagination_dynamic_main'] != '1') { ?>
				dynamicMainBullets: <?php echo $params['pagination_dynamic_main']; ?>,
			<?php } ?>
			<?php if(!$params['pagination_hideOnClick']) { ?>
				hideOnClick: false,
			<?php } ?>
			<?php if($params['pagination_clickable']) { ?>
				clickable: true,
			<?php } ?>
			<?php if($params['pagination_progressbarOpposite']) { ?>
				progressbarOpposite: true,
			<?php } ?>
			<?php if($params['pagination_bulletClass'] != 'swiper-pagination-bullet') { ?>
				bulletClass: '<?php echo $params['pagination_bulletClass']; ?>',
			<?php } ?>
			<?php if($params['pagination_bulletActiveClass'] != 'swiper-pagination-bullet-active') { ?>
				bulletActiveClass: '<?php echo $params['pagination_bulletActiveClass']; ?>',
			<?php } ?>
		},
	<?php } ?>
	<?php if($params['scrollbar']) { ?>
		scrollbar: {
			el: '#sw__scrollID__<?php echo $ID; ?>',
			hide: true,
		},
	<?php } ?>
	<?php if($params['autoplay']) { ?>
		autoplay: {
			delay: <?php echo $params['autoplay_delay']; ?>,
			<?php if($params['stopOnLastSlide']) { ?>
				stopOnLastSlide: true,
			<?php } ?>
			<?php if(!$params['disableOnInteraction']) { ?>
				disableOnInteraction: false,
			<?php } ?>
			<?php if($params['pauseOnMouseEnter']) { ?>
				pauseOnMouseEnter: true,
			<?php } ?>			
		},
	<?php } ?>
	<?php if($params['keyboard_control']) { ?>
		keyboard: {
			enabled: true,
			<?php if(!$params['keyboard_control_onlyInViewport']) { ?>
				onlyInViewport: false,
			<?php } ?>
		},
	<?php } ?>
	<?php if($params['mousewheel_control']) { ?>
		mousewheel: {
			<?php if($params['mousewheel_forceToAxis']) { ?>
				forceToAxis: true,
			<?php } ?>
			<?php if($params['mousewheel_releaseOnEdges']) { ?>
				releaseOnEdges: true,
			<?php } ?>
			<?php if($params['mousewheel_invert']) { ?>
				invert: true,
			<?php } ?>
			<?php if($params['mousewheel_sensitivity'] != '1') { ?>
				sensitivity: <?php echo $params['mousewheel_sensitivity']; ?>,
			<?php } ?>
			<?php if($params['mousewheel_eventsTarget'] != 'container') { ?>
				eventsTarget: '<?php echo $params['mousewheel_eventsTarget']; ?>',
			<?php } ?>
		},
	<?php } ?>
	<?php if($params['lazyload']) { ?>
		preloadImages: false,
		lazy: true,
	<?php } ?>
	<?php if($params['hashNavigation'] && !$params['watchState'] && !$params['replaceState']) { ?>
		hashNavigation: true,
	<?php } elseif($params['hashNavigation']) { ?>
		hashNavigation: {
			<?php if($params['watchState']) { ?>
				watchState: true,
			<?php } ?>
			<?php if($params['replaceState']) { ?>
				replaceState: true,
			<?php } ?>
		},
	<?php } ?>
	<?php if($params['history'] && !$params['history_replaceState'] && $params['key'] != 'slides') { ?>
		history: true,
	<?php } elseif($params['history']) { ?>
			history: {
			<?php if($params['history_replaceState']) { ?>
				replaceState: true,
			<?php } ?>
			<?php if($params['key'] != 'slides') { ?>
				key: '<?php echo $params['key']; ?>',
			<?php } ?>
		},
	<?php } ?>
	})

	<?php if($params['thumbs']) { ?>
		Swiper<?php echo $scriptID; ?>.controller.control = thumbsSwiper<?php echo $scriptID; ?>;
		thumbsSwiper<?php echo $scriptID; ?>.controller.control = Swiper<?php echo $scriptID; ?>;
	<?php } ?>

	<?php if($slider__layout == '_nested') {
	
		$nested__init = 1;
		foreach($params['nested'] as $index => $value) {
			$nested_spaceBetween	= $value->nested_spaceBetween;
			$nested_slidesPerView	= $value->nested_slidesPerView;
			$nested_direction		= $value->nested_direction;
		?>

			const nestedSwiper<?php echo rand(1000,99999); ?> = new Swiper('#swiper__nestedID__<?php echo $nested__init; ?>', {
				<?php if($nested_spaceBetween) { ?>
					spaceBetween: <?php echo $nested_spaceBetween; ?>,
				<?php } ?>
				slidesPerView: <?php echo $nested_slidesPerView; ?>,
				direction: '<?php echo $nested_direction; ?>'
			})

			<?php $nested__init++; ?>
		<?php } ?>

	<?php } ?>
</script>