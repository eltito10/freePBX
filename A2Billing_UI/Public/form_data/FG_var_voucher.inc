<?php


getpost_ifset(array('id', 'creationdate', 'usedate', 'expirationdate', 'voucher', 'tag', 'credit', 'activated', 'used', 'currency'));


$plang='en';

$HD_Form = new FormHandler("cc_voucher","Voucher");

$HD_Form -> FG_DEBUG = 0;


$currency_list = array();
$indcur=0;

$currencies_list = get_currencies();

foreach($currencies_list as $key => $cur_value) {
	$currency_list["$key"]  = array( $cur_value[1].' ('.$cur_value[2].')', $key);
	$indcur++;
}

$actived_list = array(); 
$actived_list["t"] = array( gettext("Active"), "t" );
$actived_list["f"] = array( gettext("Inactive"), "f" );

$actived_list_r = array(); 
$actived_list_r["t"] = array( "t", gettext("Active") );
$actived_list_r["f"] = array( "f", gettext("Inactive") );

$used_list = array();
$used_list["0"] = array( gettext("NO USED"), "0");
$used_list["1"] = array( gettext("USED"), "1");

$used_list_r = array();
$used_list_r["0"] = array( "0", gettext("NO USED"));
$used_list_r["1"] = array( "1", gettext("USED"));

$yesno = array();
$yesno["1"] = array( "Yes", "1");
$yesno["0"] = array( "No", "0");

foreach($currencies_list as $key => $cur_value) {
	$currency_list[$key]  = array( $cur_value[1].' ('.$cur_value[2].')', $key);
	$currency_list_r[$key]  = array( $key, $cur_value[1]);
	$currency_list_key[$key][0] = $key;
}



$HD_Form -> AddViewElement(gettext("ID"), "id", "4%", "center", "sort");
$HD_Form -> AddViewElement(gettext("VOUCHER"), "voucher", "12%", "center", "sort");
$HD_Form -> AddViewElement(gettext("CREDIT"), "credit", "6%", "center", "sort");
$HD_Form -> AddViewElement(gettext("TAG"), "tag", "13%", "center", "sort", "30");
$HD_Form -> AddViewElement(gettext("ACTIVATED"), "activated", "6%", "center", "sort", "", "list", $actived_list);
$HD_Form -> AddViewElement(gettext("USED"), "used", "6%", "center", "sort", "", "list", $used_list);
$HD_Form -> AddViewElement(gettext("USEDCARDNUMBER"), "usedcardnumber", "12%", "center", "sort");
$HD_Form -> AddViewElement(gettext("CREATED DATE"), "creationdate", "12%", "center", "sort", "16");
$HD_Form -> AddViewElement(gettext("USED DATE"), "usedate", "13%", "center", "sort", "16");
$HD_Form -> AddViewElement(gettext("CURRENCY"), "currency", "6%", "center", "sort", "", "list", $currency_list_key);


$HD_Form -> FieldViewElement ('id, voucher, credit, tag, activated, used, usedcardnumber, creationdate, usedate, currency');



// Search form
if (!($popup_select>=1))	 $HD_Form -> FG_FILTER_SEARCH_FORM = true;
$HD_Form -> FG_FILTER_SEARCH_TOP_TEXT = gettext('Define specific criteria to search for vouchers created.');
$HD_Form -> FG_FILTER_SEARCH_1_TIME_TEXT = gettext('Creation date / Month');
$HD_Form -> FG_FILTER_SEARCH_2_TIME_TEXT = gettext('Creation date / Day');
$HD_Form -> FG_FILTER_SEARCH_2_TIME_FIELD = 'creationdate';
$HD_Form -> AddSearchElement_C1 (gettext("VOUCHER"), 'voucher','vouchertype');
$HD_Form -> AddSearchElement_C1 (gettext("CARDNUMBER"),'usedcardnumber','usedcardnumbertype');
$HD_Form -> AddSearchElement_C1 (gettext("TAG"),'tag','tagtype');
$HD_Form -> AddSearchElement_C2 (gettext("CREDIT"),'credit1','credit1type','credit2','credit2type','credit');

$HD_Form -> FG_FILTER_SEARCH_FORM_SELECT_TEXT = '';
$HD_Form -> AddSearchElement_Select (gettext("SELECT STATUS"), null, null, null, null,null , "activated", 0, $actived_list_r);
$HD_Form -> AddSearchElement_Select (gettext("SELECT USED"), null, null, null, null,null , "used", 0, $used_list_r);
$HD_Form -> AddSearchElement_Select (gettext("SELECT CURRENCY"), null, null, null, null, null, "currency", 0, $currency_list_r);




$HD_Form -> CV_NO_FIELDS  = gettext("NO")." ".strtoupper($HD_Form->FG_INSTANCE_NAME)." ".gettext("HAVE BEEN CREATED.");
$HD_Form -> CV_DISPLAY_LINE_TITLE_ABOVE_TABLE = false;
$HD_Form -> CV_TEXT_TITLE_ABOVE_TABLE = '';
$HD_Form -> CV_DISPLAY_FILTER_ABOVE_TABLE = false;
$HD_Form -> FG_EXPORT_SESSION_VAR = "pr_export_entity_voucher";
$HD_Form -> FG_EXPORT_FIELD_LIST = VOUCHER_EXPORT_FIELD_LIST;
$HD_Form -> FG_EXPORT_CSV = true;
$HD_Form -> FG_EXPORT_XML = true;

