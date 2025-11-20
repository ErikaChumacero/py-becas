-- CREACION DE LA DB
CREATE DATABASE COLEGIO;
GO
-- ELIMINAR BASE DE DATOS
-- DROP DATABASE COLEGIO;

-- USO DE LA BD
USE COLEGIO;
GO
-- CREACION DE TABLAS
-- Tabla: persona
Create table persona
(ci varchar(10) primary key, 
nombre varchar(100) not null, 
apellido varchar(100) not null, 
correo varchar(100) null,
telefono varchar(15) null,
sexo char(1) not null,
contrasena varchar(50) not null,
fecharegistro date not null,
tipou char(1) not null,
tipoe char(1) not null,
tipot char(1) not null,
tipom char(1) not null,
tipoa char(1) not null,
tipos char(1) not null,
codestudiante varchar(10) null,
codmaestro varchar(10) null
);
GO
-- Tabla: gestion
create table gestion
  ( idgestion integer Identity(1,1) primary key,
  detalleges varchar(100) not null,
  observacion varchar(200) null,
  fechaapertura date not null,
  fechacierre date not null,
  estado char(1) not null
  );
GO
-- Tabla: nivel
create table nivel
  ( idnivel integer Identity(1,1) primary key,
  descripcion varchar(100) not null
  );
GO
-- Tabla: curso
create table curso
  ( idcurso integer Identity(1,1),
  idnivel integer not null,
  descripcion varchar(100) not null,
  primary key(idcurso, idnivel)
  );
GO
-- Tabla: materia
create table materia
  ( idmateria integer Identity(1,1) PRIMARY KEY,
  sigla varchar(10) not null,
  descripcion varchar(100) not null,
  idcurso integer not null,
  idnivel integer not null
  );
GO
-- Tabla: maestromater
create table maestromater
  ( ci varchar(10) not null,
  idmateria integer not null,
  fecharegis date not null,
  observacion varchar(200) null,
  idgestion integer not null,
  idcurso integer not null,
  idnivel integer not null,
  asesor char(1) not null,
  primary key(ci, idmateria)
  );
GO
-- Tabla: beca
create table beca
  ( codbeca integer Identity(1,1) primary key,
  nombrebeca varchar(100) not null,
  tipobeca char(1) not null,
  porcentaje integer not null
  );
GO
-- Tabla: inscripcion
create table inscripcion
  ( ci varchar(10) not null,
  idcurso integer not null,
  idnivel integer not null,
  observaciones varchar(200) null,
  fecharegis date not null,
  citutor varchar(10) not null,
  idgestion integer not null,
  codbeca integer null,
  primary key(ci, idcurso, idnivel)
  );
GO
-- Tabla: detallemensualidad
create table detallemensualidad
  ( iddetallemensualidad integer Identity(1,1) primary key,
  descripcion varchar(100) not null,
  estado char(1) not null,
  monto smallmoney not null,
  montototal smallmoney not null,
  nodescuento char(1) not null,
  descuento integer not null,
  cantidadmesualidades integer not null,
  idgestion integer not null,
  idnivel integer not null
  );
GO

GO
-- Tabla: mensualidad
create table mensualidad
  ( idmensualidad integer Identity(1,1) primary key,
  fechamen date not null,
  observacion varchar(200) null,
  tipopago char(1) not null,
  iddetallemensualidad integer not null,
  ci varchar(10) not null,
  idcurso integer not null,
  idnivel integer not null
  );
  GO