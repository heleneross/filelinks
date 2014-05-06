<?php
/**
 * @copyright      Copyright (C) 2014 Helen. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @version        2.0.0
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Editor Filelink button
 *
 * @package        Joomla.Plugin
 * @subpackage     Editors-xtd.filelink
 * @since          1.5
 */
class plgButtonFilelink extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 *
	 * @param       object $subject The object to observe
	 * @param       array  $config  An array that holds the plugin configuration
	 *
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
	 * @param $name
	 *
	 * @return object $button
	 */
	function onDisplay($name)
	{
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		$asset = 'com_filelinks';
		//any of the following privileges allows user to see this button
		if ($user->authorise('core.view', $asset))
		{ /*
    		 * Javascript to insert the link
    		 * View element calls jSelectFile when an article is clicked
    		 * jSelectFile creates the link tag, sends it to the editor,
    		 * and closes the select frame.
    		 * Need to pass the editor id back from modal to insert in correct editor window         
    		 */
			$js = "
    		function jSelectFile(id, title, editor) {
    			var tag = '{filelink|' + id + '|' + title + '}';
    			jInsertEditorText(tag, editor);
    			SqueezeBox.close();
    		}";

			$jscat = "
        function jSelectFilelinkCat(catno, catid, editor) {
    			var tag = '<div class=\"filelinkcat\">{filelinkcat|' + catno + '|' + catid + '}</div>';
    			jInsertEditorText(tag, editor);
    			SqueezeBox.close();
    		}";

			$css = '.button2-left .filelink {background: url(' . JURI::root(true) . '/plugins/editors-xtd/filelink/j_button2_filelinks.png) 100% 0 no-repeat}';

			$doc = JFactory::getDocument();
			//$doc->addScriptDeclaration($js);
			$doc->addScriptDeclaration($jscat);
			$doc->addStyleDeclaration($css);

			JHtml::_('behavior.modal');

			/*
			 * Use the built-in element view to select the article.
			 * Currently uses blank class.
			 */
			if ($app->isAdmin())
			{
				$link = 'index.php?option=com_filelinks&amp;view=files&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1&amp;name=' . $name;
			}
			else
			{
				$link = 'administrator/index.php?option=com_filelinks&amp;view=files&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1&amp;name=' . $name;
			}

			$button = new JObject();
			$button->set('modal', true);
			$button->set('link', $link);
			$button->set('text', JText::_('PLG_ARTICLE_BUTTON_FILELINK'));
			$button->set('name', 'filelink');
			$button->set('options', "{handler: 'iframe', size: {x: 770, y: 400}}");

			return $button;
		}
	}
}
