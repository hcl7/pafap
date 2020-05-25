<?php

if(isset($_POST['id']))
{
  $id = $_POST['id'];
  include ('../pafap_classes/init.php');
  include ('../pafap_classes/profile_pafap_class.php');
  include ('../pafap_classes/templates_pafap_class.php');
  $city = new pafap_profile();
  $tmpl = new pafap_templates;
  $sql = "SELECT citiesID, city FROM pafap_cities WHERE citiesID = '{$id}'";
  $cities = $city->binder($sql, "", "city");
  $tmpl->showbinder($cities);
}

?>