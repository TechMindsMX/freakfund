<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
jimport('trama.class');

$token = JTrama::token();
$adminId = JFactory::getUser();
$proyeto = $this->items;
$urls = new JTrama;
$urls1 = $urls->getEditUrl($proyeto);

if( !isset($proyeto->projectBusinessCase->name) ) {
	$bussinesCase = '';
} else {
	$bussinesCase = '<div style="margin-bottom:10px">
		<a href="'.MIDDLE.BCASE.'/'.$proyeto->projectBusinessCase->name.'.xlsx" target="blank">
			Business Case
		</a>
	</div>';
}

?>
<input type="hidden" name="task" value="" />
<input type="hidden" name="token" value="<?php echo $token;?>" />
<tr class="row">
	<td width="100%" valign="top">
		<div style="padding-right: 20px;">
			<div style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px;">
				<?php echo $proyeto->name; ?>
			</div>
			<div style="margin-bottom:10px; color:#FF0000;">
				<?php echo JTrama::tipoProyProd($proyeto).' - '.$urls::getStatusName($proyeto->status); ?>			
			</div>
			
			<?php echo $bussinesCase; ?>			
			
			<div>
				<p>Descripcion del proyecto</p>
				<p align="justify"><?php echo $proyeto->description; ?></p>
			</div>
			
			<div style="margin-bottom: 10px;">
				<a href="../<?php echo $urls1->viewUrl; ?>" target="blank">Ver mas</a>
			</div>
			
			<div>
				<h4 align="center">Cambiar Estatus</h4>
				<input type="hidden" name="userId" value="<?php echo $adminId->id; ?>" />
				<input type="hidden" name="projectId" value="<?php echo $proyeto->id; ?>" />
				<div>
					<input type="radio" name="status" value="1" <?php echo $proyeto->status == 1?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(1); ?>
				</div>
				
				<div>
					<input type="radio" name="status" value="2" <?php echo $proyeto->status == 2?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(2); ?>
				</div>
				
				<div>
					<input type="radio" name="status" value="5" <?php echo $proyeto->status == 5?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(5); ?>
				</div>
				
				<div style="margin-bottom: 10px;">
					<input type="radio" name="status" value="4" <?php echo $proyeto->status == 4?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(4); ?>
				</div>		
				
				<div>
					Comentarios<br />
					<textarea name="comment" rows="15" cols="100"></textarea>
				</div>
				
				<div style="margin-top:10px;">
					<input type="button" value="Cancelar" onclick="javascript:window.history.back()">
					<input type="submit" value="Enviar" />
				</div>
			</div>
			
			<?php
			if( !empty($proyeto->logs) ) {
			?>
			<div>
				<h4 align="center">Bitacora de Cambios</h4>
				<ul>
					<?php
					foreach ($proyeto->logs as $key => $value) {
						$fechacreacion = $value->timestamp/1000;
						echo '<div style="margin-bottom: 10px;">'.
							 '<li>'.
							 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
							 '<div><strong>Status</strong>: '.JTrama::getStatusName($value->status).'</div>'.
							 '<div align="justify"><strong>Comentario</strong>: '.$value->comment.'</div>'.
							 '</li>'.
							 '</div>';
					}
					?>
				</ul>
			</div>
			<?php
			}
			?>
		</div>
	</td>
</tr>