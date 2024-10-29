<?php
require_once AYS_SB_DIR . '/includes/social-buttons.php';

if ( is_admin() )
	require_once AYS_SB_DIR . '/admin/admin.php';
else
	require_once AYS_SB_DIR . '/includes/controller.php';
?>