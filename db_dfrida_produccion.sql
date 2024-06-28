-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2024 a las 20:09:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_dfrida`
--
CREATE DATABASE IF NOT EXISTS `bd_dfrida` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_dfrida`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alamcen_mprima`
--

CREATE TABLE `alamcen_mprima` (
  `idAlmaMprima` int(11) NOT NULL,
  `idMprima` int(11) NOT NULL,
  `codigoMprima` varchar(255) NOT NULL,
  `nombreMprima` varchar(255) NOT NULL,
  `unidadMprima` int(11) NOT NULL,
  `cantidadMprima` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen_prod`
--

CREATE TABLE `almacen_prod` (
  `idAlmaProd` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `codigoProd` varchar(255) NOT NULL,
  `nombreProd` varchar(255) NOT NULL,
  `unidadProd` int(11) NOT NULL,
  `cantidadProd` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_mprima`
--

CREATE TABLE `categoria_mprima` (
  `idCatMPrima` int(11) NOT NULL,
  `nombreCategoriaMprima` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_prod`
--

CREATE TABLE `categoria_prod` (
  `idCatPro` int(11) NOT NULL,
  `nombreCategoriaProd` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCli` int(11) NOT NULL,
  `RazonSocialCli` varchar(255) DEFAULT NULL,
  `rucCli` varchar(255) DEFAULT NULL,
  `nombreCli` varchar(255) NOT NULL,
  `correoCli` varchar(255) DEFAULT NULL,
  `direccionCli` varchar(255) DEFAULT NULL,
  `celularCli` int(11) DEFAULT NULL,
  `detalleCli` varchar(255) DEFAULT NULL,
  `estadoCli` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `idCoti` int(11) NOT NULL,
  `idProd` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`idProd`)),
  `idMprima` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`idMprima`)),
  `CantidadProdCoti` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`CantidadProdCoti`)),
  `CantidadMprimaCoti` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`CantidadMprimaCoti`)),
  `totalCotiProd` decimal(10,2) NOT NULL,
  `totalCotiMprima` decimal(10,2) NOT NULL,
  `totalCoti` decimal(10,2) NOT NULL,
  `tituloCoti` varchar(255) NOT NULL,
  `razonSocialCoti` varchar(255) NOT NULL,
  `nombreComercialCoti` varchar(255) NOT NULL,
  `rucCoti` int(11) NOT NULL,
  `nombreCoti` varchar(255) NOT NULL,
  `correoCoti` varchar(255) DEFAULT NULL,
  `direccionCoti` varchar(255) DEFAULT NULL,
  `celularCoti` int(11) DEFAULT NULL,
  `detalleCoti` varchar(255) DEFAULT NULL,
  `EstadoCoti` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desecho_merma`
--

CREATE TABLE `desecho_merma` (
  `idDeseMerma` int(11) NOT NULL,
  `idMerma` int(11) NOT NULL,
  `codigoMprima` varchar(255) NOT NULL,
  `nombreMprima` varchar(255) NOT NULL,
  `unidadMprima` int(11) NOT NULL,
  `cantidadMprima` decimal(10,2) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_proceso`
--

CREATE TABLE `ficha_proceso` (
  `idFichaProc` int(11) NOT NULL,
  `tituloFichaProc` varchar(255) NOT NULL,
  `nombreFichaProc` varchar(255) NOT NULL,
  `docFichaProc` varchar(255) DEFAULT NULL,
  `procesoFichaProcJson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`procesoFichaProcJson`)),
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_tecnica`
--

CREATE TABLE `ficha_tecnica` (
  `idFichaTec` int(11) NOT NULL,
  `nombreFichaTec` varchar(255) NOT NULL,
  `docFichaTec` varchar(255) DEFAULT NULL,
  `EstadoFichaTec` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_mprima`
--

CREATE TABLE `ingreso_mprima` (
  `idIngMprima` int(11) NOT NULL,
  `idMprima` int(11) NOT NULL,
  `codigoMprima` varchar(255) NOT NULL,
  `nombreMprima` varchar(255) NOT NULL,
  `unidadMprima` int(11) NOT NULL,
  `cantidadMprima` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_prod`
--

CREATE TABLE `ingreso_prod` (
  `idIngProd` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `codigoProd` varchar(255) NOT NULL,
  `nombreProd` varchar(255) NOT NULL,
  `unidadProd` int(11) NOT NULL,
  `cantidadProd` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_prima`
--

CREATE TABLE `materia_prima` (
  `idMprima` int(11) NOT NULL,
  `idCatMprima` int(11) NOT NULL,
  `codigoMprima` varchar(255) NOT NULL,
  `nombreMprima` varchar(255) NOT NULL,
  `detalleMprima` varchar(255) DEFAULT NULL,
  `unidadMprima` int(11) NOT NULL,
  `precioMprima` decimal(10,2) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `merma`
--

CREATE TABLE `merma` (
  `idMerma` int(11) NOT NULL,
  `idProcOp` int(11) NOT NULL,
  `idSalMprima` int(11) DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `idCli` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `idFichaTec` int(11) DEFAULT NULL,
  `idFichaProc` int(11) DEFAULT NULL,
  `tituloPedido` varchar(255) NOT NULL,
  `nombrePedido` varchar(255) NOT NULL,
  `fechaPedido` date NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso_operativo`
--

CREATE TABLE `proceso_operativo` (
  `idProcOp` int(11) NOT NULL,
  `idTipoProc` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idSalMprima` int(11) NOT NULL,
  `descripcionProcOp` varchar(255) NOT NULL,
  `estadoProcOp` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso_operativo_fin`
--

CREATE TABLE `proceso_operativo_fin` (
  `idProcOpFin` int(11) NOT NULL,
  `idTipoProc` int(11) NOT NULL,
  `idProcOp` int(11) NOT NULL,
  `descripcionProcOpFin` varchar(255) NOT NULL,
  `estadoProcOpFin` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `idProduccion` int(11) NOT NULL,
  `idProcOpFin` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `estadoProduccion` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProd` int(11) NOT NULL,
  `idCatPro` int(11) NOT NULL,
  `codigoProd` varchar(255) NOT NULL,
  `nombreProd` varchar(255) NOT NULL,
  `detalleProd` varchar(255) NOT NULL,
  `unidadProd` int(11) NOT NULL,
  `precioProd` decimal(10,2) DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_merma`
--

CREATE TABLE `prod_merma` (
  `idProdMerma` int(11) NOT NULL,
  `idMerma` int(11) NOT NULL,
  `idProd` int(11) DEFAULT NULL,
  `cantidadProdMerma` int(11) NOT NULL,
  `estadoProdMerma` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProv` int(11) NOT NULL,
  `razonSocialProv` varchar(255) NOT NULL,
  `rucProv` int(11) NOT NULL,
  `nombreProv` varchar(255) NOT NULL,
  `correoProv` varchar(255) DEFAULT NULL,
  `direccionProv` varchar(255) DEFAULT NULL,
  `celularProv` int(11) DEFAULT NULL,
  `detalleProv` varchar(255) DEFAULT NULL,
  `estadoProv` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_mprima`
--

CREATE TABLE `salida_mprima` (
  `idSalMprima` int(11) NOT NULL,
  `idMprima` int(11) NOT NULL,
  `codigoMprima` varchar(255) NOT NULL,
  `nombreMprima` varchar(255) NOT NULL,
  `unidadMprima` int(11) NOT NULL,
  `cantidadMprima` int(11) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_prod`
--

CREATE TABLE `salida_prod` (
  `idSalProd` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idCli` int(11) DEFAULT NULL,
  `idProd` int(11) NOT NULL,
  `codigoProd` varchar(255) NOT NULL,
  `nombreProd` varchar(255) NOT NULL,
  `unidadProd` int(11) NOT NULL,
  `cantidadProd` decimal(10,2) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_proceso`
--

CREATE TABLE `tipo_proceso` (
  `idTipoProc` int(11) NOT NULL,
  `idFichaProc` int(11) DEFAULT NULL,
  `descripcionTipoProc` varchar(255) NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `idTipoUsu` int(11) NOT NULL,
  `descripcionTipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`idTipoUsu`, `descripcionTipo`) VALUES
(1, 'Administrador'),
(2, 'Administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsu` int(11) NOT NULL,
  `idTipoUsu` int(11) NOT NULL,
  `nombreUsu` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `LastConnection` datetime DEFAULT NULL,
  `DateCreate` datetime NOT NULL,
  `DateUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsu`, `idTipoUsu`, `nombreUsu`, `nombre`, `apellido`, `password`, `LastConnection`, `DateCreate`, `DateUpdate`) VALUES
(1, 1, 'dfrida', 'Administrador', 'administrador', '$argon2id$v=19$m=4096,t=2,p=2$ZURZWG0yNkNOZVJTLlg5Lw$MvzbwXUNlV+Inxssd1nN+A8EN5Il6CdSAs7pTc3szJk', '2024-02-27 16:53:21', '2024-02-16 12:09:23', '2024-02-16 12:09:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alamcen_mprima`
--
ALTER TABLE `alamcen_mprima`
  ADD PRIMARY KEY (`idAlmaMprima`),
  ADD KEY `idMprima` (`idMprima`);

--
-- Indices de la tabla `almacen_prod`
--
ALTER TABLE `almacen_prod`
  ADD PRIMARY KEY (`idAlmaProd`),
  ADD KEY `idProd` (`idProd`);

--
-- Indices de la tabla `categoria_mprima`
--
ALTER TABLE `categoria_mprima`
  ADD PRIMARY KEY (`idCatMPrima`);

--
-- Indices de la tabla `categoria_prod`
--
ALTER TABLE `categoria_prod`
  ADD PRIMARY KEY (`idCatPro`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCli`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`idCoti`);

--
-- Indices de la tabla `desecho_merma`
--
ALTER TABLE `desecho_merma`
  ADD PRIMARY KEY (`idDeseMerma`),
  ADD KEY `idMerma` (`idMerma`);

--
-- Indices de la tabla `ficha_proceso`
--
ALTER TABLE `ficha_proceso`
  ADD PRIMARY KEY (`idFichaProc`);

--
-- Indices de la tabla `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
  ADD PRIMARY KEY (`idFichaTec`);

--
-- Indices de la tabla `ingreso_mprima`
--
ALTER TABLE `ingreso_mprima`
  ADD PRIMARY KEY (`idIngMprima`),
  ADD KEY `idMprima` (`idMprima`);

--
-- Indices de la tabla `ingreso_prod`
--
ALTER TABLE `ingreso_prod`
  ADD PRIMARY KEY (`idIngProd`),
  ADD KEY `idProd` (`idProd`);

--
-- Indices de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`idMprima`),
  ADD KEY `idCatMprima` (`idCatMprima`);

--
-- Indices de la tabla `merma`
--
ALTER TABLE `merma`
  ADD PRIMARY KEY (`idMerma`),
  ADD KEY `idProcOp` (`idProcOp`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idCli` (`idCli`),
  ADD KEY `idProd` (`idProd`),
  ADD KEY `idFichaTec` (`idFichaTec`),
  ADD KEY `idFichaProc` (`idFichaProc`);

--
-- Indices de la tabla `proceso_operativo`
--
ALTER TABLE `proceso_operativo`
  ADD PRIMARY KEY (`idProcOp`),
  ADD KEY `idTipoProc` (`idTipoProc`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `idSalMprima` (`idSalMprima`);

--
-- Indices de la tabla `proceso_operativo_fin`
--
ALTER TABLE `proceso_operativo_fin`
  ADD PRIMARY KEY (`idProcOpFin`),
  ADD KEY `idTipoProc` (`idTipoProc`),
  ADD KEY `idProcOp` (`idProcOp`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`idProduccion`),
  ADD KEY `idProcOpFin` (`idProcOpFin`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProd`),
  ADD KEY `idCatPro` (`idCatPro`);

--
-- Indices de la tabla `prod_merma`
--
ALTER TABLE `prod_merma`
  ADD PRIMARY KEY (`idProdMerma`),
  ADD KEY `idMerma` (`idMerma`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProv`);

--
-- Indices de la tabla `salida_mprima`
--
ALTER TABLE `salida_mprima`
  ADD PRIMARY KEY (`idSalMprima`),
  ADD KEY `idMprima` (`idMprima`);

--
-- Indices de la tabla `salida_prod`
--
ALTER TABLE `salida_prod`
  ADD PRIMARY KEY (`idSalProd`),
  ADD KEY `idProd` (`idProd`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `idCli` (`idCli`);

--
-- Indices de la tabla `tipo_proceso`
--
ALTER TABLE `tipo_proceso`
  ADD PRIMARY KEY (`idTipoProc`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`idTipoUsu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsu`),
  ADD KEY `idTipoUsu` (`idTipoUsu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alamcen_mprima`
--
ALTER TABLE `alamcen_mprima`
  MODIFY `idAlmaMprima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `almacen_prod`
--
ALTER TABLE `almacen_prod`
  MODIFY `idAlmaProd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_mprima`
--
ALTER TABLE `categoria_mprima`
  MODIFY `idCatMPrima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_prod`
--
ALTER TABLE `categoria_prod`
  MODIFY `idCatPro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCli` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `idCoti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desecho_merma`
--
ALTER TABLE `desecho_merma`
  MODIFY `idDeseMerma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ficha_proceso`
--
ALTER TABLE `ficha_proceso`
  MODIFY `idFichaProc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
  MODIFY `idFichaTec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_mprima`
--
ALTER TABLE `ingreso_mprima`
  MODIFY `idIngMprima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_prod`
--
ALTER TABLE `ingreso_prod`
  MODIFY `idIngProd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `idMprima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `merma`
--
ALTER TABLE `merma`
  MODIFY `idMerma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proceso_operativo`
--
ALTER TABLE `proceso_operativo`
  MODIFY `idProcOp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proceso_operativo_fin`
--
ALTER TABLE `proceso_operativo_fin`
  MODIFY `idProcOpFin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `idProduccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prod_merma`
--
ALTER TABLE `prod_merma`
  MODIFY `idProdMerma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salida_mprima`
--
ALTER TABLE `salida_mprima`
  MODIFY `idSalMprima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salida_prod`
--
ALTER TABLE `salida_prod`
  MODIFY `idSalProd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_proceso`
--
ALTER TABLE `tipo_proceso`
  MODIFY `idTipoProc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `idTipoUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alamcen_mprima`
--
ALTER TABLE `alamcen_mprima`
  ADD CONSTRAINT `alamcen_mprima_ibfk_1` FOREIGN KEY (`idMprima`) REFERENCES `materia_prima` (`idMprima`);

--
-- Filtros para la tabla `almacen_prod`
--
ALTER TABLE `almacen_prod`
  ADD CONSTRAINT `almacen_prod_ibfk_1` FOREIGN KEY (`idProd`) REFERENCES `producto` (`idProd`);

--
-- Filtros para la tabla `desecho_merma`
--
ALTER TABLE `desecho_merma`
  ADD CONSTRAINT `desecho_merma_ibfk_1` FOREIGN KEY (`idMerma`) REFERENCES `merma` (`idMerma`);

--
-- Filtros para la tabla `ingreso_mprima`
--
ALTER TABLE `ingreso_mprima`
  ADD CONSTRAINT `ingreso_mprima_ibfk_1` FOREIGN KEY (`idMprima`) REFERENCES `materia_prima` (`idMprima`);

--
-- Filtros para la tabla `ingreso_prod`
--
ALTER TABLE `ingreso_prod`
  ADD CONSTRAINT `ingreso_prod_ibfk_1` FOREIGN KEY (`idProd`) REFERENCES `producto` (`idProd`);

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `materia_prima_ibfk_1` FOREIGN KEY (`idCatMprima`) REFERENCES `categoria_mprima` (`idCatMPrima`);

--
-- Filtros para la tabla `merma`
--
ALTER TABLE `merma`
  ADD CONSTRAINT `merma_ibfk_1` FOREIGN KEY (`idProcOp`) REFERENCES `proceso_operativo` (`idProcOp`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idCli`) REFERENCES `cliente` (`idCli`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`idProd`) REFERENCES `producto` (`idProd`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`idFichaTec`) REFERENCES `ficha_tecnica` (`idFichaTec`),
  ADD CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`idFichaProc`) REFERENCES `ficha_proceso` (`idFichaProc`);

--
-- Filtros para la tabla `proceso_operativo`
--
ALTER TABLE `proceso_operativo`
  ADD CONSTRAINT `proceso_operativo_ibfk_1` FOREIGN KEY (`idTipoProc`) REFERENCES `tipo_proceso` (`idTipoProc`),
  ADD CONSTRAINT `proceso_operativo_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `proceso_operativo_ibfk_3` FOREIGN KEY (`idSalMprima`) REFERENCES `salida_mprima` (`idSalMprima`);

--
-- Filtros para la tabla `proceso_operativo_fin`
--
ALTER TABLE `proceso_operativo_fin`
  ADD CONSTRAINT `proceso_operativo_fin_ibfk_1` FOREIGN KEY (`idTipoProc`) REFERENCES `tipo_proceso` (`idTipoProc`),
  ADD CONSTRAINT `proceso_operativo_fin_ibfk_2` FOREIGN KEY (`idProcOp`) REFERENCES `proceso_operativo` (`idProcOp`);

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `produccion_ibfk_1` FOREIGN KEY (`idProcOpFin`) REFERENCES `proceso_operativo_fin` (`idProcOpFin`),
  ADD CONSTRAINT `produccion_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idCatPro`) REFERENCES `categoria_prod` (`idCatPro`);

--
-- Filtros para la tabla `prod_merma`
--
ALTER TABLE `prod_merma`
  ADD CONSTRAINT `prod_merma_ibfk_1` FOREIGN KEY (`idMerma`) REFERENCES `merma` (`idMerma`);

--
-- Filtros para la tabla `salida_mprima`
--
ALTER TABLE `salida_mprima`
  ADD CONSTRAINT `salida_mprima_ibfk_1` FOREIGN KEY (`idMprima`) REFERENCES `materia_prima` (`idMprima`);

--
-- Filtros para la tabla `salida_prod`
--
ALTER TABLE `salida_prod`
  ADD CONSTRAINT `salida_prod_ibfk_1` FOREIGN KEY (`idProd`) REFERENCES `producto` (`idProd`),
  ADD CONSTRAINT `salida_prod_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `salida_prod_ibfk_3` FOREIGN KEY (`idCli`) REFERENCES `cliente` (`idCli`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idTipoUsu`) REFERENCES `tipo_usuario` (`idTipoUsu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
