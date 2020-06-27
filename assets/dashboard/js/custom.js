
$(function() {
	var date 		= new Date();
	date.setFullYear(date.getFullYear() - 18);
	$('#hardware_start_date').datetimepicker({
		format: 'DD MMM YYYY',
	});
	$('#hardware_service_date').datetimepicker({
		format: 'DD MMM YYYY',
		useCurrent: false
	});
	$("#hardware_start_date").on("dp.change", function (e) {
		$('#hardware_service_date').data("DateTimePicker").minDate(e.date);
	});
	$("#hardware_service_date").on("dp.change", function (e) {
		$('#hardware_start_date').data("DateTimePicker").maxDate(e.date);
	});
	$('#from-date').datetimepicker({format: 'DD MMM YYYY'});
	$('#to-date').datetimepicker({format: 'DD MMM YYYY'});
	$('#user_dob').datetimepicker({
		format: 'DD MMM YYYY',
		maxDate: date,
	});
 });
$(document).ready(function() {
	
	$.validator.addMethod("extension", function (value, element, param) {

        param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";

        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));

    }, $.validator.format("Please enter a value with a valid extension."));

	
    $.validator.addMethod('filesize', function (value, element, param) {

        return this.optional(element) || (element.files[0].size <= param)

    }, 'File size must be less than 1 mb');


	
	$("#user-form").validate({
		rules: {
			user_division: "required",
			user_zone: "required",
			shop_id: "required",
			user_type: "required",
			section_id: "required",
			user_email: {
				/* required : true, */
				email: true,
			},
			user_pin: {
							required : true,
							minlength : 6,
							maxlength : 6,
							number : true,
					    },
			user_cpin: {
							required : true,
							minlength : 6,
							maxlength : 6,
							number : true,
							equalTo: "#user_pin"
					    },
			user_pass: {
							required : true,
					    },
			user_cpass: {
							required : true,
							equalTo: "#user_pass"
							
					    },
			user_phone: {
							required : true,
							minlength : 10,
							maxlength : 10,
							number : true,
					    },
			user_zipcode: {
							minlength : 6,
							maxlength : 6,
							number : true,
						},
			user_f_name: {
					required : true,
			}	,
			/* user_l_name: {
					required : true,
			} */	
		},
		messages:{
			'user_cpass':{
				equalTo:'Confirm password should be same as password.'
			},
			'user_cpin':{
				equalTo:'Confirm pin should be same as pin.'
			}
		}
	});
	
	//SetConfigDashboard
	
	$("#SetConfigDashboard").validate({
		rules: {
			hardware_shop_id: {
					required : true,
			},
			hardware_section_id: {
					required : true,
			}
				
		}
	});
	
	$("#UpdateSectionFrom").validate({
		rules: {
			row: {
					required : true,
					number : true,
					max:100,
					min:1
			},
			column: {
					required : true,
					number : true,
					max:50,
					min:1
			},
			imageN : {
				extension: "jpg|png|jpeg",
                filesize: 1048999,
			}
				
		}
	});
	
	$("#InsertSectionFrom").validate({
		rules: {
			row: {
					required : true,
					number : true,
					max:100,
					min:1
			},
			column: {
					required : true,
					number : true,
					max:50,
					min:1
			},
			imageN : {
				extension: "jpg|png|jpeg",
                filesize: 1048999,
				required : true,
			}
				
		}
	});
	
	$("#zone-form").validate({
		rules: {
			zone_code: "required",
			zone_name: "required",
		}
	});
	$("#type-form").validate({
		rules: {
			type_code: "required",
			type_name: "required",
		}
	});
	$("#category-form").validate({
		rules: {
			category_code: "required",
			category_name: "required",
                        priority :  "required",
		}
	});
	$("#division-form").validate({
		rules: {
			division_code: "required",
			division_name: "required",
			zone_id: "required",
		}
	});
	$("#hardware-form").validate({
		rules: {
			hardware_code: "required",
			hardware_name: "required",	
			schedule_frequency_count: "required",
			service_date: "required",
			hardware_category: "required",
			hardware_type: "required",
			schedule_frequency_cycle: "required",

			schedule_frequency_count: {
					required: true,
      				number: true,
      				max: 999
			},
		}
		
	});
	$("#notification-filter-form").validate({
		rules: {
			notification_title: {
				required: true,
				maxlength: 20
			},
			user_message: {
					required: true,
      				maxlength: 150
			},
			'userlist[]': {
                    required: true,
            },
			//userlist: "required needsSelection",
		}
		
	});
	$("#assign-hardware-form").validate({
		rules: {
			start_date: {
				required : true,
			},
			service_date: {
				required : true,
			},
			shop_id: {
				required : true,
			},
			hardware_serial_no: {
				required : true,
			},
			section_id: {
				required : true,
			},
			hardware_cycle: {
				required : true,
			},
			daily_every_day: {
				required : true,
				number : true
			},
			
			daily_every_day: {
				required : true,
				number : true
			},
			weekly_recur_every:  {
				required : true,
				number : true
			},
			monthly_date: {
				required : true,
				number : true,
				max : 31
			},
			monthly_name: {
				required : true,
				number : true,
				max : 12
			}			
		}
	});
	$("#shop-form").validate({
		rules: {
			shop_name: "required",
		}
	});
	$("#section-form").validate({
		rules: {
			shop_id: "required",
			section_code: "required",
			section_name: "required",
		}
	});
	$("#maintenance-shop-form").validate({
		rules: {
			maintenance_shop_name: "required",
		}
	});
	$("#maintenance-section-form").validate({
		rules: {
			maintenance_section_code: "required",
			maintenance_section_name: "required",
		}
	});
	$("#changepass-form").validate({
		rules: {
			user_old_pass: {
							required : true,
					    },
			user_pass: {
							required : true,
					    },
			user_cpass: {
							required : true,
							equalTo: "#user_pass"
							
					    },
		},
		messages:{
			'user_cpass':{
				equalTo:'Confirm password should be same as password.'
			}
		}
	});
});
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#profile_pic').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}
$("#user_profile_pic").change(function() {
  readURL(this);
});
function hardwareImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();    
    reader.onload = function(e) {
      $('#hardware_pic').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}
