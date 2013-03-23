<div id="content_left">
	<?php if (permission($this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS'))): ?>
		<div class="block">
			<div class="heading cufon">Administration Links</div>
			<div class="content">
				<ul>
					<?php if (permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'))): ?>
						<li>&raquo; <a href="/admin/news/submit">Submit News</a></li>
					<?php endif; ?>
					<?php if (permission($this->settingsmodel->get_setting_array('POTW_PERMISSIONS'))): ?>
						<li>&raquo; <a href="/admin/potw/submit">Add Player of the Week</a></li>
					<?php endif; ?>
					<?php if (permission($this->settingsmodel->get_setting_array('DONOR_LIST_PERMISSIONS'))): ?>
						<li>&raquo; <a href="/admin/donations/donors">Donor List</a></li>
					<?php endif; ?>
					<?php if (permission($this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS'))): ?>
						<li>&raquo; <a href="/admin/servers">Server List</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	<?php endif ?>
</div>