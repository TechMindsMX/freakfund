<?php
// No direct access.
defined('_JEXEC') or die;

jimport('trama.class');
class plgUserFFAccount extends JPlugin
{

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
		
		$this->url = MIDDLE.PUERTO.'/trama-middleware/rest/user/saveUser';
		$this->token = JTrama::token();
	}

	function onUserAfterSave($user, $isnew, $success, $msg)
	{
		if(!$success) {
			return false; // si el usuario no se graba no hace nada
		}

		$user_id = (int)$user['id']; // convierte el user id a int sin importar que sea

		if (empty($user_id)) {
			die('invalid userid');
			return false; // sale si el user_id es vacio
		}

		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select($db->quoteName('id'));
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('email').' = \''. $user['email'] . '\'');
		
		$db->setQuery( $query );
		$id = $db->loadResult();

		// chequea que el usuario este activado y no este bloqueado y envia al middleware
		$respuesta = (empty($user['activation']) && ($user['block'] == 0)) ? $this->sendToMiddle($user['email']) : "blocked"; 
		
		if( $isnew ){
			$this->saveUserMiddle(json_decode($respuesta),$user);
		}
	}

	function saveUserMiddle($idMiddle, $user){
		$values = $idMiddle->id.','.$user['id'];
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->insert($db->quoteName('#__users_middleware'))
			->columns('idMiddleware, idJoomla')
			->values($values);
		
		$db->setQuery( $query );
		$db->query();
	}
	
	function sendToMiddle ($email) {
		
		$data =   array('email' => $email, 
						'token' => $this->token
				  );
				  
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$this->url);
		curl_setopt($ch, CURLOPT_POST, true);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		
		curl_close ($ch);
 //echo $server_output;exit;		
		return $server_output;

	}
}
