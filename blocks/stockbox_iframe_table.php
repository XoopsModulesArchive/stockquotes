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

include "../../../mainfile.php";
include "../language/".$xoopsConfig['language']."/blocks.php";

global $xoopsConfig, $xoopsDB, $xoopsUser;

foreach ($HTTP_GET_VARS as $k => $v) {
	${$k} = $v;
}

if ($xoopsUser) {
	$sql = "SELECT stocks FROM " . $xoopsDB->prefix('ustocks') . " WHERE uid=".$xoopsUser->getVar('uid');
	$result = $xoopsDB->query($sql);
	$numrows = $xoopsDB->getRowsNum($result);
	$stockarray = Array();
	if ($numrows) {
		list($stocks) = $xoopsDB->fetchRow($result);
		if (empty($stocks)) {
			$stocks = $default_stocks;
		}
	} else {
		$stocks = $default_stocks;
	}
} else {
	$stocks = $default_stocks;
}
$stocks = stripslashes($stocks);
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
$stocks = trim($stocks);
$stockarray = explode(' ',$stocks);
$limit = sizeof($stockarray);
for ($i=0;$i<$limit;$i++) {
	$Symbols[$i] = "'" . $stockarray[$i] . "'";
}

$quotes = Array();

Class yahoo
{
        function get_stock_quote($symbol)
        {
	        $url = sprintf("http://finance.yahoo.com/d/quotes.csv?s=%s&f=sl1d1t1c1ohgv" ,$symbol);
	        $fp = fopen($url, "r");
	        if(!fp)
	        {
		        return 1;
	        }
	        else
	        {
		        $array = fgetcsv($fp , 4096 , ', ');
		        fclose($fp);
		        $this->symbol = trim($array[0]);
		        $this->last = trim($array[1]);
		        $this->date = trim($array[2]);
		        $this->time = trim($array[3]);
		        $this->change = trim($array[4]);
		        $this->open = trim($array[5]);
		        $this->high = trim($array[6]);
		        $this->low = trim($array[7]);
		        $this->volume = trim($array[8]);
			$this->changepct = 0;
			return 0;
	        }
        }
}

$quote = new yahoo;

$i = 0;
$boxwidth = $boxwidth-20;
$boxheight = $boxheight-20;
   
while ( list(,$Sym) = each($Symbols) ) {

	if (! $quote->get_stock_quote($Sym)) {
		$quotes[$i] = "<table padding='0'><tr><td><strong>" . $quote->symbol . "</strong></td> ";
		$quotes[$i] .= "<td>" . $quote->change . "</td>";
		$quotes[$i] .= "<tr><td>" . _SB_DATE . "</td><td>" . $quote->date . "</td></tr>";
		$quotes[$i] .= "<tr><td>" . _SB_TIME . "</td><td>" . $quote->time . "</td></tr>";
		$quotes[$i] .= "<tr><td>" . _SB_LAST . "</td><td>" . $quote->last . "</td></tr>";
		$quotes[$i] .= "<tr><td>" . _SB_HIGH . "</td><td>" . $quote->high . "</td></tr>";
		$quotes[$i] .= "<tr><td>" . _SB_LOW . "</td><td>" . $quote->low . "</td></tr>";
		$quotes[$i] .= "<tr><td>" . _SB_PREV . "</td><td>" . $quote->open . "</td></tr>";
		$quotes[$i] .= "<tr><td>" . _SB_VOLUME . "</td><td>" . $quote->volume . "</td></tr></table>";
		$i++;
	}
}

$currenttheme = getTheme();

echo "<html><head>";
echo '<meta http-equiv="refresh" content="' . $refresh . '">';
if (is_file(XOOPS_ROOT_PATH . '/themes/' . $currenttheme . '/style.css')) {
	echo "<style type='text/css' media='all'>
		<!-- @import url(" . XOOPS_URL . "/themes/" . $currenttheme . "/style.css); -->
	</style>";
}
echo '</head><body>';

echo '

<!--BEGIN FADING DYNAMIC CONTENT SCRIPT-->
<script language="javascript">

