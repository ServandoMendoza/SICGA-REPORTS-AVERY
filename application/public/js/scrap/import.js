/**
 * Created by servandomendoza on 4/17/15.
 */
$(function(){
    $('#generar').click(function(){
        $(this).html('Leyendo archivo... espere porfavor');
        $(this).attr('disabled', true);

        setTimeout(function(){
            $('#upload-form').submit()
        },500);
    });
});