<?php
require ("ViewPresenter.php");
require ('Model.php');
$db = new Model();

$order = "name ASC";

$poradi = isset($_GET['sort']) ? htmlspecialchars($_GET['sort'] ?? "") : "";
$sortArr = explode('_', $poradi);

if(count($sortArr) === 2){
    switch($sortArr[0]){
        case "cislo":{
            $order = "no ";
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

$res = $db->query("SELECT * FROM room ORDER BY {$order}");
$orderStyles = explode(' ', $order);
if(count($orderStyles)==2){
    $orderStyles[2] = $orderStyles[1];
}
$data = "<table class='table'>  
            <thead>
                <tr>
                  <th scope='col'>Název<a href='mistnosti.php?sort=nazev_up' style='font-size: 3rem; text-decoration: none;'". (($orderStyles[0]=="name"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='mistnosti.php?sort=nazev_down' style='font-size: 3rem; text-decoration: none; '". (($orderStyles[0]=="name"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                  <th scope='col'>Číslo<a href='mistnosti.php?sort=cislo_up' style='font-size: 3rem; text-decoration: none;' ". (($orderStyles[0]=="no"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='mistnosti.php?sort=cislo_down' style='font-size: 3rem; text-decoration: none; '". (($orderStyles[0]=="no"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                  <th scope='col'>Telefon<a href='mistnosti.php?sort=telefon_up' style='font-size: 3rem; text-decoration: none; '". (($orderStyles[0]=="phone"&& $orderStyles[2]=="DESC") ? "class='sorted'" : '') . ">↑</a><a href='mistnosti.php?sort=telefon_down' style='font-size: 3rem; text-decoration: none; '". (($orderStyles[0]=="phone"&& $orderStyles[2]=="ASC") ? "class='sorted'" : '') . ">↓</a></th>
                </tr>
              </thead>
              <tbody>";
foreach ($res as $key => $val){
    $data = $data . "
    <tr>
      <th scope='row'><a href='mistnost.php?id=".$val->room_id."'>". $val->name ."</a></th>
      <td>" . $val->no . "</td>
      <td>" . $val->phone . "</td>
    </tr>";
}
$data = $data . "
  </tbody>
</table>
";

ViewPresenter::createLayout($data, "Seznam místností");
?>