(function( $ ) {
	'use strict';

	$(function() {

		var syncListButton = $("#dplr-lp-lists-btn");
		var buyersSelect = $("#dplr-lp-form-list select");
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

		buyersSelect.change(function(){
			$(this).val() === ''? syncListButton.attr("disabled","true") : syncListButton.removeAttr("disabled");
		});

		syncListButton.click(function(e){
			e.preventDefault();
			clearResponseMessages();
			var button = $(this);
			var buyersList = buyersSelect.val();
			if(buyersList == ''){
				button.attr('disabled','disabled').addClass("button--loading");
				$("#dplr-lp-form-list").submit();
				return false;
			}
			button.attr('disabled','disabled').addClass("button--loading");
			$("#dplr-settings-text").html(dplrlp_object_string.Syncrhonizing);
			synchBuyers(buyersList).then(function( response ){			
				var obj = JSON.parse(response);
				if(obj.createdResourceId || obj.errCode == 'NoStudentsFound'){
					$("#dplr-lp-form-list").submit();
				}else{
					if(obj.error!=1){
						displayErrors(obj);
					}
					button.removeAttr('disabled').removeClass("button--loading");
					return false;
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
			button.attr('disabled',true).addClass("button--loading");
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
				button.removeAttr('disabled').removeClass("button--loading");
			})
		});

		$("#course-mapping-form").change(function(){
			var selects = $(this).closest('form').find('select');
			var button = $(this).closest('form').find('button');
			var allCompleted = true;
			$.each(selects,function(e,s){
				if(s.value === '') allCompleted = false;
			});
			allCompleted? button.removeAttr('disabled') : button.attr('disabled',true);
		});

		$("#course-mapping-form button").click(function(e){
			e.preventDefault();
			var button = $(this);
			var mapCourse = $("#map-course").val();
			var mapList = $("#map-list").val();
			if( mapCourse === '' || mapList === '' ) return false;
			button.attr('disabled','true').addClass("button--loading");
			var data = {
				action: 'dplr_map_course',
				course_id: mapCourse,
				list_id: mapList
			}
			$.post( ajaxurl, data, function( response ){
				if(response==='1'){
					var html = '<tr>';
						html+= '<td>'+$("#map-course option:selected").text()+'</td>';
						html+= '<td>'+$("#map-list option:selected").text()+'</td>';
						html+= '<td><a class="pointer">Sync</a></td>';
						html+= '<td><a class="pointer">Delete</a></td>';
						html+= '</tr>';
					if($("#associated-lists-tbl").removeClass('d-none'));
					$("#associated-lists-tbl tbody").prepend(html);
				} 
				button.removeAttr('disabled').removeClass("button--loading");
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

	});

})( jQuery );
