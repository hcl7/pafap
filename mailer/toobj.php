<?php
     class toObj
     {
          private $_variablesCount = 0; 
          public function __construct($arr)
          {
               $this->_variablesCount = count($arr);
               if ($this->_variablesCount > 0)
               {
                    foreach ($arr as $key => $value)
                    {
                         $this->$key = $value;
                         if (is_array($this->$key))
                         {
                              $this->$key = new toObj($this->$key);
                         }
                    }
               }
          }

          
          public function __set($key, $value)
          {
               $this->$key = $value;
               $this->_variablesCount++;
          }

          
          public function delete($key)
          {
               if (isset($this->$key)) unset($this->$key);
          }
          
          
          public function varCount()
          {
               return $this->_variablesCount;
          }
     }
?>
