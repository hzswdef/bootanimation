function getRecent() {
    $.ajax({
        url: 'getRecent.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        type: 'GET',
        success: function(data) {
            //alert(data);
            $('.recent-items-wrapper').empty();
            $('.recent-items-wrapper').append(data);
        }
    });
}

$(document).ready(function(){
    getRecent();
});
