$(function () {
    $('.multiselect').multicheckbox();
    $('.linear-control').slider();
    $('.datepickers').datepicker({
        format: 'dd/mm/yyyy'
    });
    $('.timepickers').timepicki();
    $('.allow-others-control').each(function () {
        if ($(this).hasClass('multiselect')) {
            $(this).parents('div.input').find('label:last').find('input[type="checkbox"]').click(function () {
                initOthersMultiple($(this));
            });
        } else {
            $(this).change(function () {
                initOthersSingle($(this));
            })
        }
    });
});

var initOthersMultiple = function ($ele) {
    if ($ele.is(':checked')) {
        var $val = prompt('Enter value');
        $ele.attr('value', $val);
        var $parent = $ele.parent('label');
        $parent.append("<span id='others-entry'>(<span id='others-value'>" + $val + "</span>)</span>");
        $parent.parents('div.input').find('option:last').attr('value', $val);
    } else {
        $ele.attr('value', 'Others');
        var $parent = $ele.parent('label');
        var $val = $parent.find('span#others-value').text();
        $parent.find("span#others-entry").empty().remove();
        $parent.parents('div.input').find('option:last').attr('value', 'Others');
    }
}

var initOthersSingle = function ($ele) {
    var $selected = $ele.find('option:selected');
    if($selected.is(':last')) {
        var $val = prompt('Enter value');
        $selected.attr('value', $val);
        $selected.text("Others (" + $val + ")");
    } else {
        $ele.find('option:last').attr('value', 'Others').text('Others');
    }
}