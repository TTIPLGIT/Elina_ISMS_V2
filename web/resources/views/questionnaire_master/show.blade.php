@extends('layouts.app')

@section('content')
<div class="row">   
  <div class="col-md-12 col-lg-12 mlr-auto">
    <div class="tile my-4">
      <h3 class="tile-title">Document Category Show</h3>
      <div class="tile-body">
       
          @csrf
          <div class="row">




            <input class="form-control" type="hidden"  id="que_id" name="que_id"  placeholder="Enter Module Name" value="{{ $one_row[0]['category_id'] }}">



            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Document Category <span style="color: red;font-size: 16px;">*</span></label>
                <input class="form-control" type="text"  id="category_name" name="category_name"  placeholder="Enter Document Category" value="{{ $one_row[0]['category'] }}"  disabled="">
              </div>
            
            </div>


          </div>  
        </div>  
        <div class="row text-center">
          <div class="col-md-12">

            <a class="btn btn-danger" href="{{ route('document_sub_category.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
          </div>                
        </div>

      </div>


    </form>
  </div>
</div>
</div>
</div>

<script type="text/javascript">

function validateForm() {

 let category_name = document.forms["uam_category"]["category_name"].value;
 if (category_name == "") {
  bootbox.alert({
    title: "Document Category Creation",
   centerVertical: true,
   message: "Please enter category name",
});
  return false;
}

}


</script>

@endsection


