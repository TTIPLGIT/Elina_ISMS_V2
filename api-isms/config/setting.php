<?php

use Illuminate\Support\Facades\Config;

return [
	'jwt' => [
		'secret' => '5DYCzfUIoOyi45AjwOWxzZ1xCDRgc2xTxhsgRugcaJjGNpee6sIwSBsQZmROUeMe',
		'algo' => 'RS256',
		'public_key' => 'jwt/edrms-public.pem',
		'private_key' => 'jwt/edrms-private.pem',
		'passphrase' => '5DYCzfUIoOyi45AjwOWxzZ1xCDRgc2xTxhsgRugcaJjGNpee6sIwSBsQZmROUeMe',
		'ttl' => 120,
	],
	'captcha' => [
		'sitekey' => '6LcfLFUoAAAAACno3hdClnckkDsl4ERrkfhX7Alr',
		'secret' => '6LcfLFUoAAAAACNIAXgZjUfQXDvSUUdAJfjt9Yh5',
	],
	'encrypt' => [
		'key' => 'base64:w7L6oiKZjkdfeB6Fxm3Ovnt1889oq2hvaXCi2hxTVns=',
	],
	'database_connection' => [
		'connection' => 'mysql',
		'host' => '127.0.0.1',
		'port' => 3306,
		'database' => 'isms',
		'username' => 'root',
		'password' => 'root@123',
	],
	'status_code' => [
		'validation' => 400,
		'unauthenticated' => 401,
		'not_found' => 404,
		'success' => 200,
		'created' => 201,
		'exist' => 409,
		'not_exist' => 403,
		'internal' => 428,
		'exception' => 500,
	],

	'status_message' => [
		'unauthenticated' => 'Unauthenticated user.',
		'not_found' => 'Your request is not available.',
		'success' => 'Data read successfully.',
		'created' => 'Created success.',
		'uploaded' => 'Uploaded success.',
		'ticket_fail' => 'Document site authentication faild.',
	],

	// 'web_portal' => 'https://elinaservices.com/',
	// 'document_storage_path' => 'https://isms.elinaservices.com',
	// 'web_portal' => 'http://172.174.141.198/',
	// 'document_storage_path' => 'http://172.174.141.198:60161',
	'web_portal' => 'http://4.240.114.39:8080/',
	'document_storage_path' => 'http://4.240.114.39:60161',
	'isms_base' => 'http://4.240.114.39:60161',

	'web_portal_help_mail' => [
		'to' => 'rama@elinaservices.in',
		'cc' => 'sumithra@elinaservices.in',
	],
	'web_portal_mail' =>
	[
		'to' => 'rama@elinaservices.in',
		'cc' => 'sumithra@elinaservices.in',
	],
	'web_portal_events' =>
	[
		'to' => 'rama@elinaservices.in',
		'cc' => ['sumithra@elinaservices.in', 'narmatha@elinaservices.in', 'alka@elinaservices.in'],
	],
	'enrollment' => [
		'parent' => ['elinaishead@gmail.com'],
		'service_provider' => ['elinaishead@gmail.com'],
		'school' => ['elinaishead@gmail.com'],
		'intern' => ['elinaishead@gmail.com'],
		'bcc' => ['elinaishead@gmail.com'],
	],
	'webportal' => [
		'bcc' => ['elinaishead@gmail.com'],
		'journey' => ['elinaishead@gmail.com'],
		'newsletter_call' => ['elinaishead@gmail.com'],
		'newsletter_meeting' => ['elinaishead@gmail.com'],
		'comment' => ['elinaishead@gmail.com'],
		'event' => ['elinaishead@gmail.com'],
	],
	'ovm_default' => ['elinaishead@gmail.com'],
	// 'webportal' => [
	// 	'bcc' => ['elinaishead@gmail.com'],
	// 	'journey' => ['rama@elinaservices.in','aparna'],
	// 	'newsletter_call' => ['aparna@elinaservices.in'],
	// 	'newsletter_meeting' => ['narmatha@elinaservices.in'],
	// 	'comment' => ['krishnakumari@elinaservices.in','rama'],
	// 	'event' => ['sumithra@elinaservices.in','rama']
	// ],
	'parent_department' => '0,1,2,29',

	'email_id' => env('MAIL_USERNAME', 'anvitha-itservices@elinaservices.in'), 

	'cashfree_client_id' => 'TEST40388335739e65bacde2772d10388304',
	'cashfree_client_secret' => 'TEST6cf2edf0bdb2e556366767480c643dd958d5d010',
	'cashfree_sandbox' => 'https://sandbox.cashfree.com/pg/orders'

];
