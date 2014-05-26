<?php
defined('_JEXEC') or die('Restricted access');
$showRemote = (bool) (
	$this->params->get('enable_remote', 0)
	&& property_exists($this, 'remote')
	&& is_array($this->remote)
	&& array_key_exists('available', $this->remote)
	&& !empty($this->remote['available'])
);
$minchar = (int) $this->params->def('min_char', 3);
$maxchar = (int) $this->params->def('max_char', 35);
?>
<div id="searchFormContainer">
	<form id="searchForm" action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="searchForm">

		<fieldset>
			<?php if ($showRemote) : ?>
			<div class="search_also search_hidescroll w_30 f_rght">
			<h3><?php echo JText::_( 'COM_SEARCHADVANCED_SEARCH_ALSO_ON' );?></h3>
				<?php
				foreach ($this->remote['available'] as $avl) :
					$checked = is_array($this->remote['active']) && in_array($avl->id, $this->remote['active']) ? 'checked="checked"' : '';
				?>
					<input type="checkbox" name="remote[]" value="<?php echo $avl->id;?>" id="remote_<?php echo $avl->id;?>" <?php echo $checked;?> />
					<label for="remote_<?php echo $avl->id;?>">
						<?php echo $avl->label; ?>
					</label>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<div class="search_word">
				<h3><label for="search_searchword"><?php echo JText::_( 'COM_SEARCHADVANCED_SEARCH_KEYWORD' ); ?>:	</label></h3>
				<input type="text" name="searchword" id="search_searchword" size="20" <?php echo $maxchar ? 'maxlength="'.$maxchar.'"' : ''; ?> value="<?php echo $this->escape($this->searchword); ?>" class="inputbox" />
				<button type="submit" id="search_submit" class="button" value="<?php echo JText::_('COM_SEARCHADVANCED_SEARCH'); ?>"><span><?php echo JText::_('Search'); ?></span></button>
<?php /*				<input type="submit" id="search_submit" class="button" value="<?php echo JText::_('Search'); ?>" />*/?>
				<?php if ($this->params->get('enable_lucky', 1)) : ?>
				<button id="lucky_search" class="button" title="<?php echo htmlspecialchars(JText::_('COM_SEARCHADVANCED_LUCKY_SEARCH')); ?>"><img src="<?php echo rtrim(JURI::root(),'/').'/components/com_searchadvanced/assets/images/lucky.png'; ?>" alt="<?php echo htmlspecialchars(JText::_('COM_SEARCHADVANCED_LUCKY_SEARCH')); ?>" /></button>
				<?php endif; ?>
				
<?php /*
				<div class="search_phrase search_hidescroll">
					<?php echo $this->lists['searchphrase']; ?>
	    	</div>
*/ ?>
			</div>

			<?php if ($this->searchword) : ?>
			<div class="search_result_count search_hidescroll"><?php
				echo $this->result;

				if ($this->listedTotal != $this->compiledTotal) :
					echo ' ' . JText::sprintf('COM_SEARCHADVANCED_RESULTS_FROM_ALL_SITES', $this->compiledTotal);
				endif;

				if ($this->filtered) :
					echo ' <a href="#" class="search_filters_disable">' . JText::_('COM_SEARCHADVANCED_CLEAR_FILTERS') . '</a>';
				endif;
			?></div>
			<?php endif; ?>

		</fieldset>


		<div class="search_clear"><!-- --></div>

	<div class="filters">
		<div class="search_hidden">
			<?php echo $this->loadTemplate('filters'); ?>
		</div>

	</div>

		<p>
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="option" value="com_searchadvanced" />
			<input type="hidden" name="lucky" value="" id="lucky_value" />
		</p>

	</form>
</div>
<?php $db = &JFactory::getDbo(); ?>

<script type="text/javascript">
// <!--
window.com_searchadvanced = {
	enabled: <?php echo (1 == $this->params->get('sticky_search') ? 'true' : 'false'); ?>
, topOffset: <?php echo (int) $this->params->get('sticky_topoffset'); ?>
, scrollOffset: <?php echo (int) $this->params->get('sticky_scrolloffset'); ?>
, lang: {
		nosearch: <?php echo $db->Quote(JText::_('COM_SEARCHADVANCED_ENTER_A_SEARCH_KEYWORD')); ?>
	, nosave: <?php echo $db->Quote(JText::_('COM_SEARCHADVANCED_NOT_ALLOWED_TO_SAVE')); ?>
	}
};
window.addEvent('load', function() {
	// this might not be enabled
	try {
		$('lucky_search').addEvent('click', function(ev) {
			$('lucky_value').value = 1;
			$('searchForm').submit();
		});
	} catch (err) {}
	$('search_submit').addEvent('click', function(ev) {
		try {
			$('lucky_value').value = 0;
		} catch (err) {}
	});
	// catch the submit & don't allow if the search isn't long enough
	$('searchForm').addEvent('submit', function(ev) {
		var len = $('search_searchword').value.toString().length, mn = <?php echo $minchar; ?>, mx = <?php echo $maxchar; ?>;
		if (mn > len || mx < len) {
			alert ("<?php echo JText::sprintf('COM_SEARCHADVANCED_SEARCH_MESSAGE', $minchar, $maxchar); ?>");
			new Event(ev).stop();
			return false;
		}
	});
});
// -->
</script>