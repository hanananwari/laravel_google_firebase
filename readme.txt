Google Firebase

pertama install

composer require kreait/firebase-php ^4.24

setting .env

FIREBASE_SERVER_KEY
FIREBASE_MESSAGING_SENDER_ID
FIREBASE_SERVICE_ACCOUNT_PATH (relative path ke ./storage folder di aplikasi)


install di config app 

'providers' => [
	
	\Solumax\GoogleFirebase\SolumaxGoogleFirebaseProvider::class,

]

'aliases' => [
	

    'SolGoogleFirebase' => Solumax\GoogleFirebase\Facade\SolGoogleFirebaseFacade::class,
]



vendor:publish
 php artisan vendor:publish --provider="Solumax\GoogleFirebase\SolumaxGoogleFirebaseProvider" --tag=config
 php artisan vendor:publish --provider="Solumax\GoogleFirebase\SolumaxGoogleFirebaseProvider" --tag=public
 php artisan vendor:publish --provider="Solumax\GoogleFirebase\SolumaxGoogleFirebaseProvider" --tag=migrations

 php artisan migrate:byTenant 66 --path=database/migrations/solumax/google-firebase



setting di config google firebase untuk topics

'topicGroups' => [
	'admin' => [
		[
			'code' => 'antrian',
			'name' =>'Seluruh Antrian',
			'subscribe' => false
		],
		[
			'code' => 'service_express',   
			'name'=>'Service Express',
			'subscribe' =>false
		],
	],

],





tambahkan  di view index

@include('solumax.googleFirebase::_firebaseNotificationSetup')


untuk membuat notifikasi

// data yang akan muncul di notifi

$payload = new \Solumax\GoogleFirebase\App\Payload\Payload('judul notifikasi', 'body / isi dari notifikasi', 'link ', 'logo');

//masukan topic

\SolGoogleFirebase::webPushNotification()->sendByTopic((string) $topic, $payload->generate());

// atau masukan token

\SolGoogleFirebase::webPushNotification()->sendToSpecificDevice((string) $token, (string nullable) $topic, $payload->generate());


