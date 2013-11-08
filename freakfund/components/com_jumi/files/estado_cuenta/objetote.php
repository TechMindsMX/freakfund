<?php
$arregloobjetos = Array();


$obj = new stdClass;
$obj->date = '02-ene';
$obj->movimiento = 'abono';
$obj->tipo = 'deposito';
$obj->description = 'efectivo';
$obj->reference = '65465461';
$obj->institucion = 'hsbc';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '';
$obj->deposit = '1000.00';
$obj->currentBalance = '1000.00';
$obj->notas = '';
$arregloobjetos[0] = $obj;

$obj = new stdClass;
$obj->date = '04-ene';
$obj->movimiento = 'cargo';
$obj->tipo = 'transferencia';
$obj->description = 'donativos';
$obj->reference = '65498428524';
$obj->institucion = 'teleton';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '';
$obj->deposit = '300.00';
$obj->currentBalance = '700.00';
$obj->notas = '';
$arregloobjetos[1] = $obj;

$obj = new stdClass;
$obj->date = '5-ene';
$obj->movimiento = 'abono';
$obj->tipo = 'deposito';
$obj->description = 'transferencia bancaria';
$obj->reference = '5678687';
$obj->institucion = 'banorte';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '50.00';
$obj->deposit = '';
$obj->currentBalance = '750.00';
$obj->notas = '';
$arregloobjetos[2] = $obj;

$obj = new stdClass;
$obj->date = '10-ene';
$obj->movimiento = 'cargo';
$obj->tipo = 'inversion';
$obj->description = 'en productos';
$obj->reference = '587687';
$obj->institucion = 'fonca';
$obj->tasa = '';
$obj->cantidad = '2';
$obj->withdraw = '';
$obj->deposit = '240.00';
$obj->currentBalance = '510.00';
$obj->notas = '';
$arregloobjetos[3] = $obj;

$obj = new stdClass;
$obj->date = '16-ene';
$obj->movimiento = 'abono';
$obj->tipo = 'redencion';
$obj->description = 'promociones';
$obj->reference = '576786578';
$obj->institucion = 'casa ley';
$obj->tasa = '';
$obj->cantidad = '1';
$obj->withdraw = '';
$obj->deposit = '134.00';
$obj->currentBalance = '644.00';
$obj->notas = '';
$arregloobjetos[4] = $obj;

$obj = new stdClass;
$obj->date = '17-ene';
$obj->movimiento = 'abono';
$obj->tipo = 'deposito';
$obj->description = 'paypal';
$obj->reference = '26377683';
$obj->institucion = '';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '150.00';
$obj->deposit = '';
$obj->currentBalance = '907.00';
$obj->notas = '';
$arregloobjetos[5] = $obj;

$obj = new stdClass;
$obj->date = '19-ene';
$obj->movimiento = 'cargo';
$obj->tipo = 'retiros';
$obj->description = 'en efectivo';
$obj->reference = '6546546';
$obj->institucion = 'cajero ixe';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '450.00';
$obj->deposit = '-';
$obj->currentBalance = '594.00';
$obj->notas = '';
$arregloobjetos[6] = $obj;

$obj = new stdClass;
$obj->date = '27-ene';
$obj->movimiento = 'abono';
$obj->tipo = 'redencion';
$obj->description = 'cupones';
$obj->reference = '6576786187';
$obj->institucion = 'comerial mexicana';
$obj->tasa = '';
$obj->cantidad = '1';
$obj->withdraw = '163.00';
$obj->deposit = '';
$obj->currentBalance = '757.00';
$obj->notas = '';
$arregloobjetos[7] = $obj;

$obj = new stdClass;
$obj->date = '28-ene';
$obj->movimiento = 'abono';
$obj->tipo = 'deposito';
$obj->description = 'amazon';
$obj->reference = '6345645';
$obj->institucion = 'banorte';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '';
$obj->deposit = '150.00';
$obj->currentBalance = '907.00';
$obj->notas = '';
$arregloobjetos[8] = $obj;

$obj = new stdClass;
$obj->date = '2-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'deposito';
$obj->description = 'tdc';
$obj->reference = '786287';
$obj->institucion = 'mastercard';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '1200.00';
$obj->deposit = '';
$obj->currentBalance = '1407.00';
$obj->notas = '';
$arregloobjetos[9] = $obj;

