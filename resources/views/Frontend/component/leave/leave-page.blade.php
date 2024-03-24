<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <div class="row">
                            <div class="col-md-9">
                                <h4>Leave History</h4>
                            </div>
                            <div class="col-md-3 text-end">
                                <button class="btn-sm btn btn-primary add">Leave Application</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Leave Type</th>
                            <th>Start Leave </th>
                            <th>End Leave</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">
                        {{-- Table Data --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    getListemployeelist();


    async function getListemployeelist() {

        showLoader();
        let res = await axios.get("/leave-history");
        hideLoader();

        console.log(res.data);


        let tableData = $('#tableData');
        let tableList = $('#tableList');

        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, index) {

            let row = `<tr>
                    <td>${index + 1}</td>
                    <td>${item.leave_type}</td>
                    <td>${item.start_date}</td>
                    <td>${item.end_date}</td>
                    `;

            if (item.status === 'approved') {
                row += `
                <td ><span class="bg-success text-white fw-bold px-3 py-1 text-uppercase rounded">${item.status}</span></td>
                    <td class="d-flex align-items-center">
                        <br>
                    </td>
                </tr>
                `;
            } else if (item.status === 'rejected') {
                row += `<td ><span class="bg-danger text-white fw-bold px-3 py-1 rounded text-uppercase">${item.status}</span></td>
                    <td class="d-flex align-items-center">
                        <i data-id="${item.id}" class="fas fa-pen editBtn btn btn-sm btn-success me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-trash delete btn btn-sm btn-danger me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-check approveBtn btn btn-sm btn-success me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-times rejectBtn btn btn-sm btn-danger" style="font-size: 18px;padding: 7px 18px;"></i>
                        
                    </td>
                </tr>`;
            } else {
                row += `<td ><span class="bg-warning text-dark fw-bold px-3 py-1 rounded text-uppercase">${item.status}</span></td>
                    <td class="d-flex align-items-center">
                        <i data-id="${item.id}" class="fas fa-pen editBtn btn btn-sm btn-success me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-trash delete btn btn-sm btn-danger me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-check approveBtn btn btn-sm btn-success me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-times rejectBtn btn btn-sm btn-danger" style="font-size: 18px;padding: 7px 18px;"></i>
                        
                    </td>
                </tr>`;
            }


            tableList.append(row);


        });


        $('.editBtn').on('click', async function() {


            let id = $(this).data('id');


            $("#update_id").val(id);


            showLoader();
            let res = await axios.post('/single-leave-history', {
                id: id
            });
            hideLoader();

            $('#leave-create-modal').addClass("fade-in").modal('show');


            let data = res.data;
            // console.log(data.data.leave_type);


            $("#leaveType > option").each(function() {
                console.log(this.value);
                if (this.value == data.data.leave_type) {

                    $(this).attr("selected", "selected");

                }
            });



            document.getElementById('startDate').value = data.data.start_date;
            document.getElementById('endDate').value = data.data.end_date;
            document.getElementById('reson').value = data.data.reason;


            $("#update-modal").addClass("fade-in").modal('show');
            $("#update_id").val(id);
        })

        $('.delete').on('click', function() {
            let id = $(this).data('id');

            $("#leave-delete-modal").addClass("fade-in").modal('show');

            $(".catID").html(id);
        })
        $('.approveBtn').on('click', function() {
            let id = $(this).data('id');

            $("#leave-approve-modal").addClass("fade-in").modal('show');

            $(".approveId").html(id);
        })

        $('.rejectBtn').on('click', function() {
            let id = $(this).data('id');

            $("#leave-reject-modal").addClass("fade-in").modal('show');

            $(".rejectId").html(id);
        })



        tableData.DataTable({
            order: [
                [0, 'desc']
            ],
            lengthMenu: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }
        });
    }



    $('.add').on('click', async function() {
        $("#leave-create-modal")
            .addClass("fade-in")
            .modal('show');
    });
</script>
