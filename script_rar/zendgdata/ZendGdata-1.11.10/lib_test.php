<?

$clientLibraryPath = 'library';
$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $clientLibraryPath);


require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
Zend_Loader::loadClass('Zend_Gdata_YouTube');
$yt = new Zend_Gdata_YouTube();

Zend_Loader::loadClass('Zend_Gdata_ClientLogin'); 

$authenticationURL= 'https://www.google.com/youtube/accounts/ClientLogin';
$httpClient = Zend_Gdata_ClientLogin::getHttpClient(
                                          $username = 'postrealist@gmail.com',
                                          $password = 'alebastrov314',
                                          $service = 'youtube',
                                          $client = null,
                                          $source = 'boardMSU', // a short string identifying your application
                                          $loginToken = null,
                                          $loginCaptcha = null,
                                          $authenticationURL);
                                          
                                          
$myDeveloperKey = '314271';
$httpClient->setHeaders('X-GData-Key', "key=${myDeveloperKey}");
$yt = new Zend_Gdata_YouTube($httpClient);                                          
                                          
                                          

?>