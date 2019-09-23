(function( $ ) {
	'use strict';

	$(function() {

		var synchBuyers = function(list_id) {

			var data = {
				action: 'dplr_lp_ajax_synch',
				list_id: list_id,
			}

			var deferred = new $.Deferred();
			$.post( ajaxurl, data, function( response ){
				deferred.resolve(response);
			})
			return deferred.promise();
		}

		$("#dplr-lp-form-list select").change(function(){
			$("#dplr-lp-lists-btn").removeAttr("disabled");
		});

		$("#dplr-lp-lists-btn").click(function(e){
			e.preventDefault();
			clearResponseMessages();
			var button = $(this);
			var buyersList = $("#dplr-lp-form-list select").val();
			if(buyersList == ''){
				button.attr('disabled','disabled').addClass("button--loading");
				$("#dplr-lp-form-list").submit();
				return false;
			}
			button.attr('disabled','disabled').addClass("button--loading");
			$("#dplr-settings-text").html(dplrlp_object_string.Syncrhonizing);
			//Sync & save.
			synchBuyers(buyersList).then(function( response ){			
				var obj = JSON.parse(response);
				if(!obj.createdResourceId){
					if(obj!=0){
						displayErrors(obj);
					}
					button.removeAttr('disabled').removeClass("button--loading");
					return false;
				}else{
					$("#dplr-lp-form-list").submit();
				}
			});
		});

		$("#dplr-lp-clear").click(function(e){
			e.preventDefault();
			clearResponseMessages();
			var button = $(this);
			button.attr('disabled','disabled').addClass("button--loading");
			var data = {
				action: 'dplr_lp_ajax_clear_buyers_list',
			}
			$.post( ajaxurl, data, function(response){
				$("#dplr-lp-form-list select")[0].selectedIndex = 0;
				$("#dplr-settings-text").html(dplrlp_object_string.selectAList);
				button.removeClass("button--loading");
			})
		});

		$("#dplr-form-list-new input[type=text]").keyup(function(){
			var button = $(this).closest('form').find('button');
			if($(this).val().length>0){
				button.removeAttr('disabled');
				return false;
			}
			button.attr('disabled',true);
		});

		$("#dplrlp-save-list").click(function(e){
			e.preventDefault();
			clearResponseMessages();
			var button = $(this);
			var listInput = $(this).closest('form').find('input[type="text"]');
			var listName = listInput.val();
			if(listName=='') return false;
			button.addClass("button--loading");
			var data = {
				action: 'dplr_save_list',
				listName: listName
			}
			$.post( ajaxurl, data, function( response ){
				var body = 	JSON.parse(response);
				if(body.createdResourceId){		
					var html ='<option value="'+body.createdResourceId+'">'+listName+'</option>';
					$('#dplr-lp-form-list select option:first-child').after(html);
					listInput.val('');
					button.attr('disabled',true);
					displaySuccess(dplrlp_object_string.newListSuccess);
				}else if(body.status >= 400){
					displayErrors(body);
				}
				button.removeClass("button--loading");
			})
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

	
		/*

		$("#btn-lp-synch").click(function(e){
		/	e.preventDefault();
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
		*/

	});

})( jQuery );