$obj = new stdClass;
$obj->date = '2-feb';
$obj->movimiento = 'cargo';
$obj->tipo = 'retiros';
$obj->description = 'transferencia a terceros';
$obj->reference = '275345345';
$obj->institucion = 'luneta';
$obj->tasa = '';
$obj->cantidad = '4';
$obj->withdraw = '250.00';
$obj->deposit = '';
$obj->currentBalance = '407.00';
$obj->notas = '';
$arregloobjetos[10] = $obj;

$obj = new stdClass;
$obj->date = '4-feb';
$obj->movimiento = 'cargo';
$obj->tipo = 'retiros';
$obj->description = 'transferencia a terceros';
$obj->reference = '5767';
$obj->institucion = 'paypal';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '50.00';
$obj->deposit = '';
$obj->currentBalance = '357.00';
$obj->notas = '';
$arregloobjetos[11] = $obj;

$obj = new stdClass;
$obj->date = '6-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'deposito';
$obj->description = 'tdd';
$obj->reference = '57267';
$obj->institucion = 'visa';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '400.00';
$obj->deposit = '';
$obj->currentBalance = '757.00';
$obj->notas = '';
$arregloobjetos[12] = $obj;

$obj = new stdClass;
$obj->date = '8-feb';
$obj->movimiento = 'cargo';
$obj->tipo = 'retiros';
$obj->description = 'tdd';
$obj->reference = '6278';
$obj->institucion = 'visa';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '123.00';
$obj->deposit = '';
$obj->currentBalance = '634.00';
$obj->notas = '';
$arregloobjetos[13] = $obj;

$obj = new stdClass;
$obj->date = '12-feb';
$obj->movimiento = 'cargo';
$obj->tipo = 'inversion';
$obj->description = 'productos';
$obj->reference = '62857678';
$obj->institucion = 'cafe tacuva';
$obj->tasa = '';
$obj->cantidad = '1';
$obj->withdraw = '';
$obj->deposit = '150';
$obj->currentBalance = '484.00';
$obj->notas = '';
$arregloobjetos[14] = $obj;

$obj = new stdClass;
$obj->date = '14-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'redencion';
$obj->description = 'tarjetas regalo';
$obj->reference = '5276868';
$obj->institucion = 'itunes';
$obj->tasa = '';
$obj->cantidad = '1';
$obj->withdraw = '';
$obj->deposit = '200.00';
$obj->currentBalance = '684.00';
$obj->notas = '';
$arregloobjetos[15] = $obj;

$obj = new stdClass;
$obj->date = '17-feb';
$obj->movimiento = 'cargos';
$obj->tipo = 'retiros';
$obj->description = 'spei';
$obj->reference = '63546345';
$obj->institucion = 'banorte';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '';
$obj->deposit = '300.00';
$obj->currentBalance = '384.00';
$obj->notas = '';
$arregloobjetos[16] = $obj;

$obj = new stdClass;
$obj->date = '17-feb';
$obj->movimiento = 'cargos';
$obj->tipo = 'comisiones';
$obj->description = 'bancarias';
$obj->reference = '63546345';
$obj->institucion = 'banorte';
$obj->tasa = '';
$obj->cantidad = '1';
$obj->withdraw = '50.00';
$obj->deposit = '';
$obj->currentBalance = '357.00';
$obj->notas = '';
$arregloobjetos[17] = $obj;

$obj = new stdClass;
$obj->date = '17-feb';
$obj->movimiento = 'cargos';
$obj->tipo = 'impuestos';
$obj->description = 'iva';
$obj->reference = '63546345';
$obj->institucion = 'banorte';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '';
$obj->deposit = '400.00';
$obj->currentBalance = '757.00';
$obj->notas = '';
$arregloobjetos[18] = $obj;

$obj = new stdClass;
$obj->date = '20-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'reembolso';
$obj->description = 'por cancelacion';
$obj->reference = '654645';
$obj->institucion = 'fonca';
$obj->tasa = '';
$obj->cantidad = '2';
$obj->withdraw = '';
$obj->deposit = '240.00';
$obj->currentBalance = '566.00';
$obj->notas = '';
$arregloobjetos[19] = $obj;

$obj = new stdClass;
$obj->date = '22-feb';
$obj->movimiento = 'cargo';
$obj->tipo = 'transferencia';
$obj->description = 'socios terceros';
$obj->reference = '63546345';
$obj->institucion = 'grumpy cat';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '-100.00';
$obj->deposit = '';
$obj->currentBalance = '466.00';
$obj->notas = '';
$arregloobjetos[20] = $obj;

