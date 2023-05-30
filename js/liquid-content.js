jQuery(document).ready(function($) {
    $.ajax({
        url: 'https://api.leadinfo.com/v1/identify',
        success: function(data){
            // mostra i dati nella console del tuo browser
            console.log(data);
        }
    });
});
