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

/**
 * Filelinks helper.
 */
class FilelinksHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_FILELINKS_TITLE_FILES'),
			'index.php?option=com_filelinks&view=files',
			$vName == 'files'
		);
		JSubMenuHelper::addEntry(
			'Categories (Files)',
			"index.php?option=com_categories&extension=com_filelinks",
			$vName == 'categories'
		);
		//new empty view findfiles
		JSubMenuHelper::addEntry(
			JText::_('COM_FILELINKS_TITLE_FINDFILES'),
			'index.php?option=com_filelinks&view=findfiles',
			$vName == 'findfiles'
		);
		JSubMenuHelper::addEntry(
			JText::_('Help'),
			'index.php?option=com_filelinks&view=help',
			$vName == 'help'
		);

		if ($vName == 'categories.catid')
		{
			JToolBarHelper::title('FileLinks: Categories (Files)');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_filelinks';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete', 'core.view'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	public static function getDoctypes()
	{
		$doctypes = trim(JComponentHelper::getParams('com_filelinks')->get('doctypes'), ' ,');
		$allowedExtensions = strtolower($doctypes) . ',' . strtoupper($doctypes);
		$allowedExtensions = explode(',', $allowedExtensions);
		$allowedExtensions = array_map('trim', $allowedExtensions);
		return $doctypes = "^.*\.(" . implode('|', $allowedExtensions) . ")$";
	}

	/*
	 * @param string $file Filepath
	 * @param int $digits Digits to display
	 * @return string|bool Size (KB, MB, GB, TB) or boolean
	 */

	public static function getFilesize($file, $digits = 2)
	{
		if (is_file($file))
		{
			$filePath = $file;
			if (!realpath($filePath))
			{
				$filePath = $_SERVER["DOCUMENT_ROOT"] . $filePath;
			}
			$fileSize = filesize($filePath);
			$sizes = array("TB", "GB", "MB", "KB", "B");
			$total = count($sizes);
			while ($total-- && $fileSize > 1024)
			{
				$fileSize /= 1024;
			}
			return round($fileSize, $digits) . "&nbsp;" . $sizes[$total];
		}
		return false;
	}

	// upload file
	/**
	 * @param    string    $filestore   basepath for files
	 * @param    string    $folder      base64 encoded string
	 * @param    array     $filearray   from form submission
	 * @param    bool      $overwrite
	 *
	 * @return   array    at least two items, message and message type, followed by anything you want to return
	 */
	public static function upload($filestore, $folder, $filearray, $overwrite = false)
	{
		jimport('joomla.filesystem.file');
		$file_error = array(
			0 => 'There is no error, the file uploaded with success',
			1 => 'The file is too large',
			2 => 'The file is too large',
			3 => 'The file was only partially uploaded',
			4 => 'No file was uploaded',
			6 => 'Missing a temporary folder'
		);

		if ($filearray['error'] > 0)
		{
			return array('File error: ' . $filearray['error'] . ' - ' . $file_error[$filearray['error']], 'error');
		}

		//Clean up filename to get rid of strange characters like spaces etc
		$filename = str_replace(' ', '-', JFile::makeSafe($filearray['name']));

		// is there only one . (period) in the filename
		if (substr_count($filename, '.') != 1)
		{
			return array('Invalid filename: ' . $filename, 'error');
		}

		//check it is a valid filetype again
		$doctypes = '@' . self::getDoctypes() . '@';

		if (preg_match($doctypes, $filename))
		{
			$folder = base64_decode($folder);


            //Set up the source and destination of the file
			$src = $filearray['tmp_name'];
			if ($folder == $filestore)
			{
				$dest = JPATH_ROOT . DIRECTORY_SEPARATOR . $filestore . DIRECTORY_SEPARATOR . $filename;
				$short_dest = str_replace(DIRECTORY_SEPARATOR,'/',$filestore . DIRECTORY_SEPARATOR . $filename);
			}
			else
			{
				$dest = JPATH_ROOT . DIRECTORY_SEPARATOR . $filestore . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filename;
				$short_dest = str_replace(DIRECTORY_SEPARATOR,'/',$filestore . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filename);
				//check folder exists
				if(!JFolder::exists(JPATH_ROOT . DIRECTORY_SEPARATOR . $filestore . DIRECTORY_SEPARATOR . $folder))
				{
					return array('Folder: ' . $folder . ' does not exist', 'warning');
				}
			}

			// don't overwrite
			if (!$overwrite && JFile::exists($dest))
			{
				return array($filename . ' already exists!', 'warning');
			}

			// try saving file
			if (!JFile::upload($src, $dest))
			{
				//error saving
				return array('Error saving file: ' . $filename, 'error');
			}

			chmod($dest, 0644);
			return array('File saved: ' . $short_dest, 'message', $short_dest);
		}
		else
		{
			return array('Invalid filetype: ' . $filename, 'error');
		}
	}
}
