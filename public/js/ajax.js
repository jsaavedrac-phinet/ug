$(function(){
	$(document).on('click','button[type=submit]',function(event){

		if(!$(this).hasClass('trumbowyg-modal-submit')){
        event.preventDefault();
        const form = $(this).closest('form')[0];
        var data = new FormData(form);
        var action = form.action;
        if(action == null || action == ''){
            action = window.location.href;
        }
        console.log(action);
		var delete_message=false;
		for (var pair of data.entries()) {
		     if (pair[1]==="DELETE" || pair['1']==="delete") {
		    	delete_message = true;
		     }
		}

		if (delete_message) {
			Swal.fire({
			  title: "Estás seguro?",
			  text: "No podras recuperarlo en el futuro",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Sí, borralo!",
			  cancelButtonText: "Cancelar",

			}).then((result)=>{
				if(result.value){
					send();
				}
			})
		}else{
			send();
		}


		function send(){
			Swal.fire({
			  title: 'Por favor, espere...',
			  showConfirmButton: false,
			});
			$.ajax({
				url: action,
				data: data,
				type: 'POST',
				contentType: false,
				processData: false,
                cache: false,
                beforeSend: function(request) {
                    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                },
				success: function(data){
                    console.log(data);
                    if(data.type != null && data.type == "error"){
						Swal.fire({
							  type: 'error',
							  title: 'Oops...',
							  html: data.message,
							  footer: '<center>Toma una captura y enviala al soporte para ayudarte con el problema</center>'
						})
					}else if(data.message != null){
                        localStorage.setItem('mensaje',data.message);
                        if(data.redirect != null){
                            window.location.href = data.redirect;
                        }else if(data.function != null && data.function != 'reload'){
                            localStorage.removeItem('mensaje');
                            Swal.fire('Proceso Completado',data.message,'success');
                            eval(data.function + '()');
                        }
                        else if(data.function == 'reload'){
                            window.location.reload();
                        }else{
                            localStorage.removeItem('mensaje');
                            Swal.fire('Proceso Completado',data.message,'success');
                        }

					}else{
						Swal.fire({
							  type: 'error',
							  title: 'Oops...',
							  html: 'Algo salió mal!',
							  footer: '<center>Toma una captura y enviala al soporte para ayudarte con el problema</center>'
						})
					}

				},
				complete: function(xhr, status){
                    console.log('xhr',xhr);
                    console.log('status',status);
				}
			})
		}
		}



	});

});
