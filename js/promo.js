var imagedialogbox;
var savedialogbox;
var searchdialogbox;
$(document).ready(function (loadEvent) {
	initTabs();
	initDatePickers();
	initValidation();
	initImage();
	submitHandlers();
	initSearch();
});

function initSearch() {
	searchdialogbox = $("div.dialog");
	searchdialogbox.html(getSearchDialogContent());
	searchdialogbox.dialog({autoOpen: false,height:400,width:500 });
	
	$('.list-add').click(function(clickEvent) {
		searchdialogbox.dialog('open');
		clickEvent.preventDefault();
		$("button.search").click(function(buttonClick) {
			var term = $(".search-field").val();
			if(term.length < 3) {
				$(".message").html("Please enter more than 3 characters");
				return;
			}
			
			$(".message").html("Loading search..!!");
			var searchhtml = ""; 
			$.ajax({
				url:"/promo_list/nodes/search/" + term,
				dataType: "json",
				success:function(data) {
					if(data.length== 0) {
						$(".message").html("No Results Found..!! Refine your search");
						return;
					}
					$(".results > table").html("<tr><th>nid</th><th>title</th><Th></th></tr>");
					$(".message").html("");
					var nodes = [];
					$.each($('.node-id'), function(i, item) {
						nodes.push(parseInt($(item).val()));
						
					});
					var classappend = "";
					$.each(data, function(i, item) {
						classappend = "";
						if($.inArray(parseInt(item.nid), nodes)!=-1)  {
							classappend  =" disabled";
						}
						searchhtml += "<tr><td>"  + item.nid + "</td><td>" + item.title + 
									"</td><td><button class='add" + classappend  + "' data-nid='" + item.nid+ "'>Add</button></td></tr>";
					});
					$(".results > table").append(searchhtml);
					addExistingNodeEvent();
				},
				error:function(xhr, ajaxOptions, thrownError) {
					$(".message").html("Error Occured Searching...!!");
				}
			});
		});
	});
}

function addExistingNodeEvent() {
	$("button.disabled").removeClass("add").attr('disabled','disabled');
	$("button.add").click(function(clickEvent) {
		var nid = $(this).attr("data-nid");
		searchdialogbox.dialog('close');

		$.ajax({
			url:"node_add_service.php?nid=" + nid,
			type: "GET",
			dataType: "html",
			success:function(response) {
				var new_content = response;
				$('.promo-node').last().after(new_content);
				 var lihtml = '<li class="list-element"><a href="#node-promo-'+nid+'" data-tab-id="'+nid+'" '+
				 			  'data-nid="'+nid+'">Promo (nid: '+nid+')</a></li>';
				$('li.list-element').last().after(lihtml);
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert("Error Occured Adding...!!");
			}
		});
	});
}

