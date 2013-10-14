<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");

$count = 0;
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$base = JUri::base();
$input = $app->input;
$jumiurl = 'index.php?option=com_jumi&view=application&fileid=';
$htmlInversionActual = '';
$htmlFinanActual = '';

if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url = 'index.php?option=com_users&view=login';
	$url .= '&return=' . base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport("trama.class");
jimport("trama.jsocial"); 
require_once 'components/com_jumi/files/perfil_usuario/usuario_class.php';
$doc->addScript( 'libraries/trama/js/jquery.number.min.js' );
$doc->addStyleSheet($base . 'components/com_jumi/files/perfil_usuario/css/style.css');
$doc->addStyleSheet($base . 'components/com_jumi/files/escritorio/css/escritorio.css');

$objuserdata = new UserData;
$userid = $usuario->id;
$datosgenerales = $objuserdata::datosGr($userid);

if (is_null($datosgenerales)) {
	$app->redirect('index.php', JText::_('NO_HAY_DATOS'), 'notice');
}

$datosgenerales->userBalance = $objuserdata->getUserBalance($userid)->balance;
$promedio = $objuserdata->scoreUser($userid);

// $proyectos = JTrama::getProjectsByUser($userid);
$proyectos = JTrama::allProjects();

foreach ($proyectos as $key => $value) {
	if ($value->status == 5 || $value->status == 6) {
		$htmlInversionActual .= htmlInversionActual($value, $datosgenerales);
	} elseif ( $value->status == 7 ) {
		$htmlFinanActual .= htmlFinanActual($value, $datosgenerales);
	}
}

function moreProData($value, $datosgenerales) {
	if ($value->type != 'REPERTORY' && $value->status != 4) {
		JTrama::getEditUrl($value);
		$value->imgAvatar = '<img src="' . AVATAR . '/' . $value->projectAvatar->name . '" alt="' . $value->name . '" />';
		$value->investmentValue = 1000;
		$value->roi = $value->investmentValue * ($value->tri / 100);
		if ( $value->status  == 5 || $value->status == 6 ) {
			$datosgenerales->actualFundings = @$datosgenerales->actualFundings + $value->investmentValue;
		} elseif ( $value->status == 7 ) {
			$datosgenerales->actualInvestments = @$datosgenerales->actualInvestments + $value->investmentValue;
			$datosgenerales->sumRoi = @$datosgenerales->sumRoi + $value->roi;
		}
	}
	$datosgenerales->portfolioValue = @$datosgenerales->actualInvestments + @$datosgenerales->sumRoi + $datosgenerales->userBalance;
}

function htmlInversionActual($value, $datosgenerales) {
	moreProData($value, $datosgenerales);
	$htmlInversionActual = '<tr>
							<td><a href="' . $value->viewUrl . '" >' . $value->imgAvatar . '</a></td>
							<td><a href="' . $value->viewUrl . '" >' . $value->name . '</a></td>
							<td>' . $value->fundEndDate . '</td>
							<td><span class="number">' . $value->breakeven . '</span></td>
							<td>' . $value->porcentajeRecaudado . ' %</td>
							<td><span class="number">' . $value->investmentValue . '</span></td>
								</tr>';
	return $htmlInversionActual;
}
function htmlFinanActual($value, $datosgenerales){
	moreProData($value, $datosgenerales);
	$htmlFinanActual = '<tr>
						<td><a href="' . $value->viewUrl . '" >' . $value->imgAvatar . '</a></td>
						<td><a href="' . $value->viewUrl . '" >' . $value->name . '</a></td>
						<td><span class="number">' . $value->investmentValue . '</span></td>
						<td><span class="number">' . $value->roi . '</span></td>
						<td>' . $value->tri . ' %</td>
						</tr>';
	return $htmlFinanActual;
}

?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('span.number').number( true, 2, ',','.' );
	});
