/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
var dataTemplate = {};
$(document).ready(function(){
    var navHght = parseInt($('#navbar_main').css('height'));
    navHght +=25;
    $('#page_container').css('margin-top', navHght+'px');
    $('input[onkeyup]').each( function() {
        $(this).trigger('onkeyup');
    });
    $('textarea[onkeyup]').each( function() {
        $(this).trigger('onkeyup');
    });
    $('.deleteProduct').on('click', function(evt) {
        if (!confirm("Please confirm you want to delete this Product?")) {
            evt.preventDefault();
        }
    });
    $('.deleteDistributor').on('click', function(evt) {
        if (!confirm("Please confirm you want to delete this Distributor?")) {
            evt.preventDefault();
        }
    });
    if($('select.selectpicker')) {
        $('select.selectpicker').selectpicker({
            dropupAuto: false
        });
    }

});
function textCounter(field, field2, maxlimit)
{
    var countfieldId = "#"+field2;
    if (field.value.length > maxlimit) {
        field.value = field.value.substring(0, maxlimit);
        $(countfieldId).html('0');
        alert('Over character limit');
        return false;
    } else {
        var remainingChars = maxlimit - field.value.length;
        $(countfieldId).html(remainingChars);
    }
}
function ajax_update(url, type, postObj) {
    var json_obj = {};
    var data = dataTemplate;
    data["_token"] = token;
    for(var key in postObj) {
        data[key] = postObj[key];
    }
    $.ajax({
        async: false,
        type: type,
        data: data,
        url: url,
        dataType: "json",
        success: function (json_arr, msg) {
            json_obj = json_arr;
        },
        error: function (data, status, e)
        {
            json_obj['result'] = 'error';
            json_obj['errormsg'] = 'Unexpected System Error - Contact System Administrator\n\n' + e;
            alert(json_obj['errormsg']);
        }
    });
    return(json_obj);
}
