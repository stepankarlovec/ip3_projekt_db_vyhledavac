<?php
require ("ViewPresenter.php");
require ('Model.php');
$db = new Model();

$order = "name ASC";

$poradi = isset($_GET['sort']) ? htmlspecialchars($_GET['sort'] ?? "") : "";
$sortArr = explode('_', $poradi);


if(count($sortArr) === 2){
    switch($sortArr[0]){
        case "mistnost":{
            $order = "room ";
            break;
        }
        case "nazev":{
            $order = "name ";
            break;
        }
        case "telefon":{
            $order = "phone ";
            break;
        }
        case "pozice":{
            $order = "job ";
            break;
        }
        default : {
            $order = "name ";
            break;
        }
    }

    switch($sortArr[1]){
        case "up":{
            $order .= " DESC";
            break;
        }
        case "down":{
            $order .= " ASC";
            break;
        }
        default:{
            $order .= " ASC";
            break;
        }
    }
}

$res = $db->query("SELECT e.employee_id, e.name,e.surname, r.name as 'room_name', r.phone, e.job FROM `employee` e INNER JOIN room r ON e.room = r.room_id ORDER BY {$order}");
$orderStyles = explode(' ', $order);
if(count($orderStyles)==2){
    $orderStyles[2] = $orderStyles[1];
}
$data = "<table class='table'>  
            <thead>
                <tr>
                  <th scope='col'>Jméno<a href='lide.php?sort=nazev_up' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="name"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='lide.php?sort=nazev_down' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="name"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                  <th scope='col'>Místnost<a href='lide.php?sort=mistnost_up' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="room"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='lide.php?sort=mistnost_down' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="room"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                  <th scope='col'>Telefon<a href='lide.php?sort=telefon_up' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="phone"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='lide.php?sort=telefon_down' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="phone"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                  <th scope='col'>Pozice<a href='lide.php?sort=pozice_up' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="job"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='lide.php?sort=pozice_down' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="job"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                </tr>
              </thead>
              <tbody>";
foreach ($res as $key => $val){
    $data = $data . "
    <tr>
      <th scope='row'><a href='clovek.php?id=".$val->employee_id."'>". $val->name . " " . $val->surname ."</a></th>
      <td>" . $val->room_name . "</td>
      <td>" . $val->phone . "</td>
      <td>" . $val->job . "</td>
    </tr>";
}
$data = $data . "
  </tbody>
</table>
";

ViewPresenter::createLayout($data, "Seznam zaměstnanců");
?>