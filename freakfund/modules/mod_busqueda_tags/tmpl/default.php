<?php
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();

$doc -> addScript('templates/rt_hexeris/js/jquery-1.9.1.js');
$doc -> addScript('modules/mod_busqueda_tags/js/lib.js');
$doc -> addScript('components/com_jumi/files/perfil/js/jquery.validationEngine.js');
$doc -> addScript('components/com_jumi/files/perfil/js/jquery.validationEngine-es.js');
$doc -> addStyleSheet('components/com_jumi/files/perfil/css/validationEngine.jquery.css');
$doc -> addStyleSheet('modules/mod_busqueda_tags/css/modulos_busqueda_modal.css');

?>

<script>
    
	jQuery(document).ready(function() {

		jQuery("#busqueda_tags").validationEngine();

		jQuery('#tags').inputlimiter({
			limit : 1,
			limitBy : 'words',
			remText : '',
			limitText : '<?php echo JText::_('MOD_BUSQUEDA_TAGS_CAMPO_LIMITADO'); ?> %n <?php echo JText::_('MOD_BUSQUEDA_TAGS_PALABRA'); ?>.'
		});

		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
			// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
	}); 
</script>

<form class="form-container" action="<?php echo $url; ?>" id="busqueda_tags" name="busqueda_tags" method="post">

	<span class="busqueda_tag"><?php echo JText::_('BUSQUEDA_TAG'); ?></span><input type="text" name="tags" id="tags" size="30" class="search-field validate[required] minSize[3]" />
	<div class="submit-container">
	<input type="submit" id="busqueda_tags" value="" class="submit" />
	</div>
</form>

