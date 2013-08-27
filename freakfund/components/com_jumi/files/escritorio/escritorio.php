<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$count = 0;
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport("trama.class");
jimport("trama.jsocial");
require_once 'components/com_jumi/files/perfil_usuario/usuario_class.php';
$input = JFactory::getApplication()->input;
$userid = $input->get("userid",0,"int");

$objuserdata = new UserData;
$userid = ($userid==0)? $usuario->id: $userid ;

$document = JFactory::getDocument();
$base = JUri::base();
$proyectos = JTrama::getProjectsByUser($userid);
foreach ($proyectos as $key => $value) {
	$entity = new JTrama;
	
	$entity->getEditUrl($value);
}


$pathJumi = $base.'components/com_jumi/files/perfil_usuario/';
$document->addStyleSheet($pathJumi.'css/style.css');

$datosgenerales = $objuserdata::datosGr($userid);

if(is_null($datosgenerales)){
	$app->redirect('index.php', 'No hay datos de usuario','notice');
}

$id_datos_generales = $datosgenerales->id;

$promedio = $objuserdata->scoreUser($userid);

?>
<style>
.comentariosMedia{
			display:none;
		}
.editMedia {
	display:none;
}
		
@media all and (max-width: 720px){
	.comentarios{
		display:none;
	}
	.comentariosMedia{
		display:inline;
	}
	.editTabla{
		display:none;
	}
	.editMedia{
		display:inline;
	}
}
</style>
    <body>
        
      <script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
        
      <div id="contenido">  
			<section class="ac-container" style="max-width: 100%;">
				<div>
					<input id="ac-2a" name="accordion-2" type="radio" />
					<label for="ac-2a">Proyectos</label>
					<article class="ac-medium">
						<table width="100%" frame="box" rules="all" style="text-align: center">
							<tr>
								<th>Nombre</th>
								<th>Creación</th>
								<th>Status</th>
								<th>Grupo</th>
								<th>
									<span class="comentarios">Comentarios</span>
									<span class="comentariosMedia">
										<img width="20" src="components/com_jumi/files/escritorio/img/comentarios.png" />
									</span>
								</th>
								<th>
									<span class="editTabla">Editar</span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value ) {
									if ($value->type == 'PROJECT' && $value->status!=4) {
										$fecha = $value->timeCreated/1000;
										$groupId = JTrama::searchGroup($value->id);
										echo '<tr>';
											
											echo '<td><a href="'.$value->viewUrl.'" >'.$value->name.'</a></td>';
											echo '<td>'.date('d/M/Y',$fecha).'</td>';
											echo '<td>'.JTrama::getStatusName($value->status).'</td>';
											echo '<td>
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
												  </td>';
											echo '<td>';
												if ( !empty($value->logs) ) {
													echo '<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Ver</a>';
												}
											echo '</td>';
											echo '<td>';
												if($value->status == 0 || $value->status == 2) {
													echo '<a class="button" href="'.$value->editUrl.'">Ir</a>';
												}
											echo '</td>';
											
										echo "</tr>";
									}
							?>							
							<div class="divcontent" id="divContent<?php echo $count; ?>">
							<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
											 '<div><strong>Status</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>Comentario</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>
						</table>
					</article>
				</div>
				
				<div>
					<input id="ac-3a" name="accordion-2" type="radio" />
					<label for="ac-3a">Productos</label>
					<article class="ac-large">
						<table width="100%" frame="box" rules="all" style="text-align: center;">
							<tr>
								<th>Nombre</th>
								<th>Creación</th>
								<th>Status</th>
								<th>Grupo</th>
								<th>
									<span class="comentarios">Comentarios</span>
									<span class="comentariosMedia">
										<img width="20" src="components/com_jumi/files/escritorio/img/comentarios.png" />
									</span>
								</th>
								<th>
									<span class="editTabla"><?php echo JText::_('EDIT'); ?></span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type == 'PRODUCT' && $value->status != 4) {
										$fecha = $value->timeCreated/1000;
										$groupId = JTrama::searchGroup($value->id);
										echo "<tr>";
										
											echo '<td><a href="'.$value->viewUrl.'" >'.$value->name.'</a></td>';
											echo '<td>'.date('d/M/Y',$fecha).'</td>';
											echo '<td>'.JTrama::getStatusName($value->status).'</td>';
											echo '<td>
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
												  </td>';
											echo "<td>";
												if ( !empty($value->logs) ) {
													echo '<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Ver</a>';
												}
											echo '</td>';
											echo "<td>";
												if($value->status == 0 || $value->status == 2) {
													echo '<a class="button editar" href="'.$value->editUrl.'">Ir</a>';
												}
											echo "</td>";

										echo "</tr>";
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
											 '<div><strong>Status</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>Comentario</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>	
						</table>
					</article>
				</div>
				
				<div>
					<input id="ac-4a" name="accordion-2" type="radio" />
					<label for="ac-4a">Repertorio</label>
					<article class="ac-small">
						<table width="100%" frame="box" rules="all" style="text-align: center;">
							<tr>
								<th>Nombre</th>
								<th>
									<span class="editTabla"><?php echo JText::_('EDIT'); ?></span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value) {
									if ($value->type == 'REPERTORY') {
										echo '<tr>';
										echo '	<td><a href="'.$value->viewUrl.'" target="_blank">'.$value->name.'</a></td>';
										echo '	<td><a class="button" href="'.$value->editUrl.'">Ir</a></td>';	
										echo "</tr>";
									}
								}
		       				?>
		       			</table> 				
					</article>
                </div>
                    
               	<div>
                    <input id="ac-5a" name="accordion-2" type="radio" />
					<label for="ac-5a">Suspendidos</label>
					<article class="ac-large">
						<table width="100%" frame="box" rules="all" style="text-align: center;">
							<tr>
								<th>Nombre</th>
								<th>Creación</th>
								<th>Grupo</th>
								<th>
									<span class="comentarios">Comentarios</span>
									<span class="comentariosMedia">
										<img width="20" src="components/com_jumi/files/escritorio/img/comentarios.png" />
									</span>
								</th>
								<th>
									<span class="editTabla">Editar</span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type != 'REPERTORY' && $value->status == 4) {
										$groupId = JTrama::searchGroup($usuario->id, $value->id);
										$fecha = $value->timeCreated/1000;
										echo "<tr>";
										echo '	<td><a href="'.$value->viewUrl.'" >'.$value->name.'</a></td>';
										echo '	<td>'.date('d/M/Y',$fecha).'</td>';
										echo '<td>
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
												  </td>';
										echo '	<td>';
													if ( !empty($value->logs) ) {
														echo '<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Ver</a>';
													}
										echo '	</td>';
										echo '</tr>';
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
											 '<div><strong>Status</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>Comentario</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>							
						</table>
					</article>
				</div>
				
			</section>
        <div style="clear: both"></div>
       </div>
       
      