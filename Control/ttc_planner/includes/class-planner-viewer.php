<?php

class Planner_Viewer_Interface extends Planner_Editor_Interface {

	public function editor_ui() {
		?>
		<div id="plnr-wrapper">
			<div id="plnr-datepicker">
				<div id="plnr-datepicker-container"></div>
			</div>
			<div id="plnr-datelist">
				<div id="plnr-event-list" class="plnr-event-list">
				</div>
			</div>
		</div>
		<?php
		include( 'templates.php' );
	}
}