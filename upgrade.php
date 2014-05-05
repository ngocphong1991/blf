<?php
require_once("include/db_connection.php");
mysql_query("ALTER TABLE `textad` CHANGE `length` `length` INT NOT NULL DEFAULT '0' ");
mysql_query("ALTER TABLE `imagead` CHANGE `length` `length` INT NOT NULL DEFAULT '0' ");
mysql_query("ALTER TABLE `videoad` CHANGE `length` `length` INT NOT NULL DEFAULT '0' ");
mysql_query("delete from country where country='Portugal' limit 1");
mysql_query("INSERT INTO `country` (
`countrysel` ,
`country` ,
`status`
)
VALUES (
NULL , 'Portugal', 'Y'
)");

?>