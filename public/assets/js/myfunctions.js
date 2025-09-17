$(function () {
    $('#mbtn').on('click', function () {
        var str = `
        <table>
        <tr>
        <td><input type="text" id="sid"></td>
       
</tr>
</table>`;
        $.confirm({
            title: 'Myalert',
            content: str,
            boxWidth: '300px',
            useBootstrap: false,
            onContentReady: function () {
                this.$content.find('#sid').val('45678');
            },
            buttons: {
                submit: {
                    text: 'Submit',
                    btnClass: 'btn btn-primary',
                    action: function () {
                        var sid = this.$content.find('#sid').val();
                        $.alert(sid);
                    }
                },
                cancel: {
                    text: 'Cancel',
                    btnClass: 'btn-red',
                    action: function () {

                    }
                }
            }
        });
    });
});
