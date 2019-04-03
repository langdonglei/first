<?php
function down($dir,$name,$ext,$islogin=false,$ren=0){
	if($islogin){
		@session_start();
		if(isset($_SESSION['member'])){
			
		}else{
			exit("此资源，必须是会员才可以下载");
			return;
		}
	}
	$file = $dir.'/'.$name.$ext;
	if(file_exists($file)){
		$f = fopen($file,'r');
		$len = filesize($file);
		header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Accept-Length:".$len);
		switch($ren){
			case 1:$name=date('YmdHis');break;
			case 2:$name=uniqid();break;
			case 3:$name=uuid();break;
		}
		header("Content-Disposition: attachment; filename=".$name.$ext);
		$buf = 102400;
		$count = 0;
		while (!feof($f) && $count<$len) {
			$r = fread($f, $buf);
			$count += $buf;
			echo $r;
		}
		fclose($f);
		return;
	}else{
		exit('未知资源,无法下载!!!');
		return;
	}
	
}
/**
 * 
 */
function upload($dir='./',$rename=3,$size=20,$allow=['gif','jpg','png','rar','zip','pdf']) {
    $size = $size * 1048576;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $files = [];
        if (!empty($_FILES)) {
		foreach ($_FILES as $fs) {
			if (is_array($fs['name'])) {
				foreach ($fs['tmp_name'] as $k => $f) {
					$ext = strtolower(pathinfo($fs['name'][$k],PATHINFO_EXTENSION));
					if(in_array($ext,$allow) && $fs['size'][$k]<=$size){
						$name = ren($dir,$fs['name'][$k],$rename);
						if (move_uploaded_file($f,$dir.'/'.$name)) {
							$files[] = $name;
						}
					}
				}
			} else {
				$ext = strtolower(pathinfo($fs['name'],PATHINFO_EXTENSION));
				if(in_array($ext,$allow) && $fs['size']<=$size){
					$name = ren($dir,$fs['name'],$rename);
					if (move_uploaded_file($fs['tmp_name'],$dir.'./'.$name)) {
						$files[] = $name;
					}
				}
			}
		}
		return $files;
	}
	return false;
}

function ren($dir,$name,$rename){
	$ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
	$nname = $name;
	switch($rename){
		case 1:$nname = date('YmdHis').'_'.sprintf('%05d',mt_rand(0,99999)).'.'.$ext;break;
		case 2:$nname = uniqid().'.'.$ext;break;
		case 3:$nname = uuid().'.'.$ext;break;
		case 4:
			$num = 0;
			while(file_exists($dir.'/'.$nname)){
				$num++;
				$nname = pathinfo($name,PATHINFO_FILENAME).'('.$num.').'.$ext;	
			}
		break;
	}
	return $nname;
}

function uuid($namespace = '') {     
     static $guid = '';
     $uid = uniqid("", true);
     $data = $namespace;
     $data .= $_SERVER['REQUEST_TIME'];
     $data .= $_SERVER['HTTP_USER_AGENT'];
     $data .= $_SERVER['SERVER_ADDR'];
     $data .= $_SERVER['SERVER_PORT'];
     $data .= $_SERVER['REMOTE_ADDR'];
     $data .= $_SERVER['REMOTE_PORT'];
     $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
     $guid =   substr($hash,  0,  8) . '-' .substr($hash,  8,  4) . '-' .substr($hash, 12,  4) .'-' .substr($hash, 16,  4) .'-' .substr($hash, 20, 12);     
     return strtolower($guid);
   }
