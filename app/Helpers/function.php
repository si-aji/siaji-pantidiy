<?php

// New, Old, Method
function arr_diff($new_arr, $old_arr, $method)
{
    $data = null;
    switch($method){
        case 'add':
            $data = array_diff($new_arr, $old_arr);
            break;
        case 'remove':
            $data = array_diff($old_arr, $new_arr);
            break;
    }

    return $data;
}

function printRequired($text = '*', $title = 'Required'){
    return "<small class='text-danger' title='".$title."'>".$text."</small>";
}