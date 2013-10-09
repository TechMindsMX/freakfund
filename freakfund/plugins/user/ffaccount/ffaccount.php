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
		
		$this->url = 'http://localhost/post.php';
		// $this->token = JTrama::token();
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
		
		$respuesta = $this->sendToMiddle($id); // envia al middleware
var_dump($user);echo $respuesta;exit;
		if ($respuesta == "existe") {
			$mensaje = 'PLG_FFACCOUNT_ALREADY_CREATED';
			$type = 'notice';
		} elseif ($respuesta == 'true' ) {
			$mensaje = 'PLG_FFACCOUNT_SUCCESS';
			$type = 'message';
		} else {
			$mensaje = 'PLG_FFACCOUNT_ERR_FAILED';
			$type = 'error';
		}
		JFactory::getApplication()->enqueueMessage(JText::sprintf($mensaje), $type);
	}
	function sendToMiddle ($id) {
		
		$data =   array('user_id' => $id, 
						// 'token' => $this->token
				  );
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$this->url);
		curl_setopt($ch, CURLOPT_POST, true);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		
		curl_close ($ch);
// echo $server_output;exit;		
		return $server_output;

	}
}
