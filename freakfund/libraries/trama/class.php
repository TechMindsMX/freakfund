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
			$producer = JFactory::getUser($data)->name;
		}
		$html = $producer;
		return $html;
	}
	
	public static function getStatusName ($id, $statusList = '') {
		if (empty($statusList)) {
			$statusList = self::getStatus();
		}
		
		if(!empty($statusList)){
			foreach ($statusList as $llave => $valor) {
				if ( $valor->id == $id ) {
					$valor->fullName 		= JText::_('TIP_'.strtoupper($valor->name).'_FULLNAME');
					$valor->tooltipTitle 	= JText::_('TIP_'.strtoupper($valor->name).'_TITLE');
					$valor->tooltipText 	= JText::_('TIP_'.strtoupper($valor->name).'_TEXT');
				break;
				}
			}
		}
		return $valor;
	}
	
	public static function getStatus(){
		$status = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));
		
		foreach ($status as $obj) {
				$map[] = array($obj->name, $obj);
			}	
			sort($map);
			
			foreach ($map as $key => $value) {
				$statusListFinal[] = $value[1];
			}

		return $statusListFinal;
	}
	
	public static function checkValidStatus($obj, $tipoActual = '') {
		$tipoActual = strtolower($tipoActual);
		switch ($tipoActual) {
			case 'proyecto':
				$statusAceptados = array(5);
				break;
			case 'producto':
				$statusAceptados = array(6,7,10);
				break;
			default:
				$statusAceptados = array(5,6,7,10);
		}

		$aceptado = in_array($obj->status, $statusAceptados);
		
		return $aceptado;
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
		$url 			= MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$id;
		$json 			= @file_get_contents($url);
		$respuesta 		= json_decode($json); 
		$dataProyecto	= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/tx/getProjectStatement/'.$id));
		$objagrupado	= self::agrupaIngresosEgresos($dataProyecto);
		$respuesta->totalIngresos = $objagrupado['totalIngresos'];
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
		
		if ($value->balance != 0) {
			$value->porcentajeRecaudado = round(($value->balance * 100) / $value->breakeven,2);
		} else {
			$value->porcentajeRecaudado = 0; 
		};
		$value->triFormateado = (is_null($value->tri)) ? 0 : round(($value->tri * 100), 2);
		$value->trfFormateado = (is_null($value->trf)) ? 0 : round(($value->trf * 100), 2);
		
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
		if(!is_null($value->providers)) {
			foreach ($value->providers as $indice => $valor) {
				$valor->settlementDateCode = $valor->settlementDate;
				$valor->settlementDate = date('d-m-Y', ($valor->settlementDate/1000) );
				
				$valor->advanceDateCode = $valor->advanceDate;
				$valor->advanceDate = date('d-m-Y', ($valor->advanceDate/1000) );				
			}
		}
		$value->projectFinancialData = null;
	}
	
	public static function getClosestEnd()
	{
		$data = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/getByClosestToEndFunding'));
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
	
	public static function getProyByStatus($params='')
	{
		$data = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/status/'.$params));
		
		foreach ($data as $key => $value) {
			JTrama::formatDatosProy($value);	
		}
		
		return $data;
	}
	
	public function getMotivosDeBaja () {
		$data = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/catalog/closedReasons'));
		
		return $data;
	}
	
	public static function getRedemptionCodes($proyId)	{
		$redemptionCodeExist = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/isTicketmasterLayout/'.$proyId));
		
		return $redemptionCodeExist;
	}
	
	public static function dateDiff ($dateString1, $dateString2 = null) {
		if (is_null($dateString2)) {
			$fecha2 = new DateTime();
		} else {
			$fecha2 = new DateTime($dateString2);
		}
		
		$fecha1 = new DateTime($dateString1);

		$dateDiff = date_diff($fecha1,$fecha2);
		
		return $dateDiff;
	}
	
	public static function getProjectbyUser ($middlewareId){
		$jsonobj= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/projects/'.$middlewareId));
		if(isset($jsonobj)) {
			foreach ($jsonobj as $key => $value) {
				JTrama::formatDatosProy($value);
			}
		}
		return $jsonobj;
	}
	
	public static function getProductbyUser ($middlewareId){
		$jsonobj2= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/products/'.$middlewareId));
		if(isset($jsonobj2)) {
			foreach ($jsonobj2 as $key => $value) {
				JTrama::formatDatosProy($value);
			}
		}
		return $jsonobj2;
	}
	
	public static function getTransactions($idMiddleware, $startDate, $endDate) {
		$transactionsList = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/tx/getUserStatement/'.$idMiddleware.'/'.$startDate.'/'.$endDate));
		return $transactionsList;
	}
	
	public static function getDetailTransactions($bulkId) {
		$transactionsList = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/tx/getBulkTransactions/'.$bulkId));
		return $transactionsList;
		;
	}
	
	public static function getInvestmentDetail($transactionId) {
		$transactionsDetail = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/tx/get/transaction/'.$transactionId));
		return $transactionsDetail;
		;
	}
	
	public static function getStateResult($proyId){
		$dataProyecto					 	= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/tx/getProjectStatement/'.$proyId));
		$dataGral 							= self::getDatos($proyId);
		$user								= UserData::getUserJoomlaId($dataGral->userId);
		$usuario							= JFactory::getUser($user);
		$objagrupado					 	= self::agrupaIngresosEgresos($dataProyecto);
		$objagrupado					 	= self::sumatoriaIngresos($objagrupado);
		$objagrupado						= self::sumatoriaEgresos($objagrupado);
		$objagrupado						= self::operacionesEstadoResult($objagrupado,$dataGral);
		$objagrupado['sections']			= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/getSections/'.$proyId));
		$objagrupado['userIdJoomla']		= $user;
		$objagrupado['userIdMiddleware']	= $dataGral->userId;
		$objagrupado['proyectName'] 		= $dataGral->name;
		$objagrupado['producerName'] 		= $usuario->name;
		$objagrupado['breakeven'] 			= $dataGral->breakeven;
		$objagrupado['presupuesto']		 	= $dataGral->budget;
		$objagrupado['balance'] 			= $dataGral->balance;
		$objagrupado['cre']		 			= $dataGral->cre;
		$objagrupado['finFunding']			= $dataGral->fundEndDate;
		$objagrupado['FechaInicioProduc']	= $dataGral->productionStartDate;	
		$objagrupado['FechaEstreno']		= $dataGral->premiereStartDate;
		$objagrupado['fechafin']			= $dataGral->premiereEndDate;
		$objagrupado['ingresosPotenciales']	= $dataGral->revenuePotential;
		$objagrupado['account']				= $dataGral->account;		
		$objagrupado['porBreakeven']		= ($dataGral->breakeven/$dataGral->revenuePotential)*100;
		
		foreach ($dataGral->projectUnitSales as $key => $value) {
			foreach ($objagrupado['sections'] as $llave => $valor) {
				if($value->section == $valor->name){
					$valor->unitSales 	= $valor->total - $valor->units;
					$valor->price 		= $value->unitSale;					
				}
			}
		}
		
		
		return $objagrupado;
	}
	
	public static function agrupaIngresosEgresos($dataProyecto){
		$respuesta 	= array();
		$respuesta['ingresos'] 	= array();
		$respuesta['egresos'] 	= array();
		
		$respuesta['totalIngresos']	= 0;
		$respuesta['totalEgresos']	= 0;
		
		foreach ($dataProyecto as $key => $value) {
			switch ($value->type) {
				case 'CREDIT':
					$respuesta['ingresos'][] = $value;
					$respuesta['totalIngresos'] = $respuesta['totalIngresos']+$value->amount;
					break;
				case 'DEBIT':
					$respuesta['egresos'][] = $value;
					$respuesta['totalEgresos'] = $respuesta['totalEgresos']+$value->amount;
					break;
				default:					
					break;
			}			
		}
		
		return $respuesta;
	}
	
	public static function sumatoriaIngresos($objAgrupado){
		//Ingresos
		$objAgrupado['totFundin'] 		= 0;
		$objAgrupado['porFundin'] 		= 0;
		$objAgrupado['totInvers'] 		= 0;
		$objAgrupado['porInvers'] 		= 0;
		$objAgrupado['totVentas'] 		= 0;
		$objAgrupado['porVentas'] 		= 0;
		$objAgrupado['totPatroc'] 		= 0;
		$objAgrupado['toApoDona'] 		= 0;
		$objAgrupado['totalOtro']		= 0;
		$objAgrupado['toAporCap'] 		= 0;
		$objAgrupado['totalPorVentas'] 	= 0;
		
		foreach ($objAgrupado['ingresos'] as $key => $value) {
			switch ($value->description) {
				case 'FUNDING':
					$objAgrupado['totFundin'] = $objAgrupado['totFundin']+$value->amount;
					break;
				case 'INVESTMENT':
					$objAgrupado['totInvers'] = $objAgrupado['totInvers']+$value->amount;
					break;
				case 'SALES':
					$objAgrupado['totVentas'] = $objAgrupado['totVentas']+$value->amount;
					break;
				case 'SPONSORSHIP':
					$objAgrupado['totPatroc'] = $objAgrupado['totPatroc']+$value->amount;
					break;
				case 'SUPPORTDONATIONS':
					$objAgrupado['toApoDona'] = $objAgrupado['toApoDona']+$value->amount;
					break;
				case 'OTHERS':
					$objAgrupado['totalOtro'] = $objAgrupado['totalOtro']+$value->amount;
					break;
				case 'PROVIDER_PARTNERSHIP':
					$objAgrupado['toAporCap'] = $objAgrupado['toAporCap']+$value->amount;
					break;
				default:
					break;
			}
		}
		$objAgrupado['totalPorVentas'] = $objAgrupado['totFundin'] + $objAgrupado['totInvers'] + $objAgrupado['totVentas'];
		
		if($objAgrupado['totalPorVentas'] != 0){
			$objAgrupado['porFundin'] = ($objAgrupado['totFundin'] / $objAgrupado['totalPorVentas'])*100;
			$objAgrupado['porInvers'] = ($objAgrupado['totInvers'] / $objAgrupado['totalPorVentas'])*100;
			$objAgrupado['porVentas'] = ($objAgrupado['totVentas'] / $objAgrupado['totalPorVentas'])*100;
		}
		
		return $objAgrupado;
	}

	public static function sumatoriaEgresos($objAgrupado){
		//egresos
		$objAgrupado['toProveed'] = 0;
		$objAgrupado['toCapital'] = 0;
		$objAgrupado['toReemCap'] = 0;
		$objAgrupado['toProduct'] = 0;
		$objAgrupado['toCostFij'] = 0;
		
		foreach ($objAgrupado['egresos'] as $key => $value) {
			switch ($value->description) {
				case 'PROVIDERS':
					$objAgrupado['toProveed'] = $objAgrupado['toProveed']+$value->amount;
					break;
				case 'CAPITAL':
					$objAgrupado['toCapital'] = $objAgrupado['toCapital']+$value->amount;
					break;
				case 'CAPITALREPAYMENT':
					$objAgrupado['toReemCap'] = $objAgrupado['toReemCap']+$value->amount;
					break;
				case 'PRODUCER_PAYMENT':
					$objAgrupado['toProduct'] = $objAgrupado['toProduct']+$value->amount;
					break;
				case 'FEXEDCOSTS':
					$objAgrupado['toCostFij'] = $objAgrupado['toCostFij']+$value->amount;
					break;
				case 'PROVIDER_PAYMENT';
					$objAgrupado['toProveed'] = $objAgrupado['toProveed'] + $value->amount;
					break;
				default:
					break;
			}
		}

		return $objAgrupado;
	}

	public static function operacionesEstadoresult($objagrupado, $dataGral){
		$objagrupado['resultadoIE'] 	= $objagrupado['totalIngresos']-$objagrupado['totalEgresos'];
		$objagrupado['porcVentas'] 		= ($objagrupado['totVentas'] + $objagrupado['toAporCap'])/($objagrupado['totalIngresos']==0?1:$objagrupado['totalIngresos']);
		$objagrupado['porcInver'] 		= ($objagrupado['totInvers'] + $objagrupado['totFundin'])/($objagrupado['totalIngresos']==0?1:$objagrupado['totalIngresos']);
		$objagrupado['fincol3'] 		= $objagrupado['resultadoIE'] * $objagrupado['porcVentas'];
		$objagrupado['resultReden']		= $objagrupado['fincol3'] * 0.10;
		$objagrupado['resultFinan']		= $objagrupado['totFundin'] * $dataGral->trf;
		$objagrupado['resultInver']		= $objagrupado['totInvers'] * $dataGral->tri;
		$objagrupado['retornos']	 	= $objagrupado['resultFinan'] + $objagrupado['resultInver'];
		$objagrupado['resultComic']		= 0;
		$objagrupado['resultOtros']		= 0;
		$objagrupado['toResultado']		= $objagrupado['resultReden'] + $objagrupado['resultFinan'] + $objagrupado['resultInver'] + $objagrupado['resultComic'] + $objagrupado['resultOtros'];
		$objagrupado['porcentaTRI']		= $dataGral->tri*100;
		$objagrupado['porcentaTRF']		= $dataGral->trf*100;
		$objagrupado['toCostVar']		= 0;
		

		foreach ($dataGral->variableCosts as $key => $value) {
			$detalle = new stdClass();
			$detalle->nombre = $value->name;
			$detalle->porcentaje = $value->value.'%';
			$detalle->mount = ($value->value/100) * $dataGral->balance;
			
			$objagrupado['toCostVar'] = $objagrupado['toCostVar'] + (($value->value/100) * $objagrupado['totalIngresos']);
			$detalleOperacion[] = $detalle;
		}
		
		$objagrupado['detalleoperacion'] = $detalleOperacion;

		return $objagrupado;
	}

	public static function getProjectORProductParnetship($userIdMiddleware, $ProjectProduct){
		$dataProyecto= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/partnership/'.$userIdMiddleware));
		$respuesta = array();
		
		if(!is_null($dataProyecto)){
			switch ($ProjectProduct) {
				case 'project':
					$array = array(5);
					foreach ($dataProyecto as $key => $value) {
						if(in_array($value->status, $array)){
							self::formatDatosProy($value);
							$respuesta[] = $value;
						}
					}
					break;
				case 'product':
					$array = array(6,7,10);
					foreach ($dataProyecto as $key => $value) {
						if(in_array($value->status, $array)){
							self::formatDatosProy($value);
							$respuesta[] = $value;
						}
					}
					break;
				
				default:
					break;
			}
		}else{
			$respuesta = null;
		}
		return $respuesta;		
	}
}
?>
