<?php 
if (!defined("WP_UNINSTALL_PLUGIN")) {
	exit();
}

delete_option("rj_cm_message");
delete_option("rj_cm_read_more");
delete_option("rj_cm_close_message");
delete_option("rj_cm_link_to_more_info");
?>