<?php
include (dirname($_SERVER["PHP_SELF"]) == "\\" || dirname($_SERVER["PHP_SELF"]) == "/")? ('pafap_classes/sim_pafap_class.php') : ('../pafap_classes/sim_pafap_class.php');
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
$sim = new pafap_similarities();
$tmpl = new pafap_templates;
$sim->filterSim($uid);
$limit = min(count($sim->getSim()), 3);
$max = count($sim->getSim());
foreach(array_slice($sim->getSim(), rand(0, $max), rand($limit, $limit)) as $key=>$value)
{
  $tmpl->simBinder($value['uid'], $value['image'], $value['fname']." ".$value['lname'], $value['role']);
}
?>