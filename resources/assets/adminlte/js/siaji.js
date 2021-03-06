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