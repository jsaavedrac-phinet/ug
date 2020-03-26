$(function(){
	function validar(){
		var validar = false;
		if ($('#user').val() == "") {
			Swal.fire(
			  'Error',
			  'Campo vacío: Usuario',
			  'warning'
			)
		}else if ($('#password').val()== "") {
			Swal.fire(
			  'Error',
			  'Campo vacío: Clave',
			  'warning'
			)
		}else{

			validar=true;
		}

		return validar;
	}

	function acceso(){

		if (validar()) {
			Swal.fire({
			  title: 'Por favor, espere...',
			  showConfirmButton: false,
			});
		    var data = new FormData($('form')[0]);
			$.ajax({
				url: window.location.href,
				data: data,
				type: 'POST',
				contentType: false,
				processData: false,
				cache: false,
				success: function(data){
					if (data.rpta=="1") {
						window.location = window.location.href;
					}else{
						Swal.fire({
						  type: 'error',
						  title: 'Oops...',
						  text: 'Usuario y/o clave erróneos',
						  // footer: '<a href>Why do I have this issue?</a>'
						})
					}
				},
				error: function(xhr, status){
					console.log("error status",xhr.status);
					if(xhr.status == 419){
						window.location.reload();
					}
				}
			})
		};
	}

	$('#btn_ingresar').click(function(){acceso();});

	$(document).keypress(function(e) {
       if(e.which == 13) {
          // Enviar formulario.
         $('#btn_ingresar').click();
       }
    });
});
