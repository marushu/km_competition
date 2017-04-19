<?php
/**
 * Plugin Name:     KM Competition
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Hibou
 * Author URI:      https://private.hibou-web.com
 * Text Domain:     km-competition
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Km_Competition
 */

/**
 * Set the path.
 */
define( 'KMCOMPEVERSION', '0.5.0' );
define( 'KMCOMPEPATH', trailingslashit( dirname( __FILE__) ) );
define( 'KMCOMPEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );
define( 'KMCOMPEURL', plugin_dir_url( dirname( __FILE__ ) ) . KMCOMPEDIR );

require_once( KMCOMPEPATH . 'classes/kmcompe-core.php' );
$kmcompe_competition = new KMcompeclass;

require_once( KMCOMPEPATH . 'classes/kmcompe-admin.php' );
$kmcompe_competition = new KMadmin;

require_once( KMCOMPEPATH . 'post-types/kmcompe-competition.php' );
require_once ( KMCOMPEPATH . 'taxonomies/kmcompe-event.php' );