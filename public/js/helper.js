
var helper = {
    deleteConfirm: function deleteConfirm(callback) {
        swal({
              title: '確定要刪除?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
        }).then(callback);
    },
    alert: function alert(message, type='success') {
        $.notify({
        	// options
        	icon: 'glyphicon glyphicon-warning-sign',
        	message: message
        },{
        	// settings
        	type: type,
            delay: 2500,
        });
    }
}