// Use Freely as long as following messages are intact ::
//---------------------------------------------------------------
// Fading Dynamic Content JavaScript v 2.0                      |
//    Made minor changes, Works on IE and NS6                   |
//    Added support for NS4                                     |
//    Added option to AutoStart on load or onClick              |
// This script written and ? 2002 Premshree Pillai.             |
// All rights reserved.                                         |
// Created on : 28/04/02                                        |
// Modified on : 11/05/02                                       |
// Web : http://www.qiksearch.com/                              |
// Mail : qiksearch@rediffmail.com                              |
// FREE JavaScripts at http://www.qiksearch.com/javascripts.htm |
// v 2.0 - Now supports NS4                                     |
// v 1.2 - Option to Autostart on load or click to start        |
// v 1.1 - Supports IE and NS6, option to loop continuosly      |
// v 1.0 - Fading Dynamic Content                               |
//---------------------------------------------------------------
// Location of script : http://www.qiksearch.com/javascripts/fading-dynamic-content20.htm

//--------------------------------------CUTOMISE----------------------------------------------

   // The Fading Contents, HTML Tags supported
   ';

   echo '
   var qiksearch_js_text = new Array (';
   $limit = sizeof($quotes);
   for ($i=0; $i<$limit; $i++) {
	   echo '"'. $quotes[$i] . '"';
	   if ($i != ($limit-1)) {
		   echo ',';
	   }
   }
   echo ');';

echo '   
// var qiksearch_js_text = new Array("hello","goodbye","third","fourth");
var qiksearch_space_width = ' . $boxwidth . '; // The width of the content space
var qiksearch_space_height = ' . $boxheight . '; // The height of the content space
var qiksearch_space_borderw=0; // Border width
var qiksearch_space_borderc="#FF9900"; // Border Color
var qiksearch_length = ' . $limit . ';
var timeOutVal='. $circdelay . '; // Delay in milliseconds
var isLoop=true; // If you want to loop continuosly then true, else false
var isAutoStart=true; // If you want the Fading to start else you have to click to start
var qiksearch_js_text_static=\'<a href="javascript:resetAll();writeDiv();" style="text-decoration:none" accesskey="l"><font color="#808080" face="verdana,arial,helvetica" size="-1"><b>C<u>l</u>ick to Start</b></font></a>\'; // The default content if AutoStart false

//--------------------------------------------------------------------------------------------

//-----------------------------DO-NOT-MODIFY-BELOW-THIS---------------------------------------

var qiksearch_DyObj;
var qiksearch_space_ns4_left=(screen.width/2-20)-Math.round(qiksearch_space_width/2);

function setDyObj()
{
  qiksearch_DyObj=document.getElementById("qiksearch_js_space");
}

// document.write(\'<table padding="0" width="\' + qiksearch_space_width + \'" height="\' + qiksearch_space_height + \'" style="background:#FFFFFF; border:\' + qiksearch_space_borderw + \'px solid \' + qiksearch_space_borderc + \'"><tr><td>\');
document.write(\'<div id="qiksearch_js_space">\');
document.write(\'</div>\');
// document.write(\'</td></tr></table>\');

var def_10="A",def_11="B",def_12="C",def_13="D",def_14="E",def_15="F";
var colorVal=15;
var div_count=0;

function writeDiv()
{
  qiksearch_DyObj.innerHTML= \'<span style="font-size: '.$fontsize.'px; font-family: Verdana, Arial, Helvetica, sans-serif;">\' + qiksearch_js_text[div_count] + \'</span>\' ;

  div_count++;
  if (div_count==qiksearch_length)  
  {
    div_count=0;
  }
  setTimeout("writeDiv()",timeOutVal);
}

setDyObj();

function start_fader()
{
  writeDiv();
}

window.onload=start_fader;

</script>
<!--END FADING DYNAMIC CONTENT SCRIPT-->';

if ($xoopsUser) {
	echo '<center><font style="font-size: '.$fontsize.'px; font-family: Verdana, Arial, Helvetica, sans-serif;"><a target="_parent" href="'.XOOPS_URL.'/modules/stockquotes/stockbox_custom.php?default='.$default_stocks.'">'._SB_CUSTOMIZE.'</a></font></center>';
}

echo '
</body>
</html>';

?>
          