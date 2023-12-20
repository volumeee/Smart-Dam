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
      $searchQuery = " AND (tanggal LIKE :tanggal OR 
           data_sensor LIKE :data_sensor OR
           jarak LIKE :jarak  ) ";
      $searchArray = array( 
           'tanggal'=>"%$searchValue%",
           'data_sensor'=>"%$searchValue%",
           'jarak'=>"%$searchValue%"
      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM tabel1 ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM tabel1 WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $stmt = $conn->prepare("SELECT * FROM tabel1 WHERE 1 ".$searchQuery." ORDER BY id_data desc, ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

   // Bind values
   
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute();
   $empRecords = $stmt->fetchAll();

   $data = array();


$no = 1;


   foreach ($empRecords as $row) {

    if ($row['jarak'] <= 2) {
      # code...
      $status = "SIAGA 3";
    }else if ($row['jarak'] > 2 && $row['jarak'] <=4) {
      # code...
      $status = "SIAGA 2";

    }else{
      $status = "SIAGA 1";

    }

    $tgl = date_format(date_create($row['tanggal']),"d-m-Y");
    $jam  = date_format(date_create($row['tanggal']),"H:i:s");
      $data[] = array(
         "no"=>$no++,
         "tanggal"=>$tgl,
         "jam"=>$jam,
         "data_sensor"=>$row['data_sensor'],
         "jarak"=>$row['jarak'],
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