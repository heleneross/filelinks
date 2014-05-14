<?php
/**
 * @version     2.0.0
 * @package     com_filelinks
 * @copyright   Copyright (C) Helen 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Helen <heleneross@gmail.com> - http://bfgnet.de
 */

// No direct access
defined('_JEXEC') or die;

/**
 * EditFileDetails helper.
 */
class EditFileDetailsHelper
{
	public static function getFilelistArticles($lid, $filelink = true)
	{
		$text = $filelink ? 'filelink' : 'filelinkcat';
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'title', 'state')));
		$query->from('#__content');
		$query->where("`introtext` LIKE '%{".$text."|" . (int) $lid . "|%' OR `fulltext` LIKE '%{".$text."|" . (int) $lid . "|%' OR `introtext` LIKE '%{".$text."|" . (int) $lid . "}%' OR `fulltext` LIKE '%{".$text."|" . (int) $lid . "}%'");
		$db->setQuery($query);
		$rows = $db->loadAssocList('id');
		return !empty($rows) ? $rows :false;
	}

	public static function getFilelistModules($lid, $filelink = true)
	{
		$text = $filelink ? 'filelink' : 'filelinkcat';
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id', 'title', 'module', 'position', 'published'));
		$query->from('#__modules');
		$query->where("`content` LIKE '%{".$text."|" . (int) $lid . "|%' OR `content` LIKE '%{".$text."|" . (int) $lid . "}%'");
		$db->setQuery($query);
		$rows = $db->loadAssocList('id');
		return !empty($rows) ? $rows :false;
	}

	public static function showTables($lid, $r_tablenames, $filelink = true)
	{
		if (empty($lid) || empty($r_tablenames))
		{
			return false;
		}

		$config = new JConfig();
		$prefix = $config->dbprefix;
		$db = JFactory::getDbo();
		if ($r_tablenames == 'all')
		{
			$query = ('SHOW TABLES');
			$db->setQuery($query);
			$tableData = $db->loadColumn();
			$tableData = str_replace($prefix, '', $tableData);
		}
		else
		{
			$tableData = array_map('trim', explode(",", $r_tablenames));
		}

		// remove content and modules from $tableData array
		$tableData = array_diff($tableData,array('content','modules'));

		$searchFields = array();
		$index = array();
		// remove content and module from $searchFields array
		foreach ($tableData as $table)
		{
			// only need tables with text fields
			$sql = 'SHOW FIELDS IN ' . $prefix . $table . ' WHERE type LIKE "%text%"';
			$db->setQuery($sql);
			$fieldData = $db->loadColumn();
			if (!empty($fieldData))
			{
				$searchFields[$table] = $fieldData;

				// get primary key for this table
				$pri = "SHOW INDEX FROM " . $prefix . $table . " WHERE Key_name = 'PRIMARY'";
				$db->setQuery($pri);
				$priname = $db->loadAssocList();
				$index[$table] = ($priname[0]['Column_name']);
			}
		}

		$result = array();
		foreach ($searchFields as $tablename => $cols)
		{
			$query = $db->getQuery(true);
			$query->from('#__' . $tablename);
			$query->select('*');
			if ($filelink)
			{
			$string = '`' . implode("` LIKE '%{filelink|" . $lid . "|%' OR `", $cols) . "` LIKE '%{filelink|" . $lid . "|%'";
			$string .= ' OR `' . implode("` LIKE '%{filelink|" . $lid . "}%' OR `", $cols) . "` LIKE '%{filelink|" . $lid . "}%'";
			}
			else
			{
				$string = '`' . implode("` LIKE '%{filelinkcat|" . $lid . "|%' OR `", $cols) . "` LIKE '%{filelinkcat|" . $lid . "|%'";
				$string .= ' OR `' . implode("` LIKE '%{filelinkcat|" . $lid . "}%' OR `", $cols) . "` LIKE '%{filelinkcat|" . $lid . "}%'";
			}
			$query->where($string);
			$db->setQuery($query);

			// returns returns an associated array - indexed on primary key
			$tmpresult = $db->loadAssocList($index[$tablename]);
			if (!empty($tmpresult))
			{
				$result[$tablename] = $tmpresult;
			}
		}
		return $result;
	}

}
