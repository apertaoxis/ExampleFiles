<?php

/* Buscar arquivo */
if(!function_exists('buscaArquivo')){
	/**
	 * @dir 	= Full path directory name - /document_root/dir_name;
	 * @type 	= Type of files separated with coma "," - "jpg,png,jpeg,bmp";
	 * @qnt 	= Quantity of search values; (int)
	 * @prefix	= Prefix of search term;
	 * @contains= Search in anywhere of the filename;
	 * @rand 	= Return randomic vallues;
	 * @byTime 	= Sort values in reverse order;
	 * @folders = Return folders name;
	**/
	function buscaArquivo($dir, $type, $qnt, $prefix, $contains=false, $rand=false, $byTime=false, $folders= false){

		if(is_dir($dir)){
			$dir 	  = new DirectoryIterator($dir);

		}
		else {
			return false;
		}
		 foreach($dir as $file){
			if($file->isFile()){
				if(!$type){
					if($prefix){
						if(substr($file->getFilename(), 0, strlen($prefix)) == $prefix){
							$retorno[] = $file->getFilename();
						}
					}
					else if($contains){
						if(strpos($file->getFilename(), $contains) !== false){
							$retorno[] = $file->getFilename();
						}
					}
					else {
						$retorno[] = $file->getFilename();
					}
				}
				else if($type){
					$typeArray = explode(',', $type);
					if( ($file->getExtension() == $type) || (in_array($file->getExtension(), $typeArray))) {
						if($prefix){
							if(substr($file->getFilename(), 0, strlen($prefix)) == $prefix){
								$retorno[] = $file->getFilename();
							}
						}
						else if($contains){
							if(strpos($file->getFilename(), $contains) !== false){
								$retorno[] = $file->getFilename();
							}
						}
						else {
							$retorno[] = $file->getFilename();
						}
					}
				}
			 }
			 else if( ($file->isDir()) && ($folders == true) ) {
			 	$retorno[] = $file->getPathname();
			 }
		}
		 if($byTime){
		 	rsort($retorno, SORT_NUMERIC);
		 }
		 if($rand){
		 	shuffle($retorno);
		 }
		 if($qnt > 0 ){
				$array = $retorno;
				$retorno = [];

				for($i=0;$i<$qnt;$i++){
					if($array[$i]){
						$retorno[] = $array[$i];
					}
				}
		 }
		 return $retorno;
	}
}

/*

$images = buscaArquivo('/document_root/public_html/pasta/album1', 'jpg,jpeg,png', 10, 'foto');

foreach ($imagens as $image) {
	echo 'www.seusite.com/pasta/album1/'.$image;
	
}