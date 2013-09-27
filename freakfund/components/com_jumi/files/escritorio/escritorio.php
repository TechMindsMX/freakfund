<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");

$count = 0;
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$base = JUri::base();
$input = $app -> input;
$jumiurl = 'index.php?option=com_jumi&view=application&fileid=';

if ($usuario -> guest == 1) {
	$return = JURI::getInstance() -> toString();
	$url = 'index.php?option=com_users&view=login';
	$url .= '&return=' . base64_encode($return);
	$app -> redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport("trama.class");
jimport("trama.jsocial");
require_once 'components/com_jumi/files/perfil_usuario/usuario_class.php';

$userid = $input -> get("userid", 0, "int");

$userid = ($userid == 0) ? $usuario -> id : $userid;

$doc -> addStyleSheet($base . 'components/com_jumi/files/perfil_usuario/css/style.css');
$doc -> addStyleSheet($base . 'components/com_jumi/files/escritorio/css/escritorio.css');

$objuserdata = new UserData;
$datosgenerales = $objuserdata::datosGr($userid);

if (is_null($datosgenerales)) {
	$app -> redirect('index.php', 'No hay datos de usuario', 'notice');
}

$datosgenerales -> userBalance = $objuserdata->getUserBalance($userid)->balance;

$promedio = $objuserdata -> scoreUser($userid);

// $proyectos = JTrama::getProjectsByUser($userid);
$proyectos = JTrama::allProjects();
foreach ($proyectos as $key => $value) {
	if ( ($value -> type != 'REPERTORY' && $value -> status != 4)) {
		$value = JTrama::getEditUrl($value);
		$value -> imgAvatar = '<img src="' . AVATAR . '/' . $value -> projectAvatar -> name . '" alt="' . $value -> name . '" />';
		$value -> investmentValue = 1000;
		$value -> roi = $value -> investmentValue * ($value -> tri / 100);
		if ( $value->type == 'PRODUCT' ) {
			$datosgenerales->actualInvestments = @$datosgenerales->actualInvestments + $value->investmentValue;
		} elseif ( $value->type == 'PROJECT' ) {
			$datosgenerales->actualFundings = @$datosgenerales->actualFundings + $value->investmentValue;
		}
	}
}
$datosgenerales->portfolioValue = $datosgenerales->actualInvestments + $datosgenerales->actualFundings + $datosgenerales->userBalance;

?>

<h1 class=""><?php echo $datosgenerales->nomNombre.' '.$datosgenerales->nomApellidoPaterno.' '.$datosgenerales->nomApellidoMaterno;?></h1>

<div>
	<span><label><?php echo JText::_('SALDO_FF'); ?></label><h3><?php echo $datosgenerales->userBalance; ?></h3></span>
	<span><label><?php echo JText::_('ESCRIT_ACTUAL_INVEST'); ?></label><h3><?php echo $datosgenerales->actualInvestments; ?></h3></span>
	<span><label><?php echo JText::_('ESCRIT_ACTUAL_FUNDINGS'); ?></label><h3><?php echo $datosgenerales->actualFundings; ?></h3></span>
	<span><label><?php echo JText::_('ESCRIT_PORTFOLIO_VALUE'); ?></label><h3><?php echo $datosgenerales->portfolioValue; ?></h3></span>
</div>

<a class="button" href="<?php echo $jumiurl; ?>28"><?php echo JText::_('ESCRIT_CASHOUT'); ?></a>
<a class="button" href="<?php echo $jumiurl; ?>29"><?php echo JText::_('ESCRIT_TRASPASO'); ?></a>
<a class="button" href="<?php echo $jumiurl; ?>31"><?php echo JText::_('ESCRIT_ESTADO_CUENTA'); ?></a>
<a class="button" href="<?php echo $jumiurl; ?>32"><?php echo JText::_('ESCRIT_REDIMIR'); ?></a>
<script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
    
<div id="contenido">
	<section class="ac-container" style="max-width: 100%;">
		<div>
			<input id="ac-2a" name="accordion-2" type="radio" />
			<label for="ac-2a"><?php echo JText::_('ESCRIT_PROY_INVER'); ?></label>
			<article class="ac-medium">
				<table class="cartera" width="100%" frame="box" rules="all" style="text-align: center">
					<tr>
						<th><?php echo JText::_('ESCRIT_NOMBRE'); ?></th>
						<th><?php echo JText::_('ESCRIT_CIERRE'); ?></th>
						<th><?php echo JText::_('BREAKEVEN'); ?></th>
						<th><?php echo JText::_('ESCRIT_PORCENTAJE'); ?></th>
						<th><?php echo JText::_('ESCRIT_FINANCIADO'); ?></th>
					</tr>
					<?php
					foreach ($proyectos as $key => $value) {
						if ($value -> type == 'PROJECT' && $value -> status != 4) {
							echo '<tr><td>
								<span>' . $value -> imgAvatar . '</span>
								<a href="' . $value -> viewUrl . '" >' . $value -> name . '</a>
								</td>' . '<td>' . $value -> fundEndDate . '</td>
								<td>' . $value -> breakeven . '</td>
								<td>' . $value -> porcentajeRecaudado . '</td>
								<td>' . $value -> investmentValue . '</td>
								</tr>';
						}
					}
					?>							
				</table>
			</article>
		</div>
		
		<div>
			<input id="ac-3a" name="accordion-2" type="radio" />
			<label for="ac-3a"><?php echo JText::_('ESCRIT_PROD_FINAN'); ?></label>
			<article class="ac-large">
				<table class="cartera" width="100%" frame="box" rules="all" style="text-align: center;">
					<tr>
						<th><?php echo JText::_('ESCRIT_NOMBRE'); ?></th>
						<th><?php echo JText::_('ESCRIT_INVESTMENT'); ?></th>
						<th><?php echo JText::_('ESCRIT_ROI'); ?></th>
						<th><?php echo JText::_('ESCRIT_TRI'); ?></th>
					</tr>
					<?php
					foreach ($proyectos as $key => $value) {
						if ($value -> type == 'PRODUCT' && $value -> status != 4) {

							echo '<tr>
								<td>
								<span>' . $value -> imgAvatar . '</span>
								<a href="' . $value -> viewUrl . '" >' . $value -> name . '</a>
								</td>
								<td>' . $value -> investmentValue . '</td>
								<td>' . $value -> roi . '</td>
								<td>' . $value -> tri . ' %</td>
								</tr>';
						}
					}
					?>	
				</table>
			</article>
		</div>
		
	</section>
<div style="clear: both"></div>
</div>
   
      