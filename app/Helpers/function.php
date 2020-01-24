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

function find_multidimensionKey(array $arr, $key) {
        
    // is in base array?
    if (array_key_exists($key, $arr)) {
        return true;
    }

    // check arrays contained in this array
    foreach ($arr as $element) {
        if (is_array($element)) {
            if (find_multidimensionKey($element, $key)) {
                return true;
            }
        }
        
    }

    return false;
}

function printRequired($text = '*', $title = 'Required'){
    return "<small class='text-danger' title='".$title."'>".$text."</small>";
}