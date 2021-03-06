<?php

getpost_ifset(array('id_cc_card', 'cardnumber', 'id', 'name', 'amaflags', 'callgroup', 'accountcode', 'callerid', 'canreinvite', 'context', 'defaultip', 'dtmfmode', 
'fromuser', 'fromdomain', 'host', 'insecure', 'language', 'mailbox', 'md5secret', 'nat', 'permit', 'deny', 'mask', 'pickupgroup', 'port', 'qualify', 
'restrictcid', 'rtptimeout', 'rtpholdtimeout', 'secret', 'type', 'username', 'disallow', 'allow', 'musiconhold', 'regseconds', 'ipaddr', 'cancallforward', 'regexten','friend_id'));


if ($atmenu=='sipfriend'){
	$HD_Form = new FormHandler("cc_sip_buddies","Sip Friend");
}else{
	$HD_Form = new FormHandler("cc_iax_buddies","IAX Friend");
}


$HD_Form -> FG_DEBUG = 0;

$typepaid_list = array();
$typepaid_list["0"] = array( gettext("PREPAID CARD"), "0");
$typepaid_list["1"] = array( gettext("POSTPAY CARD"), "1");


$actived_list = array();
$actived_list["t"] = array( gettext("Active"), "t");
$actived_list["f"] = array( gettext("Inactive"), "f");

$yesno = array();
$yesno["1"] = array( gettext("Yes"), "1");
$yesno["0"] = array( gettext("No"), "0");


$HD_Form -> AddViewElement(gettext("CARDHOLDER"), "id_cc_card", "10%", "center", "sort", "25", "lie", "cc_card", "lastname, firstname", "id='%id'", "%1 %2");
$HD_Form -> AddViewElement(gettext("USERNAME"), "name", "12%", "center", "sort");
$HD_Form -> AddViewElement(gettext("ACCOUNTCODE"), "accountcode", "12%", "center", "sort");
$HD_Form -> AddViewElement(gettext("SECRET"), "secret", "10%", "center", "sort");
$HD_Form -> AddViewElement(gettext("CALLERID"), "callerid", "12%", "center", "sort");
$HD_Form -> AddViewElement(gettext("CONTEXT"), "context", "10%", "center", "sort");
$HD_Form -> AddViewElement(gettext("DEFAULTIP"), "defaultip", "10%", "center", "sort");
$HD_Form -> AddViewElement(gettext("DTMF"), "dtmfmode", "8%", "center", "sort");



$HD_Form -> FieldViewElement ('id_cc_card, name, accountcode, secret, callerid, context, defaultip, dtmfmode');


$HD_Form -> CV_NO_FIELDS  = gettext("THERE IS NO ".strtoupper($HD_Form->FG_INSTANCE_NAME)." CREATED!"); 
$HD_Form -> CV_DISPLAY_LINE_TITLE_ABOVE_TABLE = false;
$HD_Form -> CV_TEXT_TITLE_ABOVE_TABLE = '';
$HD_Form -> CV_DISPLAY_FILTER_ABOVE_TABLE = false;
$HD_Form -> CV_FILTER_ABOVE_TABLE_PARAM = "?friend_id=";
$HD_Form -> FG_LIMITE_DISPLAY = 10;

if (isset($friend_id)  &&  (strlen($friend_id)>0)){
	if ($friend_id!='all'){
		if (strlen($HD_Form ->FG_TABLE_CLAUSE)>0) $HD_Form ->FG_TABLE_CLAUSE.=" AND ";
		$HD_Form ->FG_TABLE_CLAUSE.="name='$friend_id'";
	}
}



$HD_Form -> FG_EDITION = true;
$HD_Form -> FG_DELETION = true;




$maxi='';
if ($form_action=="ask-add"){
	$card_gen = gen_card($HD_Form->FG_TABLE_NAME);
	$maxi = "value='".$card_gen."'";
	$pass =  MDP(6);
	$pass_secret = "value='".$pass."'";
}

$HD_Form -> AddEditElement (gettext("ID CARD"),
	"id_cc_card",
	'',
	"POPUPVALUE",
	"size=30 maxlength=50",
	"4",
	gettext("Insert the Id CardNumber"),
	"" , "", "", "", "",
	"A2B_entity_card.php?popup_select=1&"
	, ", 'CardNumberSelection','width=590,height=350,top=20,left=100,scrollbars=1'" ,
	gettext("Insert the card ID."));


