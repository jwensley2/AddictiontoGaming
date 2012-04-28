<section id="content" class="content">
	<header>
		<h1>Administration - Donors - Donor List</h1>
	</header>

	<article>
		<table class="donor-list">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Username</th>
					<th>Expire Date</th>
				</tr>
				<tr>
					<th>Last Name</th>
					<th>SteamID</th>
					<th>Total Donated</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($donors AS $donor): ?>
					<tr class="user1">
						<td><?php echo $donor->first_name ?></td>
						<td><?php echo $donor->ingame_name ?></td>
						<td class="expire_date"><?php echo date('M j Y', $donor->expire_date) ?></td>
					</tr>
					<tr class="user2">
						<td><?php echo $donor->last_name ?></td>
						<td><?php echo $donor->steam_id ?></td>
						<td class="total">$<?php echo $donor->total ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</article>
</section>