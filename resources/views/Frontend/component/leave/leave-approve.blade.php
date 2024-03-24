<div class="modal" id="leave-approve-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h4 class=" mt-3 text-warning">Are You Went To Sure To Approve This Application?</h4>
                <div class="approveId d-none">

                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeDltBtnLeave" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="approveApplication" class="btn shadow-sm btn-success">Approve</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $("#closeDltBtnLeave").on('click', function(e) {
        e.preventDefault();
        $('#leave-delete-modal').modal('hide');

    })
    $("#approveApplication").on("click", async function() {
        let id = $(".approveId").html();
        // alert(id);
        let res = await axios.post("/approved-leave-application", {
            id: id
        });
        // console.log(res.data);
        if (res.data.status === "success") {
            // e.preventDefault();
            $('#leave-approve-modal').modal('hide');

            successToast(res.data.message);


            $("#insertDataLeave").trigger("reset");
            await getListemployeelist();


        } else if(res.data.status === "error") {

            errorToast(res.data.message);

        }else{

            errorToast("Something Went Worng");

        }
    })
</script>
