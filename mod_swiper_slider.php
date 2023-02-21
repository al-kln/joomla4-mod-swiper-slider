<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_swiper_slider
 *
 * @copyright   Copyright (C) 2005 - 2023 Open Source Matters, Inc. All rights reserved.
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

$modSFX = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$modClass .= $modSFX ? ' ' . $modSFX : '';

if (!function_exists('sanitizeFileName')) :
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
endif;

switch ($params['typeselect']) :
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
endswitch;

require ModuleHelper::getLayoutPath('mod_swiper_slider', $params->get('layout', 'default'));
?>

<?php // init swiper ?>
<script>
	const Swiper<?php echo $scriptID; ?> = new Swiper ('#<?php echo $swiper__id; ?>', {
		<?php if ($params['initialSlide'] != 0) : ?>
			initialSlide: <?php echo $params['initialSlide']; ?>,
		<?php endif; ?>
		<?php if ($params['direction'] != 'horizontal') : ?>
			direction: '<?php echo $params['direction']; ?>',
		<?php endif; ?>
		<?php if ($params['speed'] != 300) : ?>
			speed: <?php echo $params['speed']; ?>,
		<?php endif; ?>
		<?php if ($params['setWrapperSize'] && $params['effect'] != 'cube') : ?>
			setWrapperSize: true,
		<?php endif; ?>
		<?php if ($params['virtualTranslate']) : ?>
			virtualTranslate: true,
		<?php endif; ?>
		<?php if ($params['width'] != null) : ?>
			width: <?php echo $params['width']; ?>,
		<?php endif; ?>
		<?php if ($params['height'] != null) : ?>
			height: <?php echo $params['height']; ?>,
		<?php endif; ?>
		<?php if ($params['autoHeight']) : ?>
			autoHeight: true,	
		<?php endif; ?>
		<?php if ($params['effect'] != 'slide') : ?>
			effect: '<?php echo $params['effect']; ?>',
		<?php endif; ?> 
		<?php if ($params['effect'] == 'fade' && $params['crossFade']) : ?>
			fadeEffect: {
				crossFade: true
			},
		<?php endif; ?>
		<?php if ($params['effect'] == 'cards') : ?>
			cardsEffect: {
				<?php if (!$params['cardsEffect__slideShadows']) : ?>
					slideShadows: false,
				<?php endif; ?>
				<?php if ($params['cardsEffect__transformEl'] != null) : ?>
					transformEl: '<?php echo $params['cardsEffect__transformEl']; ?>',
				<?php endif; ?>
			},
		<?php endif; ?>
		<?php if ($params['effect'] == 'creative') : ?>
			creativeEffect: {
				<?php if ($params['creativeEffect__limitProgress'] != '1') : ?>
					limitProgress: <?php echo $params['creativeEffect__limitProgress']; ?>,
				<?php endif; ?>
				<?php if ($params['creativeEffect__next']) : ?>
					next: <?php echo $params['creativeEffect__next']; ?>,
				<?php endif; ?>
				<?php if (!$params['creativeEffect__perspective']) : ?>
					perspective: false,
				<?php endif; ?>
				<?php if ($params['creativeEffect__prev']) : ?>
					prev: <?php echo $params['creativeEffect__prev']; ?>,
				<?php endif; ?>
				<?php if ($params['creativeEffect__progressMultipler'] != '1') : ?>
					progressMultipler: <?php echo $params['creativeEffect__progressMultipler']; ?>,
				<?php endif; ?>
				<?php if ($params['creativeEffect__shadowPerProgress']) : ?>
					shadowPerProgress: true,
				<?php endif; ?>
				<?php if ($params['creativeEffect__transformEl'] != null) : ?>
					transformEl: '<?php echo $params['creativeEffect__transformEl']; ?>',
				<?php endif; ?>	
			},
		<?php endif; ?>
		<?php if ($params['effect'] == 'cube') : ?>
			grabCursor: true,
			cubeEffect: {
				shadow: true,
				slideShadows: true,
				shadowOffset: 20,
				shadowScale: 0.94,
			},
		<?php endif; ?>
		<?php if ($params['effect'] == 'coverflow') : ?>
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
		<?php endif; ?>
		<?php if ($params['effect'] == 'flip') : ?>
			grabCursor: true,
		<?php endif; ?>
		<?php if (!$params['watchOverflow']) : ?>
			watchOverflow: false,
		<?php endif; ?>
		<?php if ($params['watchSlidesProgress']) : ?>
			watchSlidesProgress: true,
		<?php endif; ?>
		<?php if (!$params['allowSlideNext']) : ?>
			allowSlideNext: false,
		<?php endif; ?>
		<?php if (!$params['allowSlidePrev']) : ?>
			allowSlidePrev: false,
		<?php endif; ?>
		<?php if (!$params['allowTouchMove']) : ?>
			allowTouchMove: false,
		<?php endif; ?>
		<?php if ($params['breakpointsBase'] != 'window') : ?>
			breakpointsBase: 'container',
		<?php endif; ?>
		<?php if (!$params['followFinger']) : ?>
			followFinger: false,
		<?php endif; ?>
		<?php if (!$params['init']) : ?>
			init: false,
		<?php endif; ?>
		<?php if ($params['observeParents']) : ?>
			observeParents: true,
		<?php endif; ?>
		<?php if ($params['observeSlideChildren']) : ?>
			observeSlideChildren: true,
		<?php endif; ?>
		<?php if ($params['observer']) : ?>
			observer: true,
		<?php endif; ?>
		<?php if (!$params['passiveListeners']) : ?>
			passiveListeners: false,
		<?php endif; ?>
		<?php if (!$params['preloadImages']) : ?>
			preloadImages: false,
		<?php endif; ?>
		<?php if ($params['preventInteractionOnTransition']) : ?>
			preventInteractionOnTransition: true,
		<?php endif; ?>
		<?php if (!$params['shortSwipes']) : ?>
			shortSwipes: false,
		<?php endif; ?>
		<?php if (!$params['simulateTouch']) : ?>
			simulateTouch: false,
		<?php endif; ?>
		<?php if (!$params['resizeObserver']) : ?>
			resizeObserver: false,
		<?php endif; ?>
		<?php if ($params['rewind']) : ?>
			rewind: true,
		<?php endif; ?>
		<?php if ($params['touchEventsTarget'] != 'wrapper') : ?>
			touchEventsTarget: 'container',
		<?php endif; ?>
		<?php if (!$params['updateOnImagesReady']) : ?>
			updateOnImagesReady: false,
		<?php endif; ?>
		<?php if (!$params['updateOnWindowResize']) : ?>
			updateOnWindowResize: false,
		<?php endif; ?>
		<?php if ($params['url']) : ?>
			url: '<?php echo $params['url']; ?>',
		<?php endif; ?>
		<?php if ($params['userAgent']) : ?>
			userAgent: '<?php echo $params['userAgent']; ?>',
		<?php endif; ?>
		<?php if ($params['createElements']) : ?>
			createElements: true,
		<?php endif; ?>
		<?php if ($params['cssMode']) : ?>
			cssMode: true,
		<?php endif; ?>
		<?php if ($params['grabCursor']) : ?>
			grabCursor: true,
		<?php endif; ?>
		<?php if ($params['spaceBetween'] != null) : ?>
			spaceBetween: <?php echo $params['spaceBetween']; ?>,
		<?php endif; ?>
		<?php if ($params['slidesPerView'] != '1') : ?>
			slidesPerView: <?php echo $params['slidesPerView'] != 'auto' ? $params['slidesPerView'] : "'auto'"; ?>,
		<?php endif; ?>
		<?php if ($params['slidesPerGroup'] != '1') : ?>
			slidesPerGroup: <?php echo $params['slidesPerGroup']; ?>,
		<?php endif; ?>
		<?php if ($params['slidesPerGroupAuto']) : ?>
			slidesPerGroupAuto: true,
		<?php endif; ?>
		<?php if ($params['slidesPerGroupSkip'] != '0') : ?>
			slidesPerGroupSkip: <?php echo $params['slidesPerGroupSkip']; ?>,
		<?php endif; ?>
		<?php if ($params['centeredSlides']) : ?>
			centeredSlides: true,
		<?php endif; ?>
		<?php if ($params['centeredSlidesBounds']) : ?>
			centeredSlidesBounds: true,
		<?php endif; ?>
		<?php if ($params['slidesOffsetBefore'] != '0') : ?>
			slidesOffsetBefore: <?php echo $params['slidesOffsetBefore']; ?>,
		<?php endif; ?>
		<?php if ($params['slidesOffsetAfter'] != '0') : ?>
			slidesOffsetAfter: <?php echo $params['slidesOffsetAfter']; ?>,
		<?php endif; ?>
		<?php if (!$params['normalizeSlideIndex']) : ?>
			normalizeSlideIndex: false,
		<?php endif; ?>
		<?php if ($params['centerInsufficientSlides']) : ?>
			centerInsufficientSlides: true,
		<?php endif; ?>
		<?php if (!$params['preventClicks']) : ?>
			preventClicks: false,
		<?php endif; ?>
		<?php if (!$params['preventClicksPropagation']) : ?>
			preventClicksPropagation: false,
		<?php endif; ?>
		<?php if ($params['slideToClickedSlide']) : ?>
			slideToClickedSlide: true,
		<?php endif; ?>
		<?php if ($params['freeMode']) : ?>
			freeMode: true,
		<?php endif; ?>
		<?php if (!$params['freeModeMomentum']) : ?>
			freeModeMomentum: false,
		<?php endif; ?>
		<?php if ($params['freeModeMomentumRatio'] != '1') : ?>
			freeModeMomentumRatio: <?php echo $params['freeModeMomentumRatio']; ?>,
		<?php endif; ?>
		<?php if ($params['freeModeMomentumVelocityRatio'] != '1') : ?>
			freeModeMomentumVelocityRatio: <?php echo $params['freeModeMomentumVelocityRatio']; ?>,
		<?php endif; ?>
		<?php if (!$params['freeModeMomentumBounce']) : ?>
			freeModeMomentumBounce: false,
		<?php endif; ?>
		<?php if ($params['freeModeMomentumBounceRatio'] != '1') : ?>
			freeModeMomentumBounceRatio: <?php echo $params['freeModeMomentumBounceRatio']; ?>,
		<?php endif; ?>
		<?php if ($params['freeModeMinimumVelocity'] != '0,02') : ?>
			freeModeMinimumVelocity: <?php echo str_replace(',' , '.' , $params['freeModeMinimumVelocity']); ?>,
		<?php endif; ?>
		<?php if ($params['freeModeSticky']) : ?>
			freeModeSticky: true,
		<?php endif; ?>
		<?php if ($params['loop']) : ?>
			loop: true,
		<?php endif; ?>
		<?php if ($params['loopAdditionalSlides'] != '0') : ?>
			loopAdditionalSlides: <?php echo $params['loopAdditionalSlides']; ?>,
		<?php endif; ?>
		<?php if ($params['loopedSlides'] != 'null') : ?>
			loopedSlides: <?php echo $params['loopedSlides']; ?>,
		<?php endif; ?>
		<?php if ($params['loopFillGroupWithBlank']) : ?>
			loopFillGroupWithBlank: true,
		<?php endif; ?>

		<?php 

			//breakpoints subform

			$breakpointInsert = '';
			if (isset($params['breakpoints'])) :
				foreach ($params['breakpoints'] as $index => $breakpoint) :
					$viewport = $breakpoint->viewport;
					$viewportValues = $breakpoint->viewportValues;
					$breakpointInsert .= $viewport . ': {';
					foreach ($viewportValues as $index => $viewportBreakpoints) :
						$viewportAttribute = $viewportBreakpoints->viewportAttribute;
						$breaktpointDirection = $viewportBreakpoints->breaktpointDirection;
						if ($viewportBreakpoints->viewportBoolean) :
							$viewportBoolean = 'true';
						else :
							$viewportBoolean = 'false';	
						endif;
						$viewportValue = $viewportBreakpoints->viewportValue;
						$breakpointInsert .= $viewportAttribute . ': ';
						if ($viewportAttribute == 'direction') :
							$breakpointInsert .= '"' . $breaktpointDirection . '",';
						elseif ($viewportAttribute == 'loop' || $viewportAttribute == 'autoHeight') :
							$breakpointInsert .= $viewportBoolean . ',';
						else :
							$breakpointInsert .= $viewportValue . ',';
						endif;
					endforeach;
					$breakpointInsert .= '},';
				endforeach;
			endif;

		?>

		<?php if ($params['breakpoints'] != null) : ?>
			breakpoints: {<?php echo $breakpointInsert; ?>},
		<?php endif; ?>
		<?php if ($params['containerModifierClass'] != 'swiper-container-') : ?>
			containerModifierClass: '<?php echo $params['containerModifierClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideClass'] != 'swiper-slide') : ?>
			slideClass: '<?php echo $params['slideClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideActiveClass'] != 'swiper-slide-active') : ?>
			slideActiveClass: '<?php echo $params['slideActiveClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideDuplicateActiveClass'] != 'swiper-slide-duplicate-active') : ?>
			slideDuplicateActiveClass: '<?php echo $params['slideDuplicateActiveClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideVisibleClass'] != 'swiper-slide-visible') : ?>
			slideVisibleClass: '<?php echo $params['slideVisibleClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideDuplicateClass'] != 'swiper-slide-duplicate') : ?>
			slideDuplicateClass: '<?php echo $params['slideDuplicateClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideNextClass'] != 'swiper-slide-next') : ?>
			slideNextClass: '<?php echo $params['slideNextClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideDuplicateNextClass'] != 'swiper-slide-duplicate-next') : ?>
			slideDuplicateNextClass: '<?php echo $params['slideDuplicateNextClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slidePrevClass'] != 'swiper-slide-prev') : ?>
			slidePrevClass: '<?php echo $params['slidePrevClass']; ?>',
		<?php endif; ?>
		<?php if ($params['slideDuplicatePrevClass'] != 'swiper-slide-duplicate-prev') : ?>
			slideDuplicatePrevClass: '<?php echo $params['slideDuplicatePrevClass']; ?>',
		<?php endif; ?>
		<?php if ($params['wrapperClass'] != 'swiper-wrapper') : ?>
			wrapperClass: '<?php echo $params['wrapperClass']; ?>',
		<?php endif; ?>	
		<?php if ($params['typeselect'] == '3') : ?>
			parallax: true,
		<?php endif; ?>
		<?php if ($params['navigation']) : ?>
			navigation: {
				nextEl: '#sw__nav__nextID__<?php echo $ID; ?>',
				prevEl: '#sw__nav__prevID__<?php echo $ID; ?>',
			},
		<?php endif; ?>
		<?php if ($params['pagination']) : ?>
			pagination: {
				el: '#sw__pagiID__<?php echo $ID; ?>',
				<?php if ($params['pagination_dynamic']) : ?>
					dynamicBullets: true,
				<?php endif; ?>
				<?php if ($params['pagination_type'] == 'custom') : ?>
					clickable: true,
					renderBullet: function (index, className) {
						return '<span class="' + className + '">' + (index + 1) + '</span>';
					},
				<?php else : ?>
					type: "<?php echo $params['pagination_type']; ?>",
				<?php endif; ?>
				<?php if ($params['pagination_dynamic'] && $params['pagination_dynamic_main'] != '1') : ?>
					dynamicMainBullets: <?php echo $params['pagination_dynamic_main']; ?>,
				<?php endif; ?>
				<?php if (!$params['pagination_hideOnClick']) : ?>
					hideOnClick: false,
				<?php endif; ?>
				<?php if ($params['pagination_clickable']) : ?>
					clickable: true,
				<?php endif; ?>
				<?php if ($params['pagination_progressbarOpposite']) : ?>
					progressbarOpposite: true,
				<?php endif; ?>
				<?php if ($params['pagination_bulletClass'] != 'swiper-pagination-bullet') : ?>
					bulletClass: '<?php echo $params['pagination_bulletClass']; ?>',
				<?php endif; ?>
				<?php if ($params['pagination_bulletActiveClass'] != 'swiper-pagination-bullet-active') : ?>
					bulletActiveClass: '<?php echo $params['pagination_bulletActiveClass']; ?>',
				<?php endif; ?>
			},
		<?php endif; ?>
		<?php if ($params['scrollbar']) : ?>
			scrollbar: {
				el: '#sw__scrollID__<?php echo $ID; ?>',
				hide: true,
			},
		<?php endif; ?>
		<?php if ($params['autoplay']) : ?>
			autoplay: {
				delay: <?php echo $params['autoplay_delay']; ?>,
				<?php if ($params['stopOnLastSlide']) : ?>
					stopOnLastSlide: true,
				<?php endif; ?>
				<?php if (!$params['disableOnInteraction']) : ?>
					disableOnInteraction: false,
				<?php endif; ?>
				<?php if ($params['pauseOnMouseEnter']) : ?>
					pauseOnMouseEnter: true,
				<?php endif; ?>			
			},
		<?php endif; ?>
		<?php if ($params['keyboard_control']) : ?>
			keyboard: {
				enabled: true,
				<?php if (!$params['keyboard_control_onlyInViewport']) : ?>
					onlyInViewport: false,
				<?php endif; ?>
			},
		<?php endif; ?>
		<?php if ($params['mousewheel_control']) : ?>
			mousewheel: {
				<?php if ($params['mousewheel_forceToAxis']) : ?>
					forceToAxis: true,
				<?php endif; ?>
				<?php if ($params['mousewheel_releaseOnEdges']) : ?>
					releaseOnEdges: true,
				<?php endif; ?>
				<?php if ($params['mousewheel_invert']) : ?>
					invert: true,
				<?php endif; ?>
				<?php if ($params['mousewheel_sensitivity'] != '1') : ?>
					sensitivity: <?php echo $params['mousewheel_sensitivity']; ?>,
				<?php endif; ?>
				<?php if ($params['mousewheel_eventsTarget'] != 'container') : ?>
					eventsTarget: '<?php echo $params['mousewheel_eventsTarget']; ?>',
				<?php endif; ?>
			},
		<?php endif; ?>
		<?php if ($params['lazyload']) : ?>
			preloadImages: false,
			lazy: true,
		<?php endif; ?>
		<?php if ($params['hashNavigation'] && !$params['watchState'] && !$params['replaceState']) : ?>
			hashNavigation: true,
		<?php elseif ($params['hashNavigation']) : ?>
			hashNavigation: {
				<?php if ($params['watchState']) : ?>
					watchState: true,
				<?php endif; ?>
				<?php if ($params['replaceState']) : ?>
					replaceState: true,
				<?php endif; ?>
			},
		<?php endif; ?>
		<?php if ($params['history'] && !$params['history_replaceState'] && $params['key'] != 'slides') : ?>
			history: true,
		<?php elseif ($params['history']) : ?>
				history: {
				<?php if ($params['history_replaceState']) : ?>
					replaceState: true,
				<?php endif; ?>
				<?php if ($params['key'] != 'slides') : ?>
					key: '<?php echo $params['key']; ?>',
				<?php endif; ?>
			},
		<?php endif; ?>
	})

	<?php if ($params['thumbs']) : ?>
		Swiper<?php echo $scriptID; ?>.controller.control = thumbsSwiper<?php echo $scriptID; ?>;
		thumbsSwiper<?php echo $scriptID; ?>.controller.control = Swiper<?php echo $scriptID; ?>;
	<?php endif; ?>

	<?php if ($slider__layout == '_nested') :
		$nested__init = 1;
		foreach($params['nested'] as $index => $value) :
			$nested_spaceBetween	= $value->nested_spaceBetween;
			$nested_slidesPerView	= $value->nested_slidesPerView;
			$nested_direction		= $value->nested_direction;
		?>

			const nestedSwiper<?php echo rand(1000,99999); ?> = new Swiper('#swiper__nestedID__<?php echo $nested__init; ?>', {
				<?php if ($nested_spaceBetween) : ?>
					spaceBetween: <?php echo $nested_spaceBetween; ?>,
				<?php endif; ?>
				slidesPerView: <?php echo $nested_slidesPerView; ?>,
				direction: '<?php echo $nested_direction; ?>'
			})
			<?php $nested__init++; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</script>