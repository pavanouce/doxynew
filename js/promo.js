var imagedialogbox;
var savedialogbox;
var searchdialogbox;
var tabid;
$(document).ready(function (loadEvent) {
	initTabs();
	initDatePickers();
	initValidation();
	initImage();
	submitHandlers();	
	initJcrop();
	initSorts();
	initAddNode();
});
/*
function initImageUploaders() {
	$('button.image_upload_button').click(function(event){
		data = $(this).attr('data-onclick');
		filename = $(this).attr('data-filename');
		
		ajaxUpload($(this).parent(),
				'php_ajax_image_upload/scripts/ajaxupload.php?filename=' + filename +'&amp;' +
				'maxSize=9999999999&amp;maxW=1200&amp;fullPath=http://' +
				 window.location.host  + '/oxypromo/php_ajax_image_upload/uploads/&amp;' +
				 'relPath=../uploads/&amp; +
				 'colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1200',
				 data,
				'File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' ' +
				'width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' ' +
				'width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info' +
				'in source code.'); 
		event.preventDefault();
	});
}
*/
function initAddNode() {
	tabid = parseInt($('input.nodes_count').val());
	$('li.list-actions').button();
	$('li.add-new').click(function(clickEvent){
		tabid++;
		$.ajax({
			url:"node_add_service.php?tabid=" + tabid,
			type: "GET",
			dataType: "html",
			success:function(response) {
				var new_content = response;
				$('.promo-node').last().after(new_content);
				 var lihtml = '<li class="list-element"><a href="#node-promo-'+tabid+'" data-tab-id="'+tabid+'" '+
				 			  'data-nid="'+tabid+'">Promo  '+tabid+'</a></li>';
				$('li.list-element').last().after(lihtml);
				addNodeActions(tabid);
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert("Error Occured Adding...!!");
			}
		});
	});
	initSearch();
}

function initSorts() {
	$('.list-tabs-container').sortable({ items: 'li.list-element' });
}

function initJcrop() {
	$('.image_area').each(function(i, item) {
		if($('img.main_image',item).attr('src')!="") {
			$parent_element = $(item).parent();
			var x1 = $('input.x1',$parent_element).val();
			var x2 = $('input.x2',$parent_element).val();
			var y1 = $('input.y1',$parent_element).val();
			var y2 = $('input.y2',$parent_element).val();
			if($(item).attr('id').indexOf('thumbnail')==-1) {
				$('img.main_image',item).Jcrop({
					setSelect:[x1, y1, x2, y2],
					boxWidth: 450, 
					boxHeight: 400,
					aspectRatio: 340/312,
					minSize: [340,312],
					onChange: showCoords($(item).parent()),
					onSelect: showCoords($(item).parent())
				});
			} else {
				$('img.main_image',item).Jcrop({
					setSelect:[x1, y1, x2, y2],
					boxWidth: 450, 
					boxHeight: 400,
					//aspectRatio: 340/312,
					//minSize: [340,312],
					onChange: showCoords($(item).parent()),
					onSelect: showCoords($(item).parent())
				});
			}
			
			//$('.crop-info',$parent_element).show();
		}
	});
}

