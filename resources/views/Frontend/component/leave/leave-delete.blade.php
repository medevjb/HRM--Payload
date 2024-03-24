<div class="modal" id="leave-delete-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h4 class=" mt-3 text-warning">Are You Went To Sure Cancle This Leave Application?</h4>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <div class="catID d-none">

                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeDltBtnLeave" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteLeave" class="btn shadow-sm btn-danger">Delete</button>
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
    $("#confirmDeleteLeave").on("click", async function() {
        let id = $(".catID").html();
        // alert(id);
        let res = await axios.post("/delete-leave-application", {
            id: id
        });
        // console.log(res.data);
        if (res.data.status === "success") {
            // e.preventDefault();
            $('#leave-delete-modal').modal('hide');

            successToast(res.data.message);


            $("#insertDataLeave").trigger("reset");
            await getListemployeelist();


        } else if(res.data.status === "failed") {

            errorToast(res.data.message);

        }else{

            errorToast("Something Went Worng");

        }
    })
</script>
