<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

// Get the mime type class.
$mime = !empty($this->result->mime) ? 'mime-' . $this->result->mime : null;
$doctype = $this->result->doctype;
// Get the base url.
$base = JURI::getInstance()->toString(array('scheme', 'host', 'port')) . '/';
$this->result->route = ltrim($this->result->route,'/');

// Get the route with highlighting information.
if (!empty($this->query->highlight) && empty($this->result->mime) && $this->params->get('highlight_terms', 1) && JPluginHelper::isEnabled('system', 'highlight')) {
	$route = $this->result->route . '&highlight=' . base64_encode(json_encode($this->query->highlight));
} else {
	$route = $this->result->route;
}

?>

	<dt class="result-title <?php echo $mime; ?>">
		<a href="<?php echo $base . JRoute::_($this->result->route); ?>"><?php echo $this->result->title; ?></a>
	</dt>
<?php if ($this->params->get('show_description', 1)): ?>
	<dd class="result-text<?php echo $this->pageclass_sfx; ?>">
		<?php echo JHtml::_('string.truncate', $this->result->description, $this->params->get('description_length', 255)); ?>
	</dd>
<?php endif; ?>
<?php if ($this->params->get('show_url', 1)): ?>
	<dd class="result-url<?php echo $this->pageclass_sfx; ?>">
		<?php echo '<img src="' .$base . 'media/com_filelinks/images/'. $doctype . '.png" class="' . $doctype . '" />'; ?>
		&nbsp;
		<a href="<?php echo $base . JRoute::_($this->result->route); ?>"><?php echo JRoute::_($this->result->route) ?></a>
	</dd>
<?php endif;