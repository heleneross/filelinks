<?php
defined('_JEXEC') or die('Restricted access');
$isFilters = ('filters' == JRequest::getVar('layout'));
$showAreas = (1 < count($this->searchareas['search']));
?>
<div id="search_filter_options_element">
	<div id="search_filter_options">
		<h3><a name="search_filters"><?php echo JText::_('COM_SEARCHADVANCED_HEADER_FILTERS');?></a>:</h3>
		
		<fieldset class="">
			<legend><?php echo JText::_('COM_SEARCHADVANCED_FIELDSET_DATEFILTERS'); ?></legend>
			<div id="filters_date_range">
				<label for="filters_start"><?php echo JText::_('COM_SEARCHADVANCED_LABEL_FILTER_START'); ?></label>
				<?php if ($isFilters) : ?>
				<?php echo JHtml::_('calendar', @$this->searchfilters['start'].'', 'filters[start]', 'filters_start', '%Y-%m-%d', 'class="textinput"'); ?>
				<?php else : ?>
				<input type="text" id="filters_start" name="filters[start]" maxlength="19" size="25" value="<?php echo htmlspecialchars(@$this->searchfilters['start'].''); ?>" />
				<?php endif; ?>
				<label for="filters_end"><?php echo JText::_('COM_SEARCHADVANCED_LABEL_FILTER_END'); ?></label>
				<?php if ($isFilters) : ?>
				<?php echo JHtml::_('calendar', @$this->searchfilters['end'].'', 'filters[end]', 'filters_end', '%Y-%m-%d', 'class="textinput"'); ?>
				<?php else : ?>
				<input type="text" id="filters_end" name="filters[end]" maxlength="19" size="25" value="<?php echo htmlspecialchars(@$this->searchfilters['end'].''); ?>" />
				<?php endif; ?>
			</div>
		</fieldset>
		<div class="search_clear"></div>
	</div>
</div>