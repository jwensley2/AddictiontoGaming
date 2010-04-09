<div id="other_popup" class="server_popup">
	<div class="status <?php echo status_to_class($status) ?>"><?php echo status_to_word($status) ?></div>
	<div class="hostname"><?php echo $hostname ?></div>
	<div class="ip"><?php echo $ip ?>:<?php echo $port ?></div>
	<div>Players: Unknown / <?php echo $max_players ?></div>
</div>