(function($){

	$( ".sortable" ).sortable({
		stop: function(event, ui){
			console.log('hacer ajax para ordenar');
			var listado = $('.sortable li');
			var curules = [];
			$.each(listado, function(index, value){
				var item = {};
				item.id = value.id;
				item.order = index + 1;

				curules.push(item);
			})
			$.ajax({
				url: ajaxurl,
				//dataType: 'JSON',
				data: {
					action: 'oda_reordenar_curules',
					data: curules
				},
				beforeSend: function(){
					$('.rotating').removeClass('hide');
				},
				success: function(response) {
					location.reload();
				}
			})
			//console.log(curules)
		}
	});
    $( ".sortable" ).disableSelection();

	$('#oda_ciudad_owner').change(function(e){
        //console.log($(this).val());
        
		$.ajax({
			url : ajaxurl,
			dataType: 'json',
			data: {
				action: 'oda_miembros_carga_circunscripcion',
				id_post: $(this).val()
			},
			beforeSend: function(){
				$('#oda_circunscripcion_owner').prop('disabled', true);
                $( '<i id="loading" class="fas fa-spin fa-circle-notch"></i>' ).insertAfter( '#oda_circunscripcion_owner' );
			},
			success: function(response){
                if ( null == response ) {
					console.log('no tiene nada');
					$('#oda_circunscripcion_owner').remove();
					$('.cmb2-id-oda-circunscripcion-owner .cmb-td')
						.html('Aún no tiene circunscripciones agregadas a esta ciudad por favor agregue una.');
				}else{
					var html = '<select class="cmb2_select" name="oda_circunscripcion_owner" id="oda_circunscripcion_owner" data-hash="5l2vgnn60fh0" required="required"</select>';					
					if ( !$('#oda_circunscripcion_owner').length ){
						$('.cmb2-id-oda-circunscripcion-owner .cmb-td').html('');
						$('.cmb2-id-oda-circunscripcion-owner .cmb-td').append(html);
					}
					$('#oda_circunscripcion_owner').html('');
					html = '<option>Ninguno</option>';					
					$.each(response, function(index, value){
						console.log(oda_miembro_object.circunscripcion, value);
						if (oda_miembro_object){
							if(oda_miembro_object.circunscripcion == value.id){
								html += '<option value="'+value.id+'" selected="selected">' + value.title + '</option>';
							}else{
								html += '<option value="'+value.id+'">' + value.title + '</option>';
							}
						}else{
							html += '<option value="'+value.id+'">' + value.title + '</option>';
						}
					})
					$('#oda_circunscripcion_owner').append(html);
					setTimeout(() => {
						$( '#loading' ).remove();
						$('#oda_circunscripcion_owner').prop('disabled', false);
					}, 500);
				}
            }
        });
	});

})(jQuery);