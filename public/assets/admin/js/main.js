$(document).ready(function() {
	var $alertDeleteTmpl  = $("#delete-alert-template");
	var $alertErrorTmpl   = $("#error-alert-template");
	var $alertSuccessTmpl = $("#success-alert-template");

	$(".news-item .delete").on("click", function() {
		var $btn    = $(this),
			$alert  = $alertDeleteTmpl.clone().attr("id", null),
			$row    = $btn.parents(".news-item").eq(0),
			$keep   = $alert.find("[data-action=keep]"),
			$delete = $alert.find("[data-action=delete]");

		var id = $row.data("id");

		$(window).scrollTop(0);

		// If an alert already exists then we don't need to do anything
		if ($("#delete-post-"+id).length > 0) return;

		// Setup the alert
		$alert.attr("id", "delete-post-"+id);
		$alert.find(".title").text($row.data("title"));
		$alert.insertBefore("#news-list").show().alert();

		// Bind the keep button
		$keep.on("click", function() {
			$alert.alert("close");
		});

		// Bind the delete button
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