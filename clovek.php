<?php
require ("ViewPresenter.php");
require ('Model.php');
$currentID = isset($_GET['id']) ? htmlspecialchars($_GET['id'] ?? "") : '';
$db = new Model();
$res = $db->query("SELECT e.name as krestni, e.surname as prijmeni, e.job, e.wage, r.name as `room_name`, r.room_id as `room_idd`, r2.name as `jmeno_klice`, r2.room_id 
FROM employee AS `e` 
Inner join room as `r` on (e.room = r.room_id) 
Inner join `key` as `k` on (k.employee = e.employee_id) 
Inner join room as r2 on (k.room = r2.room_id) 
WHERE e.employee_id = :id;", [":id" => $currentID]);

$clovek = $res[0];
if(!$clovek){
    header("Location: /err404.php");
}
$rooms = "
    <tr>
    <th scope='col'>Klíče:</th>
    </tr>
";
foreach ($res as $room){
    $rooms = $rooms .
        "<tr>
            <td scope='col'><a href='mistnost.php?id=" . $room->room_id . "'>". $room->jmeno_klice ."</a></td>
        </tr>";
}

$data = "
<h1>Karta osoby: ". $clovek->prijmeni ." " . $clovek->krestni[0] . ".</h1>
<table class='table w-25'>  
            <tbody>
                <tr>
                  <th scope='col'>Jméno</th>
                  <td scope='col'>" . $clovek->krestni . "</td>
                </tr>
                <tr>
                  <th scope='col'>Příjmení</th>
                  <td scope='col'>" . $clovek->prijmeni . "</td>
                </tr>
                <tr>
                  <th scope='col'>Pozice</th>
                  <td scope='col'>" . $clovek->job . "</td>
                </tr>
                <tr>
                  <th scope='col'>Mzda</th>
                  <td scope='col'>" . $clovek->wage . "</td>
                </tr>
                <tr>
                  <th scope='col'>Místnost</th>
                  <td scope='col'><a href='mistnost.php?id=". $clovek->room_idd ."'>" . $clovek->room_name . "</a></td>
                </tr>
                " . $rooms;
$data = $data . "
            </tbody>
</table>              
<a href='lide.php'>z5</a>
";


ViewPresenter::createLayout($data, "Karta zaměstnance ".$clovek->prijmeni . " " . $clovek->krestni[0] . ".");
?>