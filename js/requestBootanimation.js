$('#submit').click(function() {
    var file_data = $('#file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    
    $.ajax({
        url: 'bootanimation.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        data: form_data,
        success: function(data) {
            alert(data);
            document.getElementById('dl').src = data;
        }
    });
});
