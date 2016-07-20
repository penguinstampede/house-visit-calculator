<?php
/*
Plugin Name:  House Visit Calculator
Description:  Create estimates for house calls for your business.
Version:      1.0.0
Author:       Erin Kosewic
*/

require_once( 'inc/class.housecall.php' );
//add_action( 'init', array( 'HouseCall', 'init' ), 5 );

if ( is_admin() ) {
	require_once( 'inc/class.admin.php' );
}
