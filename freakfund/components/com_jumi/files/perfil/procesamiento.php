<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
include_once 'utilidades.php';
include_once 'imagenes.php';

class procesamiento extends manejoImagenes {
		
	public function agrupacion ($datos, $tabla, $getDatosGuardados) {
		$usuario = JFactory::getUser();
		$claves  = array_keys($datos);
		
		foreach ($claves as $clave) {
			$clavelimpia 	= substr($clave, 5);
			$prefijo 		= substr($clave, 0, 5);
			
			switch ($prefijo) {
				case 'daGr_':
					if($clavelimpia != 'Foto_guardada') {
						$generales[$clavelimpia] = $datos[$clave];
					}
					break;
				
				case 'daFi_':
					$facturacion[$clavelimpia] = $datos[$clave];
					break;
					
				case 'doFi_':
					$domicilioFiscal[$clavelimpia] = $datos[$clave];
				
				default:
					
					break;
			}
		}
		
		switch ($tabla) {
			case 'perfil_persona':
				$data = $generales;
				$data['Foto'] = $this->cargar_imagen($usuario->id, 400, 300, $_POST['daGr_Foto_guardada']);
				$data['users_id'] = $usuario->id;
				$data['perfil_tipoContacto_idtipoContacto'] = 1;
				$data['existe'] = $getDatosGuardados->existingUser($usuario->id);
				break;
			case 'perfil_datosfiscales':
				$data = $facturacion;
				$id_usuario = $getDatosGuardados->datosGenerales($usuario->id);
				$data['perfil_persona_idpersona'] = $id_usuario->id;
				$data['existe'] = !(is_null($getDatosGuardados->datosFiscales($id_usuario->id)));
				break;
			
			case 'perfil_direccion':
				$data = $domicilioFiscal;
				$id_usuario = $getDatosGuardados->datosGenerales($usuario->id);
				$data['perfil_persona_idpersona'] = $id_usuario->id;
				$data['existe'] = !(is_null($getDatosGuardados->domicilio($id_usuario->id)));
				break;
				
			default:
				
				break;
		}
		
		return $data;
	}
	
	public function grabarDatosPerfil($data, $tabladb, $getDatosGuardados) {
		$usuario 		= JFactory::getUser();	
		$dataFinal 		= $this->agrupacion($data, $tabladb, $getDatosGuardados);
		$exitenDatos	= $dataFinal['existe'];

		
		foreach ($dataFinal as $key => $value) {
			if($key != 'existe') {
	        	$col[] = mysql_real_escape_string($key);
				$val[] = '"'.mysql_real_escape_string($value).'"';
			}
		}
		
		//Guarda la imagen de perfil en el perfil de Jomsocial.
		if ($tabladb == 'perfil_persona'){
			$campos = ' avatar = "'.$dataFinal['Foto'].'", thumb = "'.$dataFinal['Foto'].'"';
			$conditions = ' userid = '.$usuario->id;
			$getDatosGuardados->updateFields('c3rn2_community_users', $campos, $conditions);
		}
		
		if(!$exitenDatos){
			//Inserta los datos en caso de que no existan elementos
			$getDatosGuardados->insertFields($tabladb, $col, $val);
		} else {
			//Actualiza los datos
			$id_conditions 	= $getDatosGuardados->datosGenerales($usuario->id);
			$conunt 		= count($col);
			
			for ($i = 0; $i < $conunt; $i++) {
				$fields[] = $col[$i].' = '.$val[$i];
			}

			if($tabladb == 'perfil_persona') {
				$conditions = 'id = '.$id_conditions->id;
			} else {
				$conditions = 'perfil_persona_idpersona = '.$id_conditions->id;
			}
			
			$getDatosGuardados->updateFields($tabladb, $fields, $conditions);
		}
		
		//Si es datos de facturacion se tiene que almacenar una direccion
		if($tabladb == 'perfil_datosfiscales') {
			$this->grabarDatosPerfil($_POST, 'perfil_direccion', $getDatosGuardados);
		}
		
		$fileid = $this->redireccion($tabladb);
		$allDone = JFactory::getApplication();
		$allDone->redirect($fileid, JText::_('DATOS_GUARDADOS'));		
	}
	
	public function redireccion ($tabladb) {
		switch ($tabladb) {
			case 'perfil_persona':
				$respuesta = 'index.php?option=com_jumi&view=application&fileid=13&Itemid=200';
				break;
				
			case 'perfil_datosfiscales':
				$respuesta = 'index.php?option=com_jumi&view=application&fileid=5&Itemid=199';;
				break;
				
			case 'perfil_direccion':
				$respuesta = 'index.php?option=com_jumi&view=application&fileid=5&Itemid=199';;
				break;
			
			default:
				
				break;
		}
		return $respuesta;
	}
}

$form 			= $_GET['form'];
$objDatos 		= new getDatosObj;
$procesamiento 	= new procesamiento;

$procesamiento->grabarDatosPerfil($_POST, $form,$objDatos);
?>