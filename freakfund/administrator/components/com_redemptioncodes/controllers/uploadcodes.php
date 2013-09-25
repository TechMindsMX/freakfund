<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.controlleradmin');

class RedemptioncodesControllerUploadcodes extends JControllerAdmin 
{
	
	public function fileupload()
	{
				$campos = 2; // Cantidad de campos permitidos en el csv
		$path = JPATH_ROOT.'/images/redemptcodes/';
		$input = JFactory::getApplication()->input;
		$proid = $input->get('projectid', 'INT');
		$csv = array();
		
		// check there are no errors
		if($_FILES['csv']['error'] == 0){
		    $name = $_FILES['csv']['name'];
		    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
		    $type = $_FILES['csv']['type'];
		    $tmpName = $_FILES['csv']['tmp_name'];
		
		    // check the file is a csv
		    if($ext === 'csv'){
		        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
		            // necessary if a large csv file
		            set_time_limit(0);
		
		            $row = 0;
		
		            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
						// number of fields in the csv
						$num = count($data);
						if ($num === $campos) {
			                // get the values from the csv
			                $csv[$row]['projectid'] = $data[0];
			                $csv[$row]['redemptioncode'] = $data[1];
			
			                // inc the row
			                $row++;
						}else {
							$errores = 'Archivo invalido';
						}
		            }
					if(!isset($errores)) {
						move_uploaded_file($_FILES['csv']['tmp_name'],
					     $path . $proid.'.csv');
					    echo "Stored in: " . $path . $_FILES['csv']['name'];
					}
				fclose($handle);
				var_dump($name, $csv);
			}
		} else
				echo 'Extensión incorrecta';
		}
	}

	function savecsv($cachable = false, $urlparams = false) 
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'savecsv'));
				
		// call parent behavior
        parent::savecsv($cachable);
	}

}

?>