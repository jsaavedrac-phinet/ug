$(function(){
	
	$( ".data-sort" ).sortable({
		cursor: "move",
		forceHelperSize: true,
		beforeStop:function(event,ui){
			
			let filas = $(".data-sort .sortable");
			let nuevas_filas = new Array();
			let contador = 1;

			$.each(filas,function(){
				if (!$(this).hasClass('ui-sortable-placeholder')) {
					let elemento = $(this);
					let item = new Array(elemento.find('label').attr('id'),contador++);
					nuevas_filas.push(item);
					elemento.removeClass('ui-sortable-handle');
				}
			})
			$('#nuevas_filas').val(JSON.stringify(nuevas_filas));
		},
	});

	
});