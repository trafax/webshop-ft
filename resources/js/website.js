window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

    window.sortable = require('jquery-ui/ui/widgets/sortable');

    var tinymce = require('tinymce/tinymce');
    require('tinymce/themes/silver');
    require('tinymce/plugins/link');
    require('tinymce/plugins/media');
    require('tinymce/plugins/image');
    require('tinymce/plugins/paste');
    require('tinymce/plugins/lists');
    require('tinymce/plugins/advlist');

    window.simpleParallax = require('simple-parallax-js');

    window.Dropzone = require('dropzone');

    tinymce.init({
        selector: '.inline-editor',
        inline: true,
        language: 'nl',
        plugins: ['link', 'image', 'media', 'lists', 'paste', 'advlist'],
        link_list: "/admin/page/tinymce",
        image_title: true,
        menu_bar: false,
        paste_data_images: true,
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/admin/asset/upload_tinymce');
            xhr.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename);
            xhr.send(formData);
            },
        convert_urls: 0,
        toolbar: 'formatselect | fontsizeselect | bold italic strikethrough | numlist bullist | link image media',
        setup: function (editor) {
            editor.on('blur', function (e) {
                var content = editor.getContent();
                var object = $($(e)[0].target.bodyElement);
                var identifier = $(object).data('identifier');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $.extend($(object).data(), {'content': content, 'identifier' : identifier}),
                    //url: $(object).data('action') ? $(object).data('action') : '/admin/page/update_content',
                    url: $(object).data('action'),
                    type: 'PUT'
                });
            });
        }
    });

} catch (e) {}

$(function(){

    $('.sortable').sortable({
        delay: 300,
        handle: '.handle',
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
        var $enable_default = $(this).data('enable_default');
        $.ajax({
            url: '/admin/translate',
            type: "get",
            data: {parent_id: $parent_id, field: $parent_id, editor: $editor, enable_default: $enable_default},
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
