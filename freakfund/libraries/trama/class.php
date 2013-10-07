<?php

defined('JPATH_PLATFORM') or die ;

class JTrama 
{
	public $nomCat = null;
	
	public $nomCatPadre = null;

	public function	getAllSubCats() {
		$url = MIDDLE . PUERTO . '/trama-middleware/rest/category/subcategories/all';
		$subcats = json_decode(@file_get_contents($url));
		
		return $subcats;
	}	

	public function	getAllCatsPadre() {
	  	$url = MIDDLE.PUERTO.'/trama-middleware/rest/category/categories';
		$cats = json_decode(@file_get_contents($url));
		
		return $cats;
	}

	public function fetchAllCats()	{
		$cats = JTrama::getAllSubCats();
		$subcats = JTrama::getAllCatsPadre();
		$cats = array_merge($cats, $subcats);
		
		return $cats;
	}

	public function getSubCatName($data) {
		$cats = JTrama::fetchAllCats();
		foreach ($cats as $key => $value) {
			if ($value -> id == $data ) {
				$nomCat = $value -> name;
			}
		}
		return $nomCat;
	}
	public function getCatName($data) {
		$cats = JTrama::fetchAllCats();
		foreach ($cats as $key => $value) {
			if ($value -> id == $data ) {
				$nomCat = $value -> name;
				$idFather = $value -> father;
				if ($idFather >= 0) {
					foreach ($cats as $indice => $valor) {
						if ( $valor->id == $idFather ) {
							$nomCatPadre = $valor->name;
						}
					}
				}
				else {
					$nomCatPadre = '';
				}
			}
		}
		return $nomCatPadre;
	}
	
	public function getProducerProfile($data) {
		include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
		$link = JRoute::_('index.php?option=com_jumi&view=application&fileid=17&userid='.$data);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query
		->select(array('a.nomNombre','a.nomApellidoPaterno'))
		->from('perfil_persona AS a')
		->where('a.users_id = '.$data.' && a.perfil_tipoContacto_idtipoContacto = 1');
		
		$db->setQuery($query);
		$producer = $db->loadRow();
		if (!is_null($producer)) {
			$producer = implode(' ',$producer);
		}
		else {
			$producer = 'Anonimo';
		}
		$html = '<a href="'.$link.'" mce_href="'.$link.'">'.$producer.'</a>';
		return $html;
	}
	
