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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_filelinks/assets/css/filelinks.css');
$input = JFactory::getApplication()->input;
$task = $input->getCmd('task','');

//for validating input
$filestore = JComponentHelper::getParams('com_filelinks')->get('filestore');
$filestore = trim($filestore, '.\\/ ');
$doctypes = FilelinksHelper::getDoctypes();
$jregex = '/' . str_replace('^','^'.$filestore.'\/',$doctypes) . '/';

?>
<script type="text/javascript">
	function getScript(url, success) {
		var script = document.createElement('script');
		script.src = url;
		var head = document.getElementsByTagName('head')[0],
			done = false;
		// Attach handlers for all browsers
		script.onload = script.onreadystatechange = function () {
			if (!done && (!this.readyState
				|| this.readyState == 'loaded'
				|| this.readyState == 'complete')) {
				done = true;
				success();
				script.onload = script.onreadystatechange = null;
				head.removeChild(script);
			}
		};
		head.appendChild(script);
	}
	getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function () {
		js = jQuery.noConflict();
		js(document).ready(function () {


			Joomla.submitbutton = function (task) {
				if (task == 'editfiledetails.cancel') {
					Joomla.submitform(task, document.getElementById('editfiledetails-form'));
				}
				else {
          var regex = <?php echo $jregex;?>;
					if (task != 'editfiledetails.cancel' && document.formvalidator.isValid(document.id('editfiledetails-form')) && regex.test(document.getElementById('jform_url').value)) {

						Joomla.submitform(task, document.getElementById('editfiledetails-form'));
					}
					else {
						alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
					}
				}
			}
		});
	});
</script>
<?php
if ($task == 'add')
{
	$title = base64_decode($input->get('title', ''));
	$stitle = ltrim(strrchr($title, '/'), '/');
	$title = $stitle ? $stitle : $title;
	$url = base64_decode($input->get('url', ''));
	$this->form->setValue('title', null, JFile::stripExt($title));
	$this->form->setValue('url', null, ltrim($url,'.\\/ '));
}

?>
<form action="<?php echo JRoute::_('index.php?option=com_filelinks&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" enctype="multipart/form-data" name="adminForm" id="editfiledetails-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FILELINKS_LEGEND_EDITFILEDETAILS'); ?></legend>
			<ul class="adminformlist">

				<li><?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?></li>
				<li><?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?></li>
				<li><?php echo $this->form->getLabel('url'); ?>
					<?php echo $this->form->getInput('url'); ?></li>
				<li><?php echo $this->form->getLabel('catid'); ?>
					<?php echo $this->form->getInput('catid'); ?></li>
				<li><?php echo $this->form->getLabel('description'); ?>
					<?php echo $this->form->getInput('description'); ?></li>
				<li><?php echo $this->form->getLabel('hits'); ?>
					<?php echo $this->form->getInput('hits'); ?></li>
				<li><?php echo $this->form->getLabel('state'); ?>
					<?php echo $this->form->getInput('state'); ?></li>
				<li><?php echo $this->form->getLabel('created_by'); ?>
					<?php echo $this->form->getInput('created_by'); ?></li>
				<li><?php echo $this->form->getLabel('created'); ?>
					<?php echo $this->form->getInput('created'); ?></li>
				<li><?php echo $this->form->getLabel('access'); ?>
					<?php echo $this->form->getInput('access'); ?></li>
				<li><?php echo $this->form->getLabel('language'); ?>
					<?php echo $this->form->getInput('language'); ?></li>


			</ul>
		</fieldset>
	</div>


	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>

	<style type="text/css">
		/* Temporary fix for drifting editor fields */
		.adminformlist li {
			clear: both;
		}
	</style>
</form>