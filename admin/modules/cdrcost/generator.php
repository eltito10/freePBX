#!/usr/bin/php

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

// this file should called through cron
// eg. link cdrcost into /etc/cron.d/
// ln -s /var/www/html/admin/modules/cdrcost/cdrcost /etc/cron.d/

require_once('../../functions.inc.php');
// get settings
$amp_conf = parse_amportal_conf("/etc/amportal.conf");
// connect to database
require_once('../../common/db_connect.php');
// cdrcost's functions
require_once('functions.inc.php');

fill_cdrcost();

?>
