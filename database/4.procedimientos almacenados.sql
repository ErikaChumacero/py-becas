USE BecasBD
GO

/* -------------  PERSONA -----------------*/
CREATE PROCEDURE sp_InsertarPersona 
@ci varchar(10),
@nombre varchar(100),
@apellido varchar(100),
@telefono varchar(8),
@sexo varchar(10),
@correo varchar(255),
@tipou char(1),
@tipoa char(1),
@tipoe char(1),
@contrasena varchar(255),
@codigo varchar(20),
@nroregistro varchar(20)
AS
    INSERT INTO PERSONA VALUES 
    (@ci, @nombre, @apellido, @telefono, @sexo, @correo, @tipou, @tipoa, @tipoe, @contrasena, @codigo, @nroregistro)
GO 

CREATE PROCEDURE sp_ActualizarPersona 
@ci varchar(10),
@nombre varchar(100),
@apellido varchar(100),
@telefono varchar(8),
@sexo varchar(10),
@correo varchar(255),
@tipou char(1),
@tipoa char(1),
@tipoe char(1),
@contrasena varchar(255),
@codigo varchar(20),
@nroregistro varchar(20)
AS
    UPDATE PERSONA SET 
    nombre = @nombre, 
    apellido = @apellido, 
    telefono = @telefono, 
    sexo = @sexo, 
    correo = @correo, 
    tipou = @tipou, 
    tipoa = @tipoa, 
    tipoe = @tipoe, 
    contrasena = @contrasena, 
    codigo = @codigo, 
    nroregistro = @nroregistro 
    WHERE ci = @ci
GO

/* -------------  CARRERA -----------------*/
CREATE PROCEDURE sp_InsertarCarrera 
@idcarrera int,
@plancarrera varchar(50),
@codigo varchar(20),
@nombre varchar(100)
AS
    INSERT INTO CARRERA VALUES (@idcarrera, @plancarrera, @codigo, @nombre)
GO 

CREATE PROCEDURE sp_ActualizarCarrera 
@idcarrera int,
@plancarrera varchar(50),
@codigo varchar(20),
@nombre varchar(100)
AS
    UPDATE CARRERA SET 
    plancarrera = @plancarrera, 
    codigo = @codigo, 
    nombre = @nombre 
    WHERE idcarrera = @idcarrera
GO

/* -------------  SEMESTRE -----------------*/
CREATE PROCEDURE sp_InsertarSemestre 
@idsemestre int,
@año int,
@periodo varchar(20),
@descripcion varchar(100)
AS
    INSERT INTO SEMESTRE VALUES (@idsemestre, @año, @periodo, @descripcion)
GO 

CREATE PROCEDURE sp_ActualizarSemestre 
@idsemestre int,
@año int,
@periodo varchar(20),
@descripcion varchar(100)
AS
    UPDATE SEMESTRE SET 
    año = @año, 
    periodo = @periodo, 
    descripcion = @descripcion 
    WHERE idsemestre = @idsemestre
GO

/* -------------  TIPOBECA -----------------*/
CREATE PROCEDURE sp_InsertarTipoBeca 
@idtipobeca int,
@nombre varchar(100),
@descripcion varchar(500)
AS
    INSERT INTO TIPOBECA VALUES (@idtipobeca, @nombre, @descripcion)
GO 

CREATE PROCEDURE sp_ActualizarTipoBeca 
@idtipobeca int,
@nombre varchar(100),
@descripcion varchar(500)
AS
    UPDATE TIPOBECA SET 
    nombre = @nombre, 
    descripcion = @descripcion 
    WHERE idtipobeca = @idtipobeca
GO

/* -------------  CONVOCATORIA -----------------*/
CREATE PROCEDURE sp_InsertarConvocatoria 
@idconvocatoria int,
@titulo varchar(100),
@descripcion varchar(500),
@fechainicio date,
@fechafin date,
@estado char(1),
@idtipobeca int
AS
    INSERT INTO CONVOCATORIA VALUES (@idconvocatoria, @titulo, @descripcion, @fechainicio, @fechafin, @estado, @idtipobeca)
GO 