$HD_Form -> AddEditElement (gettext("NAME"),
						   "name",			
						   "$value",	
						   "INPUT",	
							"size=40 $maxi maxlength=40",	 
						   "9",	
						   gettext("Insert the name"),
						   "" , "", "",	"", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$TYPE_default= "value='friend'";
}

$HD_Form -> AddEditElement (gettext("TYPE"),
                           "type",
                           '',
                           "INPUT",
                           "size=10 maxlength=6 $TYPE_default",
                           "",
                           gettext("Insert the type"),
                           "" , "", "", "", "" , "", "", gettext("type = friend | peer | user ( default : friend )"));

$HD_Form -> AddEditElement (gettext("USERNAME"),
                           "username",
                           '',
                           "INPUT",
                           "size=50 $maxi maxlength=40",
                           "",
                           gettext("Insert the username"),
                           "" , "", "", "", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("ACCOUNTCODE"),
                           "accountcode",
                           '',
                           "INPUT",
                           "size=20 $maxi maxlength=50",
                           "",
                           gettext("Insert the accountcode"),
                           "" , "", "", "", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("REGEXTEN"),
                           "regexten",
                           '',
                           "INPUT",
                           "size=20 maxlength=20",
                           "",
                           gettext("Insert the regexten"),
                           "" , "", "", "", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("CALLERID"),
                           "callerid",
                           '',
                           "INPUT",
                           "size=40 maxlength=60",
                           "",
                           gettext("Insert the callerid"),
                           "" , "", "", "", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax") 
	$AMAFLAGS_default= "value='".$A2B->config["peer_friend"]['amaflag']."'";
	
$HD_Form -> AddEditElement (gettext("AMAFLAGS"),
						   "amaflags",		
						   '',	
						   "INPUT",	
						   "size=10 maxlength=7 $AMAFLAGS_default",	
						   "",	
						   gettext("Insert the amaflags"),
						   "" , "", "",	"", "", "",	"", "(default : billing)" );


$HD_Form -> AddEditElement (gettext("SECRET"),
                           "secret",
                           '',
                           "INPUT",
                           "size=40 maxlength=40 $pass_secret",
                           "",
                           gettext("Insert the secret"),
                           "" , "", "", "", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("MD5SECRET"),
                           "md5secret",
                           '',
                           "INPUT",
                           "size=60 maxlength=50",
                           "",
                           gettext("Insert the md5secret"),
                           "" , "", "", "", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$NAT_default= "value='yes'";
}

$HD_Form -> AddEditElement (gettext("NAT"),
                           "nat",
                           '4',
                           "INPUT",
                           "size=60 maxlength=50 $NAT_default",
                           "",
                           gettext("Insert the nat"),
                           "" , "", "", "", "", "",	"", gettext("nat = yes | no | never | route ( default : yes )") );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$DTMFMODE_default= "value='RFC2833'";
}

$HD_Form -> AddEditElement (gettext("DTMFMODE"),
                           "dtmfmode",
                           '',
                           "INPUT",
                           "size=10 maxlength=7 $DTMFMODE_default",
                           "",
                           gettext("Insert the dtmfmode"),
                           "" , "", "", "", "", "",	"", gettext("dtmfmode = RFC2833 | INFO | INBAND | AUTO ( default : RFC2833 )"));


$HD_Form -> AddEditElement (gettext("QUALIFY"),
                           "qualify",
                           '',
                           "INPUT",
                           "size=8 maxlength=7",
                           "",
                           gettext("Insert the qualify"),
                           "" , "", "", "", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$CANREINVITE_default= "value='yes'";
}

$HD_Form -> AddEditElement (gettext("CANREINVITE"),
                           "canreinvite",
                           '',
                           "INPUT",
                           "size=20 maxlength=10 $CANREINVITE_default",
                           "",
                           gettext("Insert the canreinvite"),
                           "" , "", "", "", "", "",	"", gettext("canreinvite : yes | no ( default : yes )"));


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$DISALLOW_default= "value='all'";
}

$HD_Form -> AddEditElement (gettext("DISALLOW"),
                           "disallow",
                           '',
                           "INPUT",
                           "size=50 maxlength=40 $DISALLOW_default",
                           "",
                           gettext("Insert the disallow"),
                           "" , "", "", "", "", "",	"", gettext("need to disallow=all before we can use allow. ( default : all )"));


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$ALLOW_default= "value='ulaw,alaw,gsm,g729'";
}

