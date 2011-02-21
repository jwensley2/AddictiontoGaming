<div id="source_popup" class="server_popup">
	<div class="close">[Close]</div>
	<div class="status <?php echo status_to_class($status) ?>"><?php echo status_to_word($status) ?></div>
	<div class="hostname"><?php echo $hostname ?></div>
	<div class="ip"><a href="steam://connect/<?php echo "$port:$ip" ?>"><?php echo $ip ?>:<?php echo $port ?></a></div>
	<div class="mapname">Map: <?php echo $mapname ?></div>
	<div>Players: <?php echo $players ?> / <?php echo $max_players ?></div>
	<?php if ($player_list): ?>
		<table id="player_list">
			<tr class="headings">
				<th class="name">Name</th>
				<th class="kills">Kills</th>
			</tr>
			<?php foreach ($player_list AS $player): ?>
				<?php $color = alternator('color1', 'color2') ?>
				<tr class="<?php echo $color ?>">
					<?php if (!empty($player->name)): ?>
						<td class="name"><?php echo $player->name ?></td>
					<?php else: ?>
						<td class="name connecting">Connecting</td>
					<?php endif ?>
					<td class="kills"><?php echo $player->kills ?></td>
				</tr>
			<?php endforeach ?>
		</table>
	<?php else: ?>
		<div id="player_list">
			No players on server
		</div>
	<?php endif ?>
</div>