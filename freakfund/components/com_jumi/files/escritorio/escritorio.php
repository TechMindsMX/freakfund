<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");
$usuario = JFactory::getUser();
$app 	 = JFactory::getApplication();
$doc 	 = JFactory::getDocument();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url = 'index.php?option=com_users&view=login';
	$url .= '&return=' . base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport("trama.class");
jimport("trama.jsocial");
jimport("trama.usuario_class");
jimport("trama.error_class");

$base 							= JUri::base();
$input 							= $app->input;
$errorCode				 		= $input->get("error", 0, "int");
$from							= $input->get("from", 0, "int");
$jumiurl		 				= 'index.php?option=com_jumi&view=application&fileid=';
$htmlInversionActual 			= '';
$htmlFinanActual		 		= '';
$count 							= 0;
$suma_inversion					= 0;
$suma_retorno					= 0;
$suma_tri						= 0;
$suma_fund						= 0;
$idMiddleware					= UserData::getUserMiddlewareId($usuario->id);
$datosgenerales 				= UserData::datosGr($idMiddleware->idJoomla);
$datosgenerales->userBalance 	= UserData::getUserBalance($idMiddleware->idMiddleware)->balance;
$promedio 						= UserData::scoreUser($idMiddleware->idJoomla);
$proyectos 						= JTrama::allProjects();
$objProyectos					= JTrama::getProjectbyUser($idMiddleware->idMiddleware); 
$objProductos					= JTrama::getProductbyUser($idMiddleware->idMiddleware);
var_dump($idMiddleware ,$objProyectos,$objProductos);
errorClass::manejoError($errorCode, $from);

$doc->addStyleSheet($base . 'components/com_jumi/files/escritorio/css/style.css');
$doc->addStyleSheet($base . 'components/com_jumi/files/escritorio/css/escritorio.css');

if (is_null($datosgenerales)) {
	$app->redirect('index.php', JText::_('NO_HAY_DATOS'), 'notice');
}
if ($objProyectos != '') {
	foreach($objProyectos as $key => $value){
		$htmlInversionActual .= htmlInversionActual($value, $datosgenerales);
		$suma_fund = $value->fundedAmount + $suma_fund;
	}
}
if ($objProductos != '') {
	foreach($objProductos as $key => $value){
		$htmlFinanActual .= htmlFinanActual($value, $datosgenerales);
		$suma_inversion = $value->investedAmount + $suma_inversion;
		$suma_retorno = $value->roi + $suma_retorno;
		$suma_tri = $value->tri + $suma_tri;
	}
}

function moreProData($value, $datosgenerales) {
	
	
	if ($value->type != 'REPERTORY' && $value->status != 4) {
		
		JTrama::getEditUrl($value);
		var_dump($value ,$datosgenerales);
		$value->imgAvatar = '<img src="' . AVATAR . '/' . $value->avatar . '" alt="' . $value->name . '" class="table-cartera"/>';
		$value->roi = $value->investedAmount * ($value->tri / 100);
		if ( $value->status  == 5 || $value->status == 6 ) {
			$datosgenerales->actualFundings = @$datosgenerales->actualFundings + $value->fundedAmount;
		} elseif ( $value->status == 7 ) {
			$datosgenerales->actualInvestments = @$datosgenerales->actualInvestments + $value->investedAmount;
			$datosgenerales->sumRoi = @$datosgenerales->sumRoi + $value->roi;
		}
	}
	$datosgenerales->portfolioValue = @$datosgenerales->actualFundings + @$datosgenerales->sumRoi + $datosgenerales->userBalance;
	
}
var_dump($datosgenerales);
function htmlInversionActual($value, $datosgenerales) {
	if( !is_null($value) && !is_null($datosgenerales) ) {
		moreProData($value, $datosgenerales);
		$htmlInversionActual = '<tr class="middle-td">
								<td class="td-img"><a href="' . $value->viewUrl . '" >' . $value->imgAvatar . '</a></td>
								<td class="td-titulo"><strong><a href="' . $value->viewUrl . '" >' . $value->name . '</a></strong></td>
								<td>' . $value->fundEndDate . '</td>
								<td>$<span class="number">' . $value->breakeven . '</span></td>
								<td>' . $value->porcentajeRecaudado . ' %</td>
								<td>$<span class="number">' . $value->fundedAmount . '</span></td>
									</tr>';
	} else {
		$htmlInversionActual = '<tr class="middle-td">
								<td colspan="6" align="center">Sin Inversiones</td>
								</tr>';
	}
	return $htmlInversionActual;
}

