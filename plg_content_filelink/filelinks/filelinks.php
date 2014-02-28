<?php
/**
 * @package       plg_filelinks for Joomla! 2.5+
 * @version       $Id: filelinks.php 2012-09-14 $
 * @author        Helen Ross
 * @copyright (c) 2014 Helen Ross
 * @license       GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_fileinks', JPATH_ADMINISTRATOR);

class plgContentFilelinks extends JPlugin
{

	function plgContentFilelinks(& $subject, $params)
	{

		parent::__construct($subject, $params);
	}

	function onContentPrepare($context, &$article, &$params, $limitstart = 0)
	{

		// exit plugin if there's no text to process
		if (!isset($article->text))
		{
			return;
		}
		// quick check for filelink text in article
		if (!strpos($article->text, 'filelink'))
		{
			return;
		}

		$app = JFactory::getApplication();
		// Don't run in back-end
		if ($app->isAdmin()) {
			return;
		}

		$user = JFactory::getUser();
		$groups = implode(',', $user->getAuthorisedViewLevels());


		// get the regex for $doctypes from component helper
		require_once(JPATH_ADMINISTRATOR . '/components/com_filelinks/helpers/filelinks.php');
		$doctypes = '@' . FilelinksHelper::getDoctypes() . '@';

		$template = $app->getTemplate();
		if ($this->params->def('usecss', true))
		{
			$document = JFactory::getDocument();
			$document->addStyleSheet($this->params->def('stylepath', 'plugins/content/filelinks/filelinks.css'));
		}
		// get the plugin parameters
		$pblank = $this->params->def('blank', true) ? ' target="_blank" ' : ' ';
		$plist = $this->params->def('liststyle', true) ? 'ul' : 'ol';
		$icon = $this->params->def('icon', true);
		$description = $this->params->def('description', false);
		$cataccess = $this->params->def('cataccess', true);
		$usetemplate = $this->params->def('usetemplate', true);
		$addtitle = $this->params->def('addtitle', true);
		$htitle = $this->params->def('htitle', '2');
		$raw = false;

		// Save the default options for later
		$defoptions = array('raw' => false, 'icon' => $icon, 'description' => $description);

		$db = JFactory::getDBO();

		// Determine sort order
		switch ($this->params->def('ordering', 'title_az'))
		{
			case 'created_asc':
				$orderBy = 'a.created';
				break;
			case 'created_dsc':
				$orderBy = 'a.created DESC';
				break;
			case 'title_az':
				$orderBy = 'a.title ASC';
				break;
			case 'title_za':
				$orderBy = 'a.title DESC';
				break;
			case 'ordering_fwd':
				$orderBy = 'a.ordering ASC';
				break;
			case 'ordering_rev':
				$orderBy = 'a.ordering DESC';
				break;
			case 'id_asc':
				$orderBy = 'a.id';
				break;
			case 'id_dsc':
				$orderBy = 'a.id DESC';
				break;
			default:
				$orderBy = 'a.title ASC';
				break;
		}


		// match filelink files
		while (preg_match("#\{\s*filelink\s*\|\s*(\d+)\s*\|{0,1}(.*?)\}#", $article->text, $matches))
		{
			// Reset all options to defaults
			extract($defoptions, EXTR_OVERWRITE);

			// Options are raw, icon, noicon, desc, nodesc
			if ($matches[2])
			{
				$options = explode('|', $matches[2]);
				$options = array_map('trim', $options);
				$linktitle = htmlspecialchars(array_shift($options));
			}
			else
			{
				$options = array();
				$linktitle = '';
			}

			foreach ($options as $value)
			{
				switch ($value)
				{
					case 'raw':
						$raw = true;
						break;
					case 'icon':
						$icon = true;
						break;
					case 'noicon':
						$icon = false;
						break;
					case 'desc':
						$description = true;
						break;
					case 'nodesc':
						$description = false;
						break;
					default:
				}
			}


			$filelinkid = $matches[1];
			$buffer = '';

			$db->setQuery("SELECT id, url, title, description FROM #__filelinks WHERE id = " . (int) $filelinkid . " AND state = 1 AND access IN (" . $groups . ")");
			$row = $db->loadAssoc();
			// check to see we have a link to replace, maybe not if user is not authorised or article is not published or incorrect doctype
			if (isset($row) && preg_match($doctypes, $row['url']))
			{
				$fileurl = JURI::base() . JPath::clean($row['url'], '/');
				if ($raw)
				{
					$article->text = preg_replace("#\{\s*filelink\s*\|\s*(\d+)(.*?)\}#", $fileurl, $article->text, 1);
					continue;
				}
				$filetitle = htmlspecialchars($row['title']);
				if (empty($linktitle))
				{
					$linktitle = $filetitle;
				}
				if ($icon)
				{
					$ext = strtolower(JFile::getExt($fileurl));
					$icon = '<img alt="' . $ext . '" src="media/com_filelinks/images/' . $ext . '.png" title="' . $ext . '" />';
				}
				else
				{
					$icon = '';
				}
				$buffer = '<a href="' . $fileurl . '" title="' . $filetitle . '"' . $pblank . ' class="filelink">' . $icon . $linktitle . '</a>';
				if ($description && !empty($row['description']))
				{
					$buffer .= '<span class="filelink-description">' . htmlspecialchars($row['description']). '</span>';
				}
				$article->text = preg_replace("#\{\s*filelink\s*\|\s*(\d+)(.*?)\}#", $buffer, $article->text, 1);
			}
			else
			{
				$article->text = preg_replace("#\{\s*filelink\s*\|\s*(\d+)(.*?)\}#", '', $article->text, 1);
			}
		}
		// match filelinkcat
		while (preg_match("#\{\s*filelinkcat\s*\|\s*(\d+)\s*\|{0,1}(.*?)\}#", $article->text, $catmatches))
		{
			extract($defoptions, EXTR_OVERWRITE);
			$filecatid = $catmatches[1];
			$buffer = '';
			$title = $catmatches[2];
			// do article or category access rules prevail
			$query = $db->getQuery(true);
			if ($cataccess)
			{
				// by category
				$query->select($db->quoteName(array('a.id', 'a.url', 'a.title', 'a.description')));
				$query->from($db->quoteName('#__filelinks', 'a'));
				$query->join('INNER', $db->quoteName('#__categories', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.catid') . ')');
				$query->where($db->quoteName('a.catid') . ' = ' . (int) $filecatid . ' AND ' . $db->quoteName('a.state') . ' = 1 AND ' . $db->quoteName('b.access') . ' IN (' . $groups . ')');
				$query->order($orderBy);
				$db->setQuery($query);
			}
			else
			{
				$db->setQuery("SELECT id, url, title, description FROM #__filelinks AS a WHERE catid = " . (int) $filecatid . " AND state = 1 AND access IN (" . $groups . ") ORDER BY " . $orderBy);
			}

			// only returns published items and authorised items
			$rows = $db->loadAssocList();

			if (isset($rows))
			{
				if ($usetemplate)
				{
					// custom template for list
					// Get the path for the layout file - only works for J3, so we'll have to fudge it in J2.5
					// $path = JPluginHelper::getLayoutPath('content', 'filelinks');
					if (file_exists(JPATH_THEMES . '/' . $template . '/html/plg_content_filelinks/default.php'))
					{
						$path = JPATH_THEMES . '/' . $template . '/html/plg_content_filelinks/default.php';
					}
					else
					{
						$path = JPATH_PLUGINS . '/content/filelinks/tmpl/default.php';
					}
					// Render the list
					ob_start();
					include $path;
					$buffer = ob_get_clean();

					// NB if buffer is empty then this also works
					$article->text = preg_replace("#\{\s*filelinkcat\s*\|(.*?)\}#", $buffer, $article->text, 1);
				}
				else
				{
					foreach ($rows as $row)
					{
						// Exclude unwanted doctypes
						if (preg_match($doctypes, $row['url']))
						{
							if ($icon)
							{
								$ext = strtolower(JFile::getExt($row['url']));
								$icon = '<img alt="' . $ext . '" src="media/com_filelinks/images/' . $ext . '.png" title="' . $ext . '" />';
							}
							else
							{
								$icon = '';
							}
							$buffer .= '<li class="filelinkcat-li"><a href="' . JURI::base() . JPath::clean($row['url'], '/') . '" title="' . htmlspecialchars($row['title']) . '"' . $pblank . '>' . $icon . htmlspecialchars($row['title']) . '</a>';
							if ($description && !empty($row['description']))
							{
								$buffer .= '<span class="filelinkcat-description">' . htmlspecialchars($row['description']) . '</span>';
							}
							$buffer .= '</li>';
						}

					}
					if ($buffer)
					{
						$buffer = '<' . $plist . ' class="filelinkcat-list">' . $buffer . '</' . $plist . '>';
						if ($addtitle)
						{
							$buffer = '<h' . $htitle . ' class="filelinkcat-title">' . htmlspecialchars($title) . '</h' . $htitle . '>' . $buffer;
						}
					}
					$article->text = preg_replace("#\{\s*filelinkcat\s*\|(.*?)\}#", $buffer, $article->text, 1);
				}

			}
			else
			{
				// Nothing to see so remove plugin syntax
				$article->text = preg_replace("#\{\s*filelinkcat\s*\|(.*?)\}#", '', $article->text, 1);
			}

		}

	}
}