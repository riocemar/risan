
	<script src="assets/js/jquery-1.11.0.min.js"></script>
<?php
	echo "New Calendar";
?>
<div class="calendar-env">
	
	<!-- Calendar Body -->
	<div class="calendar-body">
		<div id="calendar"></div>
	</div>
	
	<!-- Sidebar -->
	<div class="calendar-sidebar">
		
		<!-- new task form -->
		<div class="calendar-sidebar-row">
				
			<form role="form" id="add_event_form">
			
				<div class="input-group minimal">
					<input type="text" class="form-control" placeholder="Add event..." />
				
					<div class="input-group-addon">
						<i class="entypo-pencil"></i>
					</div>
				</div>
				
			</form>
			
		</div>
	
	
		<!-- Events List -->
		<ul class="events-list" id="draggable_events">
			<li>
				<p>Drag Events to Calendar-Dates</p>
			</li>
			<li>
				<a href="#">Sports Match</a>
			</li>
			<li>
				<a href="#" class="color-blue" data-event-class="color-blue">Meeting</a>
			</li>
			<li>
				<a href="#" class="color-orange" data-event-class="color-orange">Relax</a>
			</li>
			<li>
				<a href="#" class="color-primary" data-event-class="color-primary">Study</a>
			</li>
			<li>
				<a href="#" class="color-green" data-event-class="color-green">Family Time</a>
			</li>
		</ul>
		
	</div>
	
</div>

	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/js/neon-calendar.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>
	
	
