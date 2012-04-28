		<?php $this->load->view('templates/sidebar') ?>
	</div>

	<!-- Footer -->
	<footer class="page-footer">
		<div class="o-wrap">
			<div class="i-wrap">
				<div class="col">
					<h3>Navigate</h3>
					<ul class="links">
						<li><a href="<?php echo site_url('/') ?>">Home</a></li>
						<li><a href="http://forums.addictiontogaming.com">Forums</a></li>
						<li><a href="http://addictiontogaming.clanservers.com/">Bans</a></li>
						<li><a href="<?php echo site_url('servers') ?>">Servers</a></li>
						<li><a href="<?php echo site_url('donations') ?>">Donations</a></li>
					</ul>
				</div>
				<div class="col">
					<h3>Contact Us</h3>
					<ul class="links">
						<li><a href="mailto:addictiontogaming@gmail.com">By Email</a></li>
						<li><a href="https://twitter.com/#!/atg_tf2">On Twitter</a></li>
						<li><a href="https://www.facebook.com/AddictionToGaming">On Facebook</a></li>
					</ul>
				</div>
				<div class="cf"></div>
				<div class="copyright">
					Copyright Addiction to Gaming <?php echo date('Y') ?>
				</div>
			</div>
		</div>
	</footer>

	<?php if (ENVIRONMENT === 'production'): ?>
		<!-- Google Analytics -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-9313553-1']);
			_gaq.push(['_setDomainName', 'addictiontogaming.com']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	<?php endif ?>
</body>
</html>