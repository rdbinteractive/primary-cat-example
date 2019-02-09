<?php
/**
 * Plugin Name: RDBI Primary Category
 * Plugin URI: https://rdbinteractive.com
 * Description: Adds the ability to select and query primary categories for posts & post types.
 * Version: 1.0.0
 * Author: Robert Bardall
 * Author URI: https://rdbinteractive.com
 * Text Domain: rdbi_primary
 */

namespace PrimaryCategory;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load the Autoloader, required for class namespacing.
 */
require_once __DIR__ . '/Lib/Autoloader.php';

/**
 * Configure the Primary Category meta box.
 */
(new Meta())->configureMeta();
