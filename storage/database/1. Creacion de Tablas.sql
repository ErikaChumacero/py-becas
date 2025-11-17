create Database COLEGIO
go


use COLEGIO
go

Create table persona

(ci varchar(10) primary key, 
nombre varchar(100) not null, 
apellido varchar(100) not null,
telefono varchar(8),
fecharegistro date not null,
correo varchar(255) not null,
tipou char(1) not null,
tipoe char(1) not null,
tipot char(1) not null,
tipom char(1) not null,
tipoa char(1) not null,
contrasena varchar(100) not null,
codestudiante varchar(9) null,
codmaestro varchar(9) null
);



Create table nivel 
( idnivel integer Identity(1,1) primary key, 
  descripcion varchar(100) not null);

Create table curso
( idcurso integer Identity(1,1), 
  idnivel integer not null,
  descripcion varchar(100) not null,
  primary key(idcurso, idnivel)
);


Create table materia
( idmateria integer Identity(1,1) primary key, 
  sigla varchar(10) not null,
  descripcion varchar(100) not null,
  idcurso integer not null,
  idnivel integer not null);



Create table inscripcion
( ci  varchar(10) not null,
  idcurso integer not null,
  idnivel integer not null,
  observaciones varchar(200) null,
  fecharegis date not null,
  citutor varchar(10) not null,
  idgestion integer not null,
  codbeca integer null,
  primary key(ci, idcurso, idnivel)
);


create table gestion
  ( idgestion integer Identity(1,1) primary key,
  detalleges varchar(100) not null,
  observacion varchar(200) null,
  cantidadmensualiddad integer not null,
  fechaapertura date not null,
  fechacierre date not null,
  estado char(1) not null
  );


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


create table detallemensualidad
  ( iddetallemensualidad integer Identity(1,1) primary key,
  descripcion varchar(100) not null,
  estado char(1) not null,
  monto smallmoney not null,
  montototal smallmoney not null,
  nodescuento char(1) not null,
  descuento integer not null
  );


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
create table beca
  ( codbeca integer Identity(1,1) primary key,
  nombrebeca varchar(100) not null,
  tipobeca char(1) not null,
  porcentaje integer not null
  );



