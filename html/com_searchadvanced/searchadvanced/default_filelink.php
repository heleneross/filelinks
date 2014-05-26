<?php
defined('_JEXEC') or die;
$result = $this->row;

// fixes for output
$result->href = ltrim(str_ireplace(JURI::root(),'',$result->href),'\/\\. ');
$result->fullhref = ltrim(str_ireplace(JURI::root(),'',$result->fullhref),'\/\\. ');
$result->fullhref = (preg_match('#^(http://|https://)#',strtolower($result->fullhref)) ? $result->fullhref : JURI::root() . $result->fullhref); 
$result->section = str_ireplace('root','BFGnet',$result->section);
$filelinks = false;
if($result->plugtype == 'filelink')
{
  $filelinks = true;
}
// build title
$title = $this->escape($result->title);
$title = preg_replace($this->highlight, '<span class="highlight">\0</span>', $title);
$footer = '';
// add link
if ($result->href) :
	$tag = '<a href="%s">%s</a>';
	$title_tag = $tag;
	if (1 == $result->browsernav) :
		$tag = '<a href="%s" target="_blank">%s</a>';
		$title_tag = '<a href="%s" target="_blank" class="nolink">%s</a>';
	endif;
	$title = sprintf($title_tag, $result->fullhref, $title);
	if ($this->params->get('show_links_at_bottom')) :
    $footer = sprintf($tag, $result->fullhref, $result->href);
	endif;
endif;
// add headings
$title = sprintf('<h4>%s</h4>', $title);
// highlight text
$text = preg_replace($this->highlight, '<span class="highlight">\0</span>', $result->text);
?>
<div class="result<?php if (isset($result->remote)) echo " remote_result"; ?>">
	<div class="result-num"><span><?php echo $this->num; ?></span></div>
	<div class="result-obj">
		<div class="result-top">
    <?php if (isset($result->relevance) && $this->ordering == 'relevance' && $this->params->get('rel_enable_result')) : ?>
			<div class="search_relevance_score">
				<div class="search_relevance_score_value" style="width:<?php echo $result->scalePct; ?>%"> </div>
			</div>
			<?php endif; ?>
			<?php echo $title; ?>
			
			<div class="search_clear"><!--  --></div>
			<?php if ($result->section || $this->params->get('show_date')) : ?>
			<div class="articleinfo">
			
				<?php if ($result->section) : ?>
				<div class="category f_lft">
        <?php if ($filelinks && !empty($result->parenturl))
        {
          echo '<a href="'.$result->parenturl.'" title="'.htmlspecialchars(str_replace('Filelinks/','',$result->section)).'">'.htmlspecialchars($result->section).'</a>';
        }
        else
        {
           echo $this->escape($result->section);
        }
        ?>
        </div>
        <?php endif; ?>
				<?php if ($this->params->get('show_date')) : ?>
				<div class="createdate f_rght"><?php echo $result->created; ?></div>
				<?php endif; ?>
				
				<div class="search_clear"><!--  --></div>
			</div>
			<?php endif; ?>
		</div>
		<div class="result-bottom">
			<p class="result_text">
				<?php if (@$result->icon) : ?>
				<span class="result-icon">
					<img class="pad" src="<?php echo htmlspecialchars($result->icon); ?>" alt="<?php echo htmlspecialchars(strip_tags($result->title)); ?>" />
				</span>
				<?php endif; ?>
				<?php echo $text; ?>
			</p>
			<span class="search_clear"></span>

			<?php if (strlen($footer)) : ?>
			<p class="result_link">
      <?php if($filelinks) :?>
          <span class="filelinks-icon">
					<img src="<?php echo htmlspecialchars($result->fileicon); ?>" alt="<?php echo htmlspecialchars(strip_tags($result->title)); ?>" />
				</span> 
      <?php endif; ?>
      <?php echo $footer; ?></p>

			<span class="search_clear"></span>
			<?php endif; ?>
		</div>
	</div>
	<span class="search_clear"></span>
		<?php
		if ((defined('DEBUG') && DEBUG) || (defined('JDEBUG') && JDEBUG)) :
			echo '<h5>'.JText::sprintf('COM_SEARCHADVANCED_RELEVANCE_DEBUG', $result->relevance).'</h5>';
			if (property_exists($result, 'relevanceLog') && !empty($result->relevanceLog)) :
				echo '<ul>';
				foreach ($result->relevanceLog as $entry) :
					foreach ($entry as $key => $val) :
						echo '<li>' . $key . ': ' . $val;
					endforeach;
				endforeach;
				echo '</ul>';
			endif;
		endif; ?>
</div>