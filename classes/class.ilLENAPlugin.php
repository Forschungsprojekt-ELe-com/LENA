<?php
declare(strict_types=1);
/**
 * LENA
 *
 * @author Jean-Luc Braun <braun@qualitus.de>
 */
class ilLENAPlugin extends ilPageComponentPlugin
{
	/**
	 * Get plugin name 
	 *
	 * @return string
	 */
	function getPluginName()
	{
		return "LENA";
	}
	
	
	/**
	 * isValidParentType  
	 * @param string $a_parent_type object type
	 * @return boolean
	 */
	function isValidParentType($a_parent_type)
	{
		if (in_array($a_parent_type, array("crs", "cont"))) {
			return true;
		}
		return false;
	}
}