$HD_Form -> AddEditElement (gettext("ALLOW"),
                           "allow",
                           '',
                           "INPUT",
                           "size=50 maxlength=40 $ALLOW_default",
                           "",
                           gettext("Insert the allow"),
                           "" , "", "", "", "", "",	"", gettext("Set allow codecs separated by a comma, e.g. gsm,alaw,ulaw ( default : ulaw,alaw,gsm,g729)"));


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$HOST_default= "value='dynamic'";
}

$HD_Form -> AddEditElement (gettext("HOST"),
                           "host",
                           '',
                           "INPUT",
                           "size=40 maxlength=31 $HOST_default",
                           "",
                           gettext("Insert the host"),
                           "" , "", "", "", "", "",	"", gettext("Use dynamic or set an IP ( default : dynamic )"));


$HD_Form -> AddEditElement (gettext("CALLGROUP"),
						   "callgroup",		
						   '',	
						   "INPUT",	
						   "size=10 maxlength=10",	
						   "",	
						   gettext("Insert the callgroup"),
						   "" , "", "",	"", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$CONTEXT_default= "value='".$A2B->config["peer_friend"]['context']."'";
}

$HD_Form -> AddEditElement (gettext("CONTEXT"),
						   "context",		
						   '',	
						   "INPUT",	
						   "size=40 maxlength=40 $CONTEXT_default",	
						   "",	
						   gettext("Insert the context"),
						   "" , "", "",	"", "", "",	"", gettext("set the context for this user (default : a2billing )"));


