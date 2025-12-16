<?php
namespace Elematic;

final class ModuleManager {
	/**
	 * @var Module_Base[]
	 */
	private $modules = [];

	public function __construct() {
		$modules = [
			'wrapper-link'
		];

		foreach ( $modules as $module_name ) {
			$this->register_module( $module_name );
		}
	}

	/**
	 * Register a module
	 * 
	 * @param string $module_name
	 */
	private function register_module( $module_name ) {
		$class_name = str_replace( '-', ' ', $module_name );
		$class_name = str_replace( ' ', '', ucwords( $class_name ) );
		$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

		// Check if file exists
		$file_path = ELEMATIC_PATH . 'modules/' . $module_name . '/module.php';
		
		if ( file_exists( $file_path ) ) {
			require_once $file_path;
			
			if ( class_exists( $class_name ) ) {
				$this->modules[ $module_name ] = new $class_name();
			}
		}
	}

	/**
	 * Get registered modules
	 * 
	 * @param string $module_name
	 *
	 * @return Module_Base|Module_Base[]|null
	 */
	public function get_modules( $module_name = '' ) {
		if ( $module_name ) {
			if ( isset( $this->modules[ $module_name ] ) ) {
				return $this->modules[ $module_name ];
			}

			return null;
		}

		return $this->modules;
	}
}