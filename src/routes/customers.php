<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;
$app->get('/api/getAllCustomers', function (Request $request, Response $response) {
    $sql="select * from customers";

    try{
      $db = new db();

      $db=$db->connect();

      $stmt=$db->query($sql);
      $customers=$stmt->fetchAll(PDO::FETCH_OBJ);
      $db=null;
      echo json_encode($customers);
    }catch(PDOException $e){
      echo'{"error": {"text":'.$e->getMessage().'}}';
    }
});


$app->get('/api/getCustomer/{id}', function (Request $request, Response $response) {
    $id=$request->getAttribute('id');

    $sql="select * from customers where id= $id";

    try{
      $db = new db();

      $db=$db->connect();

      $stmt=$db->query($sql);
      $customer=$stmt->fetchAll(PDO::FETCH_OBJ);
      $db=null;
      echo json_encode($customer);
    }catch(PDOException $e){
      echo'{"error": {"text":'.$e->getMessage().'}}';
    }
});


$app->post('/api/addCustomer', function (Request $request, Response $response) {
    $first_name=$request->getParam('first_name');
    $last_name=$request->getParam('last_name');
    $phone=$request->getParam('phone');
    $email=$request->getParam('email');
    $address=$request->getParam('address');
    $city=$request->getParam('city');
    $state=$request->getParam('state');

    $sql="insert into customers (first_name,last_name,phone,email,address,city,state) values (:first_name,:last_name,:phone,:email,:address,:city,:state)";

    try{
      $db = new db();

      $db=$db->connect();

      $stmt=$db->prepare($sql);
      $stmt->bindParam(':first_name',$first_name);
      $stmt->bindParam(':last_name',$last_name);
      $stmt->bindParam(':phone',$phone);
      $stmt->bindParam(':email',$email);
      $stmt->bindParam(':address',$address);
      $stmt->bindParam(':city',$city);
      $stmt->bindParam(':state',$state);

      $stmt->execute();

      echo'{"notice": {"text":"customer added"}}';
    }catch(PDOException $e){
      echo'{"error": {"text":'.$e->getMessage().'}}';
    }
});


$app->put('/api/updateCustomer/{id}', function (Request $request, Response $response) {
    $id=$request->getAttribute('id');
    $first_name=$request->getParam('first_name');
    $last_name=$request->getParam('last_name');
    $phone=$request->getParam('phone');
    $email=$request->getParam('email');
    $address=$request->getParam('address');
    $city=$request->getParam('city');
    $state=$request->getParam('state');

    $sql="update customers set
          first_name=:first_name,
          last_name=:last_name,
          phone=:phone,
          email=:email,
          address=:address,
          city=:city,
          state=:state
          where id=$id";

    try{
      $db = new db();

      $db=$db->connect();

      $stmt=$db->prepare($sql);
      $stmt->bindParam(':first_name',$first_name);
      $stmt->bindParam(':last_name',$last_name);
      $stmt->bindParam(':phone',$phone);
      $stmt->bindParam(':email',$email);
      $stmt->bindParam(':address',$address);
      $stmt->bindParam(':city',$city);
      $stmt->bindParam(':state',$state);

      $stmt->execute();

      echo'{"notice": {"text":"customer updated"}}';
    }catch(PDOException $e){
      echo'{"error": {"text":'.$e->getMessage().'}}';
    }
});


$app->delete('/api/deleteCustomer/{id}', function (Request $request, Response $response) {
    $id=$request->getAttribute('id');
    $sql="delete from customers where id=$id";

    try{
      $db = new db();

      $db=$db->connect();

      $stmt=$db->prepare($sql);
      $stmt->execute();
      $db=null;
      echo'{"notice": {"text":"customer deleted"}}';
    }catch(PDOException $e){
      echo'{"error": {"text":'.$e->getMessage().'}}';
    }
});
