<div class="modal fade" id="templates" tabindex="-1" aria-labelledby="templates" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="height:90% !important">
    <div class="modal-content" style="height:90% !important">
      <div class="modal-header" style="background-color:darkblue;">
        <h6 class="modal-title" id="exampleModalLabel"></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" id="template">

        <div class="row">
          <div class="col-md-12">

          </div>

        </div>

        <div class="col-lg-12" id="loading_gif"><img src="{{asset('asset/img/modal_loading.gif')}}" class="document_ifarme_view"></img></div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss-x="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<script>
  // Function to close the modal
  function closeModal() {
        var modal = document.getElementById('templates');
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        modal.setAttribute('style', 'display: none');
        var modalBackdrop = document.getElementsByClassName('modal-backdrop')[0];
        modalBackdrop.parentNode.removeChild(modalBackdrop);
        //document.body.classList.remove('modal-open');
    }

    // Event listener for cancel button click
    document.querySelector('.btn-danger').addEventListener('click', function() {
        closeModal();
    });

    // Event listener for close button click
    document.querySelector('.close').addEventListener('click', function() {
        closeModal();
    });
</script>
