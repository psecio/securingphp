<?php

require_once __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

$cacheFile = '/tmp/tweet-cache.json';

if (!is_file($cacheFile) || filectime($cacheFile) <= time()-3600) {
    error_log('needs to cache!');

    $client = new Client(['base_url' => 'https://api.twitter.com/1.1/']);
    $oauth = new Oauth1([
        'consumer_key'    => '2EVSydDROeswXYGEClKBJ8WHx',
        'consumer_secret' => 'QSYVy1cBkpqV1e5jbSidhQMBtOXM32cuRCZt5A4HQCJIXrkYIw',
        'token'           => '2284179864-HjIh2X3GvzaLn0Gn879jDxVeOT2ys0Bs6SYHFrb',
        'token_secret'    => 'Wm9dzlu5gIdLUuMB9GIKooUVRGNSYgEGupoufvtEF38Mq'
    ]);

    $client->getEmitter()->attach($oauth);

    // Set the "auth" request option to "oauth" to sign using oauth
    $res = $client->get('statuses/home_timeline.json', ['auth' => 'oauth']);
    $tweets = $res->json();

    file_put_contents($cacheFile, json_encode($tweets));
}
$tweets = json_decode(file_get_contents($cacheFile));
$jsonOutput = array();

foreach ($tweets as $tweet) {
    $jsonOutput[] = array(
        'date' => $tweet->created_at,
        'text' => $tweet->text,
        'url' => 'https://twitter.com/SecuringPHP/status/'.$tweet->id
    );
}

echo json_encode($jsonOutput);