<?php /* $Id$ */
//Copyright (C) 2006 Lenux Inc. (info@lenux.eu)
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
?>

<div class="rnav">
</div>

<?php
echo "<h2>" . _("Call Cost Administration") . "</h2>";

echo "<form name=\"generate\" action=\"config.php\" method=\"post\">\n";
echo "<input type=\"hidden\" name=\"display\" value=\"".$display."\" />\n";
echo "<input type=\"hidden\" name=\"type\" value=\"".$type."\" />\n";

echo "Generate the cdrcost database: ";
echo "<input type=\"hidden\" name=\"extdisplay\" value=\"gencost\" />\n";

echo "<input type=\"submit\" name=\"process\" value=\"Run\" />\n";

switch($extdisplay) {
	case 'gencost':
		fill_cdrcost();
	break;
}

?>
