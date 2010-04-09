<?php

	function display_channels($channels, $players){
		foreach($channels AS $key => $channel){
			echo '<li class="channel">'.$channel['name'];
			foreach($players AS &$player){
				echo '<ul>';
				if($player->channel == $key){
					echo '<li class="player">'.$player->name.'</li>';
					$player = null;
				}
				echo '</ul>';
			}
			if($channel['subchannels']){
				echo "<ul>";
				display_channels($channel['subchannels'], $players);
				echo "</ul>";
			}
			echo '</li>';
		}
	}

?>

<div id="vent_popup" class="server_popup">
	<div class="status <?php echo status_to_class($status) ?>"><?php echo status_to_word($status) ?></div>
	<div class="hostname"><?php echo $hostname ?></div>
	<div class="ip"><?php echo $ip ?>:<?php echo $port ?></div>
	<div>Players: <?php echo $players ?> / <?php echo $max_players ?></div>
	<ul id="channel_list">
		<li class="channel">
			<?php echo $hostname ?>
			<?php
				foreach($player_list AS &$player){
			        echo '<ul>';
			        if($player->channel == 0){
			        	echo '<li class="player">'.$player->name.'</li>';
			        	$player = null;
			        }
			        echo '</ul>';
				}
			?>
			<ul><?php display_channels($channels, $player_list) ?><ul>
		</li>
	</ul>
</div>