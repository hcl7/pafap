<?php
 
class pafap_file_upload {

    var $the_file;
	var $the_temp_file;
	var $the_mime_type;
    var $upload_dir;
	var $replace;
	var $do_filename_check;
	var $max_length_filename = 100;
    var $extensions;
    var $valid_mime_types = array('.gif'=>'image/gif', '.jpg'=>'image/jpeg', '.jpeg'=>'image/jpeg', '.png'=>'image/png');
	var $ext_string;
	var $language;
	var $http_error;
	var $rename_file;
    var $renamed;
	var $file_copy;
	var $message = array();
	var $create_directory = true;
	var $fileperm = 0644;
	var $dirperm = 0755;

	function pafap_file_upload() {
		$this->language = 'en';
		$this->rename_file = true;
		$this->ext_string = '';
        $this->renamed = array();
	}
	function show_error_string($br = '<br />') {
		$msg_string = '';
		foreach ($this->message as $value) {
			$msg_string .= $value.$br;
		}
		return $msg_string;
	}
	function set_file_name($new_name = '', $uid) {
		if ($this->rename_file) {
          if ($this->the_file == '') return;
		  $name = ($new_name == '') ? $uid. '_'. uniqid(rand()) : $new_name;
		  sleep(3);
		  $name = $name.$this->get_extension($this->the_file);
		}
        else
        {
          $name = str_replace(' ', '_', $this->the_file);
		}
		return $name;
	}
	function upload($to_name = '') {
		$new_name = $this->set_file_name($to_name);
		if ($this->check_file_name($new_name)) {
			if ($this->validateExtension()) {
				if (is_uploaded_file($this->the_temp_file)) {
					$this->file_copy = $new_name;
					if ($this->move_upload($this->the_temp_file, $this->file_copy)) {
						$this->message[] = $this->error_text($this->http_error);
						if ($this->rename_file) $this->message[] = $this->error_text(16);
						return true;
					}
				} else {
					$this->message[] = $this->error_text($this->http_error);
					return false;
				}
			} else {
				$this->show_extensions();
				$this->message[] = $this->error_text(11);
				return false;
			}
		} else {
			return false;
		}
	}
	function check_file_name($the_name) {
		if ($the_name != '') {
			if (strlen($the_name) > $this->max_length_filename) {
				$this->message[] = $this->error_text(13);
				return false;
			} else {
				if ($this->do_filename_check == 'y') {
					if (preg_match('/^[a-z0-9_]*\.(.){1,5}$/i', $the_name)) {
						return true;
					} else {
						$this->message[] = $this->error_text(12);
						return false;
					}
				} else {
					return true;
				}
			}
		} else {
			$this->message[] = $this->error_text(10);
			return false;
		}
	}
	function get_extension($from_file) {
		$ext = strtolower(strrchr($from_file,'.'));
		return $ext;
	}
	/* New in version 2.33 */
	function validateMimeType() {
		$ext = $this->get_extension($this->the_file);
		if ($this->the_mime_type == $this->valid_mime_types[$ext]) {
			return true;
		} else {
			$this->message[] = $this->error_text(18);
			return false;
		}
	}
	/* Added here the mime check in ver. 2.33 */
	function validateExtension() {
		$extension = $this->get_extension($this->the_file);
		$ext_array = $this->extensions;
		if (in_array($extension, $ext_array)) {
			if (!empty($this->the_mime_type)) {
				if ($this->validateMimeType()) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	// this method is only used for detailed error reporting
	function show_extensions() {
		$this->ext_string = implode(' ', $this->extensions);
	}
	function move_upload($tmp_file, $new_file) {
		if ($this->existing_file($new_file)) {
			$newfile = $this->upload_dir.$new_file;
			if ($this->check_dir($this->upload_dir)) {
				if (move_uploaded_file($tmp_file, $newfile)) {
					umask(0);
					chmod($newfile , $this->fileperm);
					return true;
				} else {
					return false;
				}
			} else {
				$this->message[] = $this->error_text(14);
				return false;
			}
		} else {
			$this->message[] = $this->error_text(15);
			return false;
		}
	}
	function check_dir($directory) {
		if (!is_dir($directory)) {
			if ($this->create_directory) {
				umask(0);
				mkdir($directory, $this->dirperm);
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function existing_file($file_name) {
		if ($this->replace == 'y') {
			return true;
		} else {
			if (file_exists($this->upload_dir.$file_name)) {
				return false;
			} else {
				return true;
			}
		}
	}

	function get_uploaded_file_info($name) {
		$str = 'File name: '.basename($name).PHP_EOL;
		$str .= 'File size: '.filesize($name).' bytes'.PHP_EOL;
		if (function_exists('mime_content_type')) {
			$str .= 'Mime type: '.mime_content_type($name).PHP_EOL;
		}
		if ($img_dim = getimagesize($name)) {
			$str .= 'Image dimensions: x = '.$img_dim[0].'px, y = '.$img_dim[1].'px'.PHP_EOL;
		}
		return $str;
	}
	// this method was first located inside the foto_upload extension
	function del_temp_file($file) {
		$delete = @unlink($file); 
		clearstatcache();
		if (@file_exists($file)) { 
			$filesys = eregi_replace('/','\\',$file);
			$delete = @system('del $filesys');
			clearstatcache();
			if (@file_exists($file)) { 
				$delete = @chmod ($file, 0644);
				$delete = @unlink($file); 
				$delete = @system('del $filesys');
			}
		}
	}

	function create_file_field($element, $label = '', $length = 25, $show_replace = true, $replace_label = 'Replace old file?', $file_path = '', $file_name = '', $show_alternate = false, $alt_length = 30, $alt_btn_label = 'Delete image') {
		$field = '';
		if ($label != '') $field = '
			<label>'.$label.'</label>';
		$field = '
			<input type="file" name="'.$element.'" size="'.$length.'" />';
		if ($show_replace) $field .= '
			<span>'.$replace_label.'</span>
			<input type="checkbox" name="replace" value="y" />';
		if ($file_name != '' && $show_alternate) {
			$field .= '
			<input type="text" name="'.$element.'" size="'.$alt_length.'" value="'.$file_name.'" readonly="readonly"';
			$field .= (!@file_exists($file_path.$file_name)) ? ' title="'.sprintf($this->error_text(17), $file_name).'" />' : ' />';
			$field .= '
			<input type="checkbox" name="del_img" value="y" />
			<span>'.$alt_btn_label.'</span>';
		} 
		return $field;
	}

	function error_text($err_num) {
		switch ($this->language) {
			default:
			// start http errors
			$error[0] = 'File: <b>'.$this->the_file.'</b> successfully uploaded!';
			$error[1] = 'The uploaded file exceeds the max. upload filesize directive in the server configuration.';
			$error[2] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.';
			$error[3] = 'The uploaded file was only partially uploaded';
			$error[4] = 'No file was uploaded';
			$error[6] = 'Missing a temporary folder. ';
			$error[7] = 'Failed to write file to disk. ';
			$error[8] = 'A PHP extension stopped the file upload. ';

			// end  http errors
			$error[10] = 'Please select a file for upload.';
			$error[11] = 'Only files with the following extensions are allowed: <b>'.$this->ext_string.'</b>';
			$error[12] = 'Use only alphanumerical chars and separate parts of the name.';
			$error[13] = 'The filename exceeds the maximum length of '.$this->max_length_filename.' characters.';
			$error[14] = 'Sorry, the upload directory does not exist!';
			$error[15] = 'Uploading <b>'.$this->the_file.'...Error!</b> Sorry, a file with this name already exitst.';
			$error[16] = 'The uploaded file is renamed to <b>'.$this->file_copy.'</b>.';
			$error[17] = 'The file %s does not exist.';
			$error[18] = 'The file type (mime type) is not valid.'; // new ver. 2.33
		}
		return $error[$err_num];
	}

    function get_renamed()
    {
      return $this->renamed;
    }
}
?>
