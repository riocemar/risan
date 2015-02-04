
<link href='assets/css/fullcalendar.css' rel='stylesheet' />
<link href='assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='assets/js/moment.min.js'></script>
<script src='assets/js/jquery.min.js'></script>
<script src='assets/js/jquery-ui.custom.min.js'></script>
<script src='assets/js/fullcalendar.min.js'></script>
<style>
#calendar {
  width: 700px;
  margin: 0 auto;
  }
</style>
<script>
 	
 $(document).ready(function() {
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var calendar = $('#calendar').fullCalendar({
      
   editable: true,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "http://localhost/PainelAdmin/modulos/events.php",
   
   // Convert the allDay from string to boolean
   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
   selectable: true,
   selectHelper: true,
   
   
   
   /******************************/
   select: function(start, end, allDay) {
   var title = prompt('Título Reunião:');
   
   if (title) {
	   
	   $.ajax({
		   url: "http://localhost/PainelAdmin/modulos/add_events.php",
		   data: "&title="+ title+"&start="+ start +"&end="+ end ,
		   type: "POST",
		   success: function(json) {
		   		alert('Added Successfully');
		   }
	   });
	   
	   calendar.fullCalendar('renderEvent',
	   {
		   title: title,
		   start: start,
		   end: end,
		   allDay: allDay
		},
	   true // make the event "stick"
	   );
   }
   calendar.fullCalendar('unselect');
   }
   
   
   //******************************************************//
   ,
   
   editable: true,
   eventDrop: function(event, delta) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'http://localhost/PainelAdmin/modulos/update_events.php',
   data: '&title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
   type: "POST",
   success: function(json) {
    alert("Updated Successfully");
   }
   });
   },
   eventResize: function(event) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
    url: 'http://localhost/PainelAdmin/modulos/update_events.php',
    data: '&title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
    type: "POST",
    success: function(json) {
     alert("Updated Successfully");
    }
   });
   },
   
	eventClick: function(event) {
		var decisao = confirm("Deseja remover o evento?");
		if (decisao) {
			$.ajax({
				type: "POST",
				url: "http://localhost/fullcalendar/delete_events.php",
				data: "&id=" + event.id
			});
			$('#calendar').fullCalendar('removeEvents', event.id);
		} else {
		}
		}
   
  });
  
 });

</script>

<?php
	echo "New Calendar";
?>
<div id='calendar'></div>
