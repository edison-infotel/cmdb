<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 CMDB plugin for GLPI
 Copyright (C) 2015-2022 by the CMDB Development Team.

 https://github.com/InfotelGLPI/CMDB
 -------------------------------------------------------------------------

 LICENSE

 This file is part of CMDB.

 CMDB is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 CMDB is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with CMDB. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

global $DB;
if (strpos($_SERVER['PHP_SELF'], "dropdownStateOperationprocesses.php")) {
   header("Content-Type: text/html; charset=UTF-8");
   Html::header_nocache();
}

Session::checkCentralAccess();

// Make a select box
if (isset($_POST["operationprocessstate"])) {
   $used = [];

   // Clean used array
   if (isset($_POST['used'])
       && is_array($_POST['used'])
       && (count($_POST['used']) > 0)) {
       $criteria = [
           'FROM' => 'glpi_plugin_cmdb_operationprocesses',
           'WHERE' => [
               'id' => $_POST['used'],
               'plugin_cmdb_operationprocessstates_id' => $_POST["operationprocessstate"]
           ]
       ];

       foreach ($DB->request($criteria) AS $data) {
           $used[$data['id']] = $data['id'];
       }
   }

   Dropdown::show('PluginCmdbOperationprocess',
                  ['name'      => $_POST['myname'],
                        'used'      => $used,
                        'width'     => '50%',
                        'entity'    => $_POST['entity'],
                        'rand'      => $_POST['rand'],
                        'condition' => ["plugin_cmdb_operationprocessstates_id" => $_POST["operationprocessstate"]]]);

}
