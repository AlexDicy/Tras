<?php
//test_function();

if (isAjax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch($action) { //Switch case for value of action
            case "getSkins": skins(); break;
        }
    }
}

//Function to check if the request is an AJAX request
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


function skins(){
    $return = $_POST;

    #echo "Hello world!";
    $images = glob('./skins/*.{png}', GLOB_BRACE);
    //print_r($images);
    foreach ($images as &$path) {
        $path = basename($path,".png");
    }

    unset($path);

    #print_r($images);
    $return["nicks"] = json_encode($images);
    $return["json"] = json_encode($return);
    #print_r($return);
    #echo json_encode($images);
    echo json_encode($return);
}
?>
