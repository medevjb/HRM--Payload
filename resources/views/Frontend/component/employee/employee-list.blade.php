<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Customer</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
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
        // swal("My title", "My description", "danger");

        showLoader();
        let res = await axios.get("/employee-list");
        hideLoader();


        let tableData = $('#tableData');
        let tableList = $('#tableList');

        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, index) {
            let row = `<tr>
                    <td>${index + 1}</td>
                    <td>${item.firstName +" "+ item.lastName}</td>
                    <td>${item.email}</td>
                    <td>${item.mobile}</td>
                    <td class="d-flex align-items-center">
                        <i data-id="${item.id}" class="far fa-eye btn show  btn-sm btn-primary me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" class="fas fa-pen editBtn btn btn-sm btn-success me-1" style="font-size: 18px;padding: 7px 18px;"></i>
                        <i data-id="${item.id}" data-name="${item.firstName+" "+item.lastName}" class="fas fa-trash delete btn btn-sm btn-danger" style="font-size: 18px;padding: 7px 18px;"></i>
                        
                    </td>
                </tr>`;
            tableList.append(row);
        })


        $('.editBtn').on('click', async function() {
            let id = $(this).data('id');


            $("#update_id").val(id);

            showLoader();
            let res = await axios.post('/user-profile-full', {
                id: id
            });



            let data = res.data['data'];
            // console.log(data);

            let role = data['role'];
            document.getElementById('eoldImage').value = data['user_detail']['profile'];

            document.getElementById('eemail').value = data['email'];
            document.getElementById('efname').value = data['firstName'];
            document.getElementById('elname').value = data['lastName'];
            document.getElementById('emobile').value = data['mobile'];
            document.getElementById('eselary').value = data['user_detail']['selary'];
            document.getElementById('update_id').value = data['id'];


            if (data['user_detail']['profile'] === 'noImage') {
                
                $('#enewImg').attr("src", 'images/default.jpg');

            } else if(data['user_detail']['profile']) {
                $('#enewImg').attr("src", data['user_detail']['profile']);
            }else{
                $('#enewImg').attr("src", 'images/default.jpg');
            }
            document.getElementById('eaboutMe').value = data['user_detail']['about_me'];


            $('#erole > option').each(function() {
                if ($(this).val() === role) {
                    $(this).attr("selected", "selected");
                }
            });

            hideLoader()


            $("#update-modal").addClass("fade-in").modal('show');
            $("#update_id").val(id);
        })

        $('.delete').on('click', function() {
            let id = $(this).data('id');
            let Name = $(this).data('name');
            $(".catName").text(Name);
            $("#delete-modal").addClass("fade-in").modal('show');
            $(".catID").html(id);
        })


        $('.show').on('click', async function() {
            let id = $(this).data('id');
            $("#profile-show-modal").addClass("fade-in").modal('show');
            $(".catID").html(id);


            showLoader();
            let res = await axios.post("/single-employee-list", {
                id: id
            });
            hideLoader();

            console.log(res.data.data);
            console.log(res.data.data['user_detail']['profile']);

            $(".catName").text(res.data.data['firstName'] + " " + res.data.data['lastName']);


            if (res.data.data['user_detail']['profile'] != 'noImage') {
                $("#employeeProfile").attr("src", res.data.data['user_detail']['profile']);
            }

            // $(".role").text(res.data.data['role']);
            if (res.data.data['role'] == 'user') {
                $(".role").text('Employee');
            }
            $("#phone").text(res.data.data['mobile']);
            $("#employeeEmail").text(res.data.data['email']);

            $("#employeeAboutMe").text(res.data.data['user_detail']['about_me']);
            $("#employeeSelary").text(res.data.data['user_detail']['selary']);


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
</script>
