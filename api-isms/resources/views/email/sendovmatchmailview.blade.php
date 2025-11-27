<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<br/>
  Hi {{$data['name']}},
	<br/><br/>
	A OVM-2 Meeting Has Been Completed .<br/><br/>
    OVM Meeting Details:
    <br/><br/>
   Please click the link to view Attached file:
	<a href="{{config('setting.document_storage_path')}}{{$data['storagepathshort']}}/{{$data['ovmattachname']}}"> {{$data['ovmattachname']}}</a>

    <br/><br/>
	<br/><br/><br/>
	Thanks & Regards,
	<br/>

	ISMS
</body>
</html>