
<?php

require_once __DIR__ . '/../core/Auth.php';



class HomeController{


    public function home(){

    Auth::requireRole('athlete');


    require_once __DIR__ . "/../views/athlete/index.php";

    }
}


?>