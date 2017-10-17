/* Lightbox Modal */
$(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

/* So we can access all around, a slutty variable */
var clone_count = 1;
var active_clone = 1;
var idleTime = 0;

$(function () {
    /* Scroll Skin */
    $('.search-form').collapse('show');

    $(".scroll-container").customScrollbar();

    /* Initializing Carousel */
    $(".carousel-indicators li").first().addClass('active');
    $(".carousel-inner .item").first().addClass('active');

    /* Forced Validations */
    $('input[type=number]').bind('keypress', function (event) {
        var charCode = event.which || event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    });

    /* Initialize Gallery */
    $("#lightGallery").lightGallery();

    /* Clonable Inputs for Multiple Entries */

    /* Let's brand the first victim... haha, just giving unique ids to the first clonable group */
    $(".clone-wrap").find('input:not(#multiple_entity)input:not(#binding_field)').each(function () {
        $(this).addClass($(this).attr('id') + '-' + clone_count);
    }).attr('data-identity', clone_count);
    $(".clone-wrap").addClass('clone-id-' + clone_count).attr('data-identity', clone_count);

    clone_count = clone_count + 1;

    $(".clonable .add-clonable").bind('click', function () {
        create_clone($(this));

        return false;
    });

    $(".clonable input").bind('keyup', function () {
        var _value_field = "#" + $(this).attr('data-target');
        parse_inputs(_value_field);
    });

    /* Multiple Track Uploads */
    $(".clone-wrap").bind('mouseover', function () {
        active_clone = $(this).attr('data-identity');
    });

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function check_session() {
    $.ajax({
        type: 'POST',
        url: base_url + 'ajax/auth/check_session',
        data: {
            csrf_token: csrf_token
        }, // Choosing a JSON datatype
        success: function (data) {
            if (data === 1) {
                //your session is not expired
            } else {
                //your session is already expired
                alert('Your session has expired, please login again!');
                window.location.href = base_url + 'logout';
            }
        }
    });
}

function timer_increment() {
    idleTime = idleTime + 1;
    if (idleTime > 5) { // 20 minutes
        check_session();
    }
}

function create_clone(_this) {
    var _clone = _this.parent('.clone-wrap').clone();
    _clone.attr('class', 'clone-wrap');
    _clone.find('.add-clonable').remove();
    _clone.find('input:not(#multiple_entity)input:not(#binding_field)').val('').bind('keyup', function () {
        _value_field = "#" + $(this).attr('data-target');
        parse_inputs(_value_field);
    });
    /* Brand this mofos like a cow moooooo */
    _clone.find('input:not(#multiple_entity)input:not(#binding_field)').each(function () {
        // reset this
        $(this).attr('class', 'form-control');

        $(this).removeClass($(this).attr('id') + '-' + Math.abs(clone_count - 1));
        $(this).addClass($(this).attr('id') + '-' + clone_count);
        $(this).attr('data-identity', clone_count);
    });

    /* Multiple Uploads Fix */
    _clone.bind('mouseover', function () {
        active_clone = $(this).attr('data-identity');
        // console.log(active_clone);

        $("#upload_queue").data('uploadifive').settings.formData = {
            'csrf_token': csrf_token,
            'identity': active_clone
        };

        if (!$(this).hasClass('button-active')) {
            var position = $(this).find('.queue-trigger').position();
            $("#upload_queue_container").css({
                'position': 'absolute',
                'margin-top': Math.abs(position.top - 182) + 'px',
                'float': 'left',
                'z-index': '9999',
                'display': 'block'
            });
            $(this).addClass('button-active');
        }
    }).bind('mouseout', function () {
        if ($(this).hasClass('button-active')) {
            $("#upload_queue_container").hide();
            $(this).removeClass('button-active');
        }
    });

    // Add the new branding
    _clone.addClass('clone-id-' + clone_count).bind('mouseover', function () {
        active_clone = $(this).attr('data-identity');
    });
    _clone.attr('data-identity', clone_count);
    // Add Remove Button
    _this.parent('.clone-wrap').parent('.clonable').append(_clone);

    clone_count = clone_count + 1;

    return false;
}

function parse_inputs(_target_field) {
    var input_value = [];
    $('.clone-wrap').each(function () {
        _group_values = [];
        $(this).find('input').each(function () {
            var __name = $(this).attr('name');
            if (__name !== undefined && __name.length) {
                var _temp = [__name, $(this).val()];
                _group_values.push(_temp);
            }
        });
        input_value.push(_group_values);
    });
    console.log(input_value);
    $(_target_field).val(JSON.stringify(input_value));
}

/* Miscellaneous */
function goBack() {
    window.history.back();
}

function redirect(url) {
    window.location.href = url;
}

function message(_string) {
    $(".message-container").empty().text(_string);
}

function error(_string) {
    $(".error-container").empty().text(_string);
}

function setVal(target, value) {
    $(target).val(value);
}

/* Search */

function showSearchForm(hideResults) {
    $('.search-form').collapse('show');
    $('.search-form-controls').hide();
    if (hideResults) {
        $('.search_results_container').collapse('hide').empty();
    }
}

function loadResultBlock(results) {
    $('.search-form').collapse('hide');
    $('.search-form-controls').show();
    $('.search_results_container').empty().collapse('hide');
    $('.search_results_container').append(results).collapse('show');
}

/* End Search */

function executeFunctionByName(functionName, context /*, args */) {

    // Check if this is a json response
    /*
     try {
     var parameters = JSON.parse(response.params);
     } catch (e) {
     var parameters = response.params
     }
     */

    var args = [].slice.call(arguments).splice(2);
    var namespaces = functionName.split(".");
    var func = namespaces.pop();
    for (var i = 0; i < namespaces.length; i++) {
        context = context[namespaces[i]];
    }
    return context[func].apply(this, args);
}

/* Entities */
function entity_edit(entity, identifier) {
    window.location.href = base_url + 'entity/edit/' + entity + '/' + identifier;
}

function entity_delete(entity, identifier) {
    $.ajax({
        type: "POST",
        url: base_url + 'entity/v1/' + entity + '/delete',
        data: {
            return_url: window.location.href,
            entity_id: identifier,
            csrf_token: csrf_token
        },
        dataType: 'json' // Choosing a JSON datatype
    }).done(function (response) {
        executeFunctionByName(response.callback, window, response.params);
    });
}
/* End Entities */

/* Blocks */

/* End Blocks */

/* Debug Tools */
function _ding() {
    alert('');
}

function _alert(str) {
    alert(str);
}

function _console(str) {
    console.log(str);
}
/* End Debug Tools */

/* File Uploads */
function refresh_files()
{
    $.get('./upload/files/')
            .success(function (data) {
                $('#files').html(data);
            });
}


/* Useful Function */
var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)));
            }
    , format = function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
        });
    };
    return function (table, name) {
        if (!table.nodeType)
            table = document.getElementById(table);
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML};
        window.open(
                uri + base64(format(template, ctx)),
                '_blank' // <- This is what makes it open in a new window.
                );
    }
    ;
})();

/* String Generation for uploads */

function token(str) {
    $.ajax({
        type: "POST",
        url: base_url + 'upload/generate_token',
        data: {
            'tokenize': str,
            'csrf_token': csrf_token
        },
        dataType: 'json'
    }).done(function (response) {
        return response.token;
    });
}

