<?php
   // Database Connection
   include '../core/conn.php';

   // Reading value
   $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value

   $searchArray = array();

   // Search
   $searchQuery = " ";
   if($searchValue != ''){
      $searchQuery = " AND (tgl LIKE :tgl OR 
           jam LIKE :jam OR
           suhu LIKE :suhu OR 
           kelembaban LIKE :kelembaban ) ";
      $searchArray = array( 
           'tgl'=>"%$searchValue%",
           'jam'=>"%$searchValue%",
           'suhu'=>"%$searchValue%",
           'kelembaban'=>"%$searchValue%"
      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM suhu ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM suhu WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT * FROM suhu WHERE 1 ".$searchQuery." ORDER BY id desc, ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

   $data = array();

   foreach ($empRecords as $row) {

    if ($row['suhu'] <= 23) {
      # code...
      $status = "DINGIN";
    }else if ($row['suhu'] > 23 && $row['suhu'] <=27) {
      # code...
      $status = "NORMAL";

    }else{
      $status = "PANAS";

    }
      $data[] = array(
         "tgl"=>$row['tgl'],
         "jam"=>$row['jam'],
         "suhu"=>$row['suhu'],
         "kelembaban"=>$row['kelembaban'],
         "status"=>$status,
      );
   }

   // Response
   $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
   );

   echo json_encode($response);