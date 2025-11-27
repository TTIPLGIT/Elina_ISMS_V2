@extends('layouts.adminnav')
@section('content')
<style>
    li.paginate_button.page-item.next.disabled,
    li.paginate_button.page-item.previous.disabled {
        display: none;
    }
</style>
<div class="main-content">

    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');

        }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire('Info!', message, 'info');

        }
    </script>
    @endif

    <section class="section">
        {{ Breadcrumbs::render('ovmreportview',$rows[0]['ovm_isc_report_id']) }}


        <div class="section-body mt-1">
            @if($rows[0]['report_flag'] != 1)
            <a class="btn btn-labeled btn-warning" style="float:right;background: warning !important;margin: 0 15px 2px 0px; border-color:warning !important; color:warning !important" title="Report Preview" href="{{ route('ovm.preview', Crypt::Encrypt($rows[0]['ovm_meeting_id'])) }}"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span> Report Preview</a>
            @endif
            <div class="row">
                <div class="col-12">

                    @foreach($rows as $key => $row)
                    @php $k = $key+1; @endphp
                    <input type="hidden" value="{{$row['ovm_isc_report_id']}}" id="u{{$k}}">
                    @endforeach

                    <div class="card">

                        <div class="card-body">
                            <h5 class="text-center" style="color:darkblue">Conversation Recap</h5>
                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="recap">
                                        <thead>
                                            <tr>
                                                <th width="30%" style="border: 1px solid black !important;">Area</th>
                                                <th width="35%" style="border: 1px solid black !important;" class="u1_coordinator">{{$rows[0]['name']}}
                                                    @if($rows[0]['is_coordinator_id'] == $coordinator[0]['is_coordinator1'])
                                                    <p style="font-size: 15px;font-style: italic;">( Is Coordinator 1 )</p>
                                                    @elseif($rows[0]['is_coordinator_id'] == $coordinator[0]['is_coordinator2'])
                                                    <p style="font-size: 15px;font-style: italic;">( Is Coordinator 2 )</p>
                                                    @endif
                                                </th>
                                                <th width="35%" style="border: 1px solid black !important;" class="u2_coordinator">{{$rows[1]['name']}}
                                                    @if($rows[1]['is_coordinator_id'] == $coordinator[0]['is_coordinator1'])
                                                    <p style="font-size: 15px;font-style: italic;">( Is Coordinator 1 )</p>
                                                    @elseif($rows[1]['is_coordinator_id'] == $coordinator[0]['is_coordinator2'])
                                                    <p style="font-size: 15px;font-style: italic;">( Is Coordinator 2 )</p>
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fetch['question'] as $key => $value)
                                            <tr>
                                                <td style="background: #ffff008f;text-align: left !important;height: fit-content !important;border: 1px solid black !important;">{!! $value['question'] !!}</td>
                                                @if($rows[0]['status'] == 'Submitted' || $rows[0]['status'] == 'Completed')
                                                <td style="text-align: left !important;border: 1px solid black !important;" class="u1_{{$value['question_column_name']}}"></td>
                                                @else
                                                <td style="text-align: left !important;border: 1px solid black !important;"></td>
                                                @endif
                                                @if($rows[1]['status'] == 'Submitted' || $rows[1]['status'] == 'Completed')
                                                <td style="text-align: left !important;border: 1px solid black !important;" class="u2_{{$value['question_column_name']}}"></td>
                                                @else
                                                <td style="text-align: left !important;border: 1px solid black !important;"></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                      {{--  @if($rows[0]['report_flag'] != 1)
                                        @php $role = 'iscoordinator' @endphp
                                        <tfoot>
                                            <tr>
                                                <td style="text-align: left !important;border: 1px solid black !important;background-color: rgb(9 48 110) !important;color: white;">Action</td>
                                                <td style="border: 1px solid black !important;">
                                                    @if($rows[0]['is_coordinator_id'] == $user_id)
                                                    @php $id = Crypt::encrypt($rows[0]['ovm_meeting_id']); @endphp
                                                    <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Edit" href="{{ route('ovmcompleted', ['id' => $id , 'role' => $role]) }}">
                                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Edit </a>
                                                    @else
                                                    <p>-</p>
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black !important;">
                                                    @isset($rows[1])
                                                    @if($rows[1]['is_coordinator_id'] == $user_id)
                                                    @php $id = Crypt::encrypt($rows[1]['ovm_meeting_id']); @endphp
                                                    <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Edit" href="{{ route('ovmcompleted', ['id' => $id , 'role' => $role]) }}">
                                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Edit </a>
                                                    @else
                                                    <p>-</p>
                                                    @endif
                                                    @endisset
                                                </td>
                                            </tr>
                                        </tfoot>
                                        @endif --}}


                                    </table>
                                </div>
                            </div>

                            <div style="margin: 0 0 0 0;text-align: center;">
                                <div class="col-md-12">
                                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('ovmreport')}}" style="color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times-circle"></i></span> Close</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        var fetch = <?php echo json_encode($fetch); ?>;

        var feedbacks = fetch.feedback;

        var u1 = $('#u1').val();
        var u2 = $('#u2').val();

        // $('.u1_conversation_016').val('Text Message');
        // var valueToInsert = "YourValueHere";
        // $('.u1_conversation_016').text(valueToInsert);

        for (var i = 0; i < feedbacks.length; i++) {
            var feedback = feedbacks[i];
            // console.log(feedbacks)
            var feedbackID = feedback.ovm_isc_report_id;
            if (feedbackID == u1) {
                $.each(feedback, function(key, value) {
                    // console.log('.u1_' + key);
                    $('.u1_' + key).html(value);
                    // console.log(key , value);
                });
            } else if (feedbackID == u2) {
                $.each(feedback, function(key, value) {
                    $('.u2_' + key).html(value);
                });
            }
        }
    });
    $(document).ready(function() {
        $('#recap').DataTable({
            "lengthMenu": [
                [10, 50, 100, 250, -1],
                [10, 50, 100, 250, "All"]
            ],
            dom: 'lfrtip',
            "ordering": false,
        });
    });
    $(document).on('click', '.paginate_button:not(.disabled)', function() {
        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    });
</script>

@endsection