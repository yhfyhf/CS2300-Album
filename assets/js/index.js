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

    setTimeout(function() {
        $('#fname').trigger('focus');
    }, 500);

    $('div.movie').mouseover(function() {
        var index = this.id;
        if (index != 0) {
            $("li#close"+index).show();
        }
    });

    $('div.movie').mouseout(function() {
        var index = this.id;
        if (index != 0) {
            $("li#close"+index).hide();
        }
    });

    $("li.close").click(function() {
        var $index = this.id.substr(5);
        var r = confirm("Delete this movie?");
        if (r) {
            $.post( "delete.php", { index: $index})
                .done (function() {
                    //$("div.movie#"+$index).remove();
                    window.location.href="index.php";
                });
        }
    });
});
