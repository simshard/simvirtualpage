<?php

/**
 * Ipsychallenge Class Doc Comment
 *
 * @category Class
 * @package  SimVirtualpage
 * @author   sim <simon.kember@blueyonder.co.uk>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.example.com/
 */

declare(strict_types=1);

namespace SimVirtualpage;

//$simVirtualpage = new SimVirtualpage();

class SimVirtualpage
{
    public string $apiUrl = 'https://jsonplaceholder.typicode.com/users'; // The API endpoint URL.

    // private
    public static $instance;

    public static function svpInstance(): object
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Inpsyde plugin challenge constructor
     */
    public function __construct()
    {
        // register_activation_hook(__FILE__, [$this, 'ivpLoadPlugin']);//Doing it wrong
        add_action('wp_enqueue_scripts', [$this, 'addIvpScripts']);
        add_action('template_include', [$this, 'changeTemplate']);
        add_filter('queryVars', [$this, 'ivpQueryVars']);
        add_action('init', [$this, 'ivpRewrite']);//Doing it wrong
        //add_action('init', [$this, 'ivpLoadPlugin']);
    }



    
    public function ivpLoadPlugin()
    {
        if (get_option('Activated_Plugin') == 'simvirtualpage') {
            delete_option('Activated_Plugin');
            /* do stuff once right after activation */
            add_action('init', [$this, 'ivpActivate']);
        }
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
    }

    /**
     * WP Rewrite rules
     *
     * @return void
     */
    public function ivpRewrite()
    {
        add_rewrite_endpoint('users', EP_PERMALINK);
        flush_rewrite_rules();
    }

    /**
     * Set WP Query vars
     * @param [array] $vars query string var
     * @return array
     */
    public function ivpQueryVars(array $vars): array
    {
        $vars[] = 'users';
        return $vars;
    }

    /**
     * Enqueue styles
     * @return void
     */
    public function addIvpScripts()
    {
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
            $response = wp_remote_get($this->apiUrl);
            if (is_array($response) && ! is_wp_error($response)) {
                set_transient('ivp_userinfo', $response, HOUR_IN_SECONDS);
            }
            if (is_wp_error($response)) {
                $errorMessage = $response->get_error_message();
                return(esc_html($errorMessage));
            }
        }
        $userinfo = $ivpUserinfo['body'];

        try {
            $userinfo = json_decode($userinfo);
        } catch (\Exception $ex) {
            $userinfo = null;
        }
        return $userinfo;
    }
}
