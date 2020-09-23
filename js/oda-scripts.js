$(document).ready(function () {
    $('.excusa_miembro').change(function (e) {
        var suplente = $(this).data('option');
        if ($(this).is(':checked')) {
            if ($('#' + suplente).is('select')) {
                $('#' + suplente).removeAttr('disabled');
            } else {
                $('#' + suplente).removeClass('disabled');
            }
        } else {
            if ($('#' + suplente).is('select')) {
                $('#' + suplente + ' option:selected').prop("selected", false);
                $('#' + suplente).attr('disabled', true);
            } else {
                $('#' + suplente).addClass('disabled');
            }
        }
    });


    jQuery('#oda_solicitud_instituciones').on('change', function (e) {
        ajaxurl
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'oda_solicitud_instituciones',
                idInstitucion: jQuery(this).val()
            },
            success: function (response) {
                if (response.success == true) {
                    jQuery.each(response.data, function (key, value) {
                        jQuery('#oda_solicitud_persona_requerida').append(jQuery("<option />").val(value).text(value));
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
})
