<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$filename = "menu.json";

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

$app->post('/menu', function(){
	$result = @file_get_contents("php://input");;
//	fwrite(STDOUT, $result);
//	$obj = json_decode($result, true);  
//	echo '<p>' . $obj . '</p>';
	save_menu_item($result);//	print_r($obj);
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


function save_menu_item($obj){
	 // open the file if present
        $handle = @fopen($GLOBALS['filename'], 'w+');
        // create the file if needed
        if ($handle == null)
        {
                $handle = fopen($GLOBALS['filename'], 'w+');
        }

        if ($handle)
        {
                fwrite($handle, ($obj));
                        // close the handle on the file
                        fclose($handle);
        }

}


function append_json_menu($data){
	readmenu();
	//print_r($GLOBALS['data']);
	//echo("<br />");
	//print_r($GLOBALS['json']);
	$jdata= $GLOBALS['json'];
	$thedate = $GLOBALS['data'][0];
	//echo("<br />");
	//echo ($thedate);
	//print_r($jdata);
//	echo("<br />");
//	echo("<br />");
	$object_array = array();
	foreach($jdata as $key => $item){		
		if ($item[0] === $thedate){
			echo("<a href='edit.php'>That date already has an entry.</a>");
			exit();
		}else{
			array_push($object_array, $item);
		}
		//array_push($object_array, $item[0]);
//      if (($item[0] === $thedate[0]) || ($key == $objindex)){
//		  //print_r($data);
//		  $jdata[$key] = $data;
	  }
	array_push($object_array, $GLOBALS['data']);
	//
	$temp_array = array();
	foreach($object_array as $key => $item){
		$temp_array[$key] = $item[0][0];
	}
	array_multisort($temp_array, SORT_DESC, $object_array);
	//print_r(json_encode($GLOBALS['json']));      
   
	//print_r($object_array);
//	
//	
//	
	// open the file if present
	$handle = @fopen($GLOBALS['filename'], 'w+');
	// create the file if needed
	if ($handle == null)
	{
		$handle = fopen($GLOBALS['filename'], 'w+');
	}

	if ($handle)
	{
		fwrite($handle, json_encode($object_array));
			// close the handle on the file
			fclose($handle);
	}
	
}//---------End of append_json_menu()


