jQuery(document).ready(function($) {
    $.ajax({
        url: 'https://api.leadinfo.com/v1/identify',
        success: function(data){
            console.log(data);
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'save_liquid_data',
                    data: data
                }
            });
        }
    });
});
