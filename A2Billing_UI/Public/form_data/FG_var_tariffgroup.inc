<?php

getpost_ifset(array('id', 'tariffgroupname', 'lcrtype', 'removeinterprefix', 'idtariffplan', 'idtariffplan_hidden', 'id_cc_package_offer'));

$HD_Form = new FormHandler("cc_tariffgroup","Call Plan");

$HD_Form -> FG_DEBUG = 0;
$HD_Form -> FG_TABLE_DEFAULT_ORDER = " tariffgroupname";
$HD_Form -> FG_TABLE_DEFAULT_SENS = "DESC";


// Code Here for Deleting the Dependent Records
// Dependent Tables
$HD_Form -> FG_FK_DELETE_ALLOWED = true;
$HD_Form -> FG_FK_DELETE_CONFIRM = true;
$HD_Form -> FG_FK_WARNONLY = true;
$HD_Form -> FG_FK_TABLENAMES = array("cc_card");
$HD_Form -> FG_FK_EDITION_CLAUSE = array(" tariff ");

$HD_Form -> FG_FK_DELETE_MESSAGE = gettext("You have some cards using this Call Plan! Please comfirm that you really want to remove this Call Plan ? ");

// LCD :the cheapest Provider for a given destination number
$lcrtype_list = array();
$lcrtype_list["0"] = array( gettext("LCR : According to the buyer price"), "0");
$lcrtype_list["1"] = array( gettext("LCD : According to the seller price"), "1");


$lcrtype_list_short = array();
$lcrtype_list_short["0"] = array( gettext("LCR : buyer price"), "0");
$lcrtype_list_short["1"] = array( gettext("LCD : seller price"), "1");

$inter_prefix_list_short = array();
$inter_prefix_list_short["0"] = array( gettext("Keep prefix"), "0");
$inter_prefix_list_short["1"] = array( gettext("Remove prefix"), "1");

$HD_Form -> AddViewElement(gettext("ID"), "id", "5%", "center", "sort");
$HD_Form -> AddViewElement(gettext("NAME"), "tariffgroupname", "20%", "center", "sort");
$HD_Form -> AddViewElement(gettext("CREATIONDATE"), "creationdate", "20%", "center", "sort", "19", "", "", "", "", "", "display_dateformat");
$HD_Form -> AddViewElement(gettext("LC TYPE"), "lcrtype", "15%", "center", "sort", "", "list", $lcrtype_list_short);
$HD_Form -> AddViewElement(gettext("PACKAGE"), "id_cc_package_offer", "11%", "center", "sort", "15", "lie", "cc_package_offer", "label", "id='%id'", "%1");
$HD_Form -> AddViewElement(gettext("INTER PREFIX"), "removeinterprefix", "15%", "center", "sort", "", "list", $inter_prefix_list_short);


$HD_Form -> FieldViewElement ('id, tariffgroupname, creationdate, lcrtype,id_cc_package_offer, removeinterprefix');


$HD_Form -> CV_NO_FIELDS  = gettext("THERE IS NO")." ".strtoupper($HD_Form->FG_INSTANCE_NAME)." ".gettext("CREATED!");  
$HD_Form -> CV_DISPLAY_LINE_TITLE_ABOVE_TABLE = false;
$HD_Form -> CV_TEXT_TITLE_ABOVE_TABLE = '';
$HD_Form -> CV_DISPLAY_FILTER_ABOVE_TABLE = false;


$HD_Form -> FG_EDITION = true;
$HD_Form -> FG_DELETION = true;



$HD_Form -> AddEditElement (gettext("NAME"),
	"tariffgroupname",		
	'$value',	
	"INPUT",	
	"size=30 maxlength=20",	
	"9",	
	gettext("Insert the Call Plan name "),
	"" , "", "", "", "", "", "", "" );

$HD_Form -> AddEditElement (gettext("LC TYPE"),
	"lcrtype",				
	'$value',	
	"SELECT",	
	"",	
	"",	
	"",
	"list" , "", "", "", $lcrtype_list, "%1", "", "");


