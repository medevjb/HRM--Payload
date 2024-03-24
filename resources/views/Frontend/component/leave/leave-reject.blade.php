<div class="modal" id="leave-reject-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h4 class=" mt-3 text-danger">Are You Went To Sure To Reject This Application?</h4>
                <div class="rejectId d-none">

                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeDltBtnLeave" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="rejectDeleteLeave" class="btn shadow-sm btn-danger">Reject</button>
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
    $("#rejectDeleteLeave").on("click", async function() {
        let id = $(".rejectId").html();
        // alert(id);
        let res = await axios.post("/rejected-leave-application", {
            id: id
        });
        // console.log(res.data);
        if (res.data.status === "success") {
            // e.preventDefault();
            $('#leave-reject-modal').modal('hide');

            successToast(res.data.message);

            await getListemployeelist();


        } else if(res.data.status === "error") {

            errorToast(res.data.message);

        }else{

            errorToast("Something Went Worng");

        }
    })
</script>
