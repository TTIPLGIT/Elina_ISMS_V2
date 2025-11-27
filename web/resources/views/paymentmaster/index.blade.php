@extends('layouts.adminnav')
@section('content')


<style>
  /* General reset and layout */
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    margin: 0;
    padding: 0;
  }

  /* Tab container styling */
  .tabs {
    display: flex;
    margin-bottom: 5px;
    border-bottom: 2px solid #ddd;
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
  }

  /* Individual tab item styles */
  .tab-item {
    padding: 15px 30px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    color: #6c6c6c;
    transition: all 0.3s ease;
    border-radius: 5px 5px 0 0;
    text-align: center;
  }

  .tab-item:hover {
    background-color: #f1f1f1;
    color: #007bff;
  }

  /* Active tab styles */
  .tab-item.active {
    background-color: #007bff;
    color: white;
    box-shadow: 0 2px 10px rgba(0, 123, 255, 0.4);
  }

  /* Content container styling */
  .tab-content {
    display: none;
    /* padding: 30px; */
    background-color: #fff;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-top: -1px;
  }

  /* Active content visibility */
  .tab-content.active {
    display: block;
  }

  /* Sub-tabs under "Schools" */
  .sub-tabs {
    display: flex;
    justify-content: space-between;
    /* margin-top: 20px; */
  }

  .sub-tabs .tab-item {
    flex-grow: 1;
    text-align: center;
  }

  /* Modern typography */
  h1,
  h2,
  h3 {
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
  }

  ul {
    padding-left: 20px;
  }

  li {
    margin: 10px 0;
    font-size: 14px;
    color: #555;
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .tabs {
      flex-direction: column;
    }

    .sub-tabs {
      flex-direction: column;
    }
  }
</style>
<style>
  a:hover,
  a:focus {
    text-decoration: none;
    outline: none;
  }

  .danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
  }

  #align {
    border-collapse: collapse !important;
  }

  table.dataTable.no-footer {
    border-bottom: .5px solid #002266 !important;
  }

  thead th {
    height: 5px;
    border-bottom: solid 1px #ddd;
    font-weight: bold;
  }
</style>
<style>
  .section {
    margin-top: 20px;
  }
</style>
<style>
  .input-group-text {
    cursor: pointer;
    /* Change cursor to pointer when hovering over the icon */
  }

  table.table-bordered>tbody>tr>td {
    border: 1px solid black !important;
  }
</style>
<style>
  #openModalBtn {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
  }

  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    /* overflow: auto; */
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    /* Black with opacity */
  }

  .modal-content {
    background-color: #fff;
    margin: 5% auto;
    height: 500px;
    padding: 20px;
    border-radius: 10px;
    width: 60%;
    max-width: 600px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
  }

  .close-btn {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 20px;
    cursor: pointer;
  }

  .close-btn:hover,
  .close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  /* Timeline styles */
  .timeline {
    margin-top: 20px;
    height: 500px;
    overflow: scroll;
  }

  .timeline-item {
    background-color: #f9f9f9;
    padding: 10px;
    margin-bottom: 15px;
    border-left: 5px solid #3498db;
  }

  .timeline-item h3 {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
  }

  .timeline-item p {
    margin: 5px 0 0;
  }
