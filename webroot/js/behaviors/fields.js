$(function () {
    $('#data-type').change(function () {
        $('#typed, #existing, #new, #list-options, #linear-options, #grid-options').hide();
        switch ($(this).val())  {
            case 'single':
            case 'multiple':
                //show the list options id
                $('#list-options').show();
                $('#linear-options').find('input, select').val('');
                break;
            case 'linear':
                $('#linear-options').show();
                $('#list-options').find('input, select').val('');
                break;
            
        }
    });
    $('#source').change(function () {
        $('#typed, #existing, #new').hide();
        $('#' + $(this).val()).show();
        switch($(this).val()) {
            case 'typed':
                $('#existing, #new').find('input, select').val('');
                break;
            case 'existing':
                $('#typed, #new').find('input, select, textarea').val('');
                break;
            case 'new':
                $('#existing, #typed').find('input, select, textarea').val('');
                break;
        }
    });
    $('#data-type').change();
    $('#source').change();
    
    $('.sortable').disableSelection();
    $('.sortable').sortable({
        stop: function () {
            var $table = $('#registry-fields');
            var $registryId = $table.attr('registry');
            //get the current order
            var $order = [];
            $table.find('tbody tr').each(function (i) {
                $order.push($(this).attr('field'));
            });
            var $url = $settings.rootUrl +  'registry/registry-fields/sort';
            //alert($url);
            $.post($url, {'registry_id': $registryId, 'order': $order.toString()}, function ($response, $status) {
                //alert($response);
            });
        }
    });
});