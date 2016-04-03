/**
 * Created by yhf on 4/2/16.
 */
$(function() {
    $("button.delete_image").click(function() {
        var c = confirm("Delete this image?");
        if (c) {
            var id = $(this).attr('id').substr(12);
            var request = $.ajax({
                url: "delete.php",
                method: "POST",
                data: {"image_id": id},
                dataType: 'text',
                error: function(error) {
                    console.log(error);
                }
            });

            request.success(function(data) {
                if (data.trim() == 'true') {
                    $("div.image#image"+id).parent().remove();
                } else {
                    console.log(data);
                }
            });
        }
    });
});
