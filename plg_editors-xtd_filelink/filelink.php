<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Editor Filelink buton
 *
 * @package		Joomla.Plugin
 * @subpackage	Editors-xtd.filelink
 * @since 1.5
 */
class plgButtonFilelink extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}


	/**
	 * Display the button
	 *
	 * @return array A two element array of (article_id, article_title)
	 */
	function onDisplay($name)
	{
		/*
		 * Javascript to insert the link
		 * View element calls jSelectFile when an article is clicked
		 * jSelectFile creates the link tag, sends it to the editor,
		 * and closes the select frame.
		 */
		$js = "
		function jSelectFile(id, title) {
			var tag = '{filelink|' + id + '|' + title + '}';
			jInsertEditorText(tag, '".$name."');
			SqueezeBox.close();
		}";
    
    $jscat = "
    function jSelectFilelinkCat(catno, catid) {
			var tag = '<div class=\"filelinkcat\">{filelinkcat|' + catno + '|' + catid + '}</div>';
			jInsertEditorText(tag, '".$name."');
			SqueezeBox.close();
		}";
    
    $css = '.button2-left .filelink {background: url('.JURI::root(true).'/plugins/editors-xtd/filelink/j_button2_filelinks.png) 100% 0 no-repeat}';

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
    $doc->addScriptDeclaration($jscat);
    $doc->addStyleDeclaration($css);

		JHtml::_('behavior.modal');

		/*
		 * Use the built-in element view to select the article.
		 * Currently uses blank class.
		 */
		$link = 'index.php?option=com_filelinks&amp;view=files&amp;layout=modal&amp;tmpl=component&amp;'.JSession::getFormToken().'=1';

		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('PLG_ARTICLE_BUTTON_FILELINK'));
		$button->set('name', 'filelink');
		$button->set('options', "{handler: 'iframe', size: {x: 770, y: 400}}");

		return $button;
	}
}