</script>
<h1 class="mayusc"><?php echo $datosgenerales->nomNombre.' '.$datosgenerales->nomApellidoPaterno.' '.$datosgenerales->nomApellidoMaterno;?></h1>

<div class="infodiv">
	<span><label><?php echo JText::_('ESCRIT_ACTUAL_FUNDINGS'); ?></label>
		<h3><span class="number"><?php echo $datosgenerales->actualFundings; ?></span></h3>
	</span>
	<br />
	<span><label><?php echo JText::_('SALDO_FF'); ?></label>
		<h3><span class="number"><?php echo $datosgenerales->userBalance; ?></span></h3>
	</span>
	<span><label><?php echo JText::_('ESCRIT_ACTUAL_INVEST'); ?></label>
		<h3><span class="number"><?php echo $datosgenerales->actualInvestments; ?></span></h3>
	</span>
	<span><label><?php echo JText::_('ESCRIT_TOTAL_ROI'); ?></label>
		<h3><span class="number"><?php echo $datosgenerales->sumRoi; ?></span></h3>
	</span>
	<span><label><?php echo JText::_('ESCRIT_PORTFOLIO_VALUE'); ?></label>
		<h3><span class="number"><?php echo $datosgenerales->portfolioValue; ?></span></h3>
	</span>
</div>

<div id="movimientos" class="rt-block box5">
	<div class="rt-inner">
	<h3><?php echo JText::_('ESCRIT_MOVIMIENTOS'); ?></h3>
	<a class="button" href="<?php echo $jumiurl; ?>28"><?php echo JText::_('ESCRIT_CASHOUT'); ?></a>
	<a class="button" href="<?php echo $jumiurl; ?>32"><?php echo JText::_('ESCRIT_ABONO_PAYPAL'); ?></a>
	<a class="button" href="<?php echo $jumiurl; ?>29"><?php echo JText::_('ESCRIT_TRASPASO'); ?></a>
	<a class="button" href="<?php echo $jumiurl; ?>30"><?php echo JText::_('ESCRIT_ESTADO_CUENTA'); ?></a>
	<a class="button" href="<?php echo $jumiurl; ?>31"><?php echo JText::_('ESCRIT_REDIMIR'); ?></a>
	</div>
</div>

<script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
    
<div id="contenido">
	<section class="ac-container" style="max-width: 100%;">
		<div>
			<input id="ac-2a" name="accordion-2" type="radio" checked />
			<label for="ac-2a"><?php echo JText::_('ESCRIT_PROY_INVER'); ?></label>
			<article class="ac-medium">
				<table class="table table-striped cartera" >
					<tr>
						<th colspan="2"><?php echo JText::_('ESCRIT_NOMBRE'); ?></th>
						<th><?php echo JText::_('ESCRIT_CIERRE'); ?></th>
						<th><?php echo JText::_('BREAKEVEN'); ?></th>
						<th><?php echo JText::_('ESCRIT_PORCENTAJE'); ?></th>
						<th><?php echo JText::_('ESCRIT_FINANCIADO'); ?></th>
					</tr>
					<?php
						echo $htmlInversionActual;
					?>							
				</table>
			</article>
		</div>
		
		<div>
			<input id="ac-3a" name="accordion-2" type="radio" />
			<label for="ac-3a"><?php echo JText::_('ESCRIT_PROD_FINAN'); ?></label>
			<article class="ac-large">
				<table class="table-striped cartera"">
					<tr>
						<th colspan="2"><?php echo JText::_('ESCRIT_NOMBRE'); ?></th>
						<th><?php echo JText::_('ESCRIT_INVESTMENT'); ?></th>
						<th><?php echo JText::_('ESCRIT_ROI'); ?></th>
						<th><?php echo JText::_('ESCRIT_TRI'); ?></th>
					</tr>
					<?php
						echo $htmlFinanActual;
					?>	
				</table>
			</article>
		</div>
		
	</section>
<div style="clear: both"></div>
</div>
   
      