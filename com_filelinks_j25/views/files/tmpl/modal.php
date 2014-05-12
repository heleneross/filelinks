<?php
/**
 * @version     2.0.0
 * @package     com_filelinks
 * @copyright   Copyright (C) Helen 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Helen <heleneross@gmail.com> - http://bfgnet.de
 */


// no direct access
defined('_JEXEC') or die;
if (JFactory::getApplication()->isSite())
{
	JSession::checkToken('get') or die(JText::_('JINVALID_TOKEN'));
}

JHtml::_('behavior.tooltip');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_filelinks/assets/css/filelinks.css');

$jinput = JFactory::getApplication()->input;

// get the content plugin parameters
jimport('joomla.plugin.helper');
$plugin = JPluginHelper::getPlugin('content', 'filelinks');
$params = new JRegistry($plugin->params);

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_filelinks');
$saveOrder = $listOrder == 'a.ordering';
?>
<form
	action="" method="post" name="adminForm" id="adminForm">
<fieldset id="filelink-options">
	<p>These options apply to single links and override the defaults:</p>
	<table style="width:100%">
		<tbody>
		<tr>
			<td colspan="1">
				<label for="filelink-raw">Raw url?</label>
				<input type="checkbox" name="filelink-raw" id="filelink-raw">
			</td>
			<td  colspan="3">
				<label for="filelink-blank">Open link in new window?</label>
				<input type="checkbox" value="1" <?php echo $params->get('blank') ? 'checked="checked"' : ''; ?>
				       name="filelink-blank" id="filelink-blank">
			</td>
		</tr>
		<tr>
			<td>
				<label for="filelink-description">Add link description?</label>
				<input type="checkbox" value="1" <?php echo $params->get('description') ? 'checked="checked"' : ''; ?>
				       name="filelink-description" id="filelink-description">
			</td>
			<td>
				<label for="filelink-hdescription">Add hideable link description?</label>
				<input type="checkbox" name="filelink-hdescription" id="filelink-hdescription">
			</td>
			<td>
				<label for="filelink-filesize">Show filesize?</label>
				<input type="checkbox" name="filelink-filesize" id="filelink-filesize">
			</td>
			<td>
				<label for="filelink-icon">Add icon to link?</label>
				<input type="checkbox" value="1" <?php echo $params->get('icon') ? 'checked="checked"' : ''; ?>
				       name="filelink-icon" id="filelink-icon">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<label for="filelink-customcss">Custom css class for link?</label>
				<input type="text" name="filelink-customcss" id="filelink-customcss">
			</td>
			<td colspan="2">
				<label for="filelink-title">Change link title?</label>
				<input type="text" name="filelink-title" id="filelink-title">
			</td>
		</tr>
		</tbody>
	</table>
</fieldset>
<fieldset id="filter-bar">
	<div class="filter-search fltlft">
		<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
		<input type="text" name="filter_search" id="filter_search"
		       value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
		       title="<?php echo JText::_('Search'); ?>"/>
		<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
		<button type="button"
		        onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
	</div>


	<div class='filter-select fltrt'>
		<?php //Filter for the field catid
		$selected_catid = $jinput->getInt('filter_catid', 0);
		jimport('joomla.form.form');
		JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
		$form = JForm::getInstance('com_filelinks.editfiledetails', 'editfiledetails');
		echo $form->getLabel('filter_catid');
		echo str_replace('<option value="0">Root</option>', '<option value="">' . JText::_('JOPTION_SELECT_CATEGORY') . '</option>', $form->getInput('filter_catid', null, $selected_catid));
		?>
	</div>

	<div class='filter-select fltrt'>
		<select name="filter_published" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
			<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true); ?>
		</select>
	</div>


</fieldset>
<div class="clr"></div>