CREATE PROCEDURE sp_ActualizarConvocatoria 
@idconvocatoria int,
@titulo varchar(100),
@descripcion varchar(500),
@fechainicio date,
@fechafin date,
@estado char(1),
@idtipobeca int
AS
    UPDATE CONVOCATORIA SET 
    titulo = @titulo, 
    descripcion = @descripcion, 
    fechainicio = @fechainicio, 
    fechafin = @fechafin, 
    estado = @estado, 
    idtipobeca = @idtipobeca 
    WHERE idconvocatoria = @idconvocatoria
GO

/* -------------  REQUISITO -----------------*/
CREATE PROCEDURE sp_InsertarRequisito
@descripcion varchar(500),
@obligatorio char(1),
@idtipobeca int
AS
    INSERT INTO REQUISITO (descripcion, obligatorio, idtipobeca) VALUES (@descripcion, @obligatorio, @idtipobeca)
GO 

CREATE PROCEDURE sp_ActualizarRequisito 
@idrequisito int,
@descripcion varchar(500),
@obligatorio char(1),
@idtipobeca int
AS
    UPDATE REQUISITO SET 
    descripcion = @descripcion, 
    obligatorio = @obligatorio, 
    idtipobeca = @idtipobeca 
    WHERE idrequisito = @idrequisito
GO

/* -------------  POSTULACION -----------------*/
CREATE PROCEDURE sp_InsertarPostulacion 
@idconvocatoria int,
@idcarrera int,
@ci varchar(10),
@idsemestre int
AS
    INSERT INTO POSTULACION (fechapostulacion, estado, idconvocatoria, idcarrera, ci, idsemestre) VALUES (GETDATE(), '1', @idconvocatoria, @idcarrera, @ci, @idsemestre)
GO 

CREATE OR ALTER PROCEDURE sp_ActualizarPostulacion 
@idpostulacion int,
@estado char(1),
@idconvocatoria int,
@idcarrera int,
@ci varchar(10),
@idsemestre int
AS
    UPDATE POSTULACION SET 
    estado = @estado, 
    idconvocatoria = @idconvocatoria, 
    idcarrera = @idcarrera, 
    ci = @ci, 
    idsemestre = @idsemestre 
    WHERE idpostulacion = @idpostulacion
GO

/* -------------  HISTORIALESTADO -----------------*/
CREATE PROCEDURE sp_InsertarHistorialEstado 
@idhistorialestado int,
@estadoanterior char(1),
@estadonuevo char(1),
@fechacambio date,
@idpostulacion int
AS
    INSERT INTO HISTORIALESTADO VALUES (@idhistorialestado, @estadoanterior, @estadonuevo, @fechacambio, @idpostulacion)
GO 

CREATE PROCEDURE sp_ActualizarHistorialEstado 
@idhistorialestado int,
@estadoanterior char(1),
@estadonuevo char(1),
@fechacambio date,
@idpostulacion int
AS
    UPDATE HISTORIALESTADO SET 
    estadoanterior = @estadoanterior, 
    estadonuevo = @estadonuevo, 
    fechacambio = @fechacambio, 
    idpostulacion = @idpostulacion 
    WHERE idhistorialestado = @idhistorialestado
GO

/* -------------  DOCUMENTO -----------------*/
CREATE OR ALTER PROCEDURE sp_InsertarDocumento 
  @tipodocumento varchar(50),
  @rutaarchivo varchar(500),
  @validado char(1),
  @idpostulacion int,
  @idrequisito int
AS
  INSERT INTO DOCUMENTO (tipodocumento, rutaarchivo, validado, idpostulacion, idrequisito)
  VALUES (@tipodocumento, @rutaarchivo, @validado, @idpostulacion, @idrequisito);
GO

CREATE OR ALTER PROCEDURE sp_ActualizarDocumento 
@iddocumento int,
@tipodocumento varchar(50),
@nombrearchivo varchar(255),
@rutaarchivo varchar(500),
@validado char(1),
@idpostulacion int,
@idrequisito int
AS
    UPDATE DOCUMENTO SET 
    tipodocumento = @tipodocumento, 
    nombrearchivo = @nombrearchivo, 
    rutaarchivo = @rutaarchivo, 
    validado = @validado, 
    idpostulacion = @idpostulacion, 
    idrequisito = @idrequisito 
    WHERE iddocumento = @iddocumento
GO