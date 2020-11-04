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

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Router\Route;

require ModuleHelper::getLayoutPath('mod_swiper_slider', $params->get('layout', 'default'));