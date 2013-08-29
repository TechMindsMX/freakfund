<?php
class manejoImagenes {
	function cargar_imagen($usuario, $ancho, $alto, $existeFoto){
		
		if($_FILES["daGr_Foto"]['error'] == 0) {
			
			$tipo = $_FILES["daGr_Foto"]['type'];
			$validaciones = ( ($tipo === 'image/jpeg') || ($tipo === 'image/gif') || ($tipo === 'image/png') );
			
			if($validaciones && getimagesize($_FILES["daGr_Foto"]["tmp_name"])) {
				move_uploaded_file( $_FILES["daGr_Foto"]["tmp_name"], "images/fotoPerfil/".$usuario.".jpg");
				
				$this->resize("images/fotoPerfil/".$usuario.".jpg", $usuario.".jpg", $ancho, $alto);
				
				$respuesta = "images/fotoPerfil/".$usuario.".jpg";
				
			} else {
				$respuesta = "images/fotoPerfil/default.jpg";
			}
			
		} elseif($_FILES["daGr_Foto"]['error'] == 4 && $existeFoto == '') {
			$respuesta = "images/fotoPerfil/default.jpg";
		} elseif ($existeFoto != '' ) {
			$respuesta = $existeFoto;
		}
		
		return $respuesta;
	}
	
	function resize($ruta, $nombre, $max_ancho, $max_alto){
		$rutaImagenOriginal = $ruta;
				
		$img_original = imagecreatefromjpeg($rutaImagenOriginal);
		
		list($ancho,$alto) = getimagesize($rutaImagenOriginal);

		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;

		if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
			$ancho_final = $ancho;
			$alto_final = $alto;
		}elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		}else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}
		
		$tmp = imagecreatetruecolor($ancho_final,$alto_final);
		
		imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
		imagedestroy($img_original);
		
		$calidad = 95;
		imagejpeg($tmp,$ruta,$calidad);
	}
}

?>