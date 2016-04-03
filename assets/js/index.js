/**
 * Created by yhf on 3/21/16.
 */
$(function() {
    $('input').on('change', function() {
        var input = $(this);
        if (input.val().length) {
            input.addClass('populated');
        } else {
            input.removeClass('populated');
        }
    });

    $("p.title").click(function() {
        var id = $(this).attr('id').substr(5);
        $(this).hide();
        var form = $("form#edit_title"+id);
        form.css("display", "table");
        form.show();
        form.find("input#title").css("width", "300px");
        form.find("input#title").focus();
    });

    $("input.title").focusout(function() {
        var id = $(this).attr('data-index');
        $("form#edit_title"+id).hide();
        $("p.title#title"+id).show();
    });

    $("p.description").click(function() {
        var id = $(this).attr('id').substr(11);
        $(this).hide();
        var form = $("form#edit_description"+id);
        form.css("display", "table");
        form.show();
        form.find("input#description").css("width", "300px");
        form.find("input#description").focus();
    });

    $("input.description").focusout(function() {
        var id = $(this).attr('data-index');
        $("form#edit_description"+id).hide();
        $("p.description#description"+id).show();
    });
});
