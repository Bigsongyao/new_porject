var TableDatatablesManaged = function () {

        var initTable1 = function () {

            var table = $('#sample_1');
            var fixedHeaderOffset = 0;
            if (App.getViewPort().width < App.getResponsiveBreakpoint('md')) {
                if ($('.page-header').hasClass('page-header-fixed-mobile')) {
                    fixedHeaderOffset = $('.page-header').outerHeight(true);
                }
            } else if ($('.page-header').hasClass('navbar-fixed-top')) {
                fixedHeaderOffset = $('.page-header').outerHeight(true);
            } else if ($('body').hasClass('page-header-fixed')) {
                fixedHeaderOffset = 64; // admin 5 fixed height
            }
            // begin first table
            table.dataTable({

                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": 正序排列",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "没有数据",
                    "info": "",
                    "infoEmpty": "没有数据",
                    "infoFiltered": "(filtered1 from _MAX_ total records)",
                    "lengthMenu": "Show _MENU_",
                    "search": "搜索当前页:",
                    "zeroRecords": "没有数据"
                },
                paging: false,
                searching:false,
                "columnDefs": [
                    {  // set default column settings
                        'orderable': false,
                        'targets': [0]
                    },
                    {
                        "searchable": false,
                        "targets": [0]
                    },
                    {
                        "className": "dt-right",
                        //"targets": [2]
                    }
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: fixedHeaderOffset
                }
            });
            table.find('.group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            });


        }

        return {

            //main function to initiate the module
            init: function () {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable1();

            }

        };

    }();


    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });