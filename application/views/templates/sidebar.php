<!-- Sidebar -->
<aside class="sidebar">
	<div class="block">
		<?php
			$CI =& get_instance();
			$CI->load->library('Donations_lib');

			$goal		= $this->settingsmodel->get_setting('MONTHLY_COST');
			$total		= $CI->donations_lib->get_total_donations();
			$percent	= min(round(($total / $goal) * 100), 100);
		?>
		<h2>Donation Progress</h2>
		<div class="progress-bar">
			<p>$<?php echo $total ?> / $<?php echo $goal ?> (<?php echo $percent ?>%)</p>
			<div class="fill" style="width: <?php echo $percent ?>%"></div>
		</div>
	</div>

	<div class="block">
		<h2>Make a Donation</h2>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" accept-charset="utf-8" id="donate-form">
			<div style="display:none">
				<input type="hidden" name="cmd" value=" _donations">
				<input type="hidden" name="business" value="addictiontogaming@gmail.com">
				<input type="hidden" name="item_name" value="Donation">
				<input type="hidden" name="on0" value="SteamID">
				<input type="hidden" name="on1" value="Ingame Name">
				<input type="hidden" name="return" value="http://addictiontogaming.com/">
			</div>

			<input type="number" name="amount" placeholder="Donation Amount ($)" min="5" step="5" required>
			<input type="text" name="os0" placeholder="Steam ID (eg. STEAM_0:0:1234567)" pattern="^STEAM_0:[01]:[0-9]{7,8}">
			<input type="text" name="os1" placeholder="In Game Name">
			<input type="submit" value="Donate Now">
		</form>
	</div>

	<div class="block potm">
		<?php
			$CI =& get_instance();
			$CI->load->model('potwmodel');

			$player = $CI->potwmodel->get_current_member();
		?>
		<h2>Player of the Month</h2>
		<div>
			<img src="/assets/images/potw_pictures/<?php echo $player->id ?>_thumb.jpg">

			<dl>
				<dt>Name:</dt>
				<dd><?php echo $player->name ?><dd>

				<dt>Real Name:</dt>
				<dd><?php echo $player->real_name ?></dd>
			</dl>

			<a class="interview" href="<?php echo $player->forum_post_url ?>">&raquo; Read the interview</a>
		</div>
	</div>
</aside>