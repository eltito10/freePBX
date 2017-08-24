<?php

/**
 * @file
 * plays recording file
 */
/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,basename($file));
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}
//
if (isset($_GET['uid'])) {

  $fecha = $_GET['dia'];
  $unique = $_GET['uid'];
  $cmd = 'find /var/spool/asterisk/monitor/'.$fecha.'/ -name *'.$unique.'.*';
  $busqueda = exec($cmd, $output);
  $path1 = $output[0];
  $path2 = $output[1];
  if ($path1 == "") printf("<b>404 File not found!</b>");
  if ($path2 == "") $path = $path1;
  else { $ziped = create_zip($output,'/tmp/audios_'.$fecha.'_'.$unique.'.zip');
  	$path = '/tmp/audios_'.$fecha.'_'.$unique.'.zip';
  	}
  $size = filesize($path);
  //echo $size."\n\r";
  $name = basename($path);
  //echo $name."\n\r";
  $extension = strtolower(substr(strrchr($name,"."),1));

  // This will set the Content-Type to the appropriate setting for the file
  $ctype ='';
  switch( $extension ) {
    case "mp3": $ctype="audio/mpeg"; break;
    case "wav": $ctype="audio/x-wav"; break;
    case "Wav": $ctype="audio/x-wav"; break;
    case "WAV": $ctype="audio/x-wav"; break;
    case "gsm": $ctype="audio/x-gsm"; break;
    case "zip": $ctype="application/octet-stream"; break;

    // not downloadable
    //default: die("<b>404 File not found ext!</b>"); break ;
    default: die("<b>404 File not found ext!</b>"); break ;
  }

  // need to check if file is mislabeled or a liar.
  $fp=fopen($path, "rb");
  if ($size && $ctype && $fp) {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: wav file");
    header("Content-Type: " . $ctype);
    header("Content-Disposition: attachment; filename=" . $name);
    header("Content-Transfer-Encoding: binary");
    header("Content-length: " . $size);
    fpassthru($fp);
  } 
  
}

?>