function initSearch() {
	searchdialogbox = $("div.dialog");
	searchdialogbox.html(getSearchDialogContent());
	searchdialogbox.dialog({autoOpen: false,height:400,width:500 });
	
	$('li.add-existing').click(function(clickEvent) {
		searchdialogbox.html(getSearchDialogContent());
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
				addNodeActions(nid);
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
		async: false,
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
			//setListContents(data.nid); 
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
		beforeSerialize: function($form, options) {
			savedialogbox.dialog('open');
			var nids = [];
			var flag = true;
	        $('li.list-element').each(function(i, item) {
	        	var tab_id = $('a',item).attr('data-tab-id');
	        	$('#node-promo-'+tab_id+" input.node-weight").val(i);
	        	if($('#node-promo-'+tab_id+" form.promo_list").valid()) {
	        		$('#node-promo-'+tab_id+" form.promo_list").submit();
	        	}  else {
	        		savedialogbox.dialog('close');
	        		$.jGrowl("Please correct errors on the form", { theme: 'error' });
	        		flag = false;
	        	}
	        	var nid = $('#node-promo-'+tab_id+" input.node-id").val();
	        	nids.push(nid);
	        });
	        if(!flag) {
        		return flag;
        	}
	        $('#promo-list-content-nids').val(nids.join(','));       
		},
	    beforeSend: function() {
	    	/*
	    	if($('#promo-list-content-nids').val() == "" ||$('#promo-list-content-nids').val() == undefined ) {
	    		$.jGrowl("Atleast save one node in the list before saving the list!", { theme: 'error' });
	    		return false;
	    	}
	    	*/
	    	
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
			redirect_url = window.location.protocol + '//' + window.location.host
			+ "/oxypromo/?nid=" + data.nid;
			if($('#promo_list_nid').val()=="") {
				$('#promo_list_nid').val(data.nid);
				window.location.href = redirect_url;
				//console.log(redirect_url);
			}
			$.jGrowl("List Successfully Saved with id: "+ data.nid + " Redirecting..!");
			
			
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
	$(".promo_list").validate();
	//$('#upload_area').before(img);
}

function initTabs() {
	$('.tabs').tabs();
	$('.promos-list').tabs();
	//$('.new-window-check').button();
	$('div.submit-promo input').button();
}

function initDatePickers() {
	$('input.edit-publish').datetimepicker();
	$('input.edit-unpublish').datetimepicker();
	$('input#promo-list-publish-on').datetimepicker();
	$('input#promo-list-unpublish-on').datetimepicker();
}

function uploadActions(element) {
	imagedialogbox.dialog('close');
	var $parent_element = $('#'+element).parent();
	//$(".crop-info", $parent_element).show();
	if(element.indexOf("thumbnail")==-1) {
		$('#'+element+' img').Jcrop({
			boxWidth: 450, boxHeight: 400,
			minSize:[340,312],
			aspectRatio: 340/312,
			onChange: showCoords,
			onSelect: showCoords
		});
	} else {
		
		$('#'+element+' img').Jcrop({
			boxWidth: 450, boxHeight: 400,
			onChange: showCoords($parent_element),
			onSelect: showCoords($parent_element)
		});
	}
	$('input[data-id="' + element + '"]').val($('#'+element+' img').attr('src'));
	$('input[data-value-id="' + element + '"]').val("true");
}

function showCoords(item)
{
	return function(c) {
		
		//if($(item).attr('id').indexOf('thumbnail')==-1) 
		$('.x1_area input',item).val(parseInt(c.x));
		$('.y1_area input',item).val(parseInt(c.y));
		$('.x2_area input',item).val(parseInt(c.x2));
		$('.y2_area input',item).val(parseInt(c.y2));
		$('.width_area input',item).val(parseInt(c.w));
		$('.height_area input',item).val(parseInt(c.h));
    };
	
	/*
	$('.x1_area input').val(parseInt(c.x));
	$('.y1_area input').val(parseInt(c.y));
	$('.x2_area input').val(parseInt(c.x2));
	$('.y2_area input').val(parseInt(c.y2));
	$('.width_area input').val(parseInt(c.w));
	$('.height_area input').val(parseInt(c.h));
	*/
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

function addNodeActions(nid) {
	$('.tabs').tabs("destroy");
	$('.promos-list').tabs("destroy");
	$('.tabs').tabs();
	$('.promos-list').tabs();
	
	//$('.new-window-check').button();
	$('div.submit-promo input').button();
	//setListContents(nid);
	
	initDatePickers();
	initValidation();
	initImage();
	submitHandlers();	
	initJcrop();
	//initSorts();
}