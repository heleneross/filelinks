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

if ($this->searchdb == 3)
{
	$r_tablesnames = 'all';
}
elseif ($this->searchdb == 2)
{
	$r_tablesnames = $this->r_tablesnames; //'f2c_fieldcontent,categories,contact_details';
}
else
{
	$r_tablesnames = '';
}

$id = $this->filelink ? $this->item->id : $this->item->catid;

if ($this->searchdb > 0)
{
	if ($articles = EditFileDetailsHelper::getFilelistArticles($id,$this->filelink))
	{
		echo '<h2>Articles</h2><table style="width:100%"><thead><tr><th>id</th><th>title</th><th>published</th></tr></thead><tbody>';
		foreach ($articles as $article)
		{
			echo '<tr>';
			echo '<td>' . $article['id'] . '</td>';
			echo '<td>' . $article['title'] . '</td>';
			echo '<td>' . $article['state'] . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}

	if ($modules = EditFileDetailsHelper::getFilelistModules($id, $this->filelink))
	{
		echo '<h2>Modules</h2><table style="width:100%"><thead><tr><th>id</th><th>title</th><th>module</th><th>position</th><th>published</th></tr></thead><tbody>';
		foreach ($modules as $module)
		{
			echo '<tr>';
			echo '<td>' . $module['id'] . '</td>';
			echo '<td>' . $module['title'] . '</td>';
			echo '<td>' . $module['module'] . '</td>';
			echo '<td>' . $module['position'] . '</td>';
			echo '<td>' . $module['published'] . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}

	if (!empty($r_tablesnames) && $others = EditFileDetailsHelper::showTables($id, $r_tablesnames, $this->filelink))
	{
		echo '<h2>Other</h2><table style="width:100%"><thead><tr><th>id</th><th>title</th><th>db table</th></tr></thead><tbody>';
		foreach ($others as $tables => $other)
		{
			foreach ($other as $key => $value)
			{
				echo '<tr>';
				echo '<td>' . $key . '</td>';
				echo '<td>' . $value['title'] . '</td>';
				echo '<td>' . $tables . '</td>';
				echo '</tr>';
			}
		}
		echo '</tbody></table>';
	}
}