</style>
<div class="main-content">

  <section class="section">
    {{ Breadcrumbs::render('payment_master.index') }}
    
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data').val();
        Swal.fire('Success!', message, 'success');
      }
    </script>
    @elseif(session('error'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data1').val();
        Swal.fire('Info!', message, 'info');
      }
    </script>
    @endif

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Payment Master</h4>
    </div>
    <div class="section-body">

      <a type="button" value="Cancel" class="btn btn-labeled btn-info ml-3" title="create" href="{{ route('payment_master.create') }}"><span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Add Payment Master</span></a>

      <div class="row">
        <div class="col-12">
          <div class="card-body" style="padding: 0;">
            <!-- Tabs -->
            <div class="tabs">
              <div id="general-tab" class="tab-item active">General</div>
              <div id="schools-tab" class="tab-item">Schools</div>
            </div>
            <!-- Tab Contents -->
            <div id="general-content" class="tab-content active">
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fees Type</th>
                        <th>Payment Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      @if($row['category'] == 'General')
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['fee_type'] }}</td>
                        <td>{{ $row['final_amount'] }}</td>
                        <td>
                          <a class="btn btn-link" title="Edit" href="{{ route('payment_master_edit_data', Crypt::encrypt($row['id'])) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
                          <a class="btn btn-link" title="Timeline" data-id="{{$row['id']}}" id="openModalBtn"><i class="fa fa-history" style="color:green"></i></a>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div id="schools-content" class="tab-content">
              <!-- Sub-tab Contents -->
              <div id="registration-content" class="tab-content active">
                <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>School Name</th>
                          <th>Enrollment</th>
                          <th>Type</th>
                          <th>Fees</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($rows as $key=>$row)
                        @if($row['category'] == 'School')
                        @foreach($schools as $key => $school)
                        @if($row['school_id'] == $school['id'])
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{$school['school_name']}}</td>
                          <td>{{$school['school_unique']}}</td>
                          <td>{{ $row['fee_type'] }}</td>
                          <td>{{ $row['final_amount'] }}</td>
                          <td>
                            <a class="btn btn-link" title="Edit" href="{{ route('payment_master_edit_data', Crypt::encrypt($row['id'])) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
                            <a class="btn btn-link" title="Timeline" data-id="{{$row['id']}}" id="openModalBtn"><i class="fa fa-history" style="color:green"></i></a>
                          </td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <script>
              // Main tab switch functionality
              document.querySelectorAll('.tabs .tab-item').forEach(tab => {
                tab.addEventListener('click', function() {
                  // Remove active class from all tabs
                  document.querySelectorAll('.tabs .tab-item').forEach(item => item.classList.remove('active'));
                  // Add active class to clicked main tab
                  this.classList.add('active');

                  // Hide all tab contents
                  document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                  // Show the content of the active main tab
                  if (this.id === 'general-tab') {
                    document.getElementById('general-content').classList.add('active');
                  } else if (this.id === 'schools-tab') {
                    document.getElementById('schools-content').classList.add('active');
                  }
                });
              });

              // Sub-tab switch functionality inside "Schools"
              document.querySelectorAll('.sub-tabs .tab-item').forEach(subTab => {
                subTab.addEventListener('click', function() {
                  // Remove active class from all sub-tabs
                  document.querySelectorAll('.sub-tabs .tab-item').forEach(item => item.classList.remove('active'));
                  // Add active class to clicked sub-tab
                  this.classList.add('active');

                  // Hide all sub-tab contents inside "Schools"
                  document.querySelectorAll('#schools-content .tab-content').forEach(content => content.classList.remove('active'));

                  // Show the content of the active sub-tab
                  if (this.id === 'registration-tab') {
                    document.getElementById('registration-content').classList.add('active');
                  } else if (this.id === 'sail-tab') {
                    document.getElementById('sail-content').classList.add('active');
                  }
                });
              });

              // Set default active content for the "Schools" tab
              document.getElementById('schools-tab').addEventListener('click', function() {
                // When "Schools" is clicked, ensure that "Registration" content is visible by default
                document.getElementById('registration-content').classList.add('active');
                document.getElementById('registration-tab').classList.add('active');
              });
            </script>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Modal structure -->
<div id="timelineModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h2>Timeline</h2>
    <div class="timeline">
      <div class="timeline-item">
        <h3></h3>
        <p></p>
      </div>
    </div>
  </div>
</div>
<script>
  // Assuming you have $data in the script section
  const timelineData = <?php echo json_encode($logs); ?>;

  // Adding event listener to each "Timeline" button
  document.querySelectorAll('.btn.btn-link[title="Timeline"]').forEach(btn => {
    btn.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      console.log("Timeline button clicked! ID: " + id);

      modal.style.display = "block";

      const timelineContainer = document.querySelector('.timeline');
      timelineContainer.innerHTML = '';

      timelineData.forEach(item => {
        if (item.payment_process_id == id) {
          const timelineItem = document.createElement('div');
          timelineItem.classList.add('timeline-item');

          const title = document.createElement('h3');
          title.textContent = '₹' + item.amount;
          timelineItem.appendChild(title);

          const description = document.createElement('p');
          description.textContent = item.description;
          timelineItem.appendChild(description);
          const created_at = document.createElement('p');

          const date = new Date(item.created_at);

          const formattedDate = new Intl.DateTimeFormat('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
          }).format(date);

          created_at.textContent = formattedDate;
          timelineItem.appendChild(created_at);

          timelineContainer.appendChild(timelineItem);
        }
      });
    });
  });

  const modal = document.getElementById('timelineModal');
  const closeModalBtn = document.getElementsByClassName('close-btn')[0];

  closeModalBtn.onclick = function() {
    modal.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
@endsection