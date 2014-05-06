<?php
/**
 * Created by PhpStorm.
 * User: Helen
 * Date: 05-05-2014
 * Time: 11:46
 */
defined('_JEXEC') or die('Restricted access');
if ($article->id == '80')
{
	$pblank = " ";
	$addtitle = false;
}
// you have id, url, title, description in the result set
$temp = '';
if ($addtitle && !empty($htitle))
{
	$title = '<h' . $htitle . ' class="filelinkcat-title">' . htmlspecialchars($title) . '</h' . $htitle . '>';
}
else
{
	$title = '';
}
foreach ($rows as $row)
{
	// Exclude unwanted doctypes
	if (preg_match($doctypes, $row['url']))
	{
		if (!$description)
		{
			// Append -nd to class names if no description
			$cl = '-nd';
		}
		if ($icon)
		{
			$ext = strtolower(JFile::getExt($row['url']));
			$icon = '<img alt="' . $ext . '" src="media/com_filelinks/images/' . $ext . '.png" title="' . $ext . '" />';
		}
		else
		{
			$icon = '';
		}
		$temp .= '<dt class="filelinkcat-dt' . $cl . '"><a href="' . JURI::base() . JPath::clean($row['url'], '/') . '" title="' . htmlspecialchars($row['title']) . '"' . $pblank . '>' . $icon . htmlspecialchars($row['title']) . '</a></dt>';
		if ($description && !empty($row['description']))
		{
			$temp .= '<dd class="filelinkcat-dd">' . htmlspecialchars($row['description']) . '</dd>';
		}
	}
}
if ($temp)
{
	echo $title . '<dl class="filelinkcat-dl' . $cl . '">' . $temp . '</dl>';
}
