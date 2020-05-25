<?php

include ('mysql_pafap_class.php');
class pafap_XML extends pafap_mysql
{

  public function CreateXMLFromTable($table, $field, $uid, $file, $root, $category)
  {
    $xmlhead = "<?xml version='1.0'?>";
    $xmlformat = "";
    $xmltmp = "";
    $sql = new pafap_mysql;
    $sql->pafap_mysql();
    $file = new file($file);
    $xml = "SELECT * FROM $table WHERE $field = '{$uid}'";
    $result = mysql_query($xml);
    $num_rows = mysql_num_fields($result);
    $file->write($xmlhead);
    $file->write("\n");
    $file->write("<".$root.">");
    $file->write("\n");
    $file->write("\t");
    while ($row = mysql_fetch_array($result, MYSQL_NUM))
    {
      $file->write("<".$category.">");
      for ($l=0;$l<$num_rows;$l++)
      {
        if (mysql_field_name($result, $l))
        {
          $file->write("\n");
          $file->write("\t\t");
          $rec = mysql_field_name($result, $l);
          $xmlformat .= "<";
          $xmlformat .= "{$rec}";
          $xmlformat .= ">";
          $xmlformat .= "". $row[$l];
          $xmlformat .= "</";
          $xmlformat .= "{$rec}";
          $xmlformat .= ">";
          $file->write($xmlformat);
          $xmltmp .= $xmlformat;
          $xmlformat = "";
        }
      }
      $file->write("\n");
      $file->write("\t");
      $file->write("<".$category.">");
      $file->write("\n");
      echo $xmltmp;
    }
    $file->write("</".$root.">");
  }

  public function ReadXML($xmlfile)
  {

  }
  /**/
}
?>
