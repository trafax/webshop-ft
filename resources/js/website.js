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



     $('.option_select').change(function(){

        var total = parseFloat($('.default_price').data('default_price'));

        $('.option_select').each(function() {
            if ($(this).find(':selected').data('fixed_price')) {
                total = parseFloat($(this).find(':selected').data('fixed_price'));
            }
            else if (parseFloat($(this).find(':selected').data('adding_price'))) {
                total = (total + parseFloat($(this).find(':selected').data('adding_price')));
            }
        });

        $('.price').html('&euro; ' + Number(total).toLocaleString("nl-NL", {minimumFractionDigits: 2}));
     });

     $('.translate-field').on('click', function(){
        var $parent_id = $(this).data('parent_id');
        var $editor = $(this).data('editor');
        $.ajax({
            url: '/admin/translate',
            type: "get",
            data: {parent_id: $parent_id, field: $parent_id, editor: $editor},
            success: function(data) {
                $('body').append(data);
                $('.modal').modal('show');
                $('.modal').on('hidden.bs.modal', function (e) {
                    $('.modal').remove();
                });
            }
        });
        return false;
     });
});
