@extends('layouts.adminnav')

@section('content')

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
    {{ Breadcrumbs::render('video_creation.index') }}

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="color:darkblue;text-align: center !important;">Activity Creation List</h4>
        <div>
            <a href="{{ route('video_creation.create') }}" class="btn btn-primary me-2">
                <i class="fa fa-plus me-1"></i> Add Activity
            </a>
            <a href="{{ route('privacy.update', \Crypt::encrypt('4')) }}" class="btn btn-secondary">
                <i class="fa fa-info-circle me-1"></i> General Instructions
            </a>
        </div>
    </div>

    <!-- Toggle Button Group -->
    <div class="mb-4 text-center">
        <div class="btn-group" role="group" aria-label="Toggle Tables">
            <button type="button" id="btnAllActivities" class="btn btn-outline-primary active" onclick="showTable('all')">
                <i class="fas fa-list me-1"></i> All Activities
            </button>
            <button type="button" id="btnPending" class="btn btn-outline-primary" onclick="showTable('pending')">
                <i class="fas fa-clock me-1"></i> Pending Approvals
            </button>
        </div>
    </div>


    <!-- Activity List Table -->
    <div class="card shadow-sm mb-4" id="activityTable">
        <div class="card-body">
            <h5 class="mb-3 text-dark">All Activities</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Age Group</th>
                            <th>Type</th>
                            <th>Activity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row['group'] }}</td>
                            <td>
                                @if($row['category'] == '1') Parent
                                @elseif($row['category'] == '2') Child
                                @else All
                                @endif
                            </td>
                            <td>{{ $row['activity_name'] }}</td>
                            <td>
                                <a href="{{ route('activitymaster.show_1', Crypt::encrypt($row['activity_id'])) }}" title="View" class="btn btn-sm btn-outline-success me-1"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('activitymaster.edit_1', Crypt::encrypt($row['activity_id'])) }}" title="Edit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('activitymaster.mapping', Crypt::encrypt($row['activity_id'])) }}" title="Mapping" class="btn btn-sm btn-outline-info me-1"><i class="fa fa-link"></i></a>
                                <a href="javascript:void(0)" onclick="return myFunction('{{ $row['activity_id'] }}')" title="Delete" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></a>
                                <input type="hidden" id="delete_id_{{ $row['activity_id'] }}" value="{{ route('video_creation.delete', $row['activity_id']) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pending Approval Table -->
    <div class="card shadow-sm d-none mb-4" id="pendingTable">
        <div class="card-body">
            <h5 class="mb-3 text-dark">Pending Approvals</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Activity</th>
                            <!-- <th>Requested By</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingActivities as $index => $pending)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pending['activity_name'] }}</td>

                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="openApprovalModal({{ $pending['activity_id'] }}, '{{ $pending['activity_name'] }}')">
                                    <i class="fas fa-edit me-1"></i> Review
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="approvalForm" method="POST" action="{{route('activity.skill.action')}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Review Activity: <span id="modalActivityName"></span></h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="activity_id" id="modalActivityId">
                        <p>Do you want to approve or reject this activity?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function toggleTable() {
        document.getElementById('activityTable').classList.toggle('d-none');
        document.getElementById('pendingTable').classList.toggle('d-none');
    }

    function openApprovalModal(id, name) {
        document.getElementById('modalActivityId').value = id;
        document.getElementById('modalActivityName').innerText = name;
        
        new bootstrap.Modal(document.getElementById('approvalModal')).show();
    }
</script>
<script>
    function showTable(type) {
        const activityTable = document.getElementById('activityTable');
        const pendingTable = document.getElementById('pendingTable');
        const btnAll = document.getElementById('btnAllActivities');
        const btnPending = document.getElementById('btnPending');

        if (type === 'all') {
            activityTable.classList.remove('d-none');
            pendingTable.classList.add('d-none');
            btnAll.classList.add('active');
            btnPending.classList.remove('active');
        } else {
            activityTable.classList.add('d-none');
            pendingTable.classList.remove('d-none');
            btnAll.classList.remove('active');
            btnPending.classList.add('active');
        }
    }
</script>

@endsection