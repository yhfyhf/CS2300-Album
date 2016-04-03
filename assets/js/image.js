/**
 * Created by yhf on 4/2/16.
 */
$(function() {
    $("p.logged span").click(function() {
        $("p.caption").hide();
        
        var form = $("form#edit_caption");
        form.css("display", "table");
        form.show();
        $("input#caption").css("width", "400px");
        $("input#caption").focus();
    });

    $("input#caption").focusout(function() {
        $("form#edit_caption").hide();
        $("p.caption").show();
    });

    
    $("button#btn-edit").click(function() {
        $(this).hide();
        $("form#edit_credit").css("display", "table");
        $("form#edit_credit").show();
        $("input#credit").css("width", "600px");
        $("input#credit").focus();
    });

    $("input#credit").focusout(function() {
        $("form#edit_credit").hide();
        $("button#btn-edit").show();
    });
});
