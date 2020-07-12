<?php
// $Id: news_top.php,v 1.8 2003/03/28 04:04:51 w4z004 Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include_once('../../mainfile.php');

if (! $xoopsUser ) {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
} else {
	foreach ($HTTP_GET_VARS as $k => $v) {
		${$k} = $v;
	}
	
	include_once('../../header.php');
	include "language/".$xoopsConfig['language']."/main.php";

	if (!empty($default)) {
		$stocksymbols = $default;
		$userid = $xoopsUser->getVar("uid");
		$sql = "SELECT stocks FROM " . $xoopsDB->prefix('ustocks') . " WHERE uid=".$xoopsUser->getVar('uid');
		$result = $xoopsDB->query($sql);
		$numrows = $xoopsDB->getRowsNum($result);
		if ($numrows) {
			list($stocksymbols) = $xoopsDB->fetchRow($result);
			if (empty($stocksymbols)) {
				$stocksymbols = $default;
			}
		}
		echo '<div align="left">';
		echo '<form name="stockcustomform" action="'.XOOPS_URL.'/modules/stockquotes/stockbox_custom.php" method="GET">';
		echo _MN_SYMBOLS."&nbsp;<br><input type='text' size='40' name='stocksymbols' value='".$stocksymbols."' />&nbsp;<br>"._MN_SPACE_SEP."<BR>";
		echo '<input type="submit" value="'._MN_SUBMIT.'">';
		echo '</div>';
	} elseif (isset($stocksymbols) && !empty($stocksymbols)) {
		$stocks = stripslashes($stocksymbols);
		$stocks = str_replace("\""," ",$stocks);
		$stocks = str_replace("\'"," ",$stocks);
		$stocks = str_replace("\`"," ",$stocks);
		$stocks = str_replace("."," ",$stocks);
		$stocks = str_replace(","," ",$stocks);
		$stocks = str_replace("-"," ",$stocks);
		$stocks = str_replace("+"," ",$stocks);
		$stocks = str_replace("|"," ",$stocks);
		$stocks = str_replace("/"," ",$stocks);
		$stocks = str_replace("  "," ",$stocks);
		$stocks = str_replace("  "," ",$stocks);
		$stocks = str_replace("  "," ",$stocks);
		$stocks = str_replace("  "," ",$stocks);
		$stocksymbols = trim($stocks);
		$sql = "SELECT stocks FROM ".$xoopsDB->prefix('ustocks')." WHERE uid=".$xoopsUser->getVar('uid');
		$result = $xoopsDB->queryF($sql);
		$numrows = $xoopsDB->getRowsNum($result);
		if ($numrows) {
			$sql = "UPDATE " . $xoopsDB->prefix('ustocks') . " SET stocks='".$stocksymbols."' WHERE uid=".$xoopsUser->getVar('uid');
			$result = $xoopsDB->queryF($sql);
		} else {
			$sql = "INSERT INTO " . $xoopsDB->prefix('ustocks') . " (uid,stocks) VALUES (".$xoopsUser->getVar('uid').",'".$stocksymbols."')";
			echo $sql;
			$result = $xoopsDB->queryF($sql);
		}
		redirect_header(XOOPS_URL . "/");
	}
	include('../../footer.php');
}

?>
