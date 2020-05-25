<?php
/*
pafap file;
*/
class file
{
  var $file;
  var $binary;
  var $name;
  var $size;

  var $debug;
  var $action_before_reading=false;

  function file($filename,$binary=false)
  {
    $this->name=$filename;
	$this->binary=$binary;

	if($binary)
    {
      $this->file=@fopen($filename,"a+b");
	  if(!$this->file)
      {
        $this->file=@fopen($filename,"rb");
	  }
	}
    else
    {
      $this->file=@fopen($filename,"a+");
	  if(!$this->file)
      {
	  	$this->file=@fopen($filename,"r");
	  }
	}
  }

	function get_size()
    {
      return filesize($this->name);
	}

	function get_time()
    {
      return fileatime($this->name);
	}

	function get_name()
    {
      return $this->name;
	}

	function get_owner_id()
    {
      return fileowner($this->name);
	}

	function get_group_id()
    {
      return filegroup($this->name);
	}

	function get_suffix()
    {
      $file_array=split("\.",$this->name); // Splitting prefix and suffix of real filename
	  $suffix=$file_array[count($file_array)-1]; // Returning file type
	  if(strlen($suffix)>0)
      {
	  	return $suffix;
		}
        else
        {
          return false;
		}
	}

	function pointer_set($offset)
    {
		$this->action_before_reading=true;
		return fseek($this->file,$offset);
	}

	function pointer_get()
    {
      return ftell($this->file);
	}

	function read_line()
    {
      if($this->action_before_reading)
      {
        if(rewind($this->file))
        {
          $this->action_before_reading=false;
		  return fgets($this->file);
		}
        else
        {
          $this->halt("Pointer couldn't be reset");
		  return false;
		}
      }
      else
      {
        return fgets($this->file);
	  }
	}

	function read_bytes($bytes,$start_byte=0)
    {
      if(is_int($start_byte))
      {
        if(rewind($this->file))
        {
          if($start_byte>0)
          {
            $this->pointer_set($start_byte);
			return fread($this->file,$bytes);
		  }
          else
          {
            return fread($this->file,$bytes);
		  }
		}
        else
        {
          $this->halt("Pointer couldn't be reset");
		  return false;
		}
	  }
      else
      {
        $this->halt("Start byte have to be an integer");
	    return false;
	  }
	}

	function write($data)
    {
      $this->action_before_reading=true;
	  if(strlen($data)>0)
      {
        if($this->binary)
        {
          $bytes=fwrite($this->file,$data);
		  if(is_int($bytes))
          {
            return $bytes;
		  }
          else
          {
            $this->halt("Couldn't write data to file, please check permissions");
			return false;
		  }
		}
        else
        {
          $bytes=fputs($this->file,$data);
		  if(is_int($bytes))
          {
            return $bytes;
		  }
          else
          {
            $this->halt("Couldn't write data to file, please check permissions");
			return false;
		  }
		}
	  }
      else
      {
        $this->halt("Data must have at least one byte");
	  }
	}

	function copy($destination)
    {
      if(strlen($destination)>0)
      {
        if(copy($this->name,$destination))
        {
          return true;
		}
        else
        {
          $this->halt("Couldn't copy file to destination, please check permissions");
		  return false;
		}
	  }
      else
      {
        $this->halt("Destination must have at least one char");
	  }
	}

	function search($string)
    {
      if(strlen($string)!=0)
      {
        $offsets=array();

		$offset=$this->pointer_get();
		rewind($this->file);

		// Getting all data from file
		$data=fread($this->file,$this->get_size());

		// Replacing \r in windows new lines
		$data=preg_replace("[\r]","",$data);

		$found=false;
		$k=0;

		for($i=0;$i<strlen($data);$i++)
        {
          $char=$data[$i];
		  $search_char=$string[0];

		  // If first char of string have been found and first char havn't been found
		  if($char==$search_char && $found==false)
          {
            $j=0;
			$found=true;
			$found_now=true;
		  }
				
				// If beginning of the string have been found and next char have been set
		  if($found==true && $found_now==false)
          {
            $j++;
			// If next char have been found
			if($data[$i]==$string[$j])
            {
              if(($j+1)==strlen($string))
              {
                $found_offset=$i-strlen($string)+2;
				$offsets[$k++]=$found_offset;
			  }
			}
            else
            {
              $found=false;
			}
		  }
				
          $found_now=false;
		}
        $this->pointer_set($offset);
		return $offsets;
	  }
      else
      {
        $this->halt("Search String have to be at least 1 chars");
	  }
	}

	function halt($message)
    {
      if($this->debug)
      {
        printf("File error: %s\n", $message);
		if($this->error_nr!="" && $this->error!="")
        {
          printf("MySQL Error: %s (%s)\n",$this->error_nr,$this->error);
		}
		die ("Session halted.");
	  }
	}

	function debug_mode($debug=true)
    {
      $this->debug=$debug;
	  if(!$this->file)
      {
        $this->halt("File couln't be opened, please check permissions");
	  }
	}
}
?>