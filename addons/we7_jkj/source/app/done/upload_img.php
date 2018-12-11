<?php

load()->func('file');

$result = file_upload($_FILE['image'], 'image');
if(is_error($result)){
    die(json_encode(in_error(1, $result['message'])));
}else{
	die(json_encode(in_success(0, $result['path'])));
}