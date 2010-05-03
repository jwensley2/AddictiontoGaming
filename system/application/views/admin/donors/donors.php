<div id="content">
	<?php $this->load->view('/admin/templates/sidebar') ?>


	<div id="content_right">
		<div id="page_title" class="block cufon">Admin - Donors - Donor List</div>
		
		<div class="block">
			<table id="donor_list">
				<tr class="headings1">
					<th>First Name</th>
					<th>Username</th>
					<th>Expire Date</th>
				</tr>
				<tr class="headings2">
					<th>Last Name</th>
					<th>SteamID</th>
					<th>Total Donated</th>
				</tr>
				<?php foreach ($donors AS $donor): ?>
					<tr class="user1 <?php echo $class ?>">
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
			</table>
		</div>
	</div>
	<div class="clear"></div>
</div>