$HD_Form -> AddEditElement (gettext("DEFAULTIP"),
						   "defaultip",		
						   '',	
						   "INPUT",	
						   "size=20 maxlength=15",	
						   "",	
						   gettext("Insert the defaultip"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("FROMUSER"),
						   "fromuser",		
						   '',	
						   "INPUT",	
						   "size=40 maxlength=40",	
						   "",	
						   gettext("Insert the fromuser"),
						   "" , "", "",	"", "", "",	"", "" );



$HD_Form -> AddEditElement (gettext("FROMDOMAIN"),
						   "fromdomain",		
						   '',	
						   "INPUT",	
						   "size=40 maxlength=40",	
						   "",	
						   gettext("Insert the fromdomain"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("INSECURE"),
						   "insecure",		
						   '',	
						   "INPUT",	
						   "size=20 maxlength=30",	
						   "",	
						   gettext("Insert the insecure"),
						   "" , "", "",	"", "", "",	"", "" );



$HD_Form -> AddEditElement (gettext("LANGUAGE"),
						   "language",		
						   '',	
						   "INPUT",	
						   "size=10 maxlength=4",	
						   "",	
						   gettext("Insert the language"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("MAILBOX"),
						   "mailbox",		
						   '',	
						   "INPUT",	
						   "size=60 maxlength=50",	
						   "",	
						   gettext("Insert the mailbox"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("PERMIT"),
						   "permit",		
						   '',	
						   "INPUT",	
						   "size=60 maxlength=50",	
						   "",	
						   gettext("Insert the permit"),
						   "" , "", "",	"", "", "",	"", "" );



$HD_Form -> AddEditElement (gettext("DENY"),
						   "deny",		
						   '',	
						   "INPUT",	
						   "size=60 maxlength=50",	
						   "",	
						   gettext("Insert the deny"),
						   "" , "", "",	"", "", "",	"", "" );



$HD_Form -> AddEditElement (gettext("MASK"),
						   "mask",		
						   '',	
						   "INPUT",	
						   "size=60 maxlength=50",	
						   "",	
						   gettext("Insert the mask"),
						   "" , "", "",	"", "", "",	"", "" );



$HD_Form -> AddEditElement (gettext("PICKUPGROUP"),
						   "pickupgroup",		
						   '',	
						   "INPUT",	
						   "size=15 maxlength=10",	
						   "",	
						   gettext("Insert the pickupgroup"),
						   "" , "", "",	"", "", "", "", "");


$HD_Form -> AddEditElement (gettext("PORT"),
						   "port",		
						   '',	
						   "INPUT",	
						   "size=10 maxlength=5",	
						   "",	
						   gettext("Insert the port"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("RESTRICTCID"),
						   "restrictcid",		
						   '',	
						   "INPUT",	
						   "size=7 maxlength=1",	
						   "",	
						   gettext("Insert the restrictcid"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("RTPTIMEOUT"),
						   "rtptimeout",		
						   '',	
						   "INPUT",	
						   "size=7 maxlength=3",	
						   "",	
						   gettext("Insert the rtptimeout"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("RTPHOLDTIMEOUT"),
						   "rtpholdtimeout",		
						   '',	
						   "INPUT",	
						   "size=7 maxlength=3",	
						   "",	
						   gettext("Insert the rtpholdtimeout"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("MUSICONHOLD"),
						   "musiconhold",		
						   '',	
						   "INPUT",	
						   "size=50 maxlength=40",	
						   "",	
						   gettext("Insert the musiconhold"),
						   "" , "", "",	"", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$REGSECONDS_default= "value='0'";
}

$HD_Form -> AddEditElement (gettext("REGSECONDS"),	
						   "regseconds",		
						   '4',	
						   "INPUT",	
						   "size=50 maxlength=40 $REGSECONDS_default",	
						   "",	
						   gettext("Insert the regseconds"),
						   "" , "", "",	"", "", "",	"", "" );


$HD_Form -> AddEditElement (gettext("IPADDR"),
						   "ipaddr",		
						   '',	
						   "INPUT",	
						   "size=20 maxlength=15",	
						   "",	
						   gettext("Insert the ipaddr"),
						   "" , "", "",	"", "", "",	"", "" );


if ($form_action=="ask-add" ||  $form_action == "add_sip" || $form_action == "add_iax"){
	$CANCALLFORWARD_default= "value='yes'";
}

$HD_Form -> AddEditElement (gettext("CANCALLFORWARD"),
						   "cancallforward",		
						   '',	
						   "INPUT",	
						   "size=7 maxlength=3 $CANCALLFORWARD_default",	
						   "",	
						   gettext("Insert the cancallforward"),
						   "" , "", "",	"", "", "",	"", gettext("cancallforward = yes | no ( default : yes )"));



$HD_Form -> FieldEditElement ('id_cc_card, name, type, username, accountcode, regexten, callerid, amaflags, secret, md5secret, nat, dtmfmode, qualify, canreinvite, disallow, allow, host, callgroup, context, defaultip, fromuser, fromdomain, insecure, language, mailbox, permit, deny, mask, pickupgroup, port, restrictcid, rtptimeout, rtpholdtimeout, musiconhold, regseconds, ipaddr, cancallforward');



$HD_Form -> FG_FILTER_APPLY = true;
$HD_Form -> FG_FILTERFIELD = 'name';
$HD_Form -> FG_FILTERFIELDNAME = 'name';
$HD_Form -> FG_FILTER_FORM_ACTION = 'list';


if (isset($filterprefix)  &&  (strlen($filterprefix)>0)){
	if (strlen($HD_Form -> FG_TABLE_CLAUSE)>0) $HD_Form -> FG_TABLE_CLAUSE.=" AND ";
	$HD_Form -> FG_TABLE_CLAUSE.="name like '$filterprefix%'";
}

$HD_Form -> FG_INTRO_TEXT_EDITION= '';
$HD_Form -> FG_INTRO_TEXT_ASK_DELETION = gettext("If you really want remove this")." ".$HD_Form->FG_INSTANCE_NAME.", ".gettext("click on the delete button.");
$HD_Form -> FG_INTRO_TEXT_ADD = gettext("you can add easily a new").$HD_Form->FG_INSTANCE_NAME.".<br>".gettext("Fill the following fields and confirm by clicking on the button add.");





$HD_Form -> FG_INTRO_TEXT_ADITION = '';
$HD_Form -> FG_TEXT_ADITION_CONFIRMATION = gettext("Your new")." ".$HD_Form->FG_INSTANCE_NAME." ".gettext("has been inserted. <br>");


$HD_Form -> FG_BUTTON_EDITION_SRC = $HD_Form -> FG_BUTTON_ADITION_SRC  = Images_Path . "/cormfirmboton.gif";
$HD_Form -> FG_BUTTON_EDITION_BOTTOM_TEXT = $HD_Form -> FG_BUTTON_ADITION_BOTTOM_TEXT = gettext("Once you have completed the form above, click on the CONTINUE button.");



$HD_Form -> FG_GO_LINK_AFTER_ACTION_ADD = $_SERVER['PHP_SELF']."?atmenu=$atmenu&stitle=Document&wh=AC&id=";
$HD_Form -> FG_GO_LINK_AFTER_ACTION_EDIT = $_SERVER['PHP_SELF']."?atmenu=$atmenu&stitle=Document&wh=AC&id=";
$HD_Form -> FG_GO_LINK_AFTER_ACTION_DELETE = $_SERVER['PHP_SELF']."?atmenu=$atmenu&stitle=Document&wh=AC&id=";
?>
