jQuery(document).ready(function($) {
    $.ajax({
        url: 'https://api.leadinfo.com/v1/identify',
        success: function(data){
            // mostra i dati nella console del tuo browser
            console.log(data);

            // Aggiungi l'indirizzo IP dell'utente ai dati
            data.user_ip = userSettings.user_ip;

            // Salva i dati nel database di WordPress
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
