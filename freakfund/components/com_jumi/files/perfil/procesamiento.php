<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
include_once 'utilidades.php';
include_once 'imagenes.php';

$objDatos = new getDatosObj;

class procesamiento extends manejoImagenes {
	var $datos_generales;
	var $tels_general;
	var $mail_gral;
	var $direccion;
	var $datos_fiscales;
	var $domicilio_fiscal;
	var $representate;
	var $tels_representantes;
	var $mails_representante;
	var $domicilio_representante;
	var $datos_contacto;
	var $tels_contacto;
	var $mail_contacto;
	var $domicilio_contacto;
	var $cv;
	var $tabla;
	var $persona;
	
	function agrupacion($campos){
		
		// if(isset($generales) && $generales->perfil_personalidadJuridica_idpersonalidadJuridica != 1){
			// $validacion_rfc = $this->validacionRFC( $generales->perfil_personalidadJuridica_idpersonalidadJuridica,$campos['daFi_rfcRFC']);
			
			// if(!$validacion_rfc){
				// header("Location: {$_SERVER['HTTP_REFERER']}");
				// $error = "<p>RFC INVALIDO</p>";
					// $application = JFactory::getApplication();
					// $application->enqueueMessage(JText::_($error), 'error');
				// exit;
			// }
		// }
				
		$claves = array_keys($campos);
				
		foreach($claves as $clave ) {
			$clavevaltmp = substr($clave, 0, 5);
			$clavelimpia = substr($clave, 5);

			switch ($clavevaltmp) {
				case 'daGr_':
					if($clave === 'daGr_Foto_guardada') {
						if( $_FILES["daGr_Foto"]["name"] != ""){
							$this->cargar_imagen($_FILES['daGr_Foto']['type'], $campos['daGr_users_id']);
							$gral['Foto'] = "images/fotoPerfil/" . $campos['daGr_users_id'].".jpg";
						} elseif ($campos['daGr_Foto_guardada'] != '') {
							$gral['Foto'] = $campos['daGr_Foto_guardada'];
						} elseif ( $campos['daGr_Foto_guardada'] == '' || $_FILES["daGr_Foto"]["name"] == "" ) {
							$gral['Foto'] = "images/fotoPerfil/default.jpg";
						} 
					} else {
						if($campos[$clave] != "" || $campos['daGr_nomApellidoMaterno'] == ""){
							$gral[$clavelimpia] = $campos[$clave];
							$this->datos_generales = $gral;
						}
					}
					break;

				case 'teGr_':
					$telsGral[$clavelimpia] = $campos[$clave];
					$this->tels_general = $telsGral;
					break;

				case 'maGr_':
					$mailsGral[$clavelimpia] = $campos[$clave];
					$this->mail_gral = $mailsGral;
					break;

				case 'dire_':
					if($campos[$clave] != ""){
						$array_direccion[$clavelimpia] = $campos[$clave];
						$array_direccion['perfil_tipoDireccion_idtipoDireccion'] = '1';
						$this->direccion = $array_direccion;
					}
					break;

				case 'daFi_':
					if($campos[$clave] != ""){
						$array_datFis[$clavelimpia] = $campos[$clave];
						$this->datos_fiscales = $array_datFis;
					}
					break;

				case 'doFi_':
					if($campos[$clave] != ""){
						$array_domFis[$clavelimpia] = $campos[$clave];
						$array_domFis['perfil_tipoDireccion_idtipoDireccion'] = '2';
						$this->domicilio_fiscal = $array_domFis;
					}
					break;

				case 'repr_':
					$array_representante[$clavelimpia] = $campos[$clave];
					$this->representate = $array_representante;
					break;

				case 'teRe_':
					$telsRepresentante[$clavelimpia] = $campos[$clave];
					$this->tels_representantes = $telsRepresentante;
					break;

				case 'maRe_':
					$mailRepresentante[$clavelimpia] = $campos[$clave];
					$this->mails_representante = $mailRepresentante;
					break;

				case 'doRe_':
					if($campos[$clave] != ""){
						$array_domRep[$clavelimpia] = $campos[$clave];
						$array_domRep['perfil_tipoDireccion_idtipoDireccion'] = '1';
						$this->domicilio_representante = $array_domRep;
					}
					break;

				case 'daCo_':
					if($campos[$clave] != ""){
						$array_contacto[$clavelimpia] = $campos[$clave];
						$this->datos_contacto = $array_contacto;
					}
					break;

				case 'teCo_':
					$telsContacto[$clavelimpia] = $campos[$clave];
					$this->tels_contacto = $telsContacto;
					break;

				case 'maCo_':
					$mailContacto[$clavelimpia] = $campos[$clave];
					$this->mail_contacto = $mailContacto;
					break;
					
				case 'doCo_':
					if($campos[$clave] != ""){
						$array_domContacto[$clavelimpia] = $campos[$clave];
						$array_domContacto['perfil_tipoDireccion_idtipoDireccion'] = '1';
						$this->domicilio_contacto = $array_domContacto;
					}
					break;
			}
		}
	}
	function get_datosGenerales($dataGral){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->datos_generales, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_telsGenerales($dataGral){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->tels_general, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_mailsGeneral($dataGral){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->mail_gral, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_direccion($dataGral){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->direccion, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_datosFiscales($dataGral){
		$this->tabla = 'perfil_datosfiscales';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->datos_fiscales, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_domicilioFiscal($dataGral){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->domicilio_fiscal, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_representante($dataGral){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->representate, $this->tabla, $this->tipoContacto, $dataGral);
	}	
	function get_telsRepresentante($dataGral){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->tels_representantes, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_mailRepresentante($dataGral){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->mails_representante, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_domicilioRepresentate($dataGral){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->domicilio_representante, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_contacto($dataGral){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->datos_contacto, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_telsContacto($dataGral){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->tels_contacto, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_mailsContactos($dataGral){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->mail_contacto, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function get_domicilioContacto($dataGral){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->domicilio_contacto, $this->tabla, $this->tipoContacto, $dataGral);
	}
	function validacionRFC($tipoPersona,$rfc){
		if($tipoPersona == 3){
			$nombre = mb_substr($rfc,0,4);	
			$fecha = mb_substr($rfc,4,6);
		}elseif($tipoPersona == 2){
			$nombre = mb_substr($rfc,0,3);	
			$fecha = mb_substr($rfc,3,6);
		}
		
		$anio = mb_substr($fecha,0,2);
		$mes = mb_substr($fecha,2,2);
		$dia = mb_substr($fecha,4);
		$r = "/[A-Z]/";


		$iniciales = preg_match($r, $nombre);
		$valFecha = checkdate($mes,$dia,$anio);
		
		if($iniciales > 0 && $valFecha){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function grabarDatosPerfil($data, $tabladb, $tipoContacto, $resultado) {
		$db =& JFactory::getDBO();
		$usuario =& JFactory::getUser();
		$existe = $_GET['exi'];

		if (isset($data) && !empty($data)) {
				
			if ($tabladb != 'perfil_persona') {
				$generales = $resultado->datosGenerales($usuario->id, $tipoContacto);
				$idPersona = $generales->id;
				$data['perfil_persona_idpersona'] = $idPersona;
			}

			//Guarda la imagen de perfil en el perfil de Jomsocial.
			if ($tabladb == 'perfil_persona' && $data['perfil_tipoContacto_idtipoContacto'] == 1){
				$campos = ' avatar = "'.$data['Foto'].'", thumb = "'.$data['Foto'].'"';
				$conditions = ' userid = '.$usuario->id;
				$resultado->updateFields('c3rn2_community_users', $campos, $conditions);
				
				if( isset($data['freelance']) ) {
					$data['nomCompania'] = 'Independiente';
				}else{
					$data['freelance'] = 0;
				}
			}

			foreach ($data as $key => $value) {
				if (!empty($value) || $data['freelance'] == 0 ) {					
			        $col[] = mysql_real_escape_string($key);
					$val[] = "'".mysql_real_escape_string($value)."'";
				}
			}
			
			if (!$existe) {
				if ($tabladb == 'perfil_telefono') {
					for ($i = 0; $i < 3; $i++) {
						if($data['telTelefono'.$i] != '') {
							switch ($data['perfil_tipoTelefono_idtipoTelefono'.$i]) {
								case 1:
									$cols = array(0 => 'telTelefono',
												  1 => 'perfil_tipoTelefono_idtipoTelefono',
												  2 => 'perfil_persona_idpersona');
									$vals = array(0 => $data['telTelefono'.$i],
										  		  1 => $data['perfil_tipoTelefono_idtipoTelefono'.$i],
												  2 => $data['perfil_persona_idpersona']);
												  
									$resultado->insertFields($tabladb,$cols, $vals);

									break;
								case 2:
									$cols = array(0 => 'telTelefono',
												  1 => 'perfil_tipoTelefono_idtipoTelefono',
												  2 => 'perfil_persona_idpersona');

									$vals = array(0 => $data['telTelefono'.$i],
										  		  1 => $data['perfil_tipoTelefono_idtipoTelefono'.$i],
												  2 => $data['perfil_persona_idpersona']);
												  
									$resultado->insertFields($tabladb,$cols, $vals);

									break;
								case 3:
									$cols = array(0 => 'telTelefono', 
												  1 => 'perfil_tipoTelefono_idtipoTelefono',
												  2=>'extension',
												  3 => 'perfil_persona_idpersona');

									$vals = array(0 => $data['telTelefono'.$i],
										  		  1 => $data['perfil_tipoTelefono_idtipoTelefono'.$i],
												  2 => $data['extension'],
												  3 => $data['perfil_persona_idpersona']);
												  
									$resultado->insertFields($tabladb,$cols, $vals);

									break;
							}
						}
					}
				} elseif ($tabladb == 'perfil_email') {
					$count = count($data);
					for ($i = 0; $i < $count-1; $i++) {
						$cols = array(0 => 'coeEmail', 1=>'perfil_persona_idpersona');
						$vals = array(0 => '"'.$data['coeEmail'.$i].'"', $data['perfil_persona_idpersona']);
						
						if($data['coeEmail'.$i] != ''){
							$resultado->insertFields($tabladb, $cols, $vals);
						}
					}
				} else {
					$resultado->insertFields($tabladb, $col, $val);
				}
			} else {				
				$contador = count($col);

				for($i = 0; $i < $contador; $i++) {
					$fields[] = $col[$i].'='.$val[$i];
				}

				$fields = implode($fields,',');

				if ($tabladb == 'perfil_persona') {
					$campoId = 'id';
				}else{
					$campoId = 'perfil_persona_idpersona';
				}
						
				$datosUsuario = $resultado->datosGenerales($usuario->id, $tipoContacto);

				if( ($tabladb == 'perfil_direccion') && ($data['perfil_tipoDireccion_idtipoDireccion'] == 1) ){
					$conditions = ($campoId. ' = '.$datosUsuario->id. '&& perfil_tipoDireccion_idtipoDireccion = 1');
					$resultado->updateFields($tabladb, $fields, $conditions);

				} elseif (($tabladb == 'perfil_direccion') && ($data['perfil_tipoDireccion_idtipoDireccion'] == 2)) {
					$conditions = ($campoId. ' = '.$datosUsuario->id. ' && perfil_tipoDireccion_idtipoDireccion = 2');
					$resultado->updateFields($tabladb, $fields, $conditions);

				} elseif($tabladb == 'perfil_telefono'){
					$telefonos = $resultado->telefono($datosUsuario->id);
					$noTelefonos = count($telefonos);
					$countData = count($data);

					for ($i=0; $i < $countData-5; $i++) { 
						if(isset($telefonos[$i])){
							if( ($data['telTelefono'.$i] == '') || ($data['telTelefono'.$i] != $telefonos[$i]->telTelefono) ){
								switch ($data['perfil_tipoTelefono_idtipoTelefono'.$i]){
									case 1:	
										$conditions = ('idtelefono = '.$telefonos[$i]->idtelefono);
										$resultado->updateFields($tabladb, 'telTelefono = "'.$data['telTelefono'.$i].'"', $conditions);
									break;
									
									case 2:	
										$conditions = ('idtelefono = '.$telefonos[$i]->idtelefono);
										$campos = 'telTelefono = "'.$data['telTelefono'.$i].'"';
										$resultado->updateFields($tabladb, $campos, $conditions);
									break;
									
									case 3:	
										$conditions = ('idtelefono = '.$telefonos[$i]->idtelefono);
										$campos = 'telTelefono = "'.$data['telTelefono'.$i].'", extension = "'.$data['extension'].'" ';
										$resultado->updateFields($tabladb, $campos, $conditions);
									break;
								}
							}
						} else {
							switch ($data['perfil_tipoTelefono_idtipoTelefono'.$i]) {
								case 1:
									$cols = array(0 => 'telTelefono',
												  1 => 'perfil_tipoTelefono_idtipoTelefono',
												  2 => 'perfil_persona_idpersona');
									$vals = array(0 => '"'.$data['telTelefono'.$i].'"',
										  		  1 => $data['perfil_tipoTelefono_idtipoTelefono'.$i],
												  2 => $data['perfil_persona_idpersona']);
												  
									$resultado->insertFields($tabladb,$cols, $vals);

									break;
								case 2:
									$cols = array(0 => 'telTelefono',
												  1 => 'perfil_tipoTelefono_idtipoTelefono',
												  2 => 'perfil_persona_idpersona');

									$vals = array(0 => '"'.$data['telTelefono'.$i].'"',
										  		  1 => $data['perfil_tipoTelefono_idtipoTelefono'.$i],
												  2 => $data['perfil_persona_idpersona']);
												  
									$resultado->insertFields($tabladb,$cols, $vals);

									break;
								case 3:
									$cols = array(0 => 'telTelefono', 
												  1 => 'perfil_tipoTelefono_idtipoTelefono',
												  2=>'extension',
												  3 => 'perfil_persona_idpersona');

									$vals = array(0 => '"'.$data['telTelefono'.$i].'"',
										  		  1 => $data['perfil_tipoTelefono_idtipoTelefono'.$i],
												  2 => '"'.$data['extension'].'"',
												  3 => $data['perfil_persona_idpersona']);
												  
									$resultado->insertFields($tabladb,$cols, $vals);

									break;
							}
						}
					}
				
				} elseif ($tabladb == 'perfil_email'){
					$emails = $resultado->email($datosUsuario->id);
					$noEmails = count($emails);
					$noData = count($data);
					for($i = 0; $i < $noData-1; $i++) {
						if( isset($emails[$i]) ) {
							if ($emails[$i]->coeEmail != $data['coeEmail'.$i]) {
								$conditions = 'idemail = '.$emails[$i]->idemail;
								$resultado->updateFields($tabladb, 'coeEmail = "'.$data['coeEmail'.$i].'"', $conditions);
							} elseif ($data['coeEmail'.$i] == '') {
								$conditions = 'idemail = '.$emails[$i]->idemail;
								$resultado->updateFields($tabladb, 'coeEmail = "'.$data['coeEmail'.$i].'"', $conditions);
							}
						} else {
							$count = count($data);
							$cols = array(0 => 'coeEmail', 1=>'perfil_persona_idpersona');
							$vals = array(0 => '"'.$data['coeEmail'.$i].'"', $data['perfil_persona_idpersona']);

							if($data['coeEmail'.$i] != ''){
								$resultado->insertFields($tabladb, $cols, $vals);
							}
						}
					}					
				} elseif ($tabladb == 'perfil_historialproyectos'){
					$proyecPasados = proyectosPasados($datosUsuario->id);
					$noProyectos = count($proyecPasados);

					for($i = 0; $i < $noProyectos; $i++){
						if($proyecPasados[$i]->idHistorialProyectos == $data['idHistorialProyectos']) {
							$conditions = ($campoId. ' = '.$datosUsuario->id. ' && idHistorialProyectos = '.$data['idHistorialProyectos']);
							$resultado->updateFields($tabladb, $fields, $conditions);
							break;
						} elseif ($i == $noProyectos-1) {
							$resultado->insertFields($tabladb, $col, $val);
						}
					}					
				} else {
					if(isset($datosUsuario->id)) {
						$id = $datosUsuario->id;
					}else{
						$id = $datosUsuario->id;
					}
					$conditions = ($campoId. ' = '.$id);
					$resultado->updateFields($tabladb, $fields, $conditions);
				}
				
			}
		}
	}	
}

$usuario = JFactory::getUser();
$datos = new procesamiento;

$_POST['daGr_users_id'] = $usuario->id;
$_POST['daGr_perfil_tipoContacto_idtipoContacto'] = 1;
$_POST['repr_users_id'] = $usuario->id;
$_POST['repr_perfil_tipoContacto_idtipoContacto'] = 2;
$_POST['daCo_users_id'] = $usuario->id;
$_POST['daCo_perfil_tipoContacto_idtipoContacto'] = 3;

$datos->agrupacion($_POST);
$form = $_GET['form'];

//llamar a las funciones de guardado
if ($form == 'perfil') {
	
	$generales = $datos->get_datosGenerales($objDatos);
	$telsGen = $datos->get_telsGenerales($objDatos);
	$direccion = $datos->get_direccion($objDatos);
	$mailGen = $datos->get_mailsGeneral($objDatos);
	
	$dataGeneral = $objDatos->datosGenerales($usuario->id, 1);

	if ($dataGeneral->perfil_personalidadJuridica_idpersonalidadJuridica == 2 || $dataGeneral->perfil_personalidadJuridica_idpersonalidadJuridica == 3){
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php?option=com_jumi&view=application&fileid=13', 'Sus datos fueron grabados exitosamente' );
	} else {
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php?option=com_jumi&view=application&fileid=17', 'Sus datos fueron grabados exitosamente' );
	}
	
} elseif ($form == 'empresa') {
	$datos_fiscales = $datos->get_datosFiscales($objDatos);
	$domicilio_fiscales = $datos->get_domicilioFiscal($objDatos);
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php?option=com_jumi&view=application&fileid=16', 'Sus datos fueron grabados exitosamente' );

} elseif ($form == 'contac') {
	$repr = $datos->get_representante($objDatos);
	$domicilioRep = $datos->get_domicilioRepresentate($objDatos);
	$telsRep = $datos->get_telsRepresentante($objDatos);
	$mailRep = $datos->get_mailRepresentante($objDatos);
	
	$dat_contacto = $datos->get_contacto($objDatos);
	$dom_contacto = $datos->get_domicilioContacto($objDatos);
	$telsCon = $datos->get_telsContacto($objDatos);
	$mailCon = $datos->get_mailsContactos($objDatos);
	
	$allDone =& JFactory::getApplication($objDatos);
	$allDone->redirect('index.php?option=com_jumi&view=application&fileid=5', 'Sus datos fueron grabados exitosamente' );
}