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

function generateSlug(source, destination){
    var title = $("#"+source).val();
    var slug = title
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');
    if(slug.slice(-1) == "-"){
        slug = slug.slice(0, -1);
    }
    
    $("#"+destination).val(slug);
}

$('.as-close').click(function(){
    $(this).parent().slideUp(function(){
        $(this).remove();
    });
    console.log($(this).parent());
});