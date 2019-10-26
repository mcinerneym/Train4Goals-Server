<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

	$app->get('/workouts', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM workouts");
        $sth->execute();
        $results = $sth->fetchAll();
        return $this->response->withJson($results);
    });

    $app->get('/dishes', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM dishes");
        $sth->execute();
        $results = $sth->fetchAll();
        return $this->response->withJson($results);
   });

   $app->get('/diets', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM diets");
        $sth->execute();
        $results = $sth->fetchAll();
        return $this->response->withJson($results);
    });

    $app->get('/profile/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM profiles WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $results = $sth->fetchObject();
        return $this->response->withJson($results);
   });

    $app->get('/dish/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM dishes WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $results = $sth->fetchObject();
        return $this->response->withJson($results);
    });

    $app->get('/diet/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM diets WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $results = $sth->fetchObject();
        return $this->response->withJson($results);
    });

    $app->get('/workout/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM workouts WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $results = $sth->fetchObject();
        return $this->response->withJson($results);
    });

    $app->post('/workout', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO workouts (name,description,video_link,default_reps,default_sets,is_user_created) 
        VALUES (:name,:description,:video,:reps,:sets,:userMade)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']);
        $sth->bindParam("video", $input['video_link']);
        $sth->bindParam("reps", $input['default_reps']);
        $sth->bindParam("sets", $input['default_sets']);
        $sth->bindParam("userMade", $input['is_user_created']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });

    $app->post('/dish', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO dishes (name,description,ingredients,calories,protein,carbs,serving_size,serving_measurement,tags,is_user_created) 
        VALUES (:name,:description,:in,:cal,:pro,:carb,:size,:meas,:tags,:userMade)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']);
        $sth->bindParam("in", $input['ingredients']);
        $sth->bindParam("cal", $input['calories']);
        $sth->bindParam("pro", $input['protein']);
        $sth->bindParam("carb", $input['carbs']);
        $sth->bindParam("size", $input['serving_size']);
        $sth->bindParam("meas", $input['serving_measurment']);
        $sth->bindParam("tags", $input['tags']);
        $sth->bindParam("userMade", $input['is_user_created']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });
};
