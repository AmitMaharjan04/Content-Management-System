$(document).ready(function () {
    $('#test').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: '/admin/dashboard/ajax',
        order: [],
        columns: [{
            data: 'name',
        },
        {
            // data: 'gender'
            data: 'gender', render: function (data, type, row) {

                if (data == 'M') {
                    return '<td>Male</td>';
                } else if (data == 'F') {
                    return '<td>Female</td>';
                } else {
                    return '<td>Others</td>';
                }
            },
        },
        {
            data: 'email'
        },
        {
            data: 'address', "width": "10%"

        },
        {
            data: 'blood_group'
        },
        {
            data: 'hobbies'
        },
        {
            data: 'description', "width": "15%"
        },
        {
            data: 'file', defaultContent: ""
            , render: function (data, type, row) {
                if (data != null) {
                    return '<a class="file" href="' + data + '" target="_blank">View file</a>';
                }
            },
        },

        {
            data: null, render: function (data, type, row) {

                return '<td scope="col" class="text-nowrap"><a class="me-3 edit" href="/add/' + data.id + '">Edit</a><a class="delete text-dark" href="/delete/' + data.id + '">Trash</a></td>'
            }
        }
        ],
        columnDefs: [
            {
                "targets": [3, 6],
                "render": function (data, type, row, meta) {
                    return '<div style="word-wrap:break-word;">' + data + '</div>';

                }
            },
            { "orderable": false, "targets": [1, 5, 8] }
            // { "orderable": true, "targets": [1, 2, 3] }

        ],
    });
    $('.dataTables_filter input[type="search"]').
        attr('placeholder', 'test@gmail.com').
        css({ 'width': '152px', 'text-align' :'center' });
    $('#import').submit(function (event) {
        event.preventDefault();
        const fileInput = document.getElementById('formFile');
        if (!fileInput.value) {
            $('#msg').removeAttr('hidden');
            $('#msg').show();
            $('#msg').html('Please select file to import');
            return false;
        }
        this.submit();
    });
});