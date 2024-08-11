var controller = new Vue({
    el: '#controller',
    data: {
        datas: [],
        data: {},
        actionUrl,
        apiUrl,
        editStatus: false,
    },
    mounted: function () {
        this.datatable();
    },
    methods: {
        datatable() {
            const _this = this;
            // _this.table = $('#datatable').DataTable({
            //     ajax: {
            //         url: _this.apiUrl,
            //         type: 'GET',
            //     },
            //     columns: columns,
            // }).on('xhr', function () {
            //     _this.datas = _this.table.ajax.json().data;
            // });
            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(data) {
                    _this.datas = data.data;
                },
                error: function(error) {
                    console.log(error);
                }
            });
        },
        addData() {
            this.data = {};
            this.editStatus = false;
            $('#modal-default').modal();
        },
        editData(data, row) {
            this.data = data;
            this.editStatus = true;
            $('#modal-default').modal();
        },
        deleteData(id) {
            if (confirm("Are you sure?")) {
                $(event.target).parents('tr').remove();
                axios.post(this.actionUrl + '/' + id, { _method: 'DELETE' }).then(response => {
                    alert('Data has been removed!');
                    $('#modal-default').modal('hide');
                    this.datatable();
                });
            }
        },
        submitForm(event, id) {
            event.preventDefault();
            const _this = this;
            var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
            axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                $('#modal-default').modal('hide');
                this.datatable();
            });
        },
    }
});