window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

    window.sortable = require('jquery-ui/ui/widgets/sortable');

} catch (e) {}

$(function(){
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
});
