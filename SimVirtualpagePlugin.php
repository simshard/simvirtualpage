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

//const  PLUGIN_FILE_URL = __FILE__ ;
//$pluginSlug = dirname(plugin_basename(__FILE__));  //not needed

include_once('SimVirtualpage.php');

// $simVirtualpage = new SimVirtualpage();
$simVirtualpage =  SimVirtualpage::svpInstance();

//register_activation_hook(__FILE__, ['SimVirtualpage', 'ivpLoadPlugin']); //doing it wrong

// register_activation_hook(__FILE__, 'ivpActivate');     //doing it wrong
// register_deactivation_hook(__FILE__, 'ivpDeactivate');
