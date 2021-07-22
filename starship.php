<?php
/**
 * Plugin Name: Starship 🚀
 * Description: Add models to wordpress elements
 * Text Domain: starship
 * Domain Path: /languages
 *
 * Author: Joeri Abbo
 * Author URI: https://nl.linkedin.com/in/joeri-abbo-43a457144
 *
 * Version: 1.0.0
 */

// File Security Check
defined('ABSPATH') or die("No script kiddies please!");

const STARSHIP_TEXT_DOMAIN = 'starship';
const STARSHIP_PREFIX      = 'starship';

define("STARSHIP_VERSION", 'v1.0.0');
define("STARSHIP_URI", plugin_dir_url(__FILE__));
define("STARSHIP_PATH", plugin_dir_path(__FILE__));

define("STARSHIP_GLOBAL_MODEL", STARSHIP_PREFIX . '_model');
define("STARSHIP_GLOBAL_COLLECITON", STARSHIP_PREFIX . '_collection');
define("STARSHIP_GLOBAL_TAXONOMY", STARSHIP_PREFIX . '_taxonomy');

require_once STARSHIP_PATH . 'vendor/autoload.php';

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
class Starship
{
	/**
	 * Setup starship for flight 🚀
	 */
	public static function init()
	{
		add_action('init', [__CLASS__, 'addTextDomain']);

	}

	public function __construct()
	{
		self::init();
		new Starship\Helpers\Model();
		new Starship\Helpers\Collection();
		new Starship\Helpers\Taxonomy();
		new Starship\Helpers\ACF\FlexContent();

		add_action('admin_init', function () {
			add_filter('admin_footer_text', function ($content) {
				return __('Thanks for using Starship 🚀', STARSHIP_TEXT_DOMAIN) . ' ' . STARSHIP_VERSION;
			}, 11);
		});

//
//		add_action('wp_head', function () {
//			$layouts = starship_get_flex_content(get_queried_object_id(), 'layout');
//			dd($layouts);
//		});


	}

	/**
	 * Add text domain
	 *
	 * @since 1.0.0
	 */
	public static function addTextDomain()
	{
		load_plugin_textdomain(STARSHIP_TEXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');
	}
}

new Starship();
