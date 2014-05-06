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
class FilelinksViewFindfiles extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');


		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();

		$input = JFactory::getApplication()->input;
		$view = $input->getCmd('view', '');
		FilelinksHelper::addSubmenu($view);

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/filelinks.php';

		$state = $this->get('State');
		$canDo = FilelinksHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_FILELINKS_TITLE_FINDFILES'), 'findfiles.png');


		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_filelinks');
		}


	}
}
