<?php
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

   // Define database connection parameters
   $hn      = 'localhost';
   $un      = 'root';
   $pwd     = '';
   $db      = 'carcare';
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

   // Retrieve the posted data
   $key  = strip_tags($_REQUEST['key']);
   $data    = array();


   // Determine which mode is being requested
   switch($key)
   {

      // Add a new record to the technologies table
      case "create":

         // Sanitise URL supplied values
         $email    = filter_var($_REQUEST['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $username      = filter_var($_REQUEST['username'],   FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $license     = filter_var($_REQUEST['license'],  FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $tel     = filter_var($_REQUEST['tel'],  FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $province      = filter_var($_REQUEST['province'],   FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         
         

         // Attempt to run PDO prepared statement
         try {
            $sql  = "INSERT INTO customer(email, username, license ,tel ,province ) VALUES
                                          (:email, :username , :license, :tel, :province)";
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':license', $license, PDO::PARAM_STR);
            $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
            $stmt->bindParam(':province', $province, PDO::PARAM_STR);
           
            
            $stmt->execute();

            echo json_encode(array('message' => 'Congratulations the record ' . $email . ' was added to the database'));
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;
      

        case "update":

        // Sanitise URL supplied values
        $email 		     = filter_var($obj->email, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $username	  = filter_var($obj->username, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $license	  = filter_var($obj->license, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $tel	  = filter_var($obj->tel, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $province	  = filter_var($obj->province, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $recordID	     = filter_var($obj->recordID, FILTER_SANITIZE_NUMBER_INT);

        // Attempt to run PDO prepared statement
        try {
           $sql 	= "UPDATE customer SET email = :email, username = :username, license = :license,
                                         tel = :tel, province = :province  WHERE user_id = :recordID";
           $stmt 	=	$pdo->prepare($sql);
           $stmt->bindParam(':email', $email, PDO::PARAM_STR);
           $stmt->bindParam(':username', $username, PDO::PARAM_STR);
           $stmt->bindParam(':license', $license, PDO::PARAM_STR);
           $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
      
           $stmt->bindParam(':recordID', $recordID, PDO::PARAM_INT);
           $stmt->execute();

           echo json_encode('Congratulations the record ' . $name . ' was updated');
        }
        // Catch any errors in running the prepared statement
        catch(PDOException $e)
        {
           echo $e->getMessage();
        }

     break;
  }

      // Remove an existing record in the technologies table

?>