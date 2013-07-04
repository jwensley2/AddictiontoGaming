$(document).ready(function() {
	var $alertDeleteTmpl  = $("#delete-alert-template");
	var $alertErrorTmpl   = $("#error-alert-template");
	var $alertSuccessTmpl = $("#success-alert-template");

	$(".news-item .delete").on("click", function() {
		var $btn    = $(this),
			$row    = $btn.parents(".news-item").eq(0),
			$alert  = $alertDeleteTmpl.clone(),
			$keep   = $alert.find("[data-action=keep]"),
			$delete = $alert.find("[data-action=delete]");

		$alert.find(".title").text($row.data("title"));
		$alert.insertBefore("#news-list").show().alert();

		$keep.on("click", function() {
			$alert.alert("close");
		});

		$delete.on("click", function() {
			var url = $row.data("delete");

			$alert.alert("close");

			$.post(url, function(result) {
				if (result.success) {
					$row.fadeOut();
				} else {
					var $errorAlert = $alertErrorTmpl.clone();

					$errorAlert.append(result.message);

					$errorAlert.insertBefore("#news-list").show();
				}
			}, "json");
		});
	});
});