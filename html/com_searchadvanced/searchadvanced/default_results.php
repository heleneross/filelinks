<?php defined('_JEXEC') or die; ?>
<div id="search_results">
	<div class="search_results w_75 f_rght">
		<?php
		if (!is_null($this->suggest)) :
			echo $this->loadTemplate('suggest');
		elseif (empty($this->results)) :
			echo $this->loadTemplate('empty');
		endif;

		if (!empty($this->results)) :
		
			// before-search-results module position
			if (!empty($this->beforemods)) :
				?><div class="search_results_mods search_results_before_search"><?php
				echo "\n".implode("\n", $this->beforemods)."\n";
				?></div><?php
			endif;
			
			?><div class="search_results_list"><?php 
			// ================================== BFGnet mod ============================================
			// load a whole new template for each
			$this->num = JRequest::getInt('limitstart', 0) + 1;
			foreach ($this->results as $result) :
				$this->row = $result;
				if($result->section == 'Assets')
				{
					$result->plugtype = 'asset';
				}
				if(isset($result->plugtype))
				{
					try {
						echo $this->loadTemplate($result->plugtype);
					} catch(exception $ex) {
						echo $this->loadTemplate("result");
					}
				}
				else
				{
					echo $this->loadTemplate('result');
				}
				$this->num = $this->num + 1;
			endforeach;
			?></div>
		<?php
		// =======================================================================================
			// after-search-results module position
			if (!empty($this->aftermods)) :
				?><div class="search_results_mods search_results_after_search"><?php
				echo "\n".implode("\n", $this->aftermods)."\n";
				?></div><?php
			endif;
		
			echo $this->pagination->getPagesLinks( );
		endif; ?>
	</div>

	<div id="search_sidebar" class="w_20 f_lft">
		<div id="search_sidebar_lists">
			<?php
			// before-search-sidebar module position
			if (!empty($this->beforesidebarmods)) :
				?><div class="search_sidebar_mods search_sidebar_before"><?php
				echo "\n".implode("\n", $this->beforesidebarmods)."\n";
				?></div><?php
			endif;
			?>
			<ul class="sidebar_list">
			<?php if (count($this->savegroups)) : ?>
				<li><a href="#" class="advancedSearchSaveSearchButton<?php echo $this->savesearchex ? '' : 'Disabled'; ?>"><?php echo JText::_('COM_SEARCHADVANCED_ADD_NOTIFICATION'); ?></a></li>
			<?php endif; ?>
				<li><a href="#search_filters" id="search_filter_modal"><?php echo JText::_('COM_SEARCHADVANCED_ADVANCED'); ?></a></li>
			</ul>

			<?php if (!empty($this->datefilters)) : ?>
			<ul class="sidebar_list">
				<?php foreach ($this->datefilters as $date) : ?>
				<li><a href="#" class="sidebar_list_date <?php echo @$date['class']; ?>" rel="<?php echo $date['start'].','.$date['end']; ?>"><?php echo $date['title']; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<?php
			// after-search-sidebar module position
			if (!empty($this->aftersidebarmods)) :
				?><div class="search_sidebar_mods search_sidebar_after"><?php
				echo "\n".implode("\n", $this->aftersidebarmods)."\n";
				?></div><?php
			endif;
			?>
		</div>
	</div>

	<div class="search_clear"><!-- --></div>
</div>
