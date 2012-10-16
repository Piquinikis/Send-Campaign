-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2012 a las 03:30:24
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Crear base de datos 
CREATE DATABASE `newsletter`;

-- Estructura de tabla para la tabla `mails`
--

CREATE TABLE IF NOT EXISTS `mails` (
  `id_mail` tinyint(4) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`id_mail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaingns`
--

CREATE TABLE IF NOT EXISTS `campaingns` (
  `id_campaign` tinyint(4) NOT NULL AUTO_INCREMENT,
  `fecha` int(10) NOT NULL,
  `enviados` int(11) NOT NULL,
  `rebotados` int(11) NOT NULL,
  PRIMARY KEY (`id_campaign`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------