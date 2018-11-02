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
   $data    = array();


   // Attempt to query database table and retrieve data
   try {
      $stmt 	= $pdo->query('SELECT booking.user_id_fk,booking.created,booking.province,booking.booking_service_id,booking.license, booking.tel, 
                                booking.status_id,  booking.tel, customer.email,booking_time.time ,status.status_name FROM booking

                               INNER JOIN customer ON booking.user_id_fk=customer.user_id LEFT JOIN booking_time ON booking.time_id=booking_time.time_id 
                               INNER JOIN status ON booking.status_id=status.status_id

                               ORDER BY booking_id DESC');
      while($row  = $stmt->fetch(PDO::FETCH_OBJ))
      {
         // Assign each row of data to associative array
         $data[] = $row;
      }

      // Return data as JSON
      echo json_encode($data);
   }
   catch(PDOException $e)
   {
      echo $e->getMessage();
   }


?>