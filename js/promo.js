var imagedialogbox;
var savedialogbox;
$(document).ready(function (loadEvent) {
	initTabs();
	initDatePickers();
	initValidation();
	initImage();
	submitHandlers();
});

function submitHandlers(){
	var bar = $('.bar');
	var percent = $('.percent');
	var status = $('#status');
	savedialogbox =  $(".saving-box").dialog({
        autoOpen: false,
        modal: true,
        title: 'Saving..!!',
        width: 370,
        height:200
    });
	$('#promo_list').ajaxForm({
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
	    	$.jGrowl("Error Occured Saving.!", { theme: 'error' });
	    },
	    success: function(data) {
	    	savedialogbox.dialog('close');
			console.log(data);
			$('#promo_list .node-id').val(data.nid);
			$.jGrowl("Promo Node Successfully Saved with id"+ data.nid );
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
	//var img = $('#image_upload').remove();
	//$("#promo_list").validate();
	//$('#upload_area').before(img);
}

function initTabs() {
	$('.tabs').tabs();
	$('.promos-list').tabs();
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
};