function submitHandlers(){
	var bar = $('.bar');
	var percent = $('.percent');
	var status = $('#status');
	savedialogbox =  $(".saving-box").dialog({
        autoOpen: false,
        modal: true,
        title: 'Saving..!!',
        width: 437,
        height:90
    });
	$('.promo_list').ajaxForm({
		dataType: "json",
	    beforeSend: function() {
	    	savedialogbox.dialog('open');
	        status.empty();
	        var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	        var percentVal = percentComplete + '%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
	    error: function(jqXHR, textStatus, errorThrown) {
	    	savedialogbox.dialog('close');
	    	$.jGrowl("Error Occured Saving.!", { theme: 'error' });
	    },
	    success: function(data, statusText, xhr, $form) {
	    	savedialogbox.dialog('close');
			console.log(data);
			$('.node-id', $form).val(data.nid);
			setListContents(data.nid); 
			var old_id = $form.attr('data-nid');
			$form.attr('data-nid',data.nid);
			
			var html = $('li a[data-nid='+old_id+']').html();
			if(html.indexOf(data.nid)==-1){
				html = html.slice(0,-2);
				html += ' (nid:' +  data.nid + ')';
				$('li a[data-nid='+old_id+']').html(html);
				$('li a[data-nid='+old_id+']').attr('data-nid',data.nid);
			}
			$.jGrowl("Promo Node Successfully Saved with nid: "+ data.nid );
	    },
		complete: function(xhr) {
			
		}
	}); 
	$('#promo-list-form').ajaxForm({
		dataType: "json",
	    beforeSend: function() {
	    	if($('#promo-list-content-nids').val() == "" ||$('#promo-list-content-nids').val() == undefined ) {
	    		$.jGrowl("Atleast save one node in the list before saving the list!", { theme: 'error' });
	    		return false;
	    	}
	    	
	    	savedialogbox.dialog('open');
	        status.empty();
	        var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	        var percentVal = percentComplete + '%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
	    error: function(jqXHR, textStatus, errorThrown) {
	    	savedialogbox.dialog('close');
	    	$.jGrowl("Error Occured Saving.!", { theme: 'error' });
	    },
	    success: function(data) {
	    	savedialogbox.dialog('close');
			console.log(data);
			$('#promo_list_nid').val(data.nid);
			$.jGrowl("List Successfully Saved with id: "+ data.nid );
	    },
		complete: function(xhr) {
			
		}
	}); 
}

function initImage() {
	
	$('.image_upload button').click(function(clickEvent){
		clickEvent.preventDefault();
		var form = $(this).attr('data-form-id');
		imagedialogbox =  $('#'+form).dialog({
	        autoOpen: false,
	        modal: true,
	        title: 'Select an Image',
	        width: 370,
	        height:200
	    });
		imagedialogbox.dialog('open');
	});
}

function initValidation() {
	$.validator.setDefaults({ ignore: '' });
	$('.promo-list-form').validate();
	//var img = $('#image_upload').remove();
	//$(".promo_list").validate();
	//$('#upload_area').before(img);
}

function initTabs() {
	$('.tabs').tabs();
	$('.promos-list').tabs();
	$('.new-window-check').button();
	$('div.submit-promo input').button();
}

function initDatePickers() {
	$('input#edit-publish').datetimepicker();
	$('input#edit-unpublish').datetimepicker();
}

function uploadActions(element) {
	alert(element);
	imagedialogbox.dialog('close');
	$('#'+element+" div.image_crop_info").css("display","inline-block");
	$('#'+element+' img').Jcrop({
		boxWidth: 450, boxHeight: 400,
		onChange: showCoords,
		onSelect: showCoords
	});
	$('input[data-id="' + element + '"]').val($('#'+element+' img').attr('src'));
	$('input[data-value-id="' + element + '"]').val("true");
}

function showCoords(c)
{
	$('.x1_area span').html(parseInt(c.x));
	$('.y1_area span').html(parseInt(c.y));
	$('.x2_area span').html(parseInt(c.x2));
	$('.y2_area span').html(parseInt(c.y2));
	$('.width_area span').html(parseInt(c.w));
	$('.height_area span').html(parseInt(c.h));
	/*
	var rx = 100 / c.w;
	var ry = 100 / c.h;
	$('#preview img').css({
		width: Math.round(rx * 500) + 'px',
		height: Math.round(ry * 370) + 'px',
		marginLeft: '-' + Math.round(rx * c.x) + 'px',
		marginTop: '-' + Math.round(ry * c.y) + 'px'
	});
	*/
}

function getSearchDialogContent() {
	var html = "<div class='dialog'>";
	html += "<div class='search-bar'><input class='search-field' type='text'></input><button class='search'>Search</button></div>";
	html += "<div class='message'></div>";
	html += "<div class='results'><table></table></div></div>";
	return html;
}

function setListContents(nid) {
	var list_nid_value = $('#promo-list-content-nids').val();
	if(list_nid_value== "" || list_nid_value == undefined) {
		$('#promo-list-content-nids').val(nid);
	} else {
		if(list_nid_value.indexOf(nid)==-1) {
			list_nid_value += "," + nid;
			$('#promo-list-content-nids').val(list_nid_value);
		} 
	}
}

function addNodeActions() {
	$('.tabs').tabs("destroy");
	$('.promos-list').tabs("destroy");
	$('.tabs').tabs();
	$('.promos-list').tabs();
	
	$('.new-window-check').button();
	$('div.submit-promo input').button();
	setListContents(nid);
	submitHandlers();
}