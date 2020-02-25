jQuery(function ($) {

    $( document ).on('click', '.customizer-reset', function (event) {
        event.preventDefault();

        var data = {
            wp_customize: 'on',
            action: 'customizer_reset',
            nonce: CUSTOMIZERRESET.nonce.reset
        };

        var r = confirm(CUSTOMIZERRESET.confirm);

        if (!r) return;

        $( this ).attr( 'disabled', 'disabled' );

        $( this ).html( '<i class="fa fa-refresh fa-spin"></i>&nbsp; Loading' );
        
        $.post( ajaxurl, data, function () {
            wp.customize.state('saved').set(true);
            location.reload();
        });
    });
});