$obj = new stdClass;
$obj->date = '23-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'transferencia';
$obj->description = 'solcios terceros';
$obj->reference = '63546345';
$obj->institucion = 'grumpy cat';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '50.00';
$obj->deposit = '';
$obj->currentBalance = '516.00';
$obj->notas = '';
$arregloobjetos[21] = $obj;

$obj = new stdClass;
$obj->date = '25-feb';
$obj->movimiento = 'cargos';
$obj->tipo = 'retiros';
$obj->description = 'transferencia a tercero';
$obj->reference = '8762778';
$obj->institucion = 'amazon';
$obj->tasa = '';
$obj->cantidad = '';
$obj->withdraw = '25.00';
$obj->deposit = '';
$obj->currentBalance = '491.00';
$obj->notas = '';
$arregloobjetos[22] = $obj;

$obj = new stdClass;
$obj->date = '28-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'retorno';
$obj->description = 'de financiamientos';
$obj->reference = '63546345';
$obj->institucion = 'preferente';
$obj->tasa = '';
$obj->cantidad = '2';
$obj->withdraw = '';
$obj->deposit = '350.00';
$obj->currentBalance = '841.00';
$obj->notas = '';
$arregloobjetos[23] = $obj;

$obj = new stdClass;
$obj->date = '28-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'utilidades';
$obj->description = 'de financiamientos';
$obj->reference = '63546345';
$obj->institucion = 'preferente';
$obj->tasa = '';
$obj->cantidad = '2';
$obj->withdraw = '175.00';
$obj->deposit = '';
$obj->currentBalance = '841.00';
$obj->notas = '';
$arregloobjetos[24] = $obj;

$obj = new stdClass;
$obj->date = '28-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'financiamientos';
$obj->description = 'de financiamientos';
$obj->reference = '63546345';
$obj->institucion = 'preferente';
$obj->tasa = '';
$obj->cantidad = '2';
$obj->withdraw = '175.00';
$obj->deposit = '';
$obj->currentBalance = '841.00';
$obj->notas = '';
$arregloobjetos[25] = $obj;

$obj = new stdClass;
$obj->date = '28-feb';
$obj->movimiento = 'abono';
$obj->tipo = 'financiamientos';
$obj->description = 'de financiamientos';
$obj->reference = '63546345';
$obj->institucion = 'preferente';
$obj->tasa = '';
$obj->cantidad = '5';
$obj->withdraw = '100.00';
$obj->deposit = '';
$obj->currentBalance = '841.00';
$obj->notas = '';
$arregloobjetos[26] = $obj;



$arregloCatalogo = Array();

$catalogoTipo = new stdClass;
$catalogoTipo->id = 0;
$catalogoTipo->name = 'transferencia';
$arregloCatalogo[0] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 1;
$catalogoTipo->name = 'deposito';
$arregloCatalogo[1] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 2;
$catalogoTipo->name = 'inversion';
$arregloCatalogo[2] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 3;
$catalogoTipo->name = 'retorno';
$arregloCatalogo[3] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 4;
$catalogoTipo->name = 'retiros';
$arregloCatalogo[4] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 5;
$catalogoTipo->name = 'impuestos';
$arregloCatalogo[5] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 6;
$catalogoTipo->name = 'reembolso';
$arregloCatalogo[6] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 7;
$catalogoTipo->name = 'Retiro';
$arregloCatalogo[7] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 8;
$catalogoTipo->name = 'utilidades';
$arregloCatalogo[8] = $catalogoTipo;

$catalogoTipo = new stdClass;
$catalogoTipo->id = 9;
$catalogoTipo->name = 'financiamientos';
$arregloCatalogo[9] = $catalogoTipo;

$sumaUtilidad=0;

foreach ($arregloobjetos as $key => $value){
	if ($value->tipo == 'utilidades'){
	$sumaUtilidad= $value->deposit + $sumaUtilidad;
	}
}

$sumaFinanciamientos=0;

foreach ($arregloobjetos as $key => $value){
	if ($value->tipo == 'financiamientos'){
		$sumaFinanciamientos= $value->deposit + $sumaFinanciamientos;
	}
}

$sumaInversiones=0;

foreach ($arregloobjetos as $key => $value){
	if ($value->tipo == 'inversion'){
		$sumaInversiones= $value->deposit + $sumaInversiones;
	}
}

$sumaRetornos=0;

foreach ($arregloobjetos as $key => $value){
	if ($value->tipo == 'retorno'){
		$sumaRetornos= $value->deposit + $sumaRetornos;
	}
}

$valorCartera= $sumaFinanciamientos + $sumaInversiones;


?>