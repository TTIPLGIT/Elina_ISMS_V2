<div class="modal fade" id="requiredmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <textarea name="emaildraft" id="emaildraft">
                    <p>Dear Parent,</p>
                    <p>All activities marked * are mandatory for our observation and assessment. We request you to carry out the activity to the best possible extent without causing distress to the child.</p>
                    <!-- <p>Here is a comprehensive list of the activities that need to be addressed:</p> -->
                    <!-- <p>listActivity</p> -->
                    <p>&nbsp;</p>
                    <p>Thanks and Regards,</p>
                    <p>Team Elina</p>  
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background: dodgerblue;" class="btn btn-default" onclick="sendRequired()">Send</button>
                    <button type="button" style="background: dodgerblue;" class="btn btn-default" id="btnclose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#emaildraft',
            height: 180,
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    });

    function sendRequired() {
        var emaildraft = tinymce.get('emaildraft').getContent();
        var activityids = [];
        $("input[name='markRequired']:checked").each(function() {
            id = $(this).val();
            activityids.push(id);
        });
        var enrollment_id = document.getElementById('enrollment_id').value;
        $('.loader').show();
        $.ajax({
            url: "{{ url('/activity/send/required') }}",
            type: 'POST',
            data: {
                'activityids': activityids,
                'emaildraft': emaildraft,
                'enrollment_id':enrollment_id,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            if (data != '[]') {
                if (data.Code == 200) {
                    $('.loader').hide();
                    swal.fire("Success!", "Activity Updated Successfully", "success").then(function() {
                        location.reload();
                    });

                } else {
                    Swal.fire('Info!', data.Message, 'info');
                    return false;
                    // location.reload();
                }
            }
        })
    }
</script>