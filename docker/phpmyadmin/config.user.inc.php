<?php
    $cfg['LoginCookieValidity'] = (86400 * 30); //86400 is 24 hours in seconds. Therefore, this is 30 days.
    ini_set('session.gc_maxlifetime', (86400 * 30));
