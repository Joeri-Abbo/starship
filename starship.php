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

const SPACESHIP_TEXT_DOMAIN = 'starship';

define("STARSHIP_URI", plugin_dir_url(__FILE__));
define("STARSHIP_PATH", plugin_dir_path(__FILE__));

define("STARSHIP_GLOBAL_POST", 'starship_model');

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

		add_action('wp_head', function () {
			dd(starship_get_post());
		});
	}

	/**
	 * Add text domain
	 *
	 * @since 1.0.0
	 */
	public static function addTextDomain()
	{
		load_plugin_textdomain(SPACESHIP_TEXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');
	}
}

new Starship();
new Starship\Helpers\Model();
new Starship\Helpers\Collection();
new Starship\Helpers\Category();
