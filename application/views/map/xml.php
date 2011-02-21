<locations>
	<player>
		<lastName><?php echo $player->lastName; ?></lastName>
		<lat><?php echo $player->lat; ?></lat>
		<lng><?php echo $player->lng; ?></lng>
	</player>
	<players>
		<?php foreach ($players AS $player): ?>
			<player>
				<lastname><?php echo xml_convert($player->lastName); ?></lastname>
				<lat><?php echo $player->lat ?></lat>
				<lng><?php echo $player->lng ?></lng>
			</player>
		<?php endforeach ?>
	</players>
</locations>