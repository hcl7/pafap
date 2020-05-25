<?php
include ("../pafap_classes/upload_pafap_class.php");
//error_reporting(E_ALL);

class pafap_multi_files extends pafap_file_upload {

	var $number_of_files = 0;
	var $names_array;
	var $tmp_names_array;
	var $error_array;
	var $wrong_extensions = 0;
	var $bad_filenames = 0;

    var $x_size;
	var $y_size;
	var $x_max_size = 700;
	var $y_max_size = 600;
	var $larger_dim;
	var $larger_curr_value;
	var $larger_dim_value;

	function extra_text($msg_num) {
		switch ($this->language) {
			case "de":
			// add you translations here
			break;
			default:
			$extra_msg[1] = "Error for: <b>".$this->the_file."</b>";
			$extra_msg[2] = "You have tried to upload ".$this->wrong_extensions." files with a bad extension, the following extensions are allowed: <b>".$this->ext_string."</b>";
			$extra_msg[3] = "Select at least on file.";
			$extra_msg[4] = "Select the file(s) for upload.";
			$extra_msg[5] = "You have tried to upload <b>".$this->bad_filenames." files</b> with invalid characters inside the filename.";
		}
		return $extra_msg[$msg_num];
	}
	// this method checkes the number of files for upload
	// this example works with one or more files
	function count_files() {
		foreach ($this->names_array as $test) {
			if ($test != "") {
				$this->number_of_files++;
			}
		}
		if ($this->number_of_files > 0) {
			return true;
		} else {
			return false;
		}
	}
	function upload_multi_files () {
		$this->message = "";
		if ($this->count_files()) {
			foreach ($this->names_array as $key => $value) {
				if ($value != "") {
					$this->the_file = $value;
					$new_name = $this->set_file_name('', $_SESSION['uid']);
                    $this->renamed[] = $new_name;
					if ($this->check_file_name($new_name)) {
						if ($this->validateExtension()) {
							$this->file_copy = $new_name;
							$this->the_temp_file = $this->tmp_names_array[$key];
							if (is_uploaded_file($this->the_temp_file)) {
								if ($this->move_upload($this->the_temp_file, $this->file_copy)) {
									$this->message[] = $this->error_text($this->error_array[$key]);
									if ($this->rename_file) $this->message[] = $this->error_text(16);
									sleep(1);
								}
							} else {
								$this->message[] = $this->extra_text(1);
								$this->message[] = $this->error_text($this->error_array[$key]);
							}
						} else {
							$this->wrong_extensions++;
						}
					} else {
						$this->bad_filenames++;
					}
				}
			}
			if ($this->bad_filenames > 0) $this->message[] = $this->extra_text(5);
			if ($this->wrong_extensions > 0) {
				$this->show_extensions();
				$this->message[] = $this->extra_text(2);
			}
		} else {
			$this->message[] = $this->extra_text(3);
		}
	}
    //image upload
    function process_image($fn, $compression = 85) {
		$filename = $this->upload_dir.$fn;
		if($this->get_img_size($filename)){
          $this->check_dimensions($filename);
		  if ($this->larger_curr_value > $this->larger_dim_value) {
		    $this->thumbs($filename, $filename, $this->larger_dim_value, $compression);
		  }
          else {
			copy($filename, $filename);
		  }
        return true;
		}
        else {
          if (is_file($filename)) {
            unlink($filename);
          }
          return false;
        }
	}
	function get_img_size($file) {
		$img_size = getimagesize($file);
        if (empty($img_size)){
          return false;
        }
        else {
          $this->x_size = $img_size[0];
          $this->y_size = $img_size[1];
          return true;
        }
	}
	function check_dimensions($filename) {
		$this->get_img_size($filename);
		$x_check = $this->x_size - $this->x_max_size;
		$y_check = $this->y_size - $this->y_max_size;
		if ($x_check < $y_check) {
			$this->larger_dim = "y";
			$this->larger_curr_value = $this->y_size;
			$this->larger_dim_value = $this->y_max_size;
		} else {
			$this->larger_dim = "x";
			$this->larger_curr_value = $this->x_size;
			$this->larger_dim_value = $this->x_max_size;
		}
	}
	function img_rotate($wr_file, $comp) {
		$new_x = $this->y_size;
		$new_y = $this->x_size;
		if ($this->use_image_magick) {
			exec(sprintf("mogrify -rotate 90 -quality %d %s", $comp, $wr_file));
		} else {
			$src_img = imagecreatefromjpeg($wr_file);
			$rot_img = imagerotate($src_img, 90, 0);
			$new_img = imagecreatetruecolor($new_x, $new_y);
			imageantialias($new_img, TRUE);
			imagecopyresampled($new_img, $rot_img, 0, 0, 0, 0, $new_x, $new_y, $new_x, $new_y);
			imagejpeg($new_img, $this->upload_dir.$this->file_copy, $comp);
		}
	}
	function thumbs($file_name_src, $file_name_dest, $target_size, $quality = 80) {
		//print_r(func_get_args());
		$size = getimagesize($file_name_src);
		if ($this->larger_dim == "x") {
			$w = number_format($target_size, 0, ',', '');
			$h = number_format(($size[1]/$size[0])*$target_size,0,',','');
		} else {
			$h = number_format($target_size, 0, ',', '');
			$w = number_format(($size[0]/$size[1])*$target_size,0,',','');
		}
    	$dest = imagecreatetruecolor($w, $h);
		imageantialias($dest, TRUE);
		$src = imagecreatefromjpeg($file_name_src);
		imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
		imagejpeg($dest, $file_name_dest, $quality);
	}
    public function sd($data)
    {
      return mysql_real_escape_string($data);
    }
}

session_start();
include ("../pafap_classes/init.php");
include ("../pafap_classes/mysql_pafap_class.php");
$max_size = 1024*6144;
$uid = $_SESSION['uid'];
$multi_upload = new pafap_multi_files;
$multi_upload->upload_dir = "../users/ImagesPool/";
$multi_upload->extensions = array(".png", ".jpg", ".gif");
$multi_upload->message[] = $multi_upload->extra_text(4);
$multi_upload->do_filename_check = "y";

if(isset($_FILES['upload']))
{
  $multi_mysql = new pafap_mysql();
  $multi_upload->tmp_names_array = $_FILES['upload']['tmp_name'];
  $multi_upload->names_array = $_FILES['upload']['name'];
  $multi_upload->error_array = $_FILES['upload']['error'];
  $multi_upload->upload_multi_files();
  echo $multi_upload->show_error_string();
  foreach($multi_upload->renamed as $key=>$ren)
  {
    if ($multi_upload->process_image($ren)){
      $sql = "INSERT INTO pafap_images (img_url, iuid) VALUES ('{$multi_upload->sd($ren)}', '{$multi_upload->sd($uid)}')";
      $multi_mysql->ExecuteSQL($sql);
    }
  }

}
else { echo $multi_upload->show_error_string(); }

?>
