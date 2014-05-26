<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of FileLinks component
 */
class com_FilelinksInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{
		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_filelinks');
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// $parent is the class calling this method
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		// $parent is the class calling this method
		echo '<p>' . JText::sprintf('Filelinks version: ', $parent->get('manifest')->version) . '</p>';
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		// Create categories for our component
		if ($type == 'install' || $type == 'discover_install')
		{
			$basePath = JPATH_ADMINISTRATOR . '/components/com_categories';
			require_once $basePath . '/models/category.php';
			$config = array('table_path' => $basePath . '/tables');
			$catmodel = new CategoriesModelCategory($config);
			$catData = array('parent_id' => 1, 'level' => 1, 'path' => 'uncategorised', 'extension' => 'com_filelinks', 'title' => 'Uncategorised', 'alias' => 'uncategorised', 'published' => 1, 'language' => '*');
			$status = $catmodel->save($catData);

			if (!$status)
			{
				JError::raiseWarning(500, JText::_('Unable to create uncategorised content category!'));
			}
		}

	}
}