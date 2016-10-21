/**
 * Created by servandomac on 3/12/15.
 */
function getSubAreas()
{
    var obj = {
        id_area : $("#id_area").val()
    };

    $.ajax({
        type: "POST",
        url: ajaxGetSubAreas,
        data: obj,
        dataType: "json",
        async: false,
        cache:false,
        success: function(data){
            if(data.subareas != null)
            {
                $.each(data.subareas, function( key, value ) {
                    $("#id_sub_area").append('<option value='+value.id+'>'+value.name +'</option>');
                });
            }
            else{
                $("#id_sub_area").append('<option value="0">No se encontraron subareas...</option>');
            }
        }
    });
}

function validateNext(){
    if($("#id_area").val() <= 0){
        alert("Debe elegir un area");
        $("#id_area").focus();
        return false;
    }

    if($("#id_sub_area").val() <= 0){
        alert("Debe elegir una subarea");
        $("#id_sub_area").focus();
        return false;
    }

    return true;
}

$(function(){
    $("#id_area").change(function(){
        $("#id_sub_area").html('');

        if($(this).val() > 0)
            getSubAreas();
    });

    $('#next').click(function(){
        if(!validateNext())
            return false;
    });
});