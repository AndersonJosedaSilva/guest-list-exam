<?php
require 'vendor/autoload.php';
require 'database/Connectionfactory.php';
require 'guests/GuestService2.php';


$app = new \Slim\Slim();



$app->get('/guests/', function() use ( $app ) {
    $guests = GuestService2::listGuests();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
});


$app->put('/guests/', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $updatedGuest = json_decode($GuestJson, true);
    
    if($updatedGuest && $updatedGuest['id']) {
        if(GuestService2::update($updatedGuest)) {
          echo "Guest {$updatedGuest['name']} updated";  
        }
        else {
          $app->response->setStatus('404');
          echo "Guest not found";
        }
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});

$app->post('/guests', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $newGuest = json_decode($guestJson,true);
    if($newGuest) {
        $guest = GuestService2::add($newGuest);
        echo "Guest {$guest['name']} added";
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});






$app->delete('/guests/:id', function($id) use ( $app ) {
    if(GuestService2::delete($id)) {
      echo "Guest with id = $id was deleted";
    }
    else {
      $app->response->setStatus('404');
      echo "Guest with id = $id not found";
    }
});
$app->run();
?>