(function( $ ) {
	'use strict';

	$(function() {

		$('#dplr-form-connect').submit(function(e){

			e.preventDefault();

			var f = $(this);
			var button = f.children('button');
			var userfield = $('input[name="dplr_learnpress_user"]');
			var keyfield = $('input[name="dplr_learnpress_key"]');

			$('#dplr-form-connect .error').remove();

			var data = {
				action: 'dplr_ajax_connect',
				user: userfield.val(),
				key: keyfield.val()
			}

			$('.doppler-settings .error').remove();
			$('#dplr-messages').html('');

			if(data.user === ''){
				userfield.after('<span class="error">Mensaje de error</span>');
			}

			if(data.key === ''){
				keyfield.after('<span class="error">Mensaje de error</span>');
			}

			if( data.user === '' || data.key === '' ){
				return false;
			}

			button.attr('disabled','disabled');

			$.post( ajaxurl, data, function( response ) {
				if(response == 0){
					$("#dplr-messages").html('Mensaje de datos incorrectos');
					button.removeAttr('disabled');
				}else if(response == 1){
					var fields =  f.serialize();
					$.post( 'options.php', fields, function(obj){
						window.location.reload(false); 					
					});
				}
			})
		
		}); 

		$("#dplr-save-list").click(function(e){

			e.preventDefault();			
			var listName = $(this).closest('form').find('input[type="text"]').val();

			if(listName!==''){
				
				var data = {
					action: 'dplr_ajax_save_list',
					listName: listName
				};

				listsLoading();

				$.post( ajaxurl, data, function( response ) {

					var body = 	JSON.parse(response);
					
					if(body.createdResourceId){
						
						var html ='<tr>';
						html+='<td>'+body.createdResourceId+'</td><td><strong>'+listName+'</strong></td>';
						html+='<td>0</td>';
						html+='<td><a href="#" class="text-dark-red" data-list-id="'+body.createdResourceId+'">Delete</a></td>'
						html+='</tr>';

						$("#dplr-tbl-lists tbody").prepend(html);

					}else{
						
						if(body.status == '400'){
							alert(body.title);
						}
					}

					listsLoaded();

				});
			
			}

		});

		$("#dplr-form-list select").change(function(){
			$("#btn-synch").css('display','none');
			$(this).closest('tr').find('td span').html(
				$('option:selected', this).attr('data-subscriptors')
			);
		});

		if($('#dplr-dialog-confirm').length>0){
			$("#dplr-dialog-confirm").dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width: 400,
				modal: true
			});
		}
	
		$("#dplr-tbl-lists tbody").on("click","tr a",deleteList);

		$("#view-students-list").click(function(){
			var frame = $("#students-frame");
			if(frame.css('display')=='block'){
				frame.css('display','none');
				$(this).html('View');
			}else{
				frame.css('display','block');
				$(this).html('Hide');
			}
		});

		$("#btn-synch").click(function(){
			var button = $(this);
			$('.doing-synch').css('display','inline');
			$('.synch-ok').css('display', 'none');
			button.attr('disabled','true');
			var emails = $('.subscribers-item');
			var subscribers = [];
			for(var i=0; i<emails.length; i++){
				subscribers[i] = emails[i].value;
			}
			
			var data = {
				action: 'dplr_lp_ajax_synch',
				subscribers: subscribers,
			}
			
			var synchBuyers = function() {
				var deferred = new $.Deferred();
				$.post( ajaxurl, data, function( response ){
					deferred.resolve(response);
				})
				return deferred.promise();
			}
			
			synchBuyers().then(function( response ){
				//$('.buyers-count').html('...');
				if(response == 1){
					$.post(ajaxurl,{action: 'dplr_ajax_update_counter'}, function(response){
						var obj = JSON.parse(response);
						console.log(obj);
						$('.buyers-count').html(obj.buyers);
						$('.synch-ok').css('display', 'inline');
						button.removeAttr('disabled');
						$('.doing-synch').css('display','none');
						return;
					})
				}else{
					alert(response);
					button.removeAttr('disabled');
					$('.doing-synch').css('display','none');
				}
			});
		
		});

		if($("#dplr-tbl-lists").length>0){
			loadLists(1);
		}

	});


	function listsLoading(){
		$('form input, form button').prop('disabled', true);
		$('#dplr-crud').addClass('loading');
	}

	function listsLoaded(){
		$('form input, form button').prop('disabled', false);
		$('form input').val('');
		$('#dplr-crud').removeClass('loading');
	}

	function loadLists( page ){

		var data = {
			action: 'dplr_ajax_get_lists',
			page: page
		};
		
		listsLoading();

		$("#dpr-tbl-lists tbody tr").remove();

		$.post( ajaxurl, data, function( response ) {
	
			if(response.length>0){

				var obj = JSON.parse(response);
				var html = '';
				
				for (const key in obj) {
					
					var value = obj[key];
					
					html += '<tr>';
					html += '<td>'+value.listId+'</td>';
					html += '<td><strong>'+value.name+'</strong></td>';
					html += '<td>'+value.subscribersCount+'</td>';
					html += '<td><a href="#" class="text-dark-red" data-list-id="'+value.listId+'">Delete</a></td>'
					html += '</tr>';
					
				}

				$("#dplr-tbl-lists tbody").prepend(html);
				$("#dplr-tbl-lists").attr('data-page','1');
				
				listsLoaded();
			}

		})
	
	}

	function deleteList(e){

		e.preventDefault();

		var a = $(this);
		var tr = a.closest('tr');
		var listId = a.attr('data-list-id');
		var data = {
			action: 'dplr_ajax_delete_list',
			listId : listId
		};
		
		$("#dplr-dialog-confirm").dialog("option", "buttons", [{
			text: 'Delete',
			click: function() {
				$(this).dialog("close");
				tr.addClass('deleting');
				$.post( ajaxurl, data, function( response ) {
					var obj = JSON.parse(response);
					if(obj.response.code == 200){
						tr.remove();
					}else{
						if(obj.response.code == 0){
							alert('No se puede eliminar lista.')
						}else{
							alert('Error');
						}
						tr.removeClass('deleting');
					}
				});
			}
		  }, 
		  {
			text: 'Cancel',
			click: function() {
			  $(this).dialog("close");
			}
		  }]);
  
		  $("#dplr-dialog-confirm").dialog("open");

	}


})( jQuery );
