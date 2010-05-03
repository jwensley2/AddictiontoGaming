<div id="content">
	<?php $this->load->view('templates/sidebar') ?>
	
	<div id="content_right">
		
		<script type="text/javascript">
			<!--
			$(document).ready(function(){
				$("#donate_form").submit(function(){
					error = false;
					msg = "";

					if($("input[name='os0']").val().length == 0){
						msg += "Please enter your Steam ID \n";
						error = true;
					}

					if($("input[name='os1']").val().length == 0){
						msg += "Please enter your Ingame Name \n";
						error = true;
					}

					if(error){
						alert(msg);
						return false;
					}
				})
			})
			//-->
		</script>
		
		<div id="page_title" class="block cufon">Donations</div>
		<div class="block">
			<div class="title cufon">Make a Donation</div>
			<p>
				If you wish to make a donation you can do so using the form below.
				<br />If you are not a Steam user you may enter STEAM_0:0:0 in the Steam ID field
			</p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" accept-charset="utf-8" id="donate_form">
				<table>
					<tr>
						<td style="display:none">
							<input type="hidden" name="cmd" value=" _donations" />
							<input type="hidden" name="business" value="addictiontogaming@gmail.com" />
							<input type="hidden" name="item_name" value="Donation" />
							<input type="hidden" name="on0" value="SteamID" />
							<input type="hidden" name="on1" value="Ingame Name" />
							<input type="hidden" name="return" value="http://addictiontogaming.com/" />
						</td>
						
						<th>Amount:</th>
						<td><input type="text" name="amount" value="5.00" /></td>
					</tr>
					<tr>
						<th>SteamID:</th>
						<td><input type="text" name="os0"/> <span class="small">(e.g. STEAM_0:0:3883133)</span></td>
					</tr>
					<tr>
						<th>Ingame Name:</th>
						<td><input type="text" name="os1"/> <span class="small">(e.g. [ATG] Joe)</span></td>
						</tr>
					<tr>
						<td colspan="2" align="center"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" /></td>
					</tr>
				</table>
			</form>
		</div>
		
		<div class="block">
			<div class="title cufon">This months donations</div>
			<table id="donation_list">
				<tr class="headings">
					<th class="name">Name</th>
					<th class="ingame_name">In-game Name</th>
					<th class="steam_id">Steam ID</th>
					<th class="amount">Amount(USD)</th>
				</tr>
				<?php foreach ($donators as $donator): ?>
					<?php if($donator->steam_id == 'STEAM_0:0:0'){ $donator->steam_id = 'N/A'; } ?>
					
					<tr class="<?php echo alternator('color1', 'color2') ?>">
						<td class="name"><?php echo $donator->first_name ?></td>
						<td class="ingame_name"><?php echo $donator->ingame_name ?></td>
						<td class="steam_id"><?php echo $donator->steam_id ?></td>
						<td class="amount">$<?php echo $donator->amount ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		
		<div class="block">
			<div class="title cufon">Top 10 Donors</div>
			<table id="top_donors">
				<?php foreach ($top_donors as $key => $donator): ?>
					<tr class="<?php echo alternator('color1', 'color2') ?>">
						<td class="position"><?php echo $key+1 ?></td>
						<td class="ingame_name"><?php echo $donator->ingame_name ?></td>
						<td class="amount"><?php echo $donator->total ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
	<div class="clear"></div>
</div>