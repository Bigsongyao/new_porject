<?php

include(CLASS_ROOT.'sms.clsaa.php');

$sms = new sms();

if($_GPC['type'] == 'register'){

}elseif($_GPC['type'] == 'login'){

}elseif($_GPC['type'] == 'reset'){

}else{
    die(json_encode(in_success(0)));
}

