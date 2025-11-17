USE COLEGIO
GO

/* -------------  PERSONA -----------------*/
CREATE PROCEDURE sp_InsertarPersona 
@ci varchar(10),
@nombre varchar(100),
@apellido varchar(100),
@telefono varchar(8),
@fecharegistro date,
@correo varchar(255),
@tipou char(1),
@tipoe char(1),
@tipot char(1),
@tipom char(1),
@tipoa char(1),
@contrasena varchar(100),
@codestudiante varchar(9),
@codmaestro varchar(9)
AS
    INSERT INTO persona VALUES 
    (@ci, @nombre, @apellido, @telefono, @fecharegistro, @correo, @tipou, @tipoe, @tipot, @tipom, @tipoa, @contrasena, @codestudiante, @codmaestro)
GO 

CREATE PROCEDURE sp_ActualizarPersona 
@ci varchar(10),
@nombre varchar(100),
@apellido varchar(100),
@telefono varchar(8),
@fecharegistro date,
@correo varchar(255),
@tipou char(1),
@tipoe char(1),
@tipot char(1),
@tipom char(1),
@tipoa char(1),
@contrasena varchar(100),
@codestudiante varchar(9),
@codmaestro varchar(9)
AS
    UPDATE persona SET 
    nombre = @nombre, 
    apellido = @apellido, 
    telefono = @telefono, 
    fecharegistro = @fecharegistro, 
    correo = @correo, 
    tipou = @tipou, 
    tipoe = @tipoe, 
    tipot = @tipot, 
    tipom = @tipom, 
    tipoa = @tipoa, 
    contrasena = @contrasena, 
    codestudiante = @codestudiante, 
    codmaestro = @codmaestro 
    WHERE ci = @ci
GO

/* -------------  NIVEL -----------------*/
CREATE PROCEDURE sp_InsertarNivel 
@descripcion varchar(100)
AS
    INSERT INTO nivel (descripcion) VALUES (@descripcion)
GO 

CREATE PROCEDURE sp_ActualizarNivel 
@idnivel integer,
@descripcion varchar(100)
AS
    UPDATE nivel SET descripcion = @descripcion WHERE idnivel = @idnivel
GO

/* -------------  CURSO -----------------*/
CREATE PROCEDURE sp_InsertarCurso 
@idnivel integer,
@descripcion varchar(100)
AS
    INSERT INTO curso (idnivel, descripcion) VALUES (@idnivel, @descripcion)
GO 

CREATE PROCEDURE sp_ActualizarCurso 
@idcurso integer,
@idnivel integer,
@descripcion varchar(100)
AS
    UPDATE curso SET descripcion = @descripcion 
    WHERE idcurso = @idcurso AND idnivel = @idnivel
GO

/* -------------  MATERIA -----------------*/
CREATE PROCEDURE sp_InsertarMateria 
@sigla varchar(10),
@descripcion varchar(100),
@idcurso integer,
@idnivel integer
AS
    INSERT INTO materia (sigla, descripcion, idcurso, idnivel) 
    VALUES (@sigla, @descripcion, @idcurso, @idnivel)
GO 

CREATE PROCEDURE sp_ActualizarMateria 
@idmateria integer,
@sigla varchar(10),
@descripcion varchar(100),
@idcurso integer,
@idnivel integer
AS
    UPDATE materia SET 
    sigla = @sigla, 
    descripcion = @descripcion, 
    idcurso = @idcurso, 
    idnivel = @idnivel 
    WHERE idmateria = @idmateria
GO

/* -------------  INSCRIPCION -----------------*/
CREATE PROCEDURE sp_InsertarInscripcion 
@ci varchar(10),
@idcurso integer,
@idnivel integer,
@observaciones varchar(200),
@fecharegis date,
@citutor varchar(10),
@idgestion integer,
@codbeca integer
AS
    INSERT INTO inscripcion (ci, idcurso, idnivel, observaciones, fecharegis, citutor, idgestion, codbeca) 
    VALUES (@ci, @idcurso, @idnivel, @observaciones, @fecharegis, @citutor, @idgestion, @codbeca)
GO 

CREATE PROCEDURE sp_ActualizarInscripcion 
@ci varchar(10),
@idcurso integer,
@idnivel integer,
@observaciones varchar(200),
@fecharegis date,
@citutor varchar(10),
@idgestion integer,
@codbeca integer
AS
    UPDATE inscripcion SET 
    observaciones = @observaciones, 
    fecharegis = @fecharegis, 
    citutor = @citutor, 
    idgestion = @idgestion, 
    codbeca = @codbeca 
    WHERE ci = @ci AND idcurso = @idcurso AND idnivel = @idnivel
GO

