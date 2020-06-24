<?php

/**
 * Plugin Name: simvirtualpage
 * Plugin URI: http://example.com
 * Description: sim virtual page plugin
 * Version: 1.0
 * Author URI: https://www.linkedin.com/in/simon-kember-923551a7/
 * License: GPL2
 * php version 7.2.10
 *
 * @category Sim_Virtual_Page_Plugin
 * @package  Wpplugin
 * @author   sim <simon.kember@blueyonder.co.uk>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * */

declare(strict_types=1);

namespace SimVirtualpage;

defined('ABSPATH') or die();

include_once('SimVirtualpage.php');

$simVirtualpage = new SimVirtualpage();
