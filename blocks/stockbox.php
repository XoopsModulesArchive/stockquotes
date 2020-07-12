<?php 

include("../../../mainfile.php");

function b_stockbox_show($options) {

//	error_reporting(E_ALL);

	$default_stocks = $options[0];
	$boxwidth = $options[1];
	$boxheight = $options[2];
	$fontsize = $options[3];
	$circdelay = $options[4];
	$refresh = $options[5] * 60;

	$block['iframeurl'] = XOOPS_URL.'/modules/stockquotes/blocks/stockbox_iframe.php?default_stocks='.$default_stocks.'&boxwidth='.$boxwidth.'&boxheight='.$boxheight.'&fontsize='.$fontsize.'&circdelay='.$circdelay.'&refresh='.$refresh.'';
	$block['iframewidth'] = $boxwidth;
	$block['iframeheight'] = $boxheight;

	if ($xoopsUser) {
		$block['customize'] = '<br><center><a href="'.XOOPS_URL.'/modules/stockquotes/stockbox_custom.php?default='.$default_stocks.'">'._SB_CUSTOMIZE.'</a></center>';
	} else {
		$block['customize'] = '';
	}
	
	return $block;

}

function b_stockbox_edit($options) {
	
	$stocks = stripslashes($options[0]);
	$stocks = str_replace("\""," ",$stocks);
	$stocks = str_replace("\'"," ",$stocks);
	$stocks = str_replace("\`"," ",$stocks);
	$stocks = str_replace("."," ",$stocks);
	$stocks = str_replace(","," ",$stocks);
	$stocks = str_replace("-"," ",$stocks);
	$stocks = str_replace("|"," ",$stocks);
	$stocks = str_replace("/"," ",$stocks);
	$stocks = str_replace("  "," ",$stocks);
	$stocks = str_replace("  "," ",$stocks);
	$stocks = str_replace("  "," ",$stocks);
	$stocks = str_replace("  "," ",$stocks);
	$options[0] = trim($stocks);
	
	$form  = ""._SB_DEFAULT_SYMBOLS."&nbsp;<input type='text' name='options[0]' value='".$options[0]."' />&nbsp;"._SB_SPACE_SEP."";
	$form .= "&nbsp;<br>"._SB_WIDTH."&nbsp;<input type='text' name='options[1]' value='".$options[1]."' />&nbsp;"._SB_PIXELS."";
	$form .= "&nbsp;<br>"._SB_HEIGHT."&nbsp;<input type='text' name='options[2]' value='".$options[2]."' />&nbsp;"._SB_PIXELS."";
	$form .= "&nbsp;<br>"._SB_FONT."&nbsp;<input type='text' name='options[3]' value='".$options[3]."' />&nbsp;"._SB_PIXELS."";
	$form .= "&nbsp;<br>"._SB_DELAY."&nbsp;<input type='text' name='options[4]' value='".$options[4]."' />&nbsp;"._SB_MILL."";
	$form .= "&nbsp;<br>"._SB_REFRESH."&nbsp;<input type='text' name='options[5]' value='".$options[5]."' />&nbsp;"._SB_MIN."";
	return $form;
}

?>

