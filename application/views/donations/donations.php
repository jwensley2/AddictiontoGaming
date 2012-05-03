<!-- Content -->
<section class="content donations">
	<header>
		<h1>Donations</h1>
	</header>

	<article>
		<h2>This months donations</h2>
		<table class="donation-list">
			<thead>
				<tr>
					<th class="name">Name</th>
					<th class="ingame-name">In-game Name</th>
					<th class="steam-id">Steam ID</th>
					<th class="amount">Amount(USD)</th>
				</tr>
			</thead>

			<tbody>
				<?php $month_total = 0 ?>
				<?php if ($donators): ?>
					<?php foreach ($donators as $donator): ?>
						<?php $month_total += $donator->amount ?>
						<tr>
							<td class="name"><?php echo $donator->first_name ?></td>
							<td class="ingame-name"><?php echo $donator->ingame_name ?></td>
							<td class="steam-id"><?php echo $donator->steam_id ?></td>
							<td class="amount">$<?php echo $donator->amount ?></td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="4">No donations yet this month</td>
					</tr>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3"><strong>Total:</strong></th>
					<td class="amount"><strong>$<?php echo $month_total ?></strong></td>
				</tr>
			</tfoot>
		</table>
	</article>

	<article>
		<h2>Top 10 Donors</h2>
		<table class="top-donors">
			<thead>
				<tr>
					<th class="rank">Rank</th>
					<th class="ingame-name">Name</th>
					<th class="amount">Total Donated(USD)</th>
				</tr>
			</thead>

			<tbody>
				<?php $top10_total = 0; ?>
				<?php foreach ($top_donors as $key => $donator): ?>
					<?php $top10_total += $donator->total; ?>
					<tr>
						<td class="rank"><?php echo $key+1 ?></td>
						<td class="ingame-name"><?php echo $donator->ingame_name ?></td>
						<td class="amount">$<?php echo $donator->total ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2"><strong>Total:</strong></th>
					<td class="amount"><strong>$<?php echo $top10_total; ?></strong></td>
				</tr>
			</tfoot>
		</table>
	</article>

	<article>
		<h2>Total Donations to Date</h2>
		<p class="total-donations">$<?php echo $total_donations ?>!</p>
	</article>
</section>