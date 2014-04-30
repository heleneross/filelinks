<?php
/**
 * @version     1.0.4
 * @package     com_filelinks
 * @copyright   Copyright (C) Helen 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Helen <heleneross@gmail.com> - http://bfgnet.de
 */
// no direct access
defined('_JEXEC') or die;


?>
	<script type="text/javascript">
		Joomla.submitbutton = function (pressbutton) {
			var form = document.getElementById('folderform');
      var foldercookie = document.getElementsByName('folders')[0];
      document.cookie = 'filelinksfolder=' + foldercookie.options[foldercookie.selectedIndex].text;
			form.submit();
		}

	</script>
<?php
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_filelinks/assets/css/filelinks.css');
$input = JFactory::getApplication()->input;

// is the filelinksfolder cookie set
$cookie = $input->cookie->get('filelinksfolder','','cmd');
$folders = ($cookie) ? $cookie : $input->getCmd('folders', '');


// root of documents folder
$filestore = JComponentHelper::getParams('com_filelinks')->get('filestore');
$filestore = trim($filestore, '.\\/ ');

//allowed document types - from helper
$doctypes = FilelinksHelper::getDoctypes();

$list = JFolder::folders(JPATH_ROOT . '/' . $filestore, '.', false, false);
array_unshift($list,$filestore);
echo '<div class="findfiles">';
echo '<form enctype="multipart/form-data" action="' . JRoute::_('index.php?option=com_filelinks&view=findfiles') . '" method="post" name="folderform" id="folderform">';
echo '<select name="folders">';
foreach ($list as $item)
{
	if ($item == $folders)
	{
		echo '<option value="' . $item . '" selected>' . $item . '</option>';
	}
	else
	{
		echo '<option value="' . $item . '">' . $item . '</option>';
	}
}
?>
	</select>
	<input class="button" type="button" value="Submit" onclick="Joomla.submitbutton()"/>
	<input type="hidden" name="task" value="folder"/>
<?php echo JHtml::_('form.token'); ?>
	</form>
<?php
$ds = DIRECTORY_SEPARATOR;
$site = str_replace($ds, '/', JPATH_SITE);

$task = $input->getCmd('task', '');
if ($filestore == '')
{
	echo '<p>&nbsp;</p>';
	echo '<p><strong>You need to set the root of the documents folder in options</strong></p>';
	echo '<p><strong>It is not possible to set the documents folder to your site root folder</strong></p>';
}
else
{
	if (($task == 'folder' || $cookie) && $folders && $folders != $filestore )
	{
		$folders = '/' . $folders;
    $files = JFolder::files(JPATH_ROOT . '/' . $filestore . $folders, $doctypes, true, true);
  }
  else
  {
     $folders = '';
     $files = JFolder::files(JPATH_ROOT . '/' . $filestore, $doctypes, false, true);
  }
		$urlarray = array();
		foreach ($this->items as $url)
		{
			$urlarray[$url->url] = array($url->state, $url->id, $url->title);
		}
		?>
		<table class="adminlist">
		<thead>
		<tr>
			<th class="thview">
				<?php echo JText::_('COM_FILELINKS_TH_VIEW'); ?></th>
			<th class="thaction">
				<?php echo JText::_('COM_FILELINKS_TH_ACTION'); ?></th>
			<th class="thicon">
				<?php echo JText::_('COM_FILELINKS_TH_TYPE'); ?></th>
			<th class="thstate">
				<?php echo JText::_('COM_FILELINKS_TH_STATE'); ?></th>
			<th class="thfile">
				<?php echo JText::_('COM_FILELINKS_TH_FILE'); ?></th>
			<th class="thtitle">
				<?php echo JText::_('COM_FILELINKS_TH_TITLE'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$replace = array($ds, $site . '/' . $filestore . $folders . '/');
		foreach ($files as $file)
		{
			$file = ltrim(str_replace($replace, '/', $file), '/');
			$filetype = strtolower(JFile::getExt($file));
			echo '<tr>';
			echo '<td><a href="' . JURI::root() . $filestore . $folders . '/' . $file . '" target="_blank" class="view">[view]</a></td>';
			if (array_key_exists($filestore . $folders . '/' . $file, $urlarray))
			{
				echo '<td><a href="' . JRoute::_('index.php?option=com_filelinks&task=editfiledetails.edit&id=' . $urlarray[$filestore . $folders . '/' . $file][1]) . '" class="edit">[edit]</a></td>';
				echo '<td><i class="' . $filetype . '"></i></td>';
				echo '<td><i class="state' . $urlarray[$filestore . $folders . '/' . $file][0] . '"></i></td>';
				echo '<td><span class="pub' . $urlarray[$filestore . $folders . '/' . $file][0] . '">' . $filestore . $folders . '/' . $file . '</span></td>';
				echo '<td><span class="pub' . $urlarray[$filestore . $folders . '/' . $file][0] . '">' . $urlarray[$filestore . $folders . '/' . $file][2] . '</span></td>';
			}
			else
			{
				echo '<td><a href="' . JRoute::_('index.php?option=com_filelinks&view=editfiledetails&layout=edit&task=add&title=' . base64_encode($file) . '&url=' . base64_encode($filestore . $folders . '/' . $file)) . '" class="add">[add]</a></td>';
				echo '<td><i class="' . $filetype . '"></i></td>';
				echo '<td><i class="stateu"></i></td>';
				echo '<td><a class="copylink" href="#" onclick="window.prompt(' ."'Press CTRL+C, then ENTER'" .',(this.innerText || this.textContent)); return false;">' . $filestore . $folders . '/' . $file . '</a></td><td>&nbsp;</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table>';

}
echo '</div>';