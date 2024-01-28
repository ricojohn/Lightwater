<?php
// connect with database
$conn = mysqli_connect("localhost", "root", "", "light_water_db");
// Fetch brgy list by city id

if(isset($_POST['request'])){
    $request = $_POST['request'];

    $city_id = $_POST['city_id'];
    $sql = "SELECT * FROM `refbrgy` WHERE citymunCode = '$city_id' ";
    $stateData = mysqli_query($conn,$sql);
    $count = 0;
    $response = array();
    while($state = mysqli_fetch_assoc($stateData)){
          $response[$count] = array(
               "brgyCode" => $state['brgyCode'],
               "brgyDesc" => $state['brgyDesc']
          );
        $count++;
    }

    echo json_encode($response);
    exit;
}
?>