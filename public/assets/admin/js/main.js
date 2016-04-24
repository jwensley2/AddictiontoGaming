var $alertDeleteTmpl, $alertErrorTmpl, $alertSuccessTmpl;

$(document).ready(function() {
	// Set alert templates
	$alertDeleteTmpl  = $("#delete-alert-template");
	$alertErrorTmpl   = $("#error-alert-template");
	$alertSuccessTmpl = $("#success-alert-template");

	initTableSorter();
	initUserList();
	initPermissionsEditor();

	// Pass the CSRF Token with all ajax requests
	$.ajaxSetup({
		headers: { 'X-CSRF-TOKEN': getCSRFToken() }
	});

	// Setup the buttons to delete news posts
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
			var url   = $row.data("delete");

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

// ------------------------------------------------------------------------

function initUserList () {
	var $actions    = $("#user-list .user-actions");

	$actions.on("click", ".activate, .de-activate", function(e) {
		var url          = $(this).data("url");
		var $thisActions = $(e.delegateTarget);
		var $activate    = $thisActions.find(".activate");
		var $deActivate  = $thisActions.find(".de-activate");
		var $status      = $thisActions.find(".status");

		$.post(url, function(response) {
			if (response.success) {

				$status.text(response.status);
				$activate.toggle();
				$deActivate.toggle();

				showSuccessAlert(response.message);
			} else {
				showErrorAlert(response.message);
			}
		}, "json");
	})
}

// ------------------------------------------------------------------------

function initPermissionsEditor () {
	var $save        = $("#save-permissions");
	var $permissions = $("input.permission");

	$save.on("click", function() {
		$.post($save.data('url'), $permissions.serialize(), function(result) {
			$(window).scrollTop(0);

			if (result.success) {
				showSuccessAlert(result.message);
			} else {
				showErrorAlert(result.message);
			}
		}, "json");
	})
}

// ------------------------------------------------------------------------

function initTableSorter () {
	$.extend($.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables
		table      : 'table table-bordered',
		caption    : 'caption',
		header     : 'bootstrap-header', // give the header a gradient background
		footerRow  : '',
		footerCells: '',
		icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'bootstrap-icon-unsorted',
		sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     // includes classes for Bootstrap v2 & v3
		sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', // includes classes for Bootstrap v2 & v3
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});

	$(".sortable").tablesorter({
		theme : "bootstrap",
		headerTemplate : '{content} {icon}',
		widgets : [ "uitheme" ],
	});
}

// ------------------------------------------------------------------------

// Get the CSRF Token
function getCSRFToken () {
	return $("body").data("csrf-token");
}

// ------------------------------------------------------------------------

function showSuccessAlert (message, $before) {
	var $alert = $alertSuccessTmpl.clone();

	showAlert($alert, message, $before);
}

// ------------------------------------------------------------------------

function showErrorAlert (message, $before) {
	var $alert = $alertErrorTmpl.clone();

	showAlert($alert, message, $before);
}

// ------------------------------------------------------------------------

function showAlert ($alert, message, $before) {
	$alert.find(".close").before(message);

	if ( ! $before) {
		$alert.appendTo($("#alert-container"));
	} else {
		$alert.insertBefore($before);
	}

	setTimeout(function() {
		$alert.fadeOut(function() {
			$alert.remove();
		});
	}, 5000);
}