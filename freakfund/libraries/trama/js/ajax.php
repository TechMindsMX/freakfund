<?php
$fun = is_numeric($_POST['fun']) ? $_POST['fun'] : 0;

include('../../../configuration.php');
$configuracion = new JConfig;
$bd = new mysqli($configuracion->host, $configuracion->user ,$configuracion->password, $configuracion->db);

date_default_timezone_set('America/Mexico_City');

switch ($fun) {
	case 1:
		$calificador = is_numeric($_POST['calificador']) ? $_POST['calificador'] : 0;
		$calificado = is_numeric($_POST['calificado']) ? $_POST['calificado'] : 0;
		$score = is_numeric($_POST['score']) ? $_POST['score'] : 0;
		
		$respuesta = array();
		
		$query = 'SELECT * FROM perfil_rating_usuario WHERE idUserCalificador = '.$calificador.' AND iduserCalificado = '.$calificado;
		$resultado = $bd->query($query);
		
		if( ($resultado->num_rows == 0) AND ($calificador != $calificado)) {
			$query_insert = 'INSERT INTO perfil_rating_usuario VALUES (NULL, '.$calificador.','.$calificado.' , '.$score.')';
			$bd->query("SET NAMES 'utf8'");
			$bd->query($query_insert);
			
			$query_promedio = 'SELECT avg(rating) as score FROM perfil_rating_usuario WHERE idUserCalificado = '.$calificado;
			$resultado_score = $bd->query($query_promedio);
		
			$obj_score = $resultado_score->fetch_object();
			
			$respuesta['score'] = $obj_score->score;
			$respuesta['msg'] = 'Guardado';
			$respuesta['bloquear'] = true;
		} else {
			$query_promedio = 'SELECT avg(rating) as score FROM perfil_rating_usuario WHERE idUserCalificado = '.$calificado;
		// echo $query_promedio;
		// exit;
		
			$resultado_score = $bd->query($query_promedio);
		
			$obj_score = $resultado_score->fetch_object();
			
			$respuesta['score'] = is_null($obj_score->score)? 0 : $obj_score->score;
			$respuesta['msg'] = 'Solo se acepta una sola calificación';
			$respuesta['bloquear'] = true;
		}
		
		echo json_encode($respuesta);
		break;
		
	case 2:
		$url = "http://192.168.0.122:7070/sepomex-middleware/rest/sepomex/get/".$_POST["cp"];
		echo file_get_contents($url);
		break;
		
	case 3:
		
		$userId = $_POST['userId'];
		$projectId = $_POST['projectId'];
		$linkProyecto = $_POST['linkProyecto'];
		$nomUser = $_POST['nomUser'];
		$nomProyecto = $_POST['nomProyecto'];
		
		$queryShared = 'SELECT * FROM c3rn2_community_activities WHERE actor = '.$userId.' && proyId = '.$projectId;
		$resultShared = $bd->query($queryShared);
		
		if ($resultShared->num_rows == 0) {
			
			$queryMaxId = 'SELECT MAX(id) AS id from c3rn2_community_activities';
			$resultado = $bd->query($queryMaxId);
			
			$objMaxId = $resultado->fetch_object();
			$objMaxId->id = $objMaxId->id + 1;
			
			$frase = $nomUser.' ha compartido '.$nomProyecto.', '.$linkProyecto;
			$fecha = date("Y-m-d H:i:s");
			
			$query_proy = 'INSERT INTO `c3rn2_community_activities` ';
			$query_proy .= '(`id`, `actor`, `target`, `title`, `content`, `app`, `verb`, `cid`, `groupid`, `eventid`, `group_access`, `event_access`, `created`, `access`, `params`, `points`, `archived`, `location`, `latitude`, `longitude`, `comment_id`, `comment_type`, `like_id`, `like_type`, `actors`, `proyId`)';
			$query_proy .= 'VALUES ("NULL", "'.$userId.'", "'.$userId.'", "'.$frase.'", "", "profile", "", "'.$userId.'", "0", "0", "0", "0", "'.$fecha.'", "20", "", "1", "0", "", "255", "255", "'.$objMaxId->id.'", "profile.status", "'.$objMaxId->id.'", "profile.status", "", "'.$projectId.'")';
			
			$bd->query("SET NAMES 'utf8'");
			$bd->query($query_proy);
			
			$respuesta['shared'] = false;
			
		} else {
			
			$respuesta['shared'] = true;
			$respuesta['name'] = $nomUser;
			
		}

		echo json_encode($respuesta);
		break;
		
	case 4:
		require_once('recaptchalib.php');
		
		$privatekey = "6LfC7OcSAAAAAHZd7gT6NBMQzjzUjtMhaSGl-DM6";
		$codigo = array();
		
		$resp = recaptcha_check_answer ($privatekey,
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			$codigo['error'] = 'El captcha es incorrecto.';
			$codigo['mensaje'] = false;
		} else {
			// Your code here to handle a successful verification
			$codigo['mensaje'] = true;
			$codigo['error'] =  'nada';
		}
		
		
		echo json_encode($codigo);
		break;
		
	case 5:
		$codigo = array();
		$codigo['mensaje'] = true;
		$codigo['proyid'] =  3;
		$codigo['monto'] = 70;
		$codigo['tasa'] = '10%';
		$codigo['nombreProy'] = 'Kill Bill';
		
		echo json_encode($codigo);
		break;
		
	default:
		echo 'error';
		break;
}
?>