<?php 

/* -------------------- CREAZIONE DATA -------------------- */

// classi contenenti due variabili aeroportuali
class Airport {

  public $id;
  public $name;
  public $code;
  public $lat;
  public $lng;

  // costruttore per creare nuovo oggetto
  public function __construct($id, $name, $code, $lat, $lng) {
    $this->id = $id;
    $this->name = $name;
    $this->code = $code;
    $this->lat = $lat;
    $this->lng = $lng;
  }
}

class Flight {
  public $code_departure;
  public $code_arrival;
  public $price;

  // costruttore per creare nuovo oggetto
  public function __construct($code_departure, $code_arrival, $price) {
    $this->code_departure = $code_departure;
    $this->code_arrival = $code_arrival;
    $this->price = $price;
  }
  
}

// prendo tutti gli aeroporti
$airportArray = [];

// creo due oggetti aeroporti e pusho nell'array sopra
$napoliAirport = new Airport (
  '1',
  'Aeroporto Capodichino, Napoli, NA',
  'NAP',
  40.88457083053576, 
  14.289253727024969
);

$romeAirport = new Airport (
  '2',
  'Aeroporto internazionale Leonardo da Vinci (FCO), Fiumicino, RM',
  'FCO',
  41.799854786808645, 
  12.246184754030878
);

// aeroporti messi nell'array
array_push($airportArray, $napoliAirport, $romeAirport);

// prendo tutti i voli
$flightsArray = [];

// creo oggetto di un volo casuale e lo inserisco nell'array sopra
for($i = 0; $i <= 6; $i++){
    
  $flightObj = new Flight (
    'NAP ' . rand(1, 100),
    'FCO '. rand(1, 100),
    rand(20, 100)
  );
  array_push($flightsArray, $flightObj);
}

/* -------------------- LOGICA -------------------- */


// prendo i prezzi dei voli
$prices = [];

// ciclo foreach e pusho il prezzo del volo
foreach($flightsArray as $flightPrice) {
  array_push($prices, $flightPrice->price);
}

// calcolo lunghezza dell'array $prices
$arraySize = count($prices);

// cicli for per ordinare array con un valore crescente come la funzione di ordinamento sort
for($i = 0; $i < $arraySize; $i++) {
  
  for($y = $i + 1; $y < $arraySize; $y++) {
    if($prices[$i] > $prices[$y]){
      $loopIndex = $prices[$i];
      $prices[$i] = $prices[$y];
      $prices[$y] = $loopIndex;
    }
  }

}

// prendo il primo valore dell'array del prezzo ordinato
$bestPrice = $prices[0];

// faccio array_filter che contiene solo oggetto con il prezzo più basso
$flightLow = array_filter(
  $flightsArray,
  function ($flight) use ($bestPrice) {
    return $flight->price == $bestPrice;
  }
);

// stabilisco due variabili codici aeroporto di partenza e di arrivo 
// e poi foreach dove dal volo con il prezzo più basso prendo i due valori
$codeDeparture;
$codeArrival;

foreach($flightLow as $item) {
  $codeDeparture = $item->code_departure;
  $codeArrival = $item->code_arrival;
}

// stabilisco due variabili nomi aeroporto di partenza e di arrivo 
// e poi foreach dove se il codice dell'aeroporto è incluso nel codice del volo, estraggo il nome dell'aeroporto
$depAirpName;
$arrAirpName;

foreach($airportArray as $element) {
  if($codeDeparture == strpos($codeDeparture, $element->code)){
    $depAirpName = $element->name;
  } else {
    $arrAirpName = $element->name;
  }
}

?>

<!--  -------------------- STAMPO IN HTML --------------------  -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
    crossorigin="anonymous">
    <title>LT-CHALLENGE-PHP</title>
  </head>
  <body>

    <div class="container py-5">
      <!-- Sezione lista voli -->
      <section>
          <div class="row">
              <div class="col-md-8">
                <h1><i class="fas fa-plane-departure"></i>Departures</h1>
              </div>
          </div>
      </section>

      <div>
        <div class="table-responsive-sm">
          <table class="table table-striped table-hover" style="cursor: pointer;">
            <thead>
              <tr>
                <th scope="col" style="color: #3d342c;">Partenza da</th>
                <th scope="col" style="color: #3d342c;">Codice di partenza</th>
                <th scope="col" style="color: #3d342c;">Arrivo a</th>
                <th scope="col" style="color: #3d342c;">Codice di arrivo</th>
                <th scope="col" style="color: #3d342c;">Prezzo</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              <?php
              foreach($flightsArray as $singleFlight) {
              ?>
                <td scope="row"> <?php echo $depAirpName ?></th>
                <td> <?php echo $singleFlight->code_departure ?></th>
                <td><?php echo $arrAirpName ?></td>
                <td><?php echo $singleFlight->code_arrival ?></td>
                <td><?php echo $singleFlight->price ?> &euro;</td>
              </tr>
              <?php
              }
             ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Sezione volo con il prezzo migliore -->
      <section>
          <div class="row">
              <div class="col-md-8">
                <h1><i class="fas fa-money-check-alt"></i>Best Price</h1>
              </div>
          </div>
      </section>

      <div>
        <div class="table-responsive-sm">
          <table class="table table-striped table-hover" style="cursor: pointer;">
            <thead>
              <tr>
                <th scope="col" style="color: #3d342c;">Partenza da</th>
                <th scope="col" style="color: #3d342c;">Codice di partenza</th>
                <th scope="col" style="color: #3d342c;">Arrivo a</th>
                <th scope="col" style="color: #3d342c;">Codice di arrivo</th>
                <th scope="col" style="color: #3d342c;">Prezzo</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              <?php
              foreach($flightLow as $flight) {
              ?>
                <td scope="row"> <?php echo $depAirpName ?></th>
                <td><?php echo $flight->code_departure ?></td>
                <td><?php echo $arrAirpName ?></td>
                <td><?php echo $flight->code_arrival ?></td>
                <td><?php echo $flight->price ?> &euro;</td>
              </tr>
              <?php
              }
             ?>
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </body>
</html>