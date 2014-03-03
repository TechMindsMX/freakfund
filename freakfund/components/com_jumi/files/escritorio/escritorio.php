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
$objProyectos					= JTrama::getProjectORProductParnetship($idMiddleware->idMiddleware, 'project'); 
$objProductos					= JTrama::getProjectORProductParnetship($idMiddleware->idMiddleware, 'product');
$datosgenerales->sumRoi			= 0;
$datosgenerales->portfolioValue	= 0;

$doc->addStyleSheet($base . 'components/com_jumi/files/escritorio/css/style.css');
$doc->addStyleSheet($base . 'components/com_jumi/files/escritorio/css/escritorio.css');

errorClass::manejoError($errorCode,$from);

if (is_null($datosgenerales)) {
	$app->redirect('index.php', JText::_('NO_HAY_DATOS'), 'notice');
}

if (!empty($objProyectos)) {
	foreach($objProyectos as $key => $value){
		$htmlFinanActual .= htmlFinanActual($value, $datosgenerales);
		$suma_fund = $value->fundedAmount + $suma_fund;
	}
} else {
		$htmlFinanActual = '<div class="clase-tr" >
							<div class="clase-td" >'.JText::_('SIN_FINAN').'</div>
							</div>';
}
if (!empty($objProductos)) {
	foreach($objProductos as $key => $value){
		$htmlInversionActual .= htmlInversionActual($value, $datosgenerales);
		$suma_inversion 	 = $value->fundedAmount+$value->investedAmount + $suma_inversion;

		if($suma_inversion != 0){
			$suma_tri2 = ($datosgenerales->sumRoi * 100)/ $suma_inversion;
		}else{
			$suma_tri2 = 0;
		}
		
		$suma_tri = round($suma_tri2 , 2);
	}
} else {
		$htmlInversionActual = '<div class="clase-tr" class="middle-td">
								<div class="clase-td" colspan="6" align="center">'.JText::_('SIN_INVER').'</div>
								</div>';
}

function moreProData($value, $datosgenerales) {
	JTrama::getEditUrl($value);
	$value->imgAvatar = '<img src="' . AVATAR . '/' . $value->avatar . '" alt="' . $value->name . '" class="table-cartera"/>';	
	
	if ($value->type != 'REPERTORY' && $value->status != 4 && $value->status != 5) {
		if ( !is_null($value->fundedAmount) ) {
			$value->rof = $value->fundedAmount * $value->trf;
			$datosgenerales->actualFundings = @$datosgenerales->actualFundings + $value->fundedAmount;
			$datosgenerales->sumRoi = @$datosgenerales->sumRoi + $value->rof;
		} 
		
		if ( !is_null($value->investedAmount) ) {
			$value->roi = $value->investedAmount * $value->tri;
			$datosgenerales->actualInvestments = @$datosgenerales->actualInvestments + $value->investedAmount;
			$datosgenerales->sumRoi = @$datosgenerales->sumRoi + $value->roi;
		}
	}elseif( $value->status == 5){
		$datosgenerales->sumInFunding = @$datosgenerales->sumInFunding + $value->fundedAmount;
	}
	
	$datosgenerales->portfolioValue = @$datosgenerales->sumInFunding + @$datosgenerales->sumRoi + $datosgenerales->userBalance;
}
function htmlInversionActual($value, $datosgenerales) {
	
	if( !is_null($value) && !is_null($datosgenerales) ) {
		moreProData($value, $datosgenerales);
		$financiado 		= '';
		$trf				= '';
		$montoFinanciado 	= '';
		$inversion			= '';
		$montoInversion		= '';
		$tri				= '';

		if($value->fundedAmount != 0){
			$financiado 		= '<div>
						  				Financiado: $<span class="number">' . $value->fundedAmount . '</span>
						  		   </div>';
			$montoFinanciado 	= '<div>
						  				$<span class="number">' . $value->fundedAmount*$value->trf . '</span>
						  		   </div>';
			$trf 				= '<div>'.$value->trfFormateado.'%</div>';
		}
		
		if($value->investedAmount != 0){
			$inversion 			= '<div>Invertido: $<span class="number">' . $value->investedAmount . '</span></div>';
			
			$montoInversion 	= '<div>$<span class="number">' . $value->roi . '</span></div>';
			
			$tri 				= '<div>' . $value->triFormateado . ' %</div>';
		}
		
		$htmlInversionActual = '<div class="clase-tr" >
							<div class="clase-td" >
								<div class="td-avatar"><a href="' . $value->viewUrl . '" >' . $value->imgAvatar . '</a>
								</div>
								<strong><a href="' . $value->viewUrl . '" >' . $value->name . '</a></strong>
							</div>
							<div class="clase-td" >'.
								$financiado.
								$inversion.
							'</div>
							<div class="clase-td" >'.
								'<span class="foca-magica">Montos de Retorno:</span>'.$montoFinanciado.
								$montoInversion.
							'</div>
							<div class="clase-td" >'.
								'<span class="foca-magica">Tasas de Retorno:</span>'.$trf.
								$tri.
							'</div>
							<div class="clearfix">
									</div>
							</div>';
	}
	return $htmlInversionActual;
}