$HD_Form -> FG_EDITION = true;
$HD_Form -> FG_DELETION = true;




if ($form_action=="ask-add"){
	$card_gen = gen_card($HD_Form->FG_TABLE_NAME, LEN_VOUCHER, voucher);
	$maxi = "value='".$card_gen."'";
}

$HD_Form -> AddEditElement (gettext("VOUCHER"),
	"voucher",			
	"$value",	
	"INPUT",
	"size=20 $maxi readonly maxlength=40",	 
	"4",	
	gettext("Insert the voucher"),
	"" , "", "",	"", "" , "", "", "");


$HD_Form -> AddEditElement (gettext("AMOUNT"),
	"credit",
	'$value',	
	"INPUT",	
	"size=30 maxlength=30",	
	"12",
	gettext("Insert the number of credit"),
	"" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("TAG"),
	"tag",			
	'$value',	
	"INPUT",
	"size=30 maxlength=30",	
	"11",	
	gettext("Insert the tag"),
	"" , "", "",	"", "", "", "NO-NULL", "" );


$HD_Form -> AddEditElement (gettext("ACTIVATED"),
	"activated",
	't',
	"RADIOBUTTON",	
	"",	
	"",
	gettext("Choose if you want to activate this card"),
	"" , "", "" ,"Yes :t, - No:f", "", "" , "" , "");

$HD_Form -> AddEditElement (gettext("CURRENCY"),
	"currency",
	'$value',
	"SELECT",
	"",
	"",
	"",
	"list" , "", "",	"", $currency_list, "%1", "", "" );


if ($form_action=="ask-add"){
	$begin_date = date("Y");
	$begin_date_plus = date("Y")+10;
	$end_date = date("-m-d H:i:s");
	$comp_date = "value='".$begin_date.$end_date."'";
	$comp_date_plus = "value='".$begin_date_plus.$end_date."'";
	$comp_zero = "value='0'";
}

$HD_Form -> AddEditElement (gettext("EXPIRY DATE"),
	"expirationdate",
	'$value',
	"INPUT",
	"size=40 maxlength=40  $comp_date_plus",	
	"10",
	gettext("Insert the expiration date"),
	"" , "", "",	"", "", "", "", gettext("Format YYYY-MM-DD HH:MM:SS. For instance, '2004-12-31 00:00:00'"), null, "res_display_dateformat" );


$HD_Form -> FieldEditElement ('voucher, credit, tag, activated, currency, expirationdate ');


if (DB_TYPE == "postgres"){
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_FIELDS = "";
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_VALUE  = "";	
}else{
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_FIELDS = "creationdate ";
	$HD_Form -> FG_QUERY_ADITION_HIDDEN_VALUE  = "now()";	
}


// Set the filter variables

$HD_Form -> FG_FILTER_APPLY = true;
$HD_Form -> FG_FILTERFIELD = 'voucher';
$HD_Form -> FG_FILTERFIELDNAME = 'voucher';

if (isset($filterprefix)  &&  (strlen($filterprefix)>0)){
	if (strlen($HD_Form -> FG_TABLE_CLAUSE)>0) $HD_Form -> FG_TABLE_CLAUSE.=" AND ";
	$HD_Form -> FG_TABLE_CLAUSE.="voucher like '$filterprefix%'";
}



$HD_Form -> FG_INTRO_TEXT_EDITION= gettext("Modify the properties of the selected voucher.");
$HD_Form -> FG_INTRO_TEXT_ASK_DELETION = gettext("If you really want remove this")." ".$HD_Form->FG_INSTANCE_NAME.", ".gettext("click on the delete button.");
$HD_Form -> FG_INTRO_TEXT_ADD = gettext("you can add easily a new")." ".$HD_Form->FG_INSTANCE_NAME.".<br>".gettext("Fill the following fields and confirm by clicking on the button add.");





$HD_Form -> FG_INTRO_TEXT_ADITION = '';
$HD_Form -> FG_TEXT_ADITION_CONFIRMATION = gettext("Your new")." ".$Form->FG_INSTANCE_NAME." ".gettext("has been inserted.")."<br>";


$HD_Form -> FG_BUTTON_EDITION_SRC = $HD_Form -> FG_BUTTON_ADITION_SRC  = Images_Path . "/cormfirmboton.gif";
$HD_Form -> FG_BUTTON_EDITION_BOTTOM_TEXT = $HD_Form -> FG_BUTTON_ADITION_BOTTOM_TEXT = gettext("Click 'Confirm Data' to continue.");




$HD_Form -> FG_GO_LINK_AFTER_ACTION_ADD = $_SERVER['PHP_SELF']."?atmenu=document&stitle=Document&wh=AC&id=";
$HD_Form -> FG_GO_LINK_AFTER_ACTION_EDIT = $_SERVER['PHP_SELF']."?atmenu=document&stitle=Document&wh=AC&id=";
$HD_Form -> FG_GO_LINK_AFTER_ACTION_DELETE = $_SERVER['PHP_SELF']."?atmenu=document&stitle=Document&wh=AC&id=";
?>
