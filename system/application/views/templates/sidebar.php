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
	
	<?php
		$CI =& get_instance();
		$CI->load->library('Donations_lib');
	
		$goal = $this->settingsmodel->get_setting('MONTHLY_COST');
		$total = $CI->donations_lib->get_total_donations();
	?>
	
	<div id="donations_module" class="block">
		<div class="heading cufon">Donations</div>
		<div class="content">
			<div id="donation_totals">
				<div class="total">Total: $<?php echo $total ?></div>
				<div class="goal">Goal: $<?php echo $goal ?></div>
			</div>
			<div class="clear"></div>
			<img id="donation_progress" src="/assets/images/donation_progress.png" alt="Donation Progress"/>
			<div id="donate_button">
				<a href="/donations">Donate Now</a>
			</div>
		</div>
	</div>
	
	<?php	
		$CI =& get_instance();
		$CI->load->model('potwmodel');
	
		$player = $CI->potwmodel->get_current_member();
	?>
	<?php if ($player): ?>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$('#potw_module .photo a').colorbox();
			})
		</script>
		<div id="potw_module" class="block">
			<div class="heading cufon">Player of the Week</div>
			<div class="content">
				<div class="photo">
					<a href="/assets/images/potw_pictures/<?php echo $player->id ?>_full.jpg">
						<img src="/assets/images/potw_pictures/<?php echo $player->id ?>_thumb.jpg"/>
					</a>
				</div>
				<div class="name">
					<span class="heading">Name:</span> <?php echo $player->name ?>
				</div>
				<div class="real_name">
					<span class="heading">Real Name:</span> <?php echo $player->real_name ?>
				</div>
				<?php if ($player->steam_id): ?>
					<div class="stats">
						<span class="heading">Stats:</span> <a href="/stats/hlstats.php?mode=search&amp;q=<?php echo $player->steam_id ?>&amp;st=uniqueid&amp;game=">View Stats</a>
					</div>
				<?php endif ?>
				<div class="interview_link"><a href="<?php echo $player->forum_post_url ?>">&raquo; Read the full interview</a></div>
			</div>
		</div>
	<?php endif ?>
	
	<?php
		$CI =& get_instance();
		$CI->load->library('Twitter_lib');
		$CI->load->helper('security');
		
		$twitter_user = $this->settingsmodel->get_setting('TWITTER_USERNAME');
		$twitter_pass = $this->settingsmodel->get_setting('TWITTER_PASSWORD');
		$CI->twitter_lib->auth($twitter_user, $twitter_pass);
		$timeline = $CI->twitter_lib->user_timeline(3);
	?>
	<div id="twitter_module" class="block">
		<div class="heading cufon"><a href="http://twitter.com/<?php echo $twitter_user ?>">Twitter Feed</a></div>
		<div class="content">
			<?php foreach ($timeline as $tweet): ?>
				<div class="tweet">
					<div class="msg"><?php echo auto_link(xss_clean($tweet->text), 'both', TRUE) ?></div>
					<div class="date"><?php echo $CI->twitter_lib->relative_time($tweet->created_at) ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>