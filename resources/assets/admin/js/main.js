import {app} from './app';

$(document).ready(function () {
    initTableSorter();
    initUserList();
    initPermissionsEditor();

    // Setup the buttons to delete articles posts
    $(".articles-item .delete").on("click", function () {
        let $btn = $(this),
            $row = $btn.parents(".articles-item").eq(0),
            url  = $row.data("delete");

        $(window).scrollTop(0);

        app.$emit("alert", {
            title: "Are you sure you want to delete that?",
            message: `You are about to delete "<strong>${$row.data("title")}</strong>" , are you absolutely sure you want to delete it?`,
            buttons: [
                {
                    type: "danger",
                    label: "Delete it",
                    handle() {
                        axios.delete(url)
                            .then(response => {
                                if (response.data.success) {
                                    $row.fadeOut();
                                }
                            })
                            .catch(function (error) {
                                if (error.response) {
                                    app.$emit('alert', {message: error.response.data.message});
                                }
                            });
                    }
                },
                {label: "Keep It"},
            ]
        });
    });
});

// ------------------------------------------------------------------------

function initUserList() {
    let $actions = $("#user-list").find(".user-actions");

    $actions.on("click", ".activate, .de-activate", function (e) {
        let url          = $(this).data("url");
        let $thisActions = $(e.delegateTarget);
        let $activate    = $thisActions.find(".activate");
        let $deActivate  = $thisActions.find(".de-activate");
        let $status      = $thisActions.find(".status");

        axios.post(url)
            .then(response => {
                $(window).scrollTop(0);

                $status.text(response.data.status);
                $activate.toggle();
                $deActivate.toggle();

                app.$emit('alert', {type: 'success', message: response.data.message, timer: 5000});
            })
            .catch(error => {
                $(window).scrollTop(0);

                if (error.response) {
                    app.$emit('alert', {message: error.response.data.message})
                }
            });
    })
}

// ------------------------------------------------------------------------

function initPermissionsEditor() {
    let $save        = $("#save-permissions");
    let $permissions = $("input.permission");
    let url          = $save.data('url');

    $save.on("click", function () {
        axios.post(url, $permissions.serialize())
            .then(response => {
                $(window).scrollTop(0);

                app.$emit('alert', {type: 'success', message: response.data.message, timer: 1000});
            })
            .catch(error => {
                $(window).scrollTop(0);

                if (error.response) {
                    app.$emit('alert', {message: error.response.data.message})
                }
            });
    })
}

// ------------------------------------------------------------------------

function initTableSorter() {
    // NOTE: $.tablesorter.theme.bootstrap is ALREADY INCLUDED in the jquery.tablesorter.widgets.js
    // file; it is included here to show how you can modify the default classes
    $.tablesorter.themes.bootstrap = {
        // these classes are added to the table. To see other table classes available,
        // look here: http://getbootstrap.com/css/#tables
        table: 'table table-bordered table-striped',
        caption: 'caption',
        // header class names
        header: 'bootstrap-header', // give the header a gradient background (theme.bootstrap_2.css)
        sortNone: '',
        sortAsc: '',
        sortDesc: '',
        active: '', // applied when column is sorted
        hover: '', // custom css required - a defined bootstrap style may not override other classes
        // icon class names
        icons: '', // add "bootstrap-icon-white" to make them white; this icon class is added to the <i> in the header
        iconSortNone: 'bootstrap-icon-unsorted', // class name added to icon when column is not sorted
        iconSortAsc: 'glyphicon glyphicon-chevron-up', // class name added to icon when column has ascending sort
        iconSortDesc: 'glyphicon glyphicon-chevron-down', // class name added to icon when column has descending sort
        filterRow: '', // filter row class; use widgetOptions.filter_cssFilter for the input/select element
        footerRow: '',
        footerCells: '',
        even: '', // even row zebra striping
        odd: ''  // odd row zebra striping
    };

    // call the tablesorter plugin and apply the uitheme widget
    $("table").tablesorter({
        // this will apply the bootstrap theme if "uitheme" widget is included
        // the widgetOptions.uitheme is no longer required to be set
        theme: "bootstrap",

        widthFixed: true,

        headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

        // widget code contained in the jquery.tablesorter.widgets.js file
        // use the zebra stripe widget if you plan on hiding any rows (filter widget)
        widgets: ["uitheme", "columns", "zebra"],

        widgetOptions: {
            // using the default zebra striping class name, so it actually isn't included in the theme letiable above
            // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
            zebra: ["even", "odd"],

            // class names added to columns when sorted
            columns: ["primary", "secondary", "tertiary"],
        }
    });
}