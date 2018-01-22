<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->get('/classes', 'getClasses');  //Gets all names

$app->get('/classes/{term}', function ($request){
        $term = $request->getAttribute('term');
	require '../conn.php';
        $sql="SELECT * FROM classschedule WHERE term = '". $term . "'";
	$rs=$conn->query($sql);
	 $rs=$conn->query($sql);
 while($arr = $rs->fetch_array(MYSQLI_ASSOC)){
             if($arr == null){
                     echo json_encode(array(
                             "error" => 1,
                             "message" => "Error retreaving classes!",
                     ));
                     return;
             }else{
                     $rows[] = $arr;
             }
     }

 echo json_encode($rows);

});


$app->run();


function getClasses(){
	require '../conn.php';
	$sql="SELECT * FROM classschedule";
    $rs=$conn->query($sql);
    while($arr = $rs->fetch_array(MYSQLI_ASSOC)){
		if($arr == null){
			echo json_encode(array(
				"error" => 1,
				"message" => "Error retreaving classes!",
			));
			return;
		}else{
			$rows[] = $arr;
		}
	}
	
    echo json_encode($rows);
}


function getClassesByTerm($request){
	$term = $request->getParm('term');
	require '../conn.php';
	$sql="SELECT * FROM classschedule WHERE term = '". $term . "'";
    $rs=$conn->query($sql);
    while($arr = $rs->fetch_array(MYSQLI_ASSOC)){
		if($arr == null){
			echo json_encode(array(
				"error" => 1,
				"message" => "Error retreaving classes!",
			));
			return;
		}else{
			$rows[] = $arr;
		}
	}
	
    echo json_encode($rows);
}
