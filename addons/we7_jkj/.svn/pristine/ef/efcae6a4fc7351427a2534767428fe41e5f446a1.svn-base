<?php
include(FUN_ROOT.'product.fun.php');

$type = isset($_GPC['type']) ? intval($_GPC['type']) : 0;

$data = get_category_list($type);

die(json_encode(in_success(0, $data)));