function htmlFinanActual($value, $datosgenerales){
	if( !is_null($value) && !is_null($datosgenerales) ) {
		moreProData($value, $datosgenerales);

		$htmlFinanActual = '<div class="clase-tr" >
								<div class="clase-td" >
									<div class="td-avatar"><a href="' . $value->viewUrl . '" >' . $value->imgAvatar . '</a>
									</div>
									<strong><a href="' . $value->viewUrl . '" >' . $value->name . '</a></strong>
								</div>
								<div id="fecha-mini" class="clase-td"><span class="foca-magica">Cierre:</span>' . $value->fundEndDate . '</div>
								<div class="clase-td" ><span class="foca-magica">Punto equilibrio:</span>$<span class="number">' . $value->breakeven . '</span></div>
								<div class="clase-td"><span class="foca-magica">Porcentaje recaudado:</span>' . $value->porcentajeRecaudado . ' %</div>
								<div class="clase-td"><span class="foca-magica">Monto Financiado:</span>$<span class="number">' . $value->fundedAmount . '</span></div>
								<div class="clearfix"></div>
							</div>';
		
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
				<div class="bordesH3">
					<h3 class="cartera-h3">$
						<span class="number">
							<?php echo isset($datosgenerales->sumInFunding)? $datosgenerales->sumInFunding : 0; ?>
						</span>
					</h3>
				</div>
			</span>
			<span>
				<label class="label-cartera"><?php echo JText::_('ESCRIT_TOTAL_ROI'); ?></label>
				<div class="bordesH3">
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
		<div id="cartera-buttons" class="cartera-buttons">
			<a class="button" href="<?php echo $jumiurl; ?>37"><?php echo JText::_('ESCRIT_CASHOUT'); ?></a>
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
					<div id="productos-tabla" class="clase-tabla">
						<div class="clase-tr">
							<div class="clase-th" ><?php echo JText::_('ESCRIT_NOMBRE'); ?></div>
							<div class="clase-th" ><?php echo JText::_('ESCRIT_INVESTMENT'); ?></div>
							<div class="clase-th" ><?php echo JText::_('ESCRIT_ROI'); ?></div>
							<div class="clase-th" ><?php echo JText::_('ESCRIT_TRI'); ?></div>
						</div>
						<?php
							echo $htmlInversionActual;
						?>	
						<div class="clase-tr">
							<div class="clase-td" ><?php echo JText::_('TOTAL'); ?></div>
							<div class="clase-td" ><span class="foca-magica">Inversión realizada:</span>$</span><span class="number"><?php echo $suma_inversion; ?></span></div>
							<div class="clase-td" ><span class="foca-magica">Montos de Retorno:</span>$<span class="number"><?php echo $datosgenerales->sumRoi; ?></span></div>
							<div class="clase-td" ><span class="foca-magica">Tasas de Retorno:</span>   <?php echo $suma_tri; ?>%</div>
						</div>
					</div>
				</article>
			</div>
		
			<div>
				<input id="ac-2a" name="accordion-2" type="radio" />
				<label for="ac-2a"><?php echo JText::_('ESCRIT_PROY_INVER'); ?></label>
				<article class="ac-medium">
					<div id="proyectos-tabla" class="clase-tabla">
						<div class="clase-tr">
							<div class="clase-th" colspan="2"><?php echo JText::_('ESCRIT_NOMBRE'); ?></div>
							<div id="fecha-mini" class="clase-th" ><?php echo JText::_('ESCRIT_CIERRE'); ?></div>
							<div class="clase-th" ><?php echo JText::_('BREAKEVEN'); ?></div>
							<div class="clase-th" ><?php echo JText::_('ESCRIT_PORCENTAJE'); ?></div>
							<div class="clase-th" ><?php echo JText::_('ESCRIT_FINANCIADO'); ?></div>
						</div>
						<?php
							echo $htmlFinanActual;
						?>	
						<div class="clase-tr">
							<div class="clase-td magica2" ></div>
							<div class="clase-td" ></div>
							<div class="clase-td" ></div>
							<div class="clase-td" ><?php echo JText::_('TOTAL'); ?></div>
							<div class="clase-td" >$<span class="number"><?php echo $suma_fund ?></span></div>
						</div>						
					</div>
				</article>
			</div>
			
		</section>
	<div style="clear: both"></div>
	</div>
</div>
   
      