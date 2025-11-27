<?php

use Illuminate\Support\Facades\Config;

return [
	'captcha' => [
		'sitekey' => '6LcfLFUoAAAAACno3hdClnckkDsl4ERrkfhX7Alr',
		'secret' => '6LcfLFUoAAAAACNIAXgZjUfQXDvSUUdAJfjt9Yh5',
	],
		
	'encrypt' => [
		'key' => 'base64:w7L6oiKZjkdfeB6Fxm3Ovnt1889oq2hvaXCi2hxTVns=',
	],
	
	'editor_key' => [
		'tinymce' => 't0fwovhw9tk6zzrn7763zibhuq5id7bfkgnldor4ucjb0lsy',
	],
	'google_vision_api' => [
		'url' => 'https://vision.googleapis.com/v1',
		'key' => 'AIzaSyDmO7obczjHpmu0B4Zl0R9V31gnoWfqoOQ',
	],
	'database_connection' => [
		'connection' => 'mysql',
		'host' => '127.0.0.1',
		'port' => 3306,
		'database' => 'isms',
		'username' => 'root',
		'password' => 'root@123',
	],
	// 'base_url' => 'https://isms.elinaservices.com/',
	'base_url' => 'http://4.240.114.39:60161/',
	// 'base_url' => 'http://172.174.141.198:60161/',

	'api_gateway_url' => 'http://localhost:700/api/gateway',
	

	'document_site_url' => 'http://ttci-uat-com:8080/alfresco/api/-default-/public/alfresco/versions/1',

	'web_portal' => 'https://elinaservices.com',
	// 'web_portal' => 'http://172.174.141.198',

	'document_download_root_path' => 'file-download',

	'document_ghostscript_path' => 'C:\Program Files\gs\gs9.54.0\bin\gswin64c.exe',

	'db_username' => 'root',
	'db_password' => 'root@123',
	'db_database' => 'isms',
    'db_port' => '3306',

	'cashfree_client_id' => 'TEST40388335739e65bacde2772d10388304',
    'cashfree_client_secret' => 'TEST6cf2edf0bdb2e556366767480c643dd958d5d010',
	'cashfree_sandbox' => 'https://sandbox.cashfree.com/pg/orders/'
];