	public static function getStatusName ($string) {
		$allNames = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));
		
		if(isset($allNames)) {
			foreach ($allNames as $llave => $valor) {
				if ($valor->id == $string) {
					if($valor->name == 'Listo'){
						$statusName = 'Listo para revision';
					} else {
						$statusName = $valor->name;
					}
				}
			}
		}

		return $statusName;
	}
	
	public static function getStatus(){
		$status = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));
		
		return $status;
	}
	
	public function getProjectsByUser ($userid) {
		$projectList = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/getByUser/'.$userid));
		
		return $projectList;
	}
	
	public static function getEditUrl($value) {
		$value->viewUrl = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$value->id;
		switch ($value->type) {
			case 'PROJECT':
				$value->editUrl = 'index.php?option=com_jumi&view=appliction&fileid=9&proyid='.$value->id;
				break;
			case 'PRODUCT':
				$value->editUrl = 'index.php?option=com_jumi&view=appliction&fileid=12&proyid='.$value->id;
				break;
			case 'REPERTORY':
				$value->editUrl = 'index.php?option=com_jumi&view=appliction&fileid=14&proyid='.$value->id;
				break;
			}
		return $value;
	}
	
	public static function tipoProyProd($data) {
		$tipo = $data->type;
		switch ($tipo) {
			case 'PRODUCT':
				$tipoEtiqueta = JText::_('PRODUCT');
				$data->editUrl = '12';
				break;
			case 'REPERTORY':
				$tipoEtiqueta = JText::_('REPERTORIO');
				$data->editUrl = '14';
				break;
			default:
				$tipoEtiqueta = JText::_('PROJECT');
				$data->editUrl = '9';
				break;
		}
		return $tipoEtiqueta;
	}

	public static function searchGroup($id){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query
		->select('id')
		->from('#__community_groups')
		->where('proyid = '.$id);
		
		$db->setQuery( $query );
		
		$idGroup = $db->loadObject();
		
		return $idGroup;
		
	}
	
	public static function searchFriends($id){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('friends')
		->from('#__community_users')
		->where('userid = '.$id);
	
		$db->setQuery( $query );
	
		$idGroup = $db->loadObject();
		
		return $idGroup;
	
	}
	
	public static function token(){
		
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/security/getKey';
		$token = @file_get_contents($url);
		
		return $token;
	}
	
	public static function allProjects(){
		
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/all';
		$jsonAllProjects = @file_get_contents($url);
		$json = json_decode($jsonAllProjects);
		
		if(isset($json)) {
			foreach ($json as $key => $value) {
				JTrama::formatDatosProy($value);
			}
		}
		
		return $json;
	}

	public static function getDatos ( $id ) {
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$id;
		$json = @file_get_contents($url);
		$respuesta = json_decode($json); 
		
		JTrama::checkValidId($respuesta);
		JTrama::formatDatosProy($respuesta);
			
		return $respuesta;
	}

	public static function checkValidId($data) {
		$app = JFactory::getApplication();
		if(!isset($data->id)) {
			$url = 'index.php';
			$app->redirect($url, JText::_('ITEM_DOES_NOT_EXIST'), 'error');
		}
	}
	
	public static function getUserBalance ( $usuario ) {
	
		if( isset($usuario) ) {
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/user/get/'.$usuario;
			$json = @file_get_contents($url);
			$respuesta = json_decode($json);
				
		} else {
	
			$respuesta = null;
		}
	
		return $respuesta;
	}
	
	public static function formatDatosProy ($value)
	{
		if(isset($value->projectFinancialData)) {
			foreach ($value->projectFinancialData as $key => $valor) {
				if($key != 'id'){
					$value->$key = $valor;
				}
			}
		}
		// SIMULADOS
		$value->fundStartDate = 1370284000000;
		$value->fundEndDate = 1377284000000; 
		$value->productionStartDateCode = 1378003651000;
		$value->premiereStartDateCode = 1381003651000;
		
		if ($value->balance != 0) {
			$value->porcentajeRecaudado = $value->balance / $value->breakeven;
		} else {
			$value->porcentajeRecaudado = 0; 
		};
		if (is_null($value->tri)) { $value->tri = 32; };
		// FIN SIMULADOS
		
		if (isset($value->fundStartDate)) {
			$value->fundStartDateCode = $value->fundStartDate;
			$value->fundStartDate = date('d-m-Y', ($value->fundStartDateCode/1000) );
		}
		if (isset($value->fundEndDate)) {
			$value->fundEndDateCode = $value->fundEndDate;
			$value->fundEndDate = date('d-m-Y', ($value->fundEndDate/1000) );
		}
		if (isset($value->productionStartDate)) {
			$value->productionStartDateCode = $value->productionStartDate;
			$value->productionStartDate = date('d-m-Y', ($value->productionStartDate/1000) );
		}
		if (isset($value->premiereStartDate)) {
			$value->premiereStartDateCode = $value->premiereStartDate;
			$value->premiereStartDate = date('d-m-Y', ($value->premiereStartDate/1000) );
		}
		if (isset($value->premiereEndDate)) {
			$value->premiereEndDateCode = $value->premiereEndDate;
			$value->premiereEndDate = date('d-m-Y', ($value->premiereEndDate/1000) );
		}
		if(isset($value->advanceDate)) {
			$value->advanceDateCode = $value->advanceDate;
			$value->advanceDate = date('d-m-Y', ($value->advanceDate/1000) );
		}
		if(isset($value->settlementDate)) {
			$value->settlementDateCode = $value->settlementDate;
			$value->settlementDate = date('d-m-Y', ($value->settlementDate/1000) );
		}
		$value->projectFinancialData = null;
	}
	
	public static function getClosestEnd()
	{
		$data = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/getByClosestToEnd'));
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$value = JTrama::formatDatosProy($value);
			}
		} 

		return $data;
	}

	public static function fundPercentage($data)
	{
		$data->balancePorcentaje = round(($data->balance * 100) / $data->breakeven, 2);

		return $data;
	}
	
	public static function getMostProfitables()
	{
		$data = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/getByHigherBalance'));
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$value = JTrama::formatDatosProy($value);
			}
		}
		
		return $data;
	}
	
	public static function getTRI($data)
	{
		$data->ROI = 20;
	}

	public static function getTRF($data)
	{
		$data->ROF = 40;
	}
	
	public static function getProyByStatus($params='')
	{
		$data = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/status/'.$params));
		
		foreach ($data as $key => $value) {
			JTrama::formatDatosProy($value);	
		}
		
		
		return $data;
	}
	
	public function getMotivosDeBaja () {
		$data = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/catalog/closedReasons'));
		
		return $data;
	}
	
	public static function getRedemptionCodes($value)
	{
		$con=mysql_connect("localhost","root","");
		mysql_select_db('redempcodes', $con);
		
		$result = mysql_query("SELECT * FROM project_redemptioncodes WHERE projectid = ".$value->id);
		
		while($row=mysql_fetch_object($result)) {
			$value->redemptionCodes[] = $row->redemptioncode;
		}

		return $value;
	}
	
	
}
?>
