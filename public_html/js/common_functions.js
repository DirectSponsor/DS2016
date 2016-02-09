/**
 * This file is part of RepoMapper Framework
 *
 * @copyright Copyright (c) 2015 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$(document).ready(function(){
    var selectedLinkURL = '';
    $('button.btn-process-link').on('click', function(e) {
        selectedLinkURL = $(this).attr('URL');
        window.location.assign(selectedLinkURL);
        return true;
    });
    $('#project-info').on('shown.bs.collapse', function (){
        $("#project-info-icon").removeClass("glyphicon-plus-sign");
        $("#project-info-icon").addClass("glyphicon-minus-sign");
        $("#project-info-collapse-text").html("Hide Project Detail");
    })

    $('#project-info').on('hidden.bs.collapse', function(){
        $("#project-info-icon").removeClass("glyphicon-minus-sign");
        $("#project-info-icon").addClass("glyphicon-plus-sign");
        $("#project-info-collapse-text").html("Show Project Detail");
    })

    $('#recipient-info').on('shown.bs.collapse', function (){
        $("#recipient-info-icon").removeClass("glyphicon-plus-sign");
        $("#recipient-info-icon").addClass("glyphicon-minus-sign");
        $("#recipient-info-collapse-text").html("Hide Project Detail");
    })

    $('#recipient-info').on('hidden.bs.collapse', function(){
        $("#recipient-info-icon").removeClass("glyphicon-minus-sign");
        $("#recipient-info-icon").addClass("glyphicon-plus-sign");
        $("#recipient-info-collapse-text").html("Show Project Detail");
    })

});

