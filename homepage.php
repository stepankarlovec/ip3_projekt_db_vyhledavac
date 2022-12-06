<?php
require ("ViewPresenter.php");

$data = "
<table class='table'>
  <tbody>
    <tr>
      <th scope='row'><a href='lide.php'>Seznam zaměstnanců</a></th>
    </tr>
    <tr>
      <th scope='row'><a href='mistnosti.php'>Seznam místností</a></th>
    </tr>
  </tbody>
</table>
";

ViewPresenter::createLayout($data);
?>