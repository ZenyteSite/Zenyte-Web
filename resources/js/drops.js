$(document).ready(function() {
    var currentPath     = '/drops';
    var npclist         = $('#npclist');
    var searchField     = $('#npcname');
    var timer 			= null;

    searchField.on('keyup', function() {
        var input = searchField.val();

        if (timer != null) {
            clearTimeout(timer);
            timer = null;
        }

        timer = setTimeout(function() {
            if (input == '') {
                npclist.html("");
            } else {
                if (input.length < 3) {
                    return;
                }

                $.post(currentPath+"/search", {
                    search: input
                }).done(function(data) {
                    npclist.html(data.toString());
                });
            }
        }, 700);
    });

    $(document).on("click", "#pagebtn",  function(e) {
        e.preventDefault();

        var pageNumber = $(this).data('page');
        var pattern = /^[0-9]+$/;

        if (!pattern.test(''+pageNumber+'') || pageNumber == currentPage || locked) {
            return;
        }

        currentPage = pageNumber;
        locked = true;

        loadItems(lastCategory, pageNumber);
    });

});