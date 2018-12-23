<?php
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
     
   // Define database connection parameters
   $hn      = 'localhost';
   $un      = 'root';
   $pwd     = '';
   $db      = 'project';
   $cs      = 'utf8';

   // Set up the PDO parameters
   $dsn 	= "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
   $opt 	= array(
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                       );
   // Create a PDO instance (connect to the database)
   $pdo 	= new PDO($dsn, $un, $pwd, $opt);
   //$data    = array();

  //SELECT booking.username,booking_detail.booking_service_id,booking_service.service_name FROM `booking` 
 //inner JOIN booking_detail on booking.booking_id = booking_detail.booking_id inner JOIN booking_service on booking_detail.booking_service_id = booking_service.booking_service_id ; 
   // Attempt to query database table and retrieve data
   try {
      $orders = $pdo->query("SELECT ords.booking_id as ID , cust.username  FROM booking as ords JOIN customer as cust ON ords.user_id_fk = cust.user_id
                             JOIN booking_detail as odeet ON ords.booking_id = odeet.booking_id 
                             GROUP BY ords.booking_id ORDER BY ords.booking_id DESC");

      $json_response = array();
      $iid = $pdo->lastInsertId();
      foreach ( $orders as $row ) {
         
         $row_array = (array)$row;
         $ord_id = $row->ID;
      
          $orders2 = $pdo->query("SELECT service_name FROM booking_detail as ord
              JOIN booking_service as prod ON ord.booking_service_id = prod.booking_service_id
              ");
          foreach ( $orders2 as $vorder2 ) {
              $row_array['booking_service'][] = $vorder2;
          }
          $json_response[] = $row_array;
      }
      echo json_encode($json_response);
      // Return data as JSON
      
   }
   catch(PDOException $e)
   {
      echo $e->getMessage();
   }


?>