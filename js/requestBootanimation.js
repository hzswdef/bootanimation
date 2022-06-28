$('#submit').click(function() {
    var file_data = $('#file').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    
    $.ajax({
        url: 'create_bootanimation.php',
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
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