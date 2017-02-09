$(document).ready(function () {
    //$('#submit_'+id).attr("disabled", false);
    $('.submitform').click(function (e) {
        id = $(this).data('id');
        itemid = $(this).data('item-id');

        e.preventDefault();
        var form = $('#'+id+'_form').serialize();

        $('#submit_'+id).attr("disabled", true);
        $('#submit_'+id).html("Sending please wait...");
        $("#loading-indicator").show();

        url = $(this).closest("div#"+id).find("form").attr("action");

        $.ajax({
            type: "POST",
            data: form+itemid+"&"+id+"[type]="+id,
            url: url,
            success:function(data) {
                if(data.message=='error'){
                    $("."+id+"_error").html(data.action);
                }else {
                    $('#'+id).modal('toggle');
                    $("#"+id+" input").val("");
                    $("#"+id+" textarea").html("");

                    $('.alertz').html("Successfully sent "+id+" form.");
                    $('.alertz').addClass("alert-success");
                    $('.alertz').removeClass("hide");
                    $('.alertz').show();

                    setTimeout(function(){$('.alertz').fadeOut(1000); }, 3000);
                }
                $('#submit_'+id).attr("disabled", false);
                $('#submit_'+id).html("Send");
                $("#loading-indicator").hide();
            },
            done: function(){
                $('#submit_'+id).attr("disabled", false);
                $('#submit_'+id).html("Send");
                $("#loading-indicator").hide();
            }

        });
    })
});