/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function removeInvalid(){
    $(".form-control").removeClass('is-invalid');
    $(".invalid-feedback").remove();
}

$('.as-close').click(function(){
    $(this).parent().slideUp(function(){
        $(this).remove();
    });
    console.log($(this).parent());
});