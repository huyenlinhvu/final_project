<?php
use App\Models\Coin;
use App\Models\User;
use Services\Session\Session;

Session::init();

$userModel = new User();
$message='';
//Title of the page "Coin"
$title = "50 Crypto currencies prices list";

//Create the object Coin
$table_coin = new Coin();

//Clean the table "coins" before inserting new datas into db
$table_coin->deleteAllCoin();

//Call the CoinMarketCap API to retrieve informations from the 100 biggest coins
$array_coin = $table_coin->callAPI(); //array_coin contains all the datas retrived
//var_dump($array_coin);

//Insert the required datas for the different coins into the table coin
$table_coin->addAllCoin($array_coin);

//Load the datas to display
$all_coin = $table_coin->getAllCoins();


// set variable symbol of the search form
$symbol = "";

// if Session exists -> display the search
if (isset($_SESSION['user_name']))
{
    $symbol = $userModel->getSearch($_SESSION["id"])->search;
}

// otherwise display all coins
else{
    $all_coin = $table_coin->getAllCoins();
}

//Show the coin that user searched for 
if ($symbol != "") {
    $all_coin = $table_coin->coinsBySymbol($symbol);
}

// if no coin match -> show all coins
if(count($all_coin)<1){
    if ($symbol != "" ){
            $message="Coin does not exist";
    }
    $all_coin = $table_coin->getAllCoins();
}



//Manage the search by symbol and store the search for users
if(isset($_POST['symbol'])) {
    //Store the value of the research
    $symbol = $_POST['symbol'];
    
    //if session is opened, show the search history
    if (isset($_SESSION["user_name"]) ){ 
        $userModel->updateSearch($_SESSION["id"], $symbol);
        $symbol = $userModel->getSearch($_SESSION["id"])->search;
        //$all_coin = $table_coin->coinsBySymbol($_POST['symbol']);
    }

    $all_coin = $table_coin->coinsBySymbol($_POST['symbol']);
    
    //If coin doesn't exist, show all coins
    if(count($all_coin)<1){
        if ($symbol != "" ){
            $message="Coin does not exist";
        }
        $all_coin = $table_coin->getAllCoins();
    }
}


require_once '../Views/coin.phtml';