$("#hardware_image").change(function() {
  hardwareImage(this);
});
function doconfirm()
{
    job=confirm("Are you sure want to inactive this item?");
    if(job!=true)
    {
        return false;
    }
}

function doconfirmMsg(msg)
{
    job=confirm(msg);
    if(job!=true)
    {
        return false;
    }
}
$(function(){
   $("#user_type").on('change',function(){
		var user_type = $(this).val(); 
		if(user_type == 'ShI'){
			$('#section_id').attr("disabled", true); 
		}else if(user_type == 'MG'){
			$('#section_id').attr("disabled", true);  
			$('#shop_id').attr("disabled", true); 
		}else{
			$('#section_id').removeAttr("disabled");  
			$('#shop_id').removeAttr("disabled");
		}
		console.log(user_type);return false;
   });
}); 

$(function(){
	$('#hardwaredatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3,4,5,6]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3,4,5,6]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#userdatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#categorydatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#typedatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#divisiondatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#zonedatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#shopdatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#sectiondatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3,4]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3,4]
			}
		}],
		responsive: false
	});
});
$(function(){
	$('#maintenancelogdatatable').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3]
			}
		}],
		responsive: false
	});
});
$(function(){ 
	$('#searchByStatus').on('change', function() {
	$( "#statusChnage" ).submit();
   });
}); 

window.onload = function() {
    var $recaptcha = document.querySelector('#g-recaptcha-response');

    if($recaptcha) {
        $recaptcha.setAttribute("required", "required");
    }
};

$(function(){ 
	//var base_url 	= window.location.origin;
	//base_url 		= base_url+'/locosafety';
	$("#user_zone").change(function(){
		var $option = $(this).find('option:selected');
		var zone = $option.val();	  
		$.ajax({
			url: 'getDivisionByZone',
			data: {'zone': zone}, 
			type: "post",
			success: function(data){
				$("#user_division").html(data);
			}
		});
	});
	$("#hardware_shop_id").change(function(){
		var $option = $(this).find('option:selected');
		var shop_id = $option.val();	  
		$.ajax({
			url: base_url+'/dashboard/getSectionByShopOnDash',
			data: {'shop_id': shop_id}, 
			type: "post",
			success: function(data){
				$("#hardware_section_id").html(data);
			}
		});
	});
	var dialog;
	dialog = $("#hardwarelist").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
		Cancel: function () {
			dialog.dialog("close");
		}
		},
		close: function () {

		}
	});
	$("#hardware_list").change(function(){
		var $option 	= $(this).find('option:selected');
		var hardware_id = $option.val();
		if( hardware_id.length !== 0 ) {
			window.location.href = base_url+"/hardwares/assignShop/"+hardware_id;
		}
	});
}); 

// =============Data Tables============
$(function(){
	$('#userdatatableAdmin').DataTable({				
		dom: 'Bfrtip',
		buttons: [{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,2,3,4,5]
			}
		},{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,2,3,4,5]
			}
		}],
		initComplete: function () {
            this.api().columns(6).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">-Status-</option></select>')
                    .appendTo( $('.FilterCustom1').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );				
								
                column.data().unique().sort().each( function ( d, j ) {
					if(d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
		}
	});
});	
// =============Data Tables============