<?php
declare(strict_types=1);
namespace App\Models;
use App\Models\AbstractModel;
use Services\Database;

class Coin extends AbstractModel
{
    //Function to call the CoinMarketCap API to retrieve informations from the 50 biggest coins
    public function callAPI()
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
          'start' => '1',
          'limit' => '50',
          'convert' => 'USD'
        ];
        
        //other key : 4173e74b-d27b-4030-9e32-b4be921bcaa5
        $headers = [
          'Accepts: application/json',
          'X-CMC_PRO_API_KEY:be28ec26-1bf6-4e05-9c57-c6807ec1e474'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL
        
        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
          CURLOPT_URL => $request,            // set the request URL
          CURLOPT_HTTPHEADER => $headers,     // set the headers 
          CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));
        
        $response = curl_exec($curl); // Send the request, save the response
        $json = json_decode($response);
        // var_dump($json->data);
        return  $json->data;
    }
    
    //Function to insert the 50 biggest coins into the table "coin"
    public function addAllCoin($array_coin)
    {
      $var = new Coin();
      
      // Each element coin of the array has its data extracted then send to the database
      foreach ($array_coin as $coin){
        $var->extractSpecificData($coin);
      }
    }
    
    //Function to clean the table "coin"
    public function deleteAllCoin()
    {
        $sql = 'DELETE FROM `coins`';
        return $this->remove($sql);
    }
    
    // Function extracting the specific coin's datas needed and send them to the database
    public function extractSpecificData($element)
    {
      $var = new Coin();
      
      //Insert the datas extracted and send them to the database
      $var->addCoin(
                    $element->cmc_rank,
                    $element->symbol,
                    $element->name,
                    $element->quote->USD->price,
                    $element->quote->USD->market_cap,
                    $element->cmc_rank,
                    $element->quote->USD->percent_change_24h
                  );
    }
    //Function to insert a new coin with its informations
    public function addCoin(int $id, string $symbol, string $name, float $price, float $marketcap, float $rank, float $change)
    {
        $sql = ' INSERT INTO `coins`(`id`,`symbol`, `name`,`price`,`marketcap`,`rank`,`change` ) VALUES (:id, :symbol, :name, :price, :marketcap, :rank, :change)';
        $param = [
            ':id' => $id,
            ':symbol' => $symbol,
            ':name' => $name,
            ':price' => $price,
            ':marketcap' => $marketcap,
            ':rank'=>$rank,
            ':change'=>$change,
        ];
        return $this->insert($sql, $param);
    }
    
    //Fetch datas from de table coin
    public function getAllCoins(): array
    {
        $sql = 'SELECT * from coins';
        return $this->findAll($sql);
    }
    
    public function findCoinById(int $id): object
    {
        $sql = 'SELECT * FROM coins WHERE id = :id';
        
        $param = [
            ':id' => $id
            ];
        return $this->findOne($sql, $param);
    }

    public function coinsBySymbol(string $symbol): array
    {
        $sql = 'SELECT * FROM coins WHERE symbol = :symbol';
        $param = [
            ':symbol' => $symbol
            ];
        return $this->findAll($sql, $param);
    }
}



 


