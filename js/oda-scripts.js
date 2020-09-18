$(document).ready(function(){
    $('.excusa_miembro').change(function(e){
        var suplente = $(this).data('option');
        if ($(this).is(':checked')){
            if ($('#'+suplente).is('select')) {
                $('#'+suplente).removeAttr('disabled');
            }else{
                $('#'+suplente).removeClass('disabled');
            }
        }else{
            if ($('#'+suplente).is('select')) {
                $('#'+suplente+' option:selected').prop("selected", false);
                $('#'+suplente).attr('disabled', true);
            }else{
                $('#'+suplente).addClass('disabled');
            }
        }
    })
})
