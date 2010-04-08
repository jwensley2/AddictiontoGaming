<div id="content_left">
	<?php if (permission($this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS'))): ?>
		<div class="block">
			<div class="heading cufon">Administration Links</div>
			<div class="content">
				<ul>
					<?php if (permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'))): ?>
						<li><a href="/admin/news/submit">Submit News</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	<?php endif ?>
	
	<?php
	$CI =& get_instance();
	$CI->load->library('Donations_lib');
	
	$goal = $this->settingsmodel->get_setting('MONTHLY_COST');
	$total = $CI->donations_lib->get_total_donations();
	?>
	
	<div id="donations" class="block">
		<div class="heading cufon">Donations</div>
		<div class="content">
			<div id="donation_totals">
				<div class="total">Total: $<?php echo $total ?></div>
				<div class="goal">Goal: $<?php echo $goal ?></div>
			</div>
			<div class="clear"></div>
			<div id="donate_button">
				<a href="/donations">Donate Now</a>
			</div>
		</div>
	</div>
	
	<?php
		$CI =& get_instance();
		$CI->load->library('Twitter_lib');
		$CI->load->helper('security');
		
		$twitter_user = $this->settingsmodel->get_setting('TWITTER_USERNAME');
		$twitter_pass = $this->settingsmodel->get_setting('TWITTER_PASSWORD');
		$CI->twitter_lib->auth($twitter_user, $twitter_pass);
		$timeline = $CI->twitter_lib->user_timeline(3);
	?>
	<div id="twitter" class="block">
		<div class="heading cufon">Twitter Feed</div>
		<div class="content">
			<?php foreach ($timeline as $tweet): ?>
				<div class="tweet">
					<div class="msg"><?php echo auto_link(xss_clean($tweet->text)) ?></div>
					<div class="date"><?php echo $CI->twitter_lib->relative_time($tweet->created_at) ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>