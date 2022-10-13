$(document).ready(function() {

    var currentPath  = '/hiscores';
    var locked       = false;
    var page         = 1;
    var sort         = "kdr";
    var order        = "desc";

    $.post(currentPath+"/pvptable", {
        page:  page,
        sort:  sort,
        order: order
    }).done(function(data) {
        $('#pvptable').html(data);
    });

    $(document).on("click", ".sort-btns",  function(e) {
        var sorter = $(this).data('sort');

        if (locked) {
            return;
        }
        if (sorter != sort) {
            order = 'desc';
        } else {
            order = order == 'desc' ? 'asc' : 'desc';
        }

        sort = sorter;
        locked = true;

        $.post(currentPath+"/pvptable", {
            page:  page,
            sort:  sort,
            order: order
        }).done(function(data) {
            $('#pvptable').html(data);
            locked = false;
        });
    });

    $(document).on("click", "#pagebtn",  function(e) {
        e.preventDefault();

        var pageNumber = $(this).data('page');

        if (pageNumber == page || locked) {
            return;
        }

        page = pageNumber;
        locked = true;

        $.post(currentPath+"/pvptable", {
            page:  page,
            sort:  sort,
            order: order
        }).done(function(data) {
            $('#pvptable').html(data);
            locked = false;
        });
    });
});
