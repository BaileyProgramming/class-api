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

$app->get('/locations[/{location}[/{building}[/{room}]]]', function ($request){
        $location = $request->getAttribute('location');
        $building = $request->getAttribute('building');
        $room = $request->getAttribute('room');
//      echo "Location - " . $location . "<br />Building - " . $building . "<br />Room - " . $room;
        if ($building == null){
                getbuildings();
        }else{
                if($room == null){
                getrooms($building);
                }else{ 
                        getroom($building, $room);
                }
        }
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

function getbuildings(){
        require '../conn.php';
        $sql="SELECT * FROM buildings";
        $rs=$conn->query($sql);
         $rs=$conn->query($sql);
         while($arr = $rs->fetch_array(MYSQLI_ASSOC)){
             if($arr == null){
                     echo json_encode(array(
                             "error" => 1,
                             "message" => "Error retreaving buildings!",
                     ));
                     return;
             }else{
                     $rows[] = $arr;
             }
        }
 echo json_encode($rows);

}

function getrooms($building){
        require '../conn.php';
        $sql="select * FROM rooms left join buildings on rooms.bldgid = buildings.bldgid WHERE buildings.bldgcode = '" . $building . "'";
        $rs=$conn->query($sql);
         $rs=$conn->query($sql);
         while($arr = $rs->fetch_array(MYSQLI_ASSOC)){
             if($arr == null){
                     echo json_encode(array(
                             "error" => 1,
                             "message" => "Error retreaving buildings!",
                     ));
                     return;
             }else{
                     $rows[] = $arr;
             }
        }
 echo json_encode($rows);

}

function getroom($building, $room){
        require '../conn.php';
        $sql="select * FROM rooms left join buildings on rooms.bldgid = buildings.bldgid WHERE (buildings.bldgcode = '" . $building . "') AND (rooms.roomnumber = '" . $room . "')";
        $rs=$conn->query($sql);
         $rs=$conn->query($sql);
         while($arr = $rs->fetch_array(MYSQLI_ASSOC)){
             if($arr == null){
                     echo json_encode(array(
                             "error" => 1,
                             "message" => "Error retreaving buildings!",
                     ));
                     return;
             }else{
                     $rows[] = $arr;
             }
        }
 echo json_encode($rows);

}