$HD_Form -> AddEditElement(gettext("PACKAGE"),
	"id_cc_package_offer",
	'$value',
	"SELECT",
	"", "", "",
	"sql",
	"cc_package_offer",
	"label, id",
	"", "", "%1", "", gettext("Set the Package offer if you wish to use one with this Call Plan"), '', '<OPTION  value="-1" selected>NO PACKAGE OFFER</OPTION>');

$HD_Form -> AddEditElement (gettext("REMOVE INTER PREFIX"),
	"removeinterprefix",		
	'0',
	"RADIOBUTTON",
	"",	
	"",	
	gettext("Define if the international prefix will be removed to check the rate."),
	"" , "", "" , "Yes :1, - No:0", "", "", "", gettext("Remove the international access prefix (00 or 011) before matching the dialled digits with the rate card. E.G. If the dialled digits were 0044 for a call to the UK, only 44 would be delivered."));


	
$DBHandle_max  = DbConnect();
$numrow = 0;
$resmax = $DBHandle_max -> Execute("SELECT * FROM cc_tariffplan");
if ( $resmax )
	$numrow = $resmax -> RecordCount( );

if ($numrow>0){ 
	$HD_Form -> AddEditElement (gettext("RATECARD"),
		"tariffplan",	
		'$value',	
		"SELECT",		
		'size="10" multiple="multiple"',
		"",		
		"",	
		"sql",		
		"call_tariff",	
		"label, id",		
		"", "", "%1 : (%2)", "", "", "cc_tariffgroup_plan:idtariffplan:cc_tariffplan LEFT JOIN cc_tariffgroup_plan ON cc_tariffplan.id=cc_tariffgroup_plan.idtariffplan:DISTINCT cc_tariffplan.tariffname, cc_tariffplan.id: cc_tariffgroup_plan.idtariffgroup = %id:idtariffgroup:%2 - (%1)::::%1:id='%1'");		
		
}
																											


$HD_Form -> FieldEditElement ('tariffgroupname, lcrtype, id_cc_package_offer, removeinterprefix');


if (DB_TYPE == "postgres"){
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_FIELDS = "";
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_VALUE  = "";	
}else{
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_FIELDS = "creationdate ";
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_VALUE  = "now()";	
}




$HD_Form -> FG_INTRO_TEXT_EDITION= '';
$HD_Form -> FG_INTRO_TEXT_ASK_DELETION = gettext("If you really want remove this")." ".$HD_Form->FG_INSTANCE_NAME.", ".gettext("click on the delete button.");
$HD_Form -> FG_INTRO_TEXT_ADD = gettext("you can add easily a new")." ".$HD_Form->FG_INSTANCE_NAME.".<br>".gettext("Fill the following fields and confirm by clicking on the button add.");





$HD_Form -> FG_INTRO_TEXT_ADITION = '';
$HD_Form -> FG_TEXT_ADITION_CONFIRMATION = gettext("Your new")." ".$HD_Form->FG_INSTANCE_NAME." ".gettext("has been inserted.")."<br>";


$HD_Form -> FG_BUTTON_EDITION_SRC = $HD_Form -> FG_BUTTON_ADITION_SRC  = Images_Path . "/cormfirmboton.gif";
$HD_Form -> FG_BUTTON_EDITION_BOTTOM_TEXT = $HD_Form -> FG_BUTTON_ADITION_BOTTOM_TEXT = gettext("Click 'Confirm Data' to continue");



$HD_Form -> FG_GO_LINK_AFTER_ACTION_ADD = $_SERVER['PHP_SELF']."?atmenu=document&stitle=Document&wh=AC&id=";
$HD_Form -> FG_GO_LINK_AFTER_ACTION_EDIT = $_SERVER['PHP_SELF']."?atmenu=document&stitle=Document&wh=AC&id=";
$HD_Form -> FG_GO_LINK_AFTER_ACTION_DELETE = $_SERVER['PHP_SELF']."?atmenu=document&stitle=Document&wh=AC&id=";
?>
