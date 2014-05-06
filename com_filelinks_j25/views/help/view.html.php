<?php
/**
 * @version     2.0.0
 * @package     com_filelinks
 * @copyright   Copyright (C) Helen 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Helen <heleneross@gmail.com> - http://bfgnet.de
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Filelinks.
 */
class FilelinksViewHelp extends JView
{
	function display($tpl = null)
	{
		$input = JFactory::getApplication()->input;
		$view = $input->getCmd('view', '');
		FilelinksHelper::addSubmenu($view);
		$this->addToolbar();
		parent::display($tpl);
	}


	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/filelinks.php';
		$title = 'Help';
		JToolBarHelper::title('Help', 'help_header.png');
	}
}
