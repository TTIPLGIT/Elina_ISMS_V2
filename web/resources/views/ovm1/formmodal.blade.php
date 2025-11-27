<style>
  input[type="checkbox"] {
    display: none;
  }

  .faq-drawer {
    /* width: 75%;
    margin-bottom: 1.8rem; */
    flex: 1;
    box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
  }

  .faq-drawer__title {
    display: block;
    position: relative;
    padding: 5px 5px 5px 25px;
    margin-bottom: 0;
    background: white;
    color: #373737;
    font-weight: 600;
    font-size: 15px;
    border-radius: 8px;
    transition: all 0.25s ease-out;
    cursor: pointer;
  }

  .faq-drawer__title:hover {
    color: #747474;
  }

  .faq-drawer__title::after {
    content: " ";
    position: absolute;
    width: 0;
    height: 0;
    top: 15px;
    right: 20px;
    float: right;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid currentColor;
    transition: transform 0.2s ease-out;
  }

  .faq-drawer__trigger:checked+.faq-drawer__title::after {
    transform: rotate(-180deg);
  }

  .faq-drawer__content-wrapper {
    overflow: hidden;
    max-height: 0px;
    font-size: 15px;
    line-height: 23px;
    transition: max-height 0.25s ease-in-out;
  }

  .faq-drawer__trigger:checked+.faq-drawer__title+.faq-drawer__content-wrapper {
    max-height: max-content;
  }

  .faq-drawer__trigger:checked+.faq-drawer__title {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .faq-drawer__content-wrapper .faq-drawer__content {
    background: white;
    padding: 2px 18px 14px;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
  }
</style>
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
        <div style="display: contents;">
          <div class="faq-drawer">
            <input class="faq-drawer__trigger" id="faq-drawer" type="checkbox" /><label class="faq-drawer__title" style="background: #96a3d5c7;" for="faq-drawer">Email Preview</label>
            <div class="faq-drawer__content-wrapper">
              <div class="faq-drawer__content">
                <textarea class="form-control" id="email_content" name="email_content">
                {{$email[0]['email_body']}}
                </textarea>
              </div>
            </div>
          </div>
          <button onclick="send_form()" class="btn btn-danger" data-dismiss="modal" style="margin: 0 5px 0px 5px;">Send</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        tinymce.init({
        selector: 'textarea#email_content',
        height: 400,
        max_chars: 10,
        menubar: false,
        branding: false,
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat ',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    });
    });
</script>