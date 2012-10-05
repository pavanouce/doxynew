var imagedialogbox;
var savedialogbox;
var searchdialogbox;
var tabid;
var node_data;
var confirm_dialog_box;
var crop_ref = [];
var flag_preview = false;
var oldpromodialogbox;

$(document).ready(function (loadEvent) {
	removeActions();
	initTabs();
	initDatePickers();
	initValidation();
	initImage();
	submitHandlers();	
	initJcrop();
	initSorts();
	initAddNode();
	initOldPromoViews();
	initApply();
});

function initApply() {
	$('#promo-list-apply').button();
	$('#promo-list-apply').click(function(event) {
		event.preventDefault();
		var self = $('input#promo-list-publish-on');
		$("input.edit-publish").each(function(i, item) {
			$(item).val(self.val());
		});

		self = $('input#promo-list-unpublish-on');
		$("input.edit-unpublish").each(function(i, item) {
			$(item).val(self.val());
		});
	});
}

function initOldPromoViews(){
	var oldpromodialogbox = $('.old-promo-dialog').dialog({
		resizable: false,
		height:600,
		width:700,
		modal: true,
		title: "View Existing Promos",
		position: 'center',
		autoOpen: false,
		open: function(event, ui) {
		    $(this).parent().css('top', '20px');
		}
	});
	//$('.search-list-date').datetimepicker();
	$('.list-view-old').button();
	$('.list-view-old').click(function(clickEvent) {
		clickEvent.preventDefault();
		oldpromodialogbox.dialog('open');
		$(".search-old-promo").click(function(buttonClick) {
			var date_val = $(".search-list-date").val();
			if(date_val) {
				term = Date.parse(date_val)/1000;
			} else {
				term = '';
			}
			$(".results-container .message").html("Loading search..!!");
			$(".results-container > table").html("");
			var searchhtml = ""; 
			var randomnumber=Math.floor(Math.random()*11);
			$.ajax({
				url:"/promo_list/lists/search/" + term+"?"+randomnumber,
				dataType: "json",
				success:function(data) {
					if(data.length== 0) {
						$(".results-container .message").html("No Results Found..!! Refine your search");
						return;
					}
					$(".results-container > table").html("<tr><th>nid</th><th>title</th><th>Date</th><Th></th></tr>");
					$(".results-container .message").html("");

					var classappend = "";
					$.each(data, function(i, item) {
						classappend = "";
						console.log(item.publish_on);
						if(item.publish_on!=null && item.publish_on!='') {
							date = new Date(parseInt(item.publish_on)*1000);
							hour = date.getHours();
							min = date.getMinutes();
							sec = date.getSeconds();
							ampm_string = "AM";
							if(hour>13) {
								hour -= 12;
								ampm_string = "PM";
							}
							if(hour<10) {
								hour = "0" + hour; 
							}
							if(min < 10) {
								min = "0" + min;
							}
							if(sec < 10) {
								sec = "0" + sec;
							}
							var display_time = hour  + ":" + min + ":" + sec;
							var display_date = $.datepicker.formatDate("mm/dd/yy ", date) + display_time + " " + ampm_string;
						} else {
							var display_date = '';
						}
						searchhtml += "<tr><td>"  + item.nid + "</td><td class='title'>" + item.title + 
						"</td><td class='date'>" + display_date + "</td><td class='edit'>" +
						"<button class='edit" + classappend  + "' data-nid='" + item.nid+ "'>Edit</button></td></tr>";
					});
					$(".results-container > table").append(searchhtml);
					$('.results-container button.edit').click(function(clickEvent) {
						nid = $(this).attr('data-nid');
						window.location.href = '/oxypromo/?nid='+nid;
					});
					addExistingNodeEvent();
				},
				error:function(xhr, ajaxOptions, thrownError) {
					$(".results-container .message").html("Error Occured Searching...!!");
				}
			});
		});
	});
}

