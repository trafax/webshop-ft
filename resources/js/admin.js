window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

    require('tinymce');
    require('tinymce/themes/silver');
    require('tinymce/plugins/link');
    require('tinymce/plugins/media');
    require('tinymce/plugins/image');

    window.sortable = require('jquery-ui/ui/widgets/sortable');

    window.filemanager = require('../../vendor/unisharp/laravel-filemanager/public/js/lfm.js');

    window.Dropzone = require('dropzone');

    tinymce.init({
        selector: '.editor',
        //inline: true,
        skin: false,
        language: 'nl',
        plugins: "link image media",
        convert_urls: 0,
        toolbar: 'formatselect | fontsizeselect | bold italic strikethrough | link image media'
    });

} catch (e) {}

$(function(){

    sort();

    // store the currently selected tab in the hash value
    $(".nav-tabs > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('.nav-tabs a[href="' + hash + '"]').tab('show');
});

window.sort = function()
{
    $('.sortable').sortable({
        delay: 300,
        update: function( event, ui ) {

           var action = $(this).data('action');
           var data = $(this).sortable('toArray');

           $.ajax({
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {'items' : data},
              url: action,
              type: 'POST',
              success: function(response)
              {
                  if (response.reload) {
                    window.location.reload();
                  }
              },
              dataType: 'json'
           });
        }
     });
}
