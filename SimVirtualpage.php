<?php

/**
 * Inpsyde challenge Class
 *
 * @category Class
 * @package  SimVirtualpage
 * @author   sim <simon.kember@blueyonder.co.uk>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.example.com/
 */

declare(strict_types=1);

namespace SimVirtualpage;

class SimVirtualpage
{
      

    /**
     * Inpsyde plugin challenge constructor
     */

    public function __construct()
    {
        add_action('init', [$this, 'ivpActivate']);
        //OK but Doing it wrong-unnecessary performance overhead rewrite rules every request
        //-would be better on register_activation hook if I could get that to work
        add_action('wp_enqueue_scripts', [$this, 'addIvpScripts']);
        add_action('template_include', [$this, 'changeTemplate']);
    }

    /**
     * Initialise plugin
     * Check PHP and WP Versions meet minimum requirements
     * set api url option
     * Return Type : None
     */
    public function ivpInitialise()
    {
        if (version_compare(PHP_VERSION, '7.0.0') < 0) {
            wp_die(esc_html__("PHP version must be at least 7.0 to use this plugin"));
        }
        global $wp_version;
        if ($wp_version < 5.0) {
            wp_die(esc_html__('WordPress must be at least version 5.0 to use this plugin'));
        }
        add_option('ApiEndPoint', 'https://jsonplaceholder.typicode.com/users/');
        add_option('Initialised_Plugin', 'simvirtualpage');
    }
 
    /**
    * Activate plugin
    * on activation
    * add rewrite endpoint and flush rewrite rules
    * @return void
    */
    public function ivpActivate()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }
        add_option('Activated_Plugin', 'simvirtualpage');
        add_rewrite_endpoint('users', EP_PERMALINK);
        flush_rewrite_rules();
    }

    /**
     * Deactivate plugin
     * flush rules on deactivate
     * @return void
     */
    public function ivpDeactivate()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }
        flush_rewrite_rules();
        delete_option('ApiEndPoint');
        delete_option('Activated_Plugin');
    }
 

    /**
     * Enqueue styles
     * @return void
     */
    public function addIvpScripts()
    {
        $apiEndPoint = get_option('ApiEndPoint');
        wp_register_style(
            'ivp-css',
            plugins_url('templates/css', __FILE__) . '/ivp-style.css',
            [],
            '1.0'
        );
        wp_register_script(
            'user-data',
            plugins_url('templates/js', __FILE__) . '/user-data.js',
            [],
            '1.0',
            false
        );
        wp_enqueue_style('ivp-css', '', [], '1.0');
        wp_enqueue_script('user-data', '', [], '1.0', false);
       
        wp_localize_script(
            'user-data',
            'ivpVars',
            ['apiurl' => $apiEndPoint]
        );
    }

    /**
     * Change WP display template
     * @param [mixed] $template a wp template
     * @return void
     */
    public function changeTemplate(string $template): string
    {
        if (get_query_var('users', false) !== false) {
            //Check theme directory
            $newTemplate = locate_template('template-theusers.php');
            if ('' !== $newTemplate) {
                return $newTemplate;
            }
            //Check plugin directory
            $newTemplate = plugin_dir_path(__FILE__) . 'templates/template-theusers.php';
            if (file_exists($newTemplate)) {
                return $newTemplate;
            }
        }
        //or Fall back to original template
        return $template;
    }

    /**
     * Remote API call
     * @return Json
     */
    public function doRemoteApiCall(): ?array
    {
        $ivpUserinfo = get_transient('ivp_userinfo');
        if (false === $ivpUserinfo) {
            $apiEndPoint = get_option('ApiEndPoint');
            $response = wp_remote_get($apiEndPoint);
            if (is_array($response) && ! is_wp_error($response)) {
                set_transient('ivp_userinfo', $response, HOUR_IN_SECONDS);
            }
            if (is_wp_error($response)) {
                $errorMessage = $response->get_error_message();
                return(esc_html($errorMessage));
            }
        }
        $userinfo = $ivpUserinfo['body'];
        if (!empty($userinfo)) {
            try {
                $userinfo = json_decode($userinfo);
            } catch (\Exception $ex) {
                $userinfo = null;
            }
        }
        return $userinfo;
    }
}
