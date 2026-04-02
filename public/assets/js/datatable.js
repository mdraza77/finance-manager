let isMobile = window.matchMedia("(max-width: 768px)").matches;

// -------------------------- User Management --------------------------------------
// User_Management_table
$(document).ready(function () {
    let options = {
        responsive: true,
        fixedHeader: true,
        paging: true,
        scrollCollapse: false,
        scrollX: true,
        scrollY: 450,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        layout: {
            top1: {
                searchPanes: {
                    viewTotal: true,
                    columns: [0, 1],
                    initCollapsed: true,
                },
            },
            topStart: {
                buttons: [
                    {
                        extend: "pageLength",
                    },
                    {
                        extend: "excel",
                        text: "Excel",
                        title: "SunilSteel ( User Management Details ) ",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                            format: {
                                body: function (data, row, column, node) {
                                    // Convert HTML → plain text
                                    var text = $("<div>").html(data).text();

                                    // Multiple spaces / line-breaks ko single space bana do
                                    return text.replace(/\s+/g, " ").trim();
                                },
                            },
                        },
                    },
                    // {
                    //     extend: "print",
                    //     text: "Print",
                    //     title: "SunilSteel ( User Management Details )",
                    //     exportOptions: {
                    //         columns: [0, 1, 2, 3, 4, 5, 6],
                    //     },
                    // },
                ],
            },
        },
    };
    // Agar mobile nahi hai (desktop/tablet) tab hi fixedColumns add karo
    if (!isMobile) {
        options.scrollX = true;
        options.fixedColumns = {
            end: 1,
        };
    }

    // Initialize DataTables
    let dt = new DataTable("#User_Management_table", options);
});

// Role_Management_table
// -------------------------- Role Management --------------------------------------
$(document).ready(function () {
    let options = {
        responsive: true,
        // fixedColumns: {
        //     start: 1,
        //     end: 1,
        // },
        fixedHeader: true,
        paging: true,
        scrollCollapse: false,
        scrollX: true,
        scrollY: 450,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        layout: {
            top1: {
                searchPanes: {
                    viewTotal: true,
                    columns: [0, 1],
                    initCollapsed: true,
                },
            },
            topStart: {
                buttons: [
                    {
                        extend: "pageLength",
                    },
                    {
                        extend: "excel",
                        text: "Excel",
                        title: "SunilSteel ( Role Management Details )",
                        exportOptions: {
                            columns: [0, 1],
                            format: {
                                body: function (data, row, column, node) {
                                    // Convert HTML → plain text
                                    var text = $("<div>").html(data).text();

                                    // Multiple spaces / line-breaks ko single space bana do
                                    return text.replace(/\s+/g, " ").trim();
                                },
                            },
                        },
                    },
                    // {
                    //     extend: "print",
                    //     text: "Print",
                    //     title: "SunilSteel ( Role Management Details )",
                    //     exportOptions: {
                    //         columns: [0, 1],
                    //     },
                    // },
                ],
            },
        },
    };
    // Agar mobile nahi hai (desktop/tablet) tab hi fixedColumns add karo
    if (!isMobile) {
        options.scrollX = true;
        options.fixedColumns = {
            end: 1,
        };
    }

    // Initialize DataTables
    let dt = new DataTable("#Role_Management_table", options);
});