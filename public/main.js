$('#remove').click(function(e) {
    e.preventDefault(); // отключили поведение по-умолчанию

    var url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'DELETE',
        success: function(result) {
            document.location.reload(true);
        }
    });
});