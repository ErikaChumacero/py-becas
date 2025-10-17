create Database BecasBD
go

use BecasBD
go

Create table PERSONA
    (ci varchar(10) primary key,
    nombre varchar(100),
    apellido varchar(100),
    telefono varchar(8),
    sexo char(1),
    correo varchar(255),
    tipou char(1),
    tipoa char(1),
    tipoe char(1),
    contrasena varchar(255),
    codigo varchar(20),
    nroregistro varchar(20))

Create table CARRERA
    (idcarrera integer identity(1,1) primary key,
    plancarrera varchar(50),
    codigo varchar(20),
    nombre varchar(100))

Create table SEMESTRE
    (idsemestre integer identity(1,1) primary key,
    año int,
    periodo varchar(20),
    descripcion varchar(100))

Create table TIPOBECA
    (idtipobeca integer identity(1,1) primary key,
    nombre varchar(100),
    descripcion varchar(500))

Create table CONVOCATORIA
    (idconvocatoria integer identity(1,1) primary key,
    titulo varchar(100),
    descripcion varchar(500),
    fechainicio date,
    fechafin date,
    estado char(1),
    idtipobeca int)

Create table REQUISITO
    (idrequisito integer identity(1,1) primary key,
    descripcion varchar(500),
    obligatorio char(1),
    idtipobeca int)

Create table POSTULACION
    (idpostulacion integer identity(1,1) primary key,
    fechapostulacion date,
    estado char(1),
    idconvocatoria int,
    idcarrera int,
    ci varchar(10),
    idsemestre int)

Create table HISTORIALESTADO
    (idhistorialestado integer identity(1,1) primary key,
    estadoanterior char(1),
    estadonuevo char(1),
    fechacambio date,
    idpostulacion int)

Create table DOCUMENTO
    (iddocumento integer identity(1,1) primary key,
    tipodocumento varchar(50),
    rutaarchivo varchar(500),
    validado char(1),
    idpostulacion int,
    idrequisito int)