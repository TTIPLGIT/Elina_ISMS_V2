<div class="modal" id="logModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style=" background-color: rgb(0 103 172) !important;">
                <h4 class="modal-title" id="modalHeader"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="col-12" style="margin: 5px 0 0 0;">
            <input oninput="search(event)" id="search" style="width: 30%;float: right;margin: 0 15px 0px 0px;font-family:Arial, FontAwesome" type="text" class="form-control default" placeholder="&#xF002; Search">
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-wrapper" style="height: 500px;overflow-x: scroll;">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
        </div>
    </div>
</div>
<script>
    function search(event) {
        var value = event.target.value;
        value = value.toLowerCase();
        $("#logTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }
</script>