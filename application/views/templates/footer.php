			<div id="footer">
				<br />Copyright Addiction to Gaming <?php echo date('Y') ?>
			</div>
		</div>
		
		
		<!-- Scripts -->
		<?php echo $this->asset_lib->output_tags('js', array('footer')); ?>
		
		<script type="text/javascript" charset="utf-8">
			Cufon.replace('.cufon');
		</script>
		
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-9313553-1']);
			_gaq.push(['_setDomainName', 'addictiontogaming.com']);
			_gaq.push(['_setAllowHash', false]);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		
	</body>
</html>