/* -------------  GESTION -----------------*/
CREATE PROCEDURE sp_InsertarGestion 
@detalleges varchar(100),
@observacion varchar(200),
@fechaapertura date,
@fechacierre date,
@estado char(1)
AS
    INSERT INTO gestion (detalleges, observacion, fechaapertura, fechacierre, estado) 
    VALUES (@detalleges, @observacion, @fechaapertura, @fechacierre, @estado)
GO 

CREATE PROCEDURE sp_ActualizarGestion 
@idgestion integer,
@detalleges varchar(100),
@observacion varchar(200),
@fechaapertura date,
@fechacierre date,
@estado char(1)
AS
    UPDATE gestion SET 
    detalleges = @detalleges, 
    observacion = @observacion, 
    fechaapertura = @fechaapertura, 
    fechacierre = @fechacierre, 
    estado = @estado 
    WHERE idgestion = @idgestion
GO

/* -------------  DETALLEMENSUALIDAD -----------------*/
CREATE PROCEDURE sp_InsertarDetalleMensualidad 
@descripcion varchar(100),
@estado char(1),
@monto smallmoney,
@montototal smallmoney,
@nodescuento char(1),
@descuento integer
AS
    INSERT INTO detallemensualidad (descripcion, estado, monto, montototal, nodescuento, descuento) 
    VALUES (@descripcion, @estado, @monto, @montototal, @nodescuento, @descuento)
GO 

CREATE PROCEDURE sp_ActualizarDetalleMensualidad 
@iddetallemensualidad integer,
@descripcion varchar(100),
@estado char(1),
@monto smallmoney,
@montototal smallmoney,
@nodescuento char(1),
@descuento integer
AS
    UPDATE detallemensualidad SET 
    descripcion = @descripcion, 
    estado = @estado, 
    monto = @monto, 
    montototal = @montototal, 
    nodescuento = @nodescuento, 
    descuento = @descuento 
    WHERE iddetallemensualidad = @iddetallemensualidad
GO

/* -------------  MENSUALIDAD -----------------*/
CREATE PROCEDURE sp_InsertarMensualidad 
@fechamen date,
@observacion varchar(200),
@tipopago char(1),
@iddetallemensualidad integer,
@ci varchar(10),
@idcurso integer,
@idnivel integer
AS
    INSERT INTO mensualidad (fechamen, observacion, tipopago, iddetallemensualidad, ci, idcurso, idnivel) 
    VALUES (@fechamen, @observacion, @tipopago, @iddetallemensualidad, @ci, @idcurso, @idnivel)
GO 

CREATE PROCEDURE sp_ActualizarMensualidad 
@idmensualidad integer,
@fechamen date,
@observacion varchar(200),
@tipopago char(1),
@iddetallemensualidad integer,
@ci varchar(10),
@idcurso integer,
@idnivel integer
AS
    UPDATE mensualidad SET 
    fechamen = @fechamen, 
    observacion = @observacion, 
    tipopago = @tipopago, 
    iddetallemensualidad = @iddetallemensualidad, 
    ci = @ci, 
    idcurso = @idcurso, 
    idnivel = @idnivel 
    WHERE idmensualidad = @idmensualidad
GO

/* -------------  MAESTROMATER -----------------*/
CREATE PROCEDURE sp_InsertarMaestroMater 
@ci varchar(10),
@idmateria integer,
@fecharegis date,
@observacion varchar(200),
@idgestion integer,
@idcurso integer,
@idnivel integer,
@asesor char(1)
AS
    INSERT INTO maestromater (ci, idmateria, fecharegis, observacion, idgestion, idcurso, idnivel, asesor) 
    VALUES (@ci, @idmateria, @fecharegis, @observacion, @idgestion, @idcurso, @idnivel, @asesor)
GO 

CREATE PROCEDURE sp_ActualizarMaestroMater 
@ci varchar(10),
@idmateria integer,
@fecharegis date,
@observacion varchar(200),
@idgestion integer,
@idcurso integer,
@idnivel integer,
@asesor char(1)
AS
    UPDATE maestromater SET 
    fecharegis = @fecharegis, 
    observacion = @observacion, 
    idgestion = @idgestion, 
    idcurso = @idcurso, 
    idnivel = @idnivel, 
    asesor = @asesor 
    WHERE ci = @ci AND idmateria = @idmateria
GO

/* -------------  BECA -----------------*/
CREATE PROCEDURE sp_InsertarBeca 
@nombrebeca varchar(100),
@tipobeca char(1),
@porcentaje integer
AS
    INSERT INTO beca (nombrebeca, tipobeca, porcentaje) 
    VALUES (@nombrebeca, @tipobeca, @porcentaje)
GO 

CREATE PROCEDURE sp_ActualizarBeca 
@codbeca integer,
@nombrebeca varchar(100),
@tipobeca char(1),
@porcentaje integer
AS
    UPDATE beca SET 
    nombrebeca = @nombrebeca, 
    tipobeca = @tipobeca, 
    porcentaje = @porcentaje 
    WHERE codbeca = @codbeca
GO

