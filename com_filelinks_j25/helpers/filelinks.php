<?php
/**
 * @version     1.0.4
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
			"index.php?option=com_categories&extension=com_filelinks.files",
			$vName == 'categories.files'
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
		
if ($vName=='categories.files.catid') {			
JToolBarHelper::title('FileLinks: Categories (Files)');		
}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_filelinks';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
  
  public static function getDoctypes()
  {
      $doctypes = trim(JComponentHelper::getParams('com_filelinks')->get('doctypes'),' ,');
      $allowedExtensions = strtolower($doctypes) . ',' . strtoupper($doctypes);
      $allowedExtensions = explode(',', $allowedExtensions);
      $allowedExtensions = array_map('trim',$allowedExtensions);
      return $doctypes = "^.*\.(" . implode('|', $allowedExtensions) . ")$";
  }
  
  /*
 * @param string $file Filepath
 * @param int $digits Digits to display
 * @return string|bool Size (KB, MB, GB, TB) or boolean
 */

  public static function getFilesize($file,$digits = 2) 
  {
       if (is_file($file)) {
               $filePath = $file;
               if (!realpath($filePath)) {
                       $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
       }
           $fileSize = filesize($filePath);
               $sizes = array("TB","GB","MB","KB","B");
               $total = count($sizes);
               while ($total-- && $fileSize > 1024) {
                       $fileSize /= 1024;
                       }
               return round($fileSize, $digits)."&nbsp;".$sizes[$total];
       }
       return false;
  }
  
  // upload file
  public static function upload ($filestore, $folder, $filearray, $overwrite = false)
  {
     jimport('joomla.filesystem.file');

     //Clean up filename to get rid of strange characters like spaces etc
     $filename = str_replace(' ','-',JFile::makeSafe($filearray['name']));
     
     //Set up the source and destination of the file
     $src = $filearray['tmp_name'];
     if ($folder == $filestore)
     {
        $dest = JPATH_ROOT . DIRECTORY_SEPARATOR . $filestore . DIRECTORY_SEPARATOR . $filename;
     }
     else
     {
        $dest = JPATH_ROOT . DIRECTORY_SEPARATOR . $filestore . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filename;
     }

      // don't overwrite
      if (!$overwrite && JFile::exists($dest))
      {
          //echo '<script type="text/javascript">alert("'.$filename.' already exists!");</script>';
          return array($filename.' already exists!','warning');
      }
      
      // try saving file
      if (!JFile::upload($src, $dest))
      {
        //error saving
        //echo '<script type="text/javascript">alert("Error saving file");</script>';
        return array('Error saving file: '. $filename,'error');
      } 
     return array('File saved: '. $filename,'message');
  }
}
