<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
</div>
<!--footer start here-->
<footer id="footer">
    <p><?php
        echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId, FatUtility::VAR_STRING, 'Copyright &copy; ' . date('Y') . ' <a href="javascript:void(0);">FATbit.com');
        echo " " . FatApp::getConfig("CONF_YOCOACH_VERSION", FatUtility::VAR_STRING, 'V1.0')
        ?> </p>
</footer>
<!--footer start here-->
</div>
<!-- Custom Loader -->
<div id="app-alert" class="alert-position alert-position--top-right">
    <alert role="alert" class="alert">
        <alert-icon class="alert__icon"></alert-icon>
        <alert-message class="alert__message"><p></p></alert-message>
        <alert-close class="alert__close" onclick="$.appalert.close();" ></alert-close>
    </alert>
</div>
<!--wrapper end here-->
</body>
</html>