<table class="adminlist">
	<thead>
	<tr>
		<th class='left'>
			<?php echo JHtml::_('grid.sort', 'COM_FILELINKS_FILES_TITLE', 'a.title', $listDirn, $listOrder); ?>
		</th>
		<th class='left'>
			<?php echo JHtml::_('grid.sort', 'COM_FILELINKS_FILES_CATID', 'a.catid', $listDirn, $listOrder); ?>
		</th>
		<th class='left'>
			<?php echo JHtml::_('grid.sort', 'COM_FILELINKS_FILES_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
		</th>


		<?php if (isset($this->items[0]->state))
		{
			?>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
			</th>
		<?php } ?>
		<?php if (isset($this->items[0]->ordering))
		{
			?>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
				<?php if ($canOrder && $saveOrder) : ?>
					<?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'files.saveorder'); ?>
				<?php endif; ?>
			</th>
		<?php } ?>
		<?php if (isset($this->items[0]->id))
		{
			?>
			<th width="1%" class="nowrap">
				<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>
		<?php } ?>
	</tr>
	</thead>
	<tfoot>
	<?php
	if (isset($this->items[0]))
	{
		$colspan = count(get_object_vars($this->items[0]));
	}
	else
	{
		$colspan = 10;
	}
	?>
	<tr>
		<td colspan="<?php echo $colspan ?>">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
	<tbody>
	<?php foreach ($this->items as $i => $item) :
		$ordering = ($listOrder == 'a.ordering');
		$canCreate = $user->authorise('core.create', 'com_filelinks');
		$canEdit = $user->authorise('core.edit', 'com_filelinks');
		$canCheckin = $user->authorise('core.manage', 'com_filelinks');
		$canChange = $user->authorise('core.edit.state', 'com_filelinks');
		?>
		<tr class="row<?php echo $i % 2; ?>">
			<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'files.', $canCheckin); ?>
				<?php endif; ?>
				<?php if (file_exists(JPATH_SITE . '/' . $item->url)) : ?>
					<a class="pointer"
					   onclick="if (window.parent) jSelectFile('<?php echo $item->id; ?>', '<?php echo $this->escape(addslashes($item->title)); ?>','<?php echo JFactory::getApplication()->input->getString('name', 'text'); ?>');">
						<?php echo $this->escape($item->title); ?></a>
				<?php else : ?>
					<span class="notfound"><?php echo $item->url; ?></span>
				<?php endif; ?>
			</td>
			<td>
				<a class="pointer"
				   onclick="if (window.parent) window.parent.jSelectFilelinkCat('<?php echo $item->catno; ?>', '<?php echo $item->catid; ?>','<?php echo JFactory::getApplication()->input->getString('name', 'text'); ?>' );">
					<?php echo $item->catid; ?></a>
			</td>
			<td>
				<?php echo $item->created_by; ?>
			</td>


			<?php if (isset($this->items[0]->state))
			{
				?>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->state, $i, 'files.', $canChange, 'cb'); ?>
				</td>
			<?php } ?>
			<?php if (isset($this->items[0]->ordering))
			{
				?>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) : ?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, true, 'files.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'files.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, true, 'files.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'files.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5"
						       value="<?php echo $item->ordering; ?>" <?php echo $disabled ?>
						       class="text-area-order"/>
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
			<?php } ?>
			<?php if (isset($this->items[0]->id))
			{
				?>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
			<?php } ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<div>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<input type="hidden" name="name" value="<?php echo $jinput->getString('name', 'text'); ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>
<script type="text/javascript">
	function jSelectFile(id, title, editor) {
		var tag = '{filelink|' + id;
		if (document.getElementById('filelink-raw').checked) {
			tag += '|' + title + '|raw';
		}
		else {
			if (document.getElementById('filelink-title').value === "")
			{
				tag += '|' + title;
			}
			else {
				tag += '|' + document.getElementById('filelink-title').value;
			}
			if (document.getElementById('filelink-icon').checked) {
				tag += <?php echo $params->get('icon')?> ? '' : '|icon';
			}
			else {
				tag += <?php echo $params->get('icon')?> ? '|noicon' : '';
			}
			if (document.getElementById('filelink-hdescription').checked) {
				tag += '|hdesc';
			}
			else{
				if (document.getElementById('filelink-description').checked) {
					tag += <?php echo $params->get('description')?> ? '' : '|desc';
				}
				else {
					tag += <?php echo $params->get('description')?> ? '|nodesc' : '';
				}
			}
			if (document.getElementById('filelink-blank').checked) {
				tag += <?php echo $params->get('blank')?> ? '' : '|new';
			}
			else {
				tag += <?php echo $params->get('blank')?> ? '|same' : '';
			}
			if(document.getElementById('filelink-filesize').checked)
			{
				tag += '|size';
			}
			if (document.getElementById('filelink-customcss').value != "")
			{
				tag += '|"' + document.getElementById('filelink-customcss').value + '"';
			}
		}
		tag += '}';
		window.parent.jInsertEditorText(tag, editor);
		window.parent.SqueezeBox.close();
	}
</script>
