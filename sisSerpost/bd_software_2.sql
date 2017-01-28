--
-- Base de datos: `bd_software_2`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarNuevaEncomiendaEnvio` (IN `Videnvio_encomienda` INT, IN `Vidpersona` INT, IN `Vtipo_comprobante` VARCHAR(1), IN `Vfecha` DATETIME, IN `Vigv` DECIMAL(4,2))  BEGIN
	DECLARE 
    Vcorrelativo INT(7);
    
    DECLARE
    Vserie INT(4);
	DECLARE
    auxMayCorr INT(7);
    
    SET auxMayCorr=(SELECT MAX(correlativo) FROM envio_encomienda);
	SET Vserie=(SELECT MAX(serie) FROM envio_encomienda);
    
    IF auxMayCorr = 9999999  THEN
       SET Vserie=Vserie + 1;
       SET Vcorrelativo=1;
	ELSE
       SET Vcorrelativo=auxMayCorr + 1;
	END IF;

   INSERT INTO envio_encomienda
   VALUES(Videnvio_encomienda,Vidpersona,Vtipo_comprobante,Vfecha,Vserie,Vcorrelativo,Vigv);
   SELECT CONCAT(LPAD(Vserie, 4, '0'), '-', LPAD(Vcorrelativo, 7, '0')) serial;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `idciudad` int(11) NOT NULL,
  `iddistrito` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`iddepartamento`, `nombre`) VALUES
(12, 'Lima'),
(13, 'Trujillo'),
(15, 'Tocache'),
(16, 'Arequipa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_entrega`
--

