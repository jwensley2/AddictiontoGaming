<script src="/assets/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="/assets/js/map.js" type="text/javascript" charset="utf-8"></script>


<style type="text/css" media="screen">
	body, form{padding:0;margin:0;}
	#form_wrapper{height:25px;padding:10px;}
	#googlemap { position: absolute;
	left: 0px;
	right: 0px;
	bottom: 0px;
	top: 45px;
	}
</style>

<div id="form_wrapper">
	<form>
		<label for="steam_id">Steam ID</label> <input type="text" name="steam_id" value="" id="steam_id">
		<input type="submit" name="submit" value="Submit" id="submit">
	</form>
</div>


		
	<div id="googlemap"></div>
