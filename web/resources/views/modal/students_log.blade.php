<div class="modal" id="logModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style=" background-color: rgb(0 103 172) !important; align-items: center !important;">
                <h4 class="modal-title" id="modalHeader" style="color: white !important; font-weight: bold !important; font-size: 1.25rem !important;"></h4>
                <button type="button" class="close" data-dismiss="modal" style="color: white !important; font-size: 2.2rem !important; opacity: 1 !important; font-weight: 300 !important; line-height: 1 !important; outline: none !important; padding: 0 !important; margin: 0 !important; margin-top: -20px !important;">&times;</button>
            </div>
            <div class="col-12" style="margin: 5px 0 0 0;">
                <input oninput="search(event)" id="search"
                    style="width: 30%;float: right;margin: 0 15px 0px 0px;font-family:Arial, FontAwesome" type="text"
                    class="form-control default" placeholder="&#xF002; Search">
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-wrapper" style="height: 500px;overflow-x: scroll;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-modal-log">
                            <thead>
                                <tr>
                                    <th width="10%">Sl. No.</th>
                                    <th>Status</th>
                                    <th>Action Time</th>
                                </tr>
                            </thead>
                            <tbody id="logTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer" style="padding: 10px 15px !important; border-top: 1px solid #e9ecef !important;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: rgb(0 103 172) !important; border: none !important; font-weight: bold !important; font-size: 1.1rem !important; padding: 8px 24px !important; border-radius: 5px !important; color: white !important; cursor: pointer !important;">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function search(event) {
        var value = event.target.value.toLowerCase().trim();
        $("#logTable tr").each(function () {
            var rowText = $(this).text().toLowerCase();
            var isMatch = rowText.indexOf(value) > -1;
            $(this).toggleClass('hidden-row', !isMatch);
        });
    }

    $(document).ready(function () {
        $('#logModal').on('hidden.bs.modal', function () {
            $('#search').val('');
            $('#logTable tr').removeClass('hidden-row');
        });
    });
</script>