$('#file').on('change', function(){
    $('.upload-bl').css({'display': 'none'});
    $('.settings-bl').css({'display': 'flex'});
    
    $('#preview-src').attr({
        'src': window.URL.createObjectURL($('#file').prop('files')[0])
    });
});

function sendRequest(url=null) {
    if (url == null) {
        var file_data = $('#file').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
    } else {
        var form_data = {'url': $('#inputURL').val()}
    }
    
    $.ajax({
        url: 'bootanimation.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        data: form_data,
        success: function(data) {
            $('#submit').removeClass('button--loading');
            //alert(data);
            
            // Update 'Recent' section
            getRecent();
            
            document.getElementById('dl').src = data;
        }
    });
}

$('#submit').click(function() {
    sendRequest();
});