function removeActions() {
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:140,
		width:500,
		modal: true,
		autoOpen: false,
		buttons: {
			"Are you sure you want to remove": function() {
				var item = $(this).data('link');
				var count = $('li.list-element').length;
				if(count > 1) {
					var data_id = $(item).parent().attr('data-tab-id');
					$(item).parent().parent().remove();
					$('div#node-promo-'+data_id).remove();
				} else {
					alert("Should have atleast one element");
				}
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	$('span.remove-promo').click(function(clickEvent){
		clickEvent.preventDefault();
		$( "#dialog-confirm" ).data('link', this)  // The important part .data() method
		.dialog('open');
	});
}
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

function openPreviewPage() {
	var date_val = $('input#promo-list-publish-on').val();
	//alert(date_val);
	if(date_val!="") {
		date_ms = Date.parse(date_val);
		//alert(date_ms);
		date = new Date(date_ms);
		//alert(date);
		//alert($('input#promo-list-publish-on').datetimepicker('getDate'));
		var year = date.getFullYear();
		var month = date.getMonth();
		var day = date.getDate();
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var seconds = date.getSeconds();
		month++;
		if(month < 10) {
			month = "0" + month;
		}
		if(day < 10) {
			day = "0" + day;
		}
		if(hours < 10) {
			hours = "0" + hours;
		}
		if(minutes < 10) {
			minutes = "0" + minutes;
		}
		if(seconds < 10) {
			seconds = "0" + seconds;
		}
		var url = "http://" + window.location.hostname + "/?" 
		+ "future="+ month + "/" + day + "/"+ year + "%20" + hours + ":"
		+ minutes + ":" + seconds;

		window.location.href=url;
	} 
}

function initAddNode() {
	tabid = parseInt($('input.nodes_count').val());
	$('li.list-actions').button();
	$('li.add-new').click(function(clickEvent){
		tabid++;
		$.ajax({
			url:"/oxypromo/node_add_service.php?tabid=" + tabid,
			type: "GET",
			dataType: "html",
			success:function(response) {
				var new_content = response;
				$('.promo-node').last().after(new_content);
				$.ajax({
					url: "/oxypromo/node_summary_service.php?tabid=" + tabid,
					type: "GET",
					async:false,
					dataType: "html",
					success:function(response) {
						node_data= response;
					}
				});
				var lihtml = '<li class="list-element">'+node_data+'</li>';
				$('li.list-element').last().after(lihtml);
				addNodeActions(tabid, true);
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

function initJcrop(nid) {
	/*
	if(crop_ref.length> 0) {
		for (var i = 0; i < crop_ref.length; i++) {
			if(crop_ref[i].Jcrop!=undefined){
				crop_ref[i].destroy();
			}

		}
		crop_ref = [];
	}
	 */
	var ref;
	if(nid) {
		selector = '#node-promo-'+nid+' .image_area';
	} else {
		selector = '.image_area';
	}
	//alert(selector);
	$(selector).each(function(i, item) {
		if($('img.main_image',item).attr('src')!="") {
			$parent_element = $(item).parent();
			var x1 = $('input.x1',$parent_element).val();
			var x2 = $('input.x2',$parent_element).val();
			var y1 = $('input.y1',$parent_element).val();
			var y2 = $('input.y2',$parent_element).val();

			if($(item).attr('id').indexOf('thumbnail')==-1) {
				ref = $('img.main_image',item).Jcrop({
					setSelect:[x1, y1, x2, y2],
					boxWidth: 650, 
					boxHeight: 600,
					aspectRatio: 340/312,
					//minSize: [340,312],
					onChange: showCoords($(item).parent()),
					onSelect: showCoords($(item).parent())
				});
			} else {
				ref = $('img.main_image',item).Jcrop({
					setSelect:[x1, y1, x2, y2],
					boxWidth: 650, 
					boxHeight: 600,
					//aspectRatio: 340/312,
					//minSize: [340,312],
					onChange: showCoords($(item).parent()),
					onSelect: showCoords($(item).parent())
				});
			}
			//crop_ref.push(ref);

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
			var randomnumber=Math.floor(Math.random()*11);
			$.ajax({
				url:"/promo_list/nodes/search/" + term+"?"+randomnumber,
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
		tabid++;
		$.ajax({
			url:"/oxypromo/node_add_service.php?nid=" + nid + "&tabid=" +tabid,
			type: "GET",
			dataType: "html",
			success:function(response) {
				var new_content = response;
				$('.promo-node').last().after(new_content);

				$.ajax({
					url: "/oxypromo/node_summary_service.php?nid=" + nid + "&tabid=" +tabid,
					type: "GET",
					async:false,
					dataType: "html",
					success:function(response) {
						node_data= response;
					}
				});
				var lihtml = '<li class="list-element">' + node_data + '</li>';
				$('li.list-element').last().after(lihtml);
				$('#node-promo-'+tabid+' input[name="main-image-field-changed"]').val("true");
				$('#node-promo-'+tabid+' input[name="thumbnail-image-field-changed"]').val("true");
				addNodeActions(tabid, false);
				updatePreview(nid);
			},
			error:function(xhr, ajaxOptions, thrownError) {
				alert("Error Occured Adding...!!");
			}
		});
	});
}

function updatePreview(nid) {
	$.ajax({
		url: "node-preview.php?nid=" + nid,
		type: "GET",
		dataType: "html",
		success:function(response) {
			$("#node-promo-"+nid + " div.preview").html(response);
		}
	});

	$.jGrowl("Preview for this Node: " + nid  + " is updated.!" );
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
	$('.list-save').unbind('click');
	$('.list-save').click(function(clickEvent) {
		clickEvent.preventDefault();
		if(!$("#promo-list-form").valid()) {
			$.jGrowl("Please correct errors on the form" );
			return false;
		}
		savedialogbox.dialog('open');
		setTimeout('$("#promo-list-form").submit()',1000);

	});
	$('input.list-save-preview').unbind('click');
	$('input.list-save-preview').click(function(clickEvent) {
		clickEvent.preventDefault();
		if(!$("#promo-list-form").valid()) {
			$.jGrowl("Please correct errors on the form" );
			return false;
		}
		savedialogbox.dialog('open');
		setTimeout('$("#promo-list-form").submit()',1000);
		flag_preview = true;
	});
	/*
	$('.node-save').click(function(clickEvent) {
		clickEvent.preventDefault();
		savedialogbox.dialog('open');
		var data_nid = $(this).parent().parent().attr('data-nid');
		setTimeout($("form[data-nid="+data_nid+"]").submit(),1000);
	});
	 */
	$('.promo_list').ajaxForm({
		dataType: "json",
		async: false,
		beforeSend: function() {
			//savedialogbox.dialog('open');
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
			//savedialogbox.dialog('close');
			//console.log(data);
			$('.node-id', $form).val(data.nid);
			//setListContents(data.nid); 
			var old_id = $form.attr('data-nid');
			$form.attr('data-nid',data.nid);

			$.ajax({
				url: "node_summary_service.php?nid=" + data.nid + "&tab=" + data.nid + "&clone=true",
				type: "GET",
				async:false,
				dataType: "html",
				success:function(response) {
					node_data= response;
				}
			});


			$('li a[data-nid='+old_id+']').parent().html(node_data);
			$('div#node-promo-'+old_id).attr('data-oldid',old_id);
			$('div#node-promo-'+old_id).attr('id','node-promo-'+data.nid);
			//$('li a[data-nid='+old_id+']').attr('data-nid',data.nid);
			addNodeActions(data.nid, true);

			$.jGrowl("Promo Node Successfully Saved with nid: "+ data.nid );
			updatePreview(data.nid);

		},
		complete: function(xhr) {

		}
	}); 
	$('#promo-list-form').ajaxForm({
		dataType: "json",
		beforeSerialize: function($form, options) {
			//console.log("called");
			/*
			if(flag_preview) {
	        	flag_preview = false;
	        	openPreviewPage();
	        	return false;
	        }
			 */
			//savedialogbox.dialog('open');
			var nids = [];
			var flag = true;
			$('li.list-element').each(function(i, item) {
				//$(".saving-box").html("Saving Node"+i+".!!");
				var tab_id = $('a',item).attr('data-tab-id');
				$('#node-promo-'+tab_id+" input.node-weight").val(i);
				if($('#node-promo-'+tab_id+" form.promo_list").valid()) {
					//console.log('saving nid ' + tab_id);
					$('#node-promo-'+tab_id+" form.promo_list").submit();
					var nid = $('div[data-oldid='+tab_id+'] input.node-id').val();
					//alert(nid);
					nids.push(nid);
				}  else {
					savedialogbox.dialog('close');
					flag = false;
				}

			});
			if(!flag) {
				$.jGrowl("Please correct errors on the form", { theme: 'error' });
				return flag;
			}
			//alert(nids);
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
			//alert($('#promo-list-content-nids').val());
			if($('#promo_list_nid').val()=="") {
				$('#promo_list_nid').val(data.nid);
				window.location.href = redirect_url;
				//console.log(redirect_url);
			}
			$.jGrowl("List Successfully Saved with id: "+ data.nid + " Redirecting..!");

			if(flag_preview) {
				flag_preview = false;
				openPreviewPage();
				//return false;
			}
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
	/*
	$.validator.addMethod("unpublish_date", function(value, element) {

	});
	 */
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
	$('input.list-save-preview').button();
}

function initDatePickers() {
	$('input.edit-publish').datetimepicker({
		//minDate: new Date(),
		//showSecond: true,
		//dateFormat: 'yy-mm-dd',
		//timeFormat: 'hh:mm:ss',
		hourGrid: 4,
		minuteGrid: 10,
		secondGrid: 10,
		ampm: false
	});
	$('input.edit-unpublish').datetimepicker({
		//minDate: new Date(),
		//showSecond: true,
		//dateFormat: 'yy-mm-dd',
		//timeFormat: 'hh:mm:ss',
		hourGrid: 4,
		minuteGrid: 10,
		secondGrid: 10,
		ampm: false
	});
	$('input#promo-list-publish-on').datetimepicker({
		//minDate: new Date(),
		//showSecond: true,
		//dateFormat: 'yy-mm-dd',
		//timeFormat: 'hh:mm:ss',
		hourGrid: 4,
		minuteGrid: 10,
		secondGrid: 10,
		ampm: false
	})
	.change(function(changeEvent) {
		var self = this;
		if($(self).val()!="") {
			$("input.edit-publish").each(function(i, item) {
				if($(item).attr('data-value') != "true") {
					$(item).val($(self).val());
				}
			});

		}
	});
	$('input#promo-list-unpublish-on').datetimepicker({
		//minDate: new Date(),
		//showSecond: true,
		//dateFormat: 'yy-mm-dd',
		//timeFormat: 'hh:mm:ss',
		hourGrid: 4,
		minuteGrid: 10,
		secondGrid: 10,
		ampm: false
	}).
	change(function(changeEvent) {
		var self = this;
		if($(self).val()!="") {
			$("input.edit-unpublish").each(function(i, item) {
				if($(item).attr('data-value') != "true") {
					$(item).val($(self).val());
				}
			});

		}
	});
}

function uploadActions(element) {
	//console.log(element);
	imagedialogbox.dialog('close');
	var $parent_element = $('#'+element).parent();
	//$(".crop-info", $parent_element).show();
	var elem = $('#'+element);
	//console.log(elem.html());
	if(element.indexOf("thumbnail")==-1) {
		$('img',elem).Jcrop({
			boxWidth: 650, boxHeight: 600,
			//minSize:[340,312],
			aspectRatio: 340/312, 
			onChange: showCoords($parent_element),
			onSelect: showCoords($parent_element)
		});
	} else {
		$('img',elem).Jcrop({
			boxWidth: 650, boxHeight: 600,
			onChange: showCoords($parent_element),
			onSelect: showCoords($parent_element)
		});
	}

	//console.log($('.main_image',elem).attr('class'));
	$('input[data-id="' + element + '"]').val($('#'+element+' img').attr('src'));
	//console.log(element);
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

function addNodeActions(nid, list_save) {
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
	if(!list_save) {
		initJcrop(nid);
	}

	$('input#promo-list-publish-on').change();
	$('input#promo-list-unpublish-on').change();
	//initSorts();

	removeActions();
}