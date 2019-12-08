<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();
	//GET Functions
	//Used to get list of workouts
	$app->get('/workouts', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);

        $query = $this->db->prepare("SELECT * FROM workouts");
        $query->execute();
        $results = $query->fetchAll();
        return $this->response->withJson($results);
    });
	
	//Used to get a specific workout
    $app->get('/workouts/[{id}]', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);

        $query = $this->db->prepare("SELECT * FROM workouts WHERE id=:id");
        $query->bindParam("id", $args['id']);
        $query->execute();
        $results = $query->fetchObject();
        return $this->response->withJson($results);
    });
	
	//Used to get list of dishes
    $app->get('/dishes', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);

        $query = $this->db->prepare("SELECT * FROM dishes");
        $query->execute();
        $results = $query->fetchAll();
        return $this->response->withJson($results);
   });
   
	//Used to get a specific dish
    $app->post('/dishes', function ($request, $response) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);

        $input = $request->getParsedBody();
        $sql = "INSERT INTO dishes (name,description,ingredients,calories,protein,carbs,serving_size,serving_measurement,tags,is_user_created) 
        VALUES (:name,:description,:in,:cal,:pro,:carb,:size,:meas,:tags,:userMade)";
        $query = $this->db->prepare($sql);

        $query->bindParam("name", $input['name']);
        $query->bindParam("description", $input['description']);
        $query->bindParam("in", $input['ingredients']);
        $query->bindParam("cal", $input['calories']);
        $query->bindParam("pro", $input['protein']);
        $query->bindParam("carb", $input['carbs']);
        $query->bindParam("size", $input['serving_size']);
        $query->bindParam("meas", $input['serving_measurment']);
        $query->bindParam("tags", $input['tags']);
        $query->bindParam("userMade", $input['is_user_created']);
        $query->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });
	//Used to get list of diets
   $app->get('/diets', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);
        $query = $this->db->prepare("SELECT * FROM diets");
        $query->execute();
        $results = $query->fetchAll();
        return $this->response->withJson($results);
    });
	
	//Used to get a specific profile
    $app->get('/profiles/[{id}]', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);
        $query = $this->db->prepare("SELECT * FROM profiles WHERE id=:id");
        $query->bindParam("id", $args['id']);
        $query->execute();
        $results = $query->fetchObject();
        return $this->response->withJson($results);
   });
	
	//Used to get a specific dish
    $app->get('/dishes/[{id}]', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);
        $query = $this->db->prepare("SELECT * FROM dishes WHERE id=:id");
        $query->bindParam("id", $args['id']);
        $query->execute();
        $results = $query->fetchObject();
        return $this->response->withJson($results);
    });

    $app->get('/diets/[{id}]', function ($request, $response, $args) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);
        $query = $this->db->prepare("SELECT * FROM diets WHERE id=:id");
        $query->bindParam("id", $args['id']);
        $query->execute();
        $results = $query->fetchObject();
        return $this->response->withJson($results);
    });
	
	//POST Functions
    $app->post('/workouts', function ($request, $response) {
        $apikey = "wrong";
        if (isset($_GET['apikey']))
            $apikey = $_GET['apikey'];
        compareAPIKey($apikey);
        $input = $request->getParsedBody();
        $sql = "INSERT INTO workouts (name,description,video_link,default_reps,default_sets,is_user_created) 
        VALUES (:name,:description,:video,:reps,:sets,:userMade)";
        $query = $this->db->prepare($sql);
        $query->bindParam("name", $input['name']);
        $query->bindParam("description", $input['description']);
        $query->bindParam("video", $input['video_link']);
        $query->bindParam("reps", $input['default_reps']);
        $query->bindParam("sets", $input['default_sets']);
        $query->bindParam("userMade", $input['is_user_created']);
        $query->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });
	
};

//Function used to get the API key and make sure it matches the one provided.
//Otherwise, the API will display a blank page that says "Unauthorized".
function compareAPIKey($key){
    $key = sanitizeString(NULL, $key);
	
	require_once 'apikey.php';
    if ($key != $keytocompare){
        echo "Unauthorized";
        die();
    }
}
