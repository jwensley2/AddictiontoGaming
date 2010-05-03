<div id="content">
	<?php $this->load->view('/admin/templates/sidebar') ?>


	<div id="content_right">
		<div id="page_title" class="block cufon">Administration Panel</div>
		
		<div class="block">
			<div class="title cufon">Community Team Controls</div>
				<ul>
					<?php if (permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'))): ?>
						<li>&raquo; <a href="/admin/news/submit">Submit News</a></li>
					<?php endif; ?>
					<?php if (permission($this->settingsmodel->get_setting_array('POTW_PERMISSIONS'))): ?>
						<li>&raquo; <a href="/admin/potw/submit">Add Player of the Week</a></li>
					<?php endif; ?>
				</ul>
			<div class="title cufon">Manger Controls</div>
			<ul>
				<?php if (permission($this->settingsmodel->get_setting_array('DONOR_LIST_PERMISSIONS'))): ?>
					<li>&raquo; <a href="/admin/donations/donors">Donor List</a></li>
				<?php endif; ?>
			</ul>
				
			<div class="title cufon">Founder Controls</div>
		</div>
	</div>
	<div class="clear"></div>
</div>