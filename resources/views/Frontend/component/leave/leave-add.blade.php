<div class="modal" id="leave-create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="insertDataLeave">
            <div class="modal-content">
                <div class="card-body">
                    <h4> Leave Application </h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <h6>Fill Leave Application</h6>
                            <div class="col-md-8 p-2">
                                <label>Leave Type</label>
                                <select name="" id="leaveType" required class="form-control">
                                    <option value="">Select Leave Type</option>
                                    <option value="Casual">Casual</option>
                                    <option value="Sick">Sick</option>
                                </select>
                            </div>
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="col-md-6 p-2">
                                <label>Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="upcomingDate"
                                    min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6 p-2">
                                <label>End Date</label>
                                <input type="date" class="form-control" id="endDate" name="upcomingDate"
                                    min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-12 p-2">
                                <label>Reason Of Leave</label>
                                <textarea id="reson" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="CloseCreateLeave" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-primary" id="submitLeave">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#CloseCreateLeave").on('click', async function(e) {
        e.preventDefault();
        $("#insertDataLeave").trigger("reset");
        $("#update_id").val('');
        $('#leave-create-modal').modal('hide');

    })


    $("#submitLeave").on('click', async function(e) {
        e.preventDefault();

        let leaveType = document.getElementById('leaveType').value;
        let startDate = document.getElementById('startDate').value;
        let endDate = document.getElementById('endDate').value;
        let reson = document.getElementById('reson').value;
        let update_id = document.getElementById('update_id').value;

        // alert(startDate);


        if (leaveType.length === 0) {
            errorToast("Leave Type Required !")
        } else if (startDate.length === 0) {
            errorToast("Start Date Required")
        } else if (endDate.length === 0) {
            errorToast("End Date Required")
        } else if (reson.length === 0) {
            errorToast("Reson Required !")
        } else {

            showLoader();

            let data = {};

            if (update_id != '') {
                data = {
                    leave_type: leaveType,
                    start_date: startDate,
                    end_date: endDate,
                    reason: reson,
                    id: update_id,
                };
            } else {
                data = {
                    leave_type: leaveType,
                    start_date: startDate,
                    end_date: endDate,
                    reason: reson,
                };
            }

            // console.log(data);



            const res = await axios.post("/create-leave", data);

            // console.log(res.data);
            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast('Create Employee');

                $('#leave-create-modal').modal('hide');
                $("#insertDataLeave").trigger("reset");


                await getListemployeelist();

            } else {
                errorToast(res.data['error']);
                console.log(res.data['error'])
            }
        }


    })
</script>
