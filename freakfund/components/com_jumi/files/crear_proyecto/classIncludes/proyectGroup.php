<?php
defined('_JEXEC') OR die( "Direct Access Is Not Allowed" );

jimport('trama.class');
require_once 'components/com_jumi/files/crear_proyecto/classIncludes/libreriasPP.php';

$subCategorias = JTrama::getAllSubCats();

$objDatosProyecto = JTrama::getDatos( (!empty($_GET['projectId']))?$_GET['projectId']:null, $subCategorias);

$grupoExistente = JTrama::searchGroup($objDatosProyecto->id);

if (!isset($grupoExistente) && $objDatosProyecto->type != 'REPERTORY') {

	$fecha = date("Y-m-d H:i:s");
	$grupo = new stdClass();
	
		$grupo->published = 1;
		$grupo->proyid = $objDatosProyecto->id;
		$grupo->ownerid = $objDatosProyecto->userId;
		$grupo->categoryid = 1;
		$grupo->name = $objDatosProyecto->name;
		$grupo->description = $objDatosProyecto->description;
		$grupo->created = $fecha;
		$grupo->avatar = MIDDLE.AVATAR.'/'.$objDatosProyecto->projectAvatar->name;
		$grupo->thumb = MIDDLE.AVATAR.'/'.$objDatosProyecto->projectAvatar->name;
		$grupo->approvals = 1;
		$grupo->params = '{"discussordering":1,"photopermission":1,"videopermission":1,"eventpermission":1,"grouprecentphotos":6,"grouprecentvideos":6,"grouprecentevents":6,"newmembernotification":1,"joinrequestnotification":1,"wallnotification":1,"removeactivities":0,"groupdiscussionfilesharing":1,"groupannouncementfilesharing":1,"stream":1}';
	
	$resultGroup = JFactory::getDbo()->insertObject('#__community_groups', $grupo);
	
	if ($resultGroup) {
		
		$idGroup = JTrama::searchGroup($objDatosProyecto->id);
		
		$memberGroup = new stdClass();
		
			$memberGroup->groupid = $idGroup->id;
			$memberGroup->memberid = $objDatosProyecto->userId;
			$memberGroup->approved = 1;
			$memberGroup->permissions = 1;
			
			$resultMember = JFactory::getDbo()->insertObject('#__community_groups_members', $memberGroup);
			
		if ($resultMember) {
			
			$allDone =& JFactory::getApplication();
			$allDone->redirect('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$idGroup->id, 'Grupo creado con exito');
		
		} else {
			
			$allDone =& JFactory::getApplication();
			$allDone->redirect('index.php', 'No se pudo crear el grupo del proyecto');
		
		}
		
	} else {
		
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php', 'No se pudo crear el grupo del proyecto');
	
	}
	
} else if ($objDatosProyecto->type == 'REPERTORY'){
	
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php');

} else {
	
	$idGroup = JTrama::searchGroup($objDatosProyecto->id);
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$idGroup->id);
	
}
	
	

?>