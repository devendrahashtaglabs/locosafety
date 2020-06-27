<style>
  #calendar-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  .fc-header-toolbar {
    padding-top: 1em;
    padding-left: 1em;
    padding-right: 1em;
  }
  .modal-dialog {
    width: 70%;
  }
</style>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
	<?php /* <div class="col-md-12 ">
		<ul class="nav navbar-right panel_toolbox">
			<li><a class="add-new btn btn-primary" href="<?php echo base_url().'meeting/add'; ?>" title="Add New">Add New Safety Meeting</a></li>
		</ul>
	</div> */ ?>
    <div class="col-md-12 ">
		<div id='calendar-container1'>
			<div id='calendar'></div>
		</div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php 
	$JsHtml = "";
	//echo "<pre>";
	foreach($meetingData as $row){
		$JsHtml .= '{ title:"'.$row->title.'",';
		$JsHtml .= ' groupId:"'.$row->id.'",';
		$JsHtml .= ' start: "'.$row->meeting_date.'T'.$row->meeting_in_time.'",';
		$JsHtml .= ' end: "'.$row->meeting_date.'T'.$row->meeting_out_time.'",';
		$JsHtml .= '},';
		//print_r($row);	
	} 
	/* print_r($JsHtml);
	exit; */
?>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agenda List</h4>
      </div>
      <div class="modal-body DataAgenda ">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<link href='<?php echo base_url('assets/packages'); ?>/core/main.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/packages'); ?>/daygrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/packages'); ?>/timegrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/packages'); ?>/list/main.css' rel='stylesheet' />
<script src='<?php echo base_url('assets/packages'); ?>/core/main.js'></script>
<script src='<?php echo base_url('assets/packages'); ?>/interaction/main.js'></script>
<script src='<?php echo base_url('assets/packages'); ?>/daygrid/main.js'></script>
<script src='<?php echo base_url('assets/packages'); ?>/timegrid/main.js'></script>
<script src='<?php echo base_url('assets/packages'); ?>/list/main.js'></script>
<script>
	function formatDate(date) {
  var monthNames = [
    "01", "02", "03",
    "04", "05", "06", "07",
    "08", "09", "10",
    "11", "12"
  ];

  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();

  return day + '-' + monthNames[monthIndex] + '-' + year;
}
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      height: 'parent',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      defaultView: 'dayGridMonth',
      defaultDate: <?php echo '"'.date("Y-m-d").'"'; ?>,
      navLinks: true, // can click day/week names to navigate views
      editable: false ,
      //eventLimit: "more", // allow "more" link when too many events
	  eventLimit: false, // allow "more" link when too many events
	  eventLimitText: "More", //sets the text for more events		
	  events: [  
			
			<?php 
				echo $JsHtml;
			?>
      
        /* {
          title: 'Meeting',
          start: '2019-08-12T10:30:00',
          end: '2019-08-12T12:30:00'
        }, */
        
      ],
	  eventClick: function(info) {
		
		console.log(info);
		
		var RowID = info.event.groupId;
		var startDate = info.event.start;
		var d = new Date(info.event.start);
		var Str = d.toString("dd-mm-yyyy");		
		var da = formatDate(info.event.start);
		/* console.log(da);
		console.log(d.getMonth());
		console.log(d.getDate()); */
		var Str = da;
		var URLR = '<?php echo base_url(); ?>meeting/agenda/'+Str+'/'+RowID;
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>meeting/checkmapid',			
			data: {"map_id" : RowID},
			success: function (data) {
				
				if(data != 0){
					//alert(data);	
					$('.DataAgenda').html(data);
					
					$('#myModal').modal('show');
					$('#hardwaredatatable1').DataTable();
					
				}else{
					window.location = URLR;
				}
			},
			error: function (data) {
				console.log(data);
			}
		});
		
		
		
	 }
    });

    calendar.render();
  });

</script>