function htmlFinanActual($value, $datosgenerales){
	if( !is_null($value) && !is_null($datosgenerales) ) {
		moreProData($value, $datosgenerales);

		$htmlFinanActual = '<tr class="middle-td">
							<td class="td-img"><a href="' . $value->viewUrl . '" >' . $value->imgAvatar . '</a></td>
							<td class="td-titulo"><strong><a href="' . $value->viewUrl . '" >' . $value->name . '</a></strong></td>
							<td class="middle-td">$<span class="number">' . $value->investedAmount . '</span></td>
							<td class="middle-td">$<span class="number">' . $value->roi . '</span></td>
							<td class="middle-td">' . $value->tri . ' %</td>
							</tr>';
		
	} else {
		$htmlFinanActual = '<tr class="middle-td">
							<td colspan="5" align="center">Sin Financiamientos</td>
							</tr>';
	}
	return $htmlFinanActual;
}
?>
<div class="contenedor-cartera">
		<h1 class="mayusc"><?php echo $usuario->name ?></h1>
	
	<div class="infodiv">
		<div class="module-title">
			<h2 class="title"><?php echo JText::_('ESCRIT_CARTERA'); ?></<h2>
		</div>
		<div class="cartera-seccion-1">
			<span>
				<label class="label-cartera-inicio"><?php echo JText::_('SALDO_FF'); ?></label>
				<div class="bordesH3">
					<h3>$<span class="number"><?php echo $datosgenerales->userBalance; ?></span></h3>
				</div>
			</span>
			<span>
				<label class="label-cartera"><?php echo JText::_('ESCRIT_ACTUAL_FUNDING_TOTAL'); ?></label>
				<div class="bordesH3-centradas">
					<h3 class="cartera-h3">$
						<span class="number">
							<?php echo isset($datosgenerales->actualFundings)? $datosgenerales->actualFundings : 0; ?>
						</span>
					</h3>
				</div>
			</span>
			<span>
				<label class="label-cartera"><?php echo JText::_('ESCRIT_TOTAL_ROI'); ?></label>
				<div class="bordesH3-centradas">
					<h3 class="cartera-h3">$
						<span class="number">
							<?php echo isset($datosgenerales->sumRoi)? $datosgenerales->sumRoi: 0; ?>
						</span>
					</h3>
				</div>
			</span>
			<span>
				<label class="label-cartera upercase"><?php echo JText::_('ESCRIT_PORTFOLIO_VALUE'); ?></label>
				<div class="bordesH3-fin">
					<h3 class="cartera-h3">$
						<span class="number">
							<?php echo isset($datosgenerales->portfolioValue)? $datosgenerales->portfolioValue : 0; ?>
						</span>
					</h3>
				</div>
			</span>
		</div>
		
	
		<div class="module-title">
			<h2 class="title"><?php echo JText::_('ESCRIT_MOVIMIENTOS'); ?></h2>
		</div>
		<div class="cartera-buttons">
			<a class="button" href="<?php echo $jumiurl; ?>28"><?php echo JText::_('ESCRIT_CASHOUT'); ?></a>
			<a class="button" href="<?php echo $jumiurl; ?>32"><?php echo JText::_('ESCRIT_ABONO_PAYPAL'); ?></a>
			<a class="button" href="<?php echo $jumiurl; ?>34"><?php echo JText::_('ESCRIT_ALTA_TRASPASO'); ?></a>
			<a class="button" href="<?php echo $jumiurl; ?>29"><?php echo JText::_('ESCRIT_TRASPASO'); ?></a>
			<a class="button" href="<?php echo $jumiurl; ?>30"><?php echo JText::_('ESCRIT_ESTADO_CUENTA'); ?></a>
			<a class="button" href="<?php echo $jumiurl; ?>31"><?php echo JText::_('ESCRIT_REDIMIR'); ?></a>
		</div>
	</div>
	
	<script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
	    
	<div id="contenido" style="margin-top: 15px;">
		<section class="ac-container" style="max-width: 100%;">
		
			<div>
				<input id="ac-3a" name="accordion-2" type="radio" checked />
				<label for="ac-3a"><?php echo JText::_('ESCRIT_PROD_FINAN'); ?></label>
				<article class="ac-large">
					<table class="table table-striped cartera">
						<tr>
							<th class="th-center-cartera" colspan="2"><?php echo JText::_('ESCRIT_NOMBRE'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('ESCRIT_INVESTMENT'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('ESCRIT_ROI'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('ESCRIT_TRI'); ?></th>
						</tr>
						<?php
							echo $htmlFinanActual;
						?>	
						<tr>
							<td class="th-center-cartera" colspan="2"><?php echo JText::_('TOTAL'); ?></th>
							<td class="th-center-cartera">$<span class="number"><?php echo $suma_inversion; ?></span></th>
							<td class="th-center-cartera">$<span class="number"><?php echo $suma_retorno; ?></span></th>
							<td class="th-center-cartera"><?php echo $suma_tri; ?>%</th>
						</tr>
					</table>
				</article>
			</div>
		
		
			<div>
				<input id="ac-2a" name="accordion-2" type="radio" />
				<label for="ac-2a"><?php echo JText::_('ESCRIT_PROY_INVER'); ?></label>
				<article class="ac-medium">
					<table class="table table-striped cartera" >
						<tr>
							<th class="th-center-cartera" colspan="2"><?php echo JText::_('ESCRIT_NOMBRE'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('ESCRIT_CIERRE'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('BREAKEVEN'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('ESCRIT_PORCENTAJE'); ?></th>
							<th class="th-center-cartera"><?php echo JText::_('ESCRIT_FINANCIADO'); ?></th>
						</tr>
						<?php
							echo $htmlInversionActual;
						?>	
						<tr>
							<td style= "text-align:right" colspan="5"><?php echo JText::_('TOTAL'); ?></th>
							<td class="th-center-cartera">$<span class="number"><?php echo $suma_fund ?></span></th>
						</tr>						
					</table>
				</article>
			</div>
			
			
			
		</section>
	<div style="clear: both"></div>
	</div>
</div>
   
      