(function( $ ) {
	'use strict';

	$(function() {

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

	});

	function listsLoading(){
		$('form input, form button').prop('disabled', true);
		$('#dplr-crud').addClass('loading');
	}

})( jQuery );
