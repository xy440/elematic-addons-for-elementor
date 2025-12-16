<?php
namespace Elematic\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Module_Base {

	/**
	 * Module constructor
	 */
	public function __construct() {
		add_action( 'elementor/init', [ $this, 'init' ] );
	}

	/**
	 * Initialize module
	 */
	public function init() {
		// Override in child class if needed
	}

	/**
	 * Get module name
	 * 
	 * @return string
	 */
	abstract public function get_name();
}