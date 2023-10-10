$(document).ready(function () {
    console.log("inside document");
    $('#tabled').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: '/admin/trash/ajax',
        order: [],
        columns: [{
            data: 'name',
        },
        {
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
            data: 'address',"width": "10%"
            
        },
        {
            data: 'blood_group'
        },
        {
            data: 'hobbies'
        },
        {
            data: 'description',"width": "15%"
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

                return '<td scope="col" class="text-nowrap"><a class="me-3 restore  text-primary" href="/add/' + data.id + '">Restore</a><a class="delete text-danger" href="/delete/' + data.id + '">Delete</a></td>'
            }
        }
        ],
        columnDefs: [
            {
                "targets": [3,6], 
                "render": function (data, type, row, meta) {
                        return '<div style="word-wrap:break-word;">' + data + '</div>';
                    
                }
            },
            { "orderable": false, "targets": [1, 5, 8] }
            // { "orderable": true, "targets": [1, 2, 3] }

        ],
    });

    $("#delete").click(function(){
        var result = confirm("Want to delete?");
        if (result) {
            this.onclick();
        }
        else{
            return false;
        }
      });
})