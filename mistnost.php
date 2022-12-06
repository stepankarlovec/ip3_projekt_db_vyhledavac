<?php
require ("ViewPresenter.php");
require ('Model.php');
$currentID = isset($_GET['id']) ? htmlspecialchars($_GET['id'] ?? "") : '';

$db = new Model();
$res = $db->query("SELECT room_id,r.no as roomNumber,  r.name as roomName, r.phone as roomPhone, e.name as jmeno, e.surname as prijmeni, e.employee_id
FROM `room` AS r 
INNER JOIN `key` as k ON r.room_id = k.room 
INNER JOIN `employee` as e ON k.employee = e.employee_id 
WHERE r.room_id = :id; ", [":id" => $currentID]);

$roomPlat = $db->query("SELECT ROUND(AVG(wage),2) as plat FROM employee WHERE employee.room = :id", [":id" => $currentID]);

$roomPeople = $db->query("SELECT employee.wage,employee.surname,CONCAT(LEFT(employee.name, 1),'.') as nameshort,employee_id FROM employee WHERE employee.room = :id", [":id" => $currentID]);

$clovek = $res[0];
if(!$clovek){
    header("Location: /err404.php");
}
$roomPlat = $roomPlat[0];
$people = "";
$rooms = "";
foreach ($res as $room){
    $rooms = $rooms .
        "<tr>
            <td scope='col'><a href='clovek.php?id=".$room->employee_id."'>" . $room->prijmeni . " " . $room->jmeno[0] . "</a></td>
        </tr>";
}

foreach($roomPeople as $human){
    $people = $people . "
    <td scope='col'><a href='clovek.php?id=".$human->employee_id."'>" . $human->surname . " " . $human->nameshort . "</a></td>";
}

if($people===""){
    $people = "<td class='col'>--------</td>";
    $roomPlat->plat = "<td class='col'>--------</td>";
}

$data = "
<h1>Místnost č. ". $clovek->roomNumber ."</h1>
<table class='table w-25'>  
            <tbody>
                <tr>
                  <th scope='col'>Název</th>
                  <td scope='col'>" . $clovek->roomName . "</td>
                </tr>
                <tr>
                  <th scope='col'>Telefon</th>
                  <td scope='col'>" . $clovek->roomPhone . "</td>
                </tr>
                <tr>
                  <th scope='col'>Lidé</th>
                  ". $people ."
                </tr>
                <tr>
                  <th scope='col'>Průměrná mzda</th>
                  <td scope='col'>". $roomPlat->plat ."</td>
                </tr>
                <tr>
                  <th scope='col'>Klíče</th>
                  <td scope='col'>". $rooms ."</td>
                </tr>
                ";
$data = $data . "
            </tbody>
</table>              
<a href='mistnosti.php'>z5</a>
";


ViewPresenter::createLayout($data, "Karta místnosti " . $clovek->roomName);
?>