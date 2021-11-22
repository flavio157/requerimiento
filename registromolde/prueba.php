<?php
    function isMobile() {
        return preg_match("/(Android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|Palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    if(isMobile()){
        echo "movil";
    }
    else {
        echo "escritorio";     
    }
?>