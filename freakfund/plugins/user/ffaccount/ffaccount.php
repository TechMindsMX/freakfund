<?php
// No direct access.
defined('_JEXEC') or die;

jimport('trama.class');
jimport('trama.usuario_class');

class plgUserFFAccount extends JPlugin
{

	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
		
		$this->url = MIDDLE.PUERTO.'/trama-middleware/rest/user/saveUser';
		$this->token = JTrama::token();
	}

	function onUserLogin($user, $options = array()) {
		$instance = $this->_getUser($user, $options);

		// Envío al middleware
		if ($instance->lastvisitDate == '0000-00-00 00:00:00' && $instance->activation == '') {
			self::onFirstLogin($instance);
		}

		if ($instance instanceof Exception) {
			return false;
		}

		if ($instance->get('block') == 1) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('JERROR_NOLOGIN_BLOCKED'));
			return false;
		}

		if (!isset($options['group'])) {  // verifica que el usuario puede logear
			$options['group'] = 'USERS';
		}
		$result	= $instance->authorise($options['action']);
		if (!$result) {
			JError::raiseWarning(401, JText::_('JERROR_LOGIN_DENIED'));
			return false;
		}
		
		$instance->set('guest', 0);   // marca el usuario como logeado

		$session = JFactory::getSession();
		$session->set('user', $instance);   // set sesion de usuario
		
		$usuario = JFactory::getUser($instance->id);
		if ($usuario->get('isRoot')) {  // Chequeo para Super User en tablas de middle y users_middleware
			$chkJoomRel = self::checkJoomlaRelations($usuario);
				if (is_null($chkJoomRel)) $this->savePerfilPersona($user);
			$checkMiddle = self::checkMiddle($chkJoomRel->idMiddleware,$usuario);
				if (is_null($checkMiddle)) $this->sendToMiddle($user->email,$user->name);
		}

		$db = JFactory::getDBO();

		$app = JFactory::getApplication();
		$app->checkSession();

		$db->setQuery(
			'UPDATE '.$db->quoteName('#__session') .
			' SET '.$db->quoteName('guest').' = '.$db->quote($instance->get('guest')).',' .
			'	'.$db->quoteName('username').' = '.$db->quote($instance->get('username')).',' .
			'	'.$db->quoteName('userid').' = '.(int) $instance->get('id') .
			' WHERE '.$db->quoteName('session_id').' = '.$db->quote($session->getId())
		);
		$db->query();  // actualiza la sesion en la db

		$instance->setLastVisit();  // actualiza el momento de la ultima visita

		$prop = $instance->getProperties();   // busca las propiedades del usuario para tener el id
		$perfilff = UserData::datosGr($instance->id);  // busca los datos en nuestras tablas
				
		$faltanDatos = new stdClass;
		if ( !isset($perfilff) OR $perfilff->iddireccion == '' OR $perfilff->iddatosFiscales == '' ) {
			$haystack = $options['entry_url'];
			$needle = 'administrator';
			if ( !strstr($haystack, $needle)) { // verifica que no este en el admin
				$faltanDatos->check = true;
			}
		}
		
		//$url = 'index.php?option=com_jumi&view=application&Itemid=200&fileid=5';  // Perfil
		$carteraUrl = 'index.php?option=com_jumi&view=application&fileid=24&Itemid=218'; // Mi cartera
		$returnUrl = base64_decode(JRequest::getVar('return', '', 'method', 'base64'), true);
		
		$url = isset($returnUrl) ? $returnUrl : $carteraUrl;

		if ( isset($faltanDatos->check) ) {  // si faltan datos redirecciona redirecciona
			$app =& JFactory::getApplication();
			$app->redirect($url, JText::_('LLENAR_DATOS_USUARIO'), 'notice');
		} else {
			$app->redirect($url);
		}
	}
	
	function onFirstLogin($user) {
		$user_id = (int)$user->id; // convierte el user id a int sin importar que sea

		if (empty($user_id)) {
			die('invalid userid');
			return false; // sale si el user_id es vacio
		}
$data = date('d H:m:s').PHP_EOL.$user->email.PHP_EOL.$user->name.PHP_EOL.__FILE__.PHP_EOL.'Antes user->lastvisitDate == 0000-00-00 00:00:00 && user->activation == vacio'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
		if($user->lastvisitDate == '0000-00-00 00:00:00' && $user->activation == '') {
			// chequea que el usuario este activado y no este bloqueado y envia al middleware
$data = date('d H:m:s').PHP_EOL.$user->email.PHP_EOL.$user->name.PHP_EOL.__FILE__.PHP_EOL.'Antes de guardar en middleware'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
			if(!is_null($user->name)){
				$this->savePerfilPersona($user);
				$respuesta = (empty($user->activation) && ($user->block == 0)) ? $this->sendToMiddle($user->email,$user->name) : "blocked"; 
				$this->saveUserMiddle(json_decode($respuesta),$user);
			}
		}
	}
	
	function savePerfilPersona($datosUsuario){
$data = date('d H:m:s').PHP_EOL.$datosUsuario->email.PHP_EOL.__FILE__.PHP_EOL.'Guardando en perfil Persona'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);

		$nombreCompleto = explode(' ', trim($datosUsuario->name));

		$columnas[] 	= 'nomNombre';
		$columnas[] 	= 'nomApellidoPaterno';
		$columnas[] 	= 'users_id';
		$columnas[] 	= 'foto';
		$columnas[] 	= 'perfil_tipoContacto_idtipoContacto';
		$columnas[] 	= 'perfil_personalidadJuridica_idpersonalidadJuridica';
		
		$values[] 		= '"'.$nombreCompleto[0].'"';
		$values[]		= '"'.$nombreCompleto[1].'"';
		$values[]		= '"'.$datosUsuario->id.'"';
		$values[]		= '"images/fotoPerfil/default.jpg"';
		$values[]		= '1';
		$values[]		= '0';
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->insert($db->quoteName('perfil_persona'))
			->columns($db->quoteName($columnas))
			->values(implode(',',$values));
			
		$db->setQuery( $query );
		$db->query();

	}
	
	protected function checkJoomlaRelations($usuario) {
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->select('*')
			->from($db->quoteName('#__users_middleware'))
			->where('idJoomla = '.$usuario->id);

		$db->setQuery( $query );
		$db->query();
		
		$result = $db->loadObject();

		return $result;
	}
	
	protected function checkMiddle($userid, $usuario) {
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/user/get/'.$userid;
		$json = @file_get_contents($url);
		$respuesta = json_decode($json);
		
		if (is_null($respuesta)){
			$this->sendToMiddle($usuario->email,$usuario->name);
		}
	}

	function saveUserMiddle($idMiddle, $user) {
$data = date('d H:m:s').PHP_EOL.$idMiddle->id.PHP_EOL.__FILE__.PHP_EOL.'Guardando la relacion entre ids middleware y idJoomla'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
		$values = $idMiddle->id.','.$user->id;
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->insert($db->quoteName('#__users_middleware'))
			->columns('idMiddleware, idJoomla')
			->values($values);

		$db->setQuery( $query );
		$db->query();
	}
	
	function sendToMiddle ($email ,$name) {
$data = date('d H:m:s').PHP_EOL.$email.PHP_EOL.__FILE__.PHP_EOL.'Enviando al Middleware'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
		$data =   array('email' => $email, 
						'name' => $name,
						'token' => $this->token
				  );
				  		  
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$this->url);
		curl_setopt($ch, CURLOPT_POST, true);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		
		curl_close ($ch);
		
		return $server_output;
	}
	
	protected function _getUser($user, $options = array()) {
		$instance = JUser::getInstance();
		if ($id = intval(JUserHelper::getUserId($user['username'])))  {
			$instance->load($id);
			return $instance;
		}

		jimport('joomla.application.component.helper');
		$config	= JComponentHelper::getParams('com_users');
		// Default to Registered.
		$defaultUserGroup = $config->get('new_usertype', 2);

		$acl = JFactory::getACL();

		$instance->set('id'				, 0);
		$instance->set('name'			, $user['fullname']);
		$instance->set('username'		, $user['username']);
		$instance->set('password_clear'	, $user['password_clear']);
		$instance->set('email'			, $user['email']);	// Result should contain an email (check)
		$instance->set('usertype'		, 'deprecated');
		$instance->set('groups'			, array($defaultUserGroup));

		//If autoregister is set let's register the user
		$autoregister = isset($options['autoregister']) ? $options['autoregister'] :  $this->params->get('autoregister', 1);

		if ($autoregister) {
			if (!$instance->save()) {
				return JError::raiseWarning('SOME_ERROR_CODE', $instance->getError());
			}
		}
		else {
			// No existing user and autoregister off, this is a temporary user.
			$instance->set('tmp_user', true);
		}

		return $instance;
	}
	
}
