@extends('layouts.master')

@section('content')
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
					@if ($donations)
						@foreach ($donations as $donation)
							<tr>
								<td class="name">{{ $donation->donor->first_name }}</td>
								<td class="ingame-name">{{ $donation->donor->ingame_name }}</td>
								<td class="steam-id">{{ $donation->donor->steam_id }}</td>
								<td class="amount">${{ $donation->gross }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4">No donations yet this month</td>
						</tr>
					@endif
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3"><strong>Total:</strong></th>
						<td class="amount"><strong>${{ $monthly_total }}</strong></td>
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
					<?php $top_donors_total = 0 ?>
					@foreach ($top_donors as $key => $donor)
						<?php $top_donors_total += $donor->total ?>
						<tr>
							<td class="rank">{{ $key + 1 }}</td>
							<td class="ingame-name">{{ $donor->ingame_name }}</td>
							<td class="amount">${{ $donor->total }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2"><strong>Total:</strong></th>
						<td class="amount"><strong>${{ $top_donors_total }}</strong></td>
					</tr>
				</tfoot>
			</table>
		</article>

		<article>
			<h2>Total Donations to Date</h2>
			<p class="total-donations">${{ $total_donations }}!</p>
		</article>
	</section>
@stop