CREATE TABLE `departamento_entrega` (
  `iddepartamento_entrega` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento_entrega`
--

INSERT INTO `departamento_entrega` (`iddepartamento_entrega`, `origen`, `destino`) VALUES
(13, 13, 12),
(14, 12, 13),
(16, 15, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_envio_encomienda`
--

CREATE TABLE `detalle_envio_encomienda` (
  `iddetalle` int(11) NOT NULL,
  `idenvio_encomienda` int(11) NOT NULL,
  `idsub_tipo_correspondencia` int(11) NOT NULL,
  `consignado` varchar(45) NOT NULL,
  `idzona` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `total` double NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_envio_encomienda`
--

INSERT INTO `detalle_envio_encomienda` (`iddetalle`, `idenvio_encomienda`, `idsub_tipo_correspondencia`, `consignado`, `idzona`, `cantidad`, `descripcion`, `total`, `estado`) VALUES
(20, 20, 11, 'Manuel Riva Aguero', 14, 2, 'paquete', 20, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_liquidacion`
--

CREATE TABLE `detalle_liquidacion` (
  `iddetalle_liquidacion` int(11) NOT NULL,
  `cantidad_correspondencia_ord` int(11) NOT NULL,
  `cantidad_correspondecia_cert` int(11) NOT NULL,
  `importe` int(11) NOT NULL,
  `idliquidacion_movilidad` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_valija`
--

CREATE TABLE `detalle_valija` (
  `iddetalle_valija` int(11) UNSIGNED ZEROFILL NOT NULL,
  `idvalija` int(11) NOT NULL,
  `idenvio_encomienda` int(11) NOT NULL,
  `iddepartamento_entrega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `iddistrito` int(11) NOT NULL,
  `idprovincia` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_encomienda`
--

CREATE TABLE `envio_encomienda` (
  `idenvio_encomienda` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `tipo_comprobante` varchar(1) NOT NULL,
  `fecha` datetime NOT NULL,
  `serie` int(4) DEFAULT NULL,
  `correlativo` int(7) DEFAULT NULL,
  `numero_boleta` int(7) DEFAULT NULL,
  `igv` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `envio_encomienda`
--

INSERT INTO `envio_encomienda` (`idenvio_encomienda`, `idpersona`, `tipo_comprobante`, `fecha`, `serie`, `correlativo`, `numero_boleta`, `igv`) VALUES
(20, 7, 'F', '2017-01-03 07:18:30', 1, 1, NULL, '18.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion_movilidad`
--

CREATE TABLE `liquidacion_movilidad` (
  `idliquidacion_movilidad` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8 NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apell_paterno` varchar(20) NOT NULL,
  `apell_materno` varchar(20) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `inicio_contrato` date DEFAULT NULL,
  `fin_contrato` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo`, `nombre`, `apell_paterno`, `apell_materno`, `tipo_documento`, `numero_documento`, `direccion`, `telefono`, `inicio_contrato`, `fin_contrato`) VALUES
(7, 'Cliente', 'Abel Saul ', 'Miraval ', 'Gomez', 'DNI', '70246665', 'Jr: Pucallpa 547', '9843874883', NULL, NULL),
(9, 'Cliente', 'Abe', 'Gonzales', 'Prada', 'DNI', '4832904', 'Jr: Callao', '890038203', NULL, NULL),
(10, 'Trabajador', 'Juan', 'Matos', 'Dominguezz', 'DNI', '432423423', 'Jr: Pucallpa', '948382843', '2017-01-02', '2017-01-31'),
(11, 'Trabajador', 'Abel ', 'Gomez', 'Matos', 'DNI', '4938409', 'Jr: Pucallpa', '98437388', '2017-01-02', '2017-01-31'),
(12, 'Trabajador', 'Ronal', 'Martinez', 'Cruzado', 'DNI', '49234032', 'Jr: Callao', '93940203932', '2017-01-12', '2017-01-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peso`
--

CREATE TABLE `peso` (
  `idpeso` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `minimo` varchar(7) NOT NULL,
  `maximo` varchar(7) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `peso`
--

INSERT INTO `peso` (`idpeso`, `nombre`, `minimo`, `maximo`, `fecha`, `estado`) VALUES
(7, 'Peso 1', '0  grs', '20 grs', '2017-01-24 07:42:16', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `idprovincia` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_tipo_correspondencia`
--

CREATE TABLE `sub_tipo_correspondencia` (
  `idsub_tipo_correspondencia` int(11) NOT NULL,
  `idtipo_correspondencia` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sub_tipo_correspondencia`
--

INSERT INTO `sub_tipo_correspondencia` (`idsub_tipo_correspondencia`, `idtipo_correspondencia`, `nombre`, `descripcion`) VALUES
(11, 3, 'Diplomas', 'lore'),
(12, 4, 'Domiciliarias', 'lorem');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_correspondencia`
--

CREATE TABLE `tipo_correspondencia` (
  `idtipo_correspondencia` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_correspondencia`
--

INSERT INTO `tipo_correspondencia` (`idtipo_correspondencia`, `nombre`, `descripcion`) VALUES
(3, 'Ordinarias', 'lorem'),
(4, 'Certificada', 'lorem');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

CREATE TABLE `tipo_usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `tipo_usuario`) VALUES
(1, 'Abel Saul Miraval Gomez', 'abel@unas.edu.pe', 'saul123', 'fmsdlafañ32u92ñasfjafmadsfa', '2017-01-09 05:00:00', '2017-01-17 05:00:00', 1),
(4, 'Abel Saul Miraval Gomez', 'abel.miraval@unas.edu.pe', '$2y$10$VTevMrqjyb812SYt4w3RUOhxmb15rjoBIBvjS0zZVYYTSFVcjl0Ge', NULL, '2017-01-24 11:30:43', '2017-01-24 11:30:43', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valija`
--

CREATE TABLE `valija` (
  `idvalija` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `valija`
--

INSERT INTO `valija` (`idvalija`, `descripcion`) VALUES
(3, 'valija de color azul');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `idzona` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `iddepartamento_entrega` int(11) NOT NULL,
  `idpeso` int(11) NOT NULL,
  `tarifa` double NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`idzona`, `nombre`, `descripcion`, `iddepartamento_entrega`, `idpeso`, `tarifa`, `fecha`, `estado`) VALUES
(14, 'Zona 1', 'Zona en misma ciudad', 13, 7, 10, '2017-01-24 07:42:47', '1'),
(15, 'Zona 1', 'Zona en la ciudad', 16, 7, 15, '2017-01-24 07:44:05', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`idciudad`),
  ADD KEY `fk_ciudad_distrito1_idx` (`iddistrito`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`iddepartamento`);

--
-- Indices de la tabla `departamento_entrega`
--
ALTER TABLE `departamento_entrega`
  ADD PRIMARY KEY (`iddepartamento_entrega`),
  ADD KEY `fk_departamento_entrega_departamento1_idx` (`origen`),
  ADD KEY `fk_departamento_entrega_departamento2_idx` (`destino`);

--
-- Indices de la tabla `detalle_envio_encomienda`
--
ALTER TABLE `detalle_envio_encomienda`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `fk_detalle_encomienda_zona1_idx` (`idzona`),
  ADD KEY `fk_detalle_encomienda_factura1_idx` (`idenvio_encomienda`),
  ADD KEY `fk_detalle_envio_encomienda_sub_tipo_correspondencia1_idx` (`idsub_tipo_correspondencia`);

--
-- Indices de la tabla `detalle_liquidacion`
--
ALTER TABLE `detalle_liquidacion`
  ADD PRIMARY KEY (`iddetalle_liquidacion`),
  ADD KEY `fk_detalle_liquidacion_liquidacion_movilidad1_idx` (`idliquidacion_movilidad`);

--
-- Indices de la tabla `detalle_valija`
--
ALTER TABLE `detalle_valija`
  ADD PRIMARY KEY (`iddetalle_valija`),
  ADD KEY `fk_documento_valija_valija1_idx` (`idvalija`),
  ADD KEY `fk_documento_valija_ciudad_entrega1_idx` (`iddepartamento_entrega`),
  ADD KEY `fk_detalle_valija_envio_encomienda1_idx` (`idenvio_encomienda`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`iddistrito`),
  ADD KEY `fk_distrito_provincia1_idx` (`idprovincia`);

--
-- Indices de la tabla `envio_encomienda`
--
ALTER TABLE `envio_encomienda`
  ADD PRIMARY KEY (`idenvio_encomienda`),
  ADD KEY `fk_factura_cliente1_idx` (`idpersona`);

--
-- Indices de la tabla `liquidacion_movilidad`
--
ALTER TABLE `liquidacion_movilidad`
  ADD PRIMARY KEY (`idliquidacion_movilidad`),
  ADD KEY `fk_liquidacion_movilidad_persona1_idx` (`idpersona`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`),
  ADD UNIQUE KEY `apell_paterno_UNIQUE` (`apell_paterno`);

--
-- Indices de la tabla `peso`
--
ALTER TABLE `peso`
  ADD PRIMARY KEY (`idpeso`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`idprovincia`),
  ADD KEY `fk_provincia_departamento1_idx` (`iddepartamento`);

--
-- Indices de la tabla `sub_tipo_correspondencia`
--
ALTER TABLE `sub_tipo_correspondencia`
  ADD PRIMARY KEY (`idsub_tipo_correspondencia`),
  ADD KEY `fk_tipo_correspondecia2_idx` (`idtipo_correspondencia`);

--
-- Indices de la tabla `tipo_correspondencia`
--
ALTER TABLE `tipo_correspondencia`
  ADD PRIMARY KEY (`idtipo_correspondencia`);

--
-- Indices de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `valija`
--
ALTER TABLE `valija`
  ADD PRIMARY KEY (`idvalija`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`idzona`),
  ADD KEY `fk_capacidad_idx` (`idpeso`),
  ADD KEY `fk_capacidad_ciudad_zona_ciudad_entrega1_idx` (`iddepartamento_entrega`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `idciudad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `iddepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `departamento_entrega`
--
ALTER TABLE `departamento_entrega`
  MODIFY `iddepartamento_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `detalle_envio_encomienda`
--
ALTER TABLE `detalle_envio_encomienda`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `detalle_liquidacion`
--
ALTER TABLE `detalle_liquidacion`
  MODIFY `iddetalle_liquidacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_valija`
--
ALTER TABLE `detalle_valija`
  MODIFY `iddetalle_valija` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `distrito`
--
ALTER TABLE `distrito`
  MODIFY `iddistrito` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `envio_encomienda`
--
ALTER TABLE `envio_encomienda`
  MODIFY `idenvio_encomienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `liquidacion_movilidad`
--
ALTER TABLE `liquidacion_movilidad`
  MODIFY `idliquidacion_movilidad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `peso`
--
ALTER TABLE `peso`
  MODIFY `idpeso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `sub_tipo_correspondencia`
--
ALTER TABLE `sub_tipo_correspondencia`
  MODIFY `idsub_tipo_correspondencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `tipo_correspondencia`
--
ALTER TABLE `tipo_correspondencia`
  MODIFY `idtipo_correspondencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `valija`
--
ALTER TABLE `valija`
  MODIFY `idvalija` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `idzona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `fk_ciudad_distrito1` FOREIGN KEY (`iddistrito`) REFERENCES `distrito` (`iddistrito`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `departamento_entrega`
--
ALTER TABLE `departamento_entrega`
  ADD CONSTRAINT `fk_departamento_entrega_departamento1` FOREIGN KEY (`origen`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_departamento_entrega_departamento2` FOREIGN KEY (`destino`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_envio_encomienda`
--
ALTER TABLE `detalle_envio_encomienda`
  ADD CONSTRAINT `fk_detalle_encomienda_factura1` FOREIGN KEY (`idenvio_encomienda`) REFERENCES `envio_encomienda` (`idenvio_encomienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_encomienda_zona1` FOREIGN KEY (`idzona`) REFERENCES `zona` (`idzona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_envio_encomienda_sub_tipo_correspondencia1` FOREIGN KEY (`idsub_tipo_correspondencia`) REFERENCES `sub_tipo_correspondencia` (`idsub_tipo_correspondencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_liquidacion`
--
ALTER TABLE `detalle_liquidacion`
  ADD CONSTRAINT `fk_detalle_liquidacion_liquidacion_movilidad1` FOREIGN KEY (`idliquidacion_movilidad`) REFERENCES `liquidacion_movilidad` (`idliquidacion_movilidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_valija`
--
ALTER TABLE `detalle_valija`
  ADD CONSTRAINT `fk_detalle_valija_envio_encomienda1` FOREIGN KEY (`idenvio_encomienda`) REFERENCES `envio_encomienda` (`idenvio_encomienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_valija_ciudad_entrega1` FOREIGN KEY (`iddepartamento_entrega`) REFERENCES `departamento_entrega` (`iddepartamento_entrega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_valija_valija1` FOREIGN KEY (`idvalija`) REFERENCES `valija` (`idvalija`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD CONSTRAINT `fk_distrito_provincia1` FOREIGN KEY (`idprovincia`) REFERENCES `provincia` (`idprovincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `envio_encomienda`
--
ALTER TABLE `envio_encomienda`
  ADD CONSTRAINT `fk_factura_cliente1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `liquidacion_movilidad`
--
ALTER TABLE `liquidacion_movilidad`
  ADD CONSTRAINT `fk_liquidacion_movilidad_persona1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `fk_provincia_departamento1` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sub_tipo_correspondencia`
--
ALTER TABLE `sub_tipo_correspondencia`
  ADD CONSTRAINT `fk_tipo_correspondecia2` FOREIGN KEY (`idtipo_correspondencia`) REFERENCES `tipo_correspondencia` (`idtipo_correspondencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `fk_capacidad` FOREIGN KEY (`idpeso`) REFERENCES `peso` (`idpeso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_capacidad_ciudad_zona_ciudad_entrega1` FOREIGN KEY (`iddepartamento_entrega`) REFERENCES `departamento_entrega` (`iddepartamento_entrega`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
