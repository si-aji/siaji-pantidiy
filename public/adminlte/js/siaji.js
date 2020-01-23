/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
$(document).ready(function(){
    $("#navbar_search").bind('keydown keypress keyup change', function(){
        let value = $(this).val().toLowerCase();

        if(value != "" && value != undefined && value != null){
            $("#feature_result > li.placeholder").text('Search Result');

            $("#feature_result > li.result").hide().filter(function() {
                return $(this).text().toLowerCase().indexOf(value) > -1;
            }).show();
        } else {
            $("#feature_result > li.placeholder").text('Start to type');

            $("#feature_result > li.result").hide();
        }
    });
});

$("#navbar_search").bind('keydown keypress keyup change click focusin focusout', function(){
    console.log();
    if($(this).val() != ""){
        $("#feature_result").addClass('show');
    } else {
        $("#feature_result").removeClass('show');
    }
});

function removeInvalid(options = null){
    if(options != null){
        $("#"+options+" .form-control").removeClass('is-invalid');
        $("#"+options+" .invalid-feedback").remove();
    } else {
        $(".form-control").removeClass('is-invalid');
        $(".invalid-feedback").remove();
    }
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

function generatePreview(input, form_field = 'thumbnail'){
    console.log("Generate Preview is running...");
    console.log("Form Field : "+form_field);

    let preview_container = input.closest('#form-'+form_field).find('.sa-preview .img-preview');
    let preview_remove = input.closest('#form-'+form_field).find('.btn-preview_remove');

    // console.log(preview_container);
    // console.log(preview_remove);

    if (input[0].files[0] && input[0].files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview_container.attr('src', e.target.result);
        }

        reader.readAsDataURL(input[0].files[0]);
        preview_remove.prop('disabled', false);
    } else {
        $(preview_remove).click();
    }
}
function removePreview(input, old_value = '', form_field = 'thumbnail'){
    console.log("Remove Preview is running...");

    input.prop('disabled', true);
    let preview_container = input.closest('#form-'+form_field).find('.sa-preview .img-preview');
    let preview_input = input.closest('#form-'+form_field).find('.custom-file-input');
    let preview_label = input.closest('#form-'+form_field).find('.custom-file-label');
    
    console.log(preview_container);

    if(old_value != ''){
        preview_container.attr('src', old_value);
    } else {
        preview_container.removeAttr('src');
    }
    preview_input.val('');
    preview_label.text('Choose file');
}

$('.as-close').click(function(){
    $(this).parent().slideUp(function(){
        $(this).remove();
    });
    console.log($(this).parent());
});

function ucwords(str){
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });

    return str;
}

function markMatch(text, term){
    // Find where the match is
    var match = text.toUpperCase().indexOf(term.toUpperCase());
    var $result = $('<span></span>');

    // If there is no match, move on
    if (match < 0) {
        return $result.text(text);
    }

    // Put in whatever text is before the match
    $result.text(text.substring(0, match));
    // Mark the match
    var $match = $('<span class="select2-rendered__match" style="text-decoration: underline;"></span>');
    $match.text(text.substring(match, match + term.length));
    // Append the matching text
    $result.append($match);
    // Put in whatever is after the match
    $result.append(text.substring(match + term.length));

    return $result;
}