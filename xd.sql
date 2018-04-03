select
	`ttr_control_forms`.`id` AS `id` ,
	`trnrs_all_cc`.`cedula` AS `cedula/id_punto` ,
	`userstemp`.`nombre_empleado` AS `nombre_entrenado` ,
	`userstemp`.`cargo` AS `cargo_entrenado` ,
	`userstemp`.`empresa` AS `empresa_entrenado` ,
	`userstemp`.`canal` AS `canal_entrenado` ,
	`userstemp`.`regional` AS `regional_entrenado` ,
	`userstemp`.`plaza` AS `ciudad_entrenado` ,
	`userstemp`.`linea_contacto` AS `linea_entrenado` ,
	`trnrs_forvas34_data`.`latitud` AS `latitud` ,
	`trnrs_forvas34_data`.`longitud` AS `longitud` ,
	`ttr_control_forms`.`timestamp` AS `fecha_registro` ,
	`trnrs_forvas34_data`.`fecha_actividad` AS `fecha_actividad` ,
	(
		case
		when(
			`trnrs_forvas34_data`.`canal` = 'cde'
		) then
			'TIENDAS_PROPIAS'
		when(
			`trnrs_forvas34_data`.`canal` = 'fvd'
		) then
			'FUERZA_VD'
		when(
			`trnrs_forvas34_data`.`canal` = 'retail'
		) then
			'RETAIL'
		when(
			`trnrs_forvas34_data`.`canal` = 'dealer'
		) then
			'DISTRIBUIDORES'
		when(
			`trnrs_forvas34_data`.`canal` = 'cvds'
		) then
			'CDVS'
		when(
			`trnrs_forvas34_data`.`canal` = 'pap'
		) then
			'PAP'
		when(
			`trnrs_forvas34_data`.`canal` = 'aur y contructores'
		) then
			'AUR y Constructores'
		when(
			`trnrs_forvas34_data`.`canal` = 'puntos fijos'
		) then
			'Puntos Fijos'
		when(
			`trnrs_forvas34_data`.`canal` = 'contact center'
		) then
			'Contact Center'
		else
			`trnrs_forvas34_data`.`canal`
		end
	) AS `canal` ,
	`trnrs_forvas34_data`.`codigo_punto` AS `codigo_punto` ,
	`trnrs_forvas34_data`.`tipo_entrenamiento` AS `tipo_entrenamiento` ,
	`trnrs_forvas34_data`.`temas_entrenamiento` AS `temas_entrenamiento` ,
	`trnrs_forvas34_data`.`tiempo_entrenamiento` AS `tiempo_entrenamiento` ,
	`trnrs_forvas34_data`.`observaciones` AS `observaciones` ,
	`ttr_control_structure`.`id` AS `cedula_entrenador` ,
	`ttr_control_structure`.`user_name` AS `nombre_entrenador` ,
	`ttr_control_structure`.`user_regional` AS `regional_entrenador` ,
	`ttr_control_structure`.`business_unit` AS `unidad_negocio`
from
	(
		(
			(
				(
					`trnrs_all_cc`
					join `trnrs_forvas34_data`
				)
				join `userstemp`
			)
			join `ttr_control_forms`
		)
		join `ttr_control_structure` on(
			(
				(
					`trnrs_all_cc`.`form_id` = `ttr_control_forms`.`id`
				)
				and(
					`trnrs_forvas34_data`.`form_id` = `ttr_control_forms`.`id`
				)
				and(
					`ttr_control_forms`.`form` like 'for_vas_34%'
				)
				and(
					`ttr_control_forms`.`user_id` = `ttr_control_structure`.`id`
				)
				and(
					`trnrs_all_cc`.`cedula` = `userstemp`.`cedula`
				)
			)
		)
	)
