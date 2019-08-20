(function( $ ) {
	'use strict';

	$(function() {
		
		
		$("#dplr-lp-form-list select").change(function(){
			$("#btn-synch").css('display','none');
			$(this).closest('tr').find('td span').html(
				$('option:selected', this).attr('data-subscriptors')
			);
		});

		if($('#dplr-lp-dialog-confirm').length>0){
			$("#dplr-lp-dialog-confirm").dialog({
				autoOpen: false,
				resizable: false,
				height: "auto",
				width: 400,
				modal: true
			});
		}

		var synchBuyers = function() {

			var data = {
				action: 'dplr_lp_ajax_synch',
			}

			var deferred = new $.Deferred();
			$.post( ajaxurl, data, function( response ){
				deferred.resolve(response);
			})
			return deferred.promise();
		}

		$("#btn-lp-synch").click(function(){
			var button = $(this);
			$('.doing-synch').css('display','inline');
			$('.synch-ok').css('opacity', '0');
			clearResponseMessages();
			var emails = $('.subscribers-item');
			var subscribers = [];
			for(var i=0; i<emails.length; i++){
				subscribers[i] = emails[i].value;
			}

			synchBuyers().then(function( response ){
			
				var obj = JSON.parse(response);
				if(!obj.createdResourceId){
					if(obj!=0){
						console.log(obj);
						displayErrors(obj);
					}
					$('.doing-synch').css('display', 'none');
					button.css('pointer-events','initial');
					return false;
				}
				$.post(ajaxurl,{action: 'dplr_ajax_update_counter'}, function(response){
					var obj = JSON.parse(response);
					$('.buyers-count').html(obj.buyers);
					$('.synch-ok').css('opacity', '1');
					button.css('pointer-events','initial');
					$('.doing-synch').css('display','none');
					return;
				});
			});
		
		});

	});


})( jQuery );
