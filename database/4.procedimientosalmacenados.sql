-- procedimientos almacenados
USE COLEGIO
GO

/* -------------  PERSONA -----------------*/
-- Recrear el procedimiento con el parámetro tipos
CREATE PROCEDURE sp_InsertarPersona 
@ci varchar(10),
@nombre varchar(100),
@apellido varchar(100),
@correo varchar(100),
@telefono varchar(15),
@sexo char(1),
@contrasena varchar(50),
@fecharegistro date,
@tipou char(1),
@tipoe char(1),
@tipot char(1),
@tipom char(1),
@tipoa char(1),
@tipos char(1),
@codestudiante varchar(10),
@codmaestro varchar(10)
AS
    INSERT INTO persona (ci, nombre, apellido, correo, telefono, sexo, contrasena, fecharegistro, tipou, tipoe, tipot, tipom, tipoa, tipos, codestudiante, codmaestro) 
    VALUES (@ci, @nombre, @apellido, @correo, @telefono, @sexo, @contrasena, @fecharegistro, @tipou, @tipoe, @tipot, @tipom, @tipoa, @tipos, @codestudiante, @codmaestro)
GO
CREATE PROCEDURE sp_ActualizarPersona 
@ci varchar(10),
@nombre varchar(100),
@apellido varchar(100),
@correo varchar(100),
@telefono varchar(15),
@sexo char(1),
@contrasena varchar(50),
@fecharegistro date,
@tipou char(1),
@tipoe char(1),
@tipot char(1),
@tipom char(1),
@tipoa char(1),
@tipos char(1),
@codestudiante varchar(10),
@codmaestro varchar(10)
AS
    UPDATE persona SET 
    nombre = @nombre, 
    apellido = @apellido, 
    correo = @correo, 
    telefono = @telefono, 
    sexo = @sexo,
    contrasena = @contrasena, 
    fecharegistro = @fecharegistro, 
    tipou = @tipou, 
    tipoe = @tipoe, 
    tipot = @tipot, 
    tipom = @tipom, 
    tipoa = @tipoa,
    tipos = @tipos,
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
@descuento integer,
@cantidadmesualidades integer,
@idgestion integer
AS
    INSERT INTO detallemensualidad (descripcion, estado, monto, montototal, nodescuento, descuento, cantidadmesualidades, idgestion) 
    VALUES (@descripcion, @estado, @monto, @montototal, @nodescuento, @descuento, @cantidadmesualidades, @idgestion)
GO 

CREATE PROCEDURE sp_ActualizarDetalleMensualidad 
@iddetallemensualidad integer,
@descripcion varchar(100),
@estado char(1),
@monto smallmoney,
@montototal smallmoney,
@nodescuento char(1),
@descuento integer,
@cantidadmesualidades integer,
@idgestion integer
AS
    UPDATE detallemensualidad SET 
    descripcion = @descripcion, 
    estado = @estado, 
    monto = @monto, 
    montototal = @montototal, 
    nodescuento = @nodescuento, 
    descuento = @descuento, 
    cantidadmesualidades = @cantidadmesualidades, 
    idgestion = @idgestion 
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
CREATE OR ALTER PROCEDURE sp_AsignarBecaMejorEstudiante
    @idgestion_actual INT
AS
BEGIN
    SET NOCOUNT ON;
    
    DECLARE @mensaje VARCHAR(MAX) = '';
    DECLARE @becas_asignadas INT = 0;
    
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Obtener la gestión anterior
        DECLARE @gestion_anterior INT;
        SELECT TOP 1 @gestion_anterior = idgestion 
        FROM gestion 
        WHERE idgestion < @idgestion_actual 
        ORDER BY idgestion DESC;
        
        IF @gestion_anterior IS NULL
        BEGIN
            SET @mensaje = 'No se encontró gestión anterior';
            SELECT @mensaje as Mensaje, 0 as BecasAsignadas;
            ROLLBACK TRANSACTION;
            RETURN;
        END
        
        -- Crear beca si no existe
        DECLARE @codbeca_mejor INT;
        
        IF NOT EXISTS (SELECT 1 FROM beca WHERE nombrebeca = 'Beca Mejor Estudiante' AND tipobeca = '1')
        BEGIN
            INSERT INTO beca (nombrebeca, tipobeca, porcentaje)
            VALUES ('Beca Mejor Estudiante', '1', 100);
            
            SET @codbeca_mejor = SCOPE_IDENTITY();
        END
        ELSE
        BEGIN
            SELECT @codbeca_mejor = codbeca 
            FROM beca 
            WHERE nombrebeca = 'Beca Mejor Estudiante' AND tipobeca = '1';
        END
        
        -- Cursor para recorrer cada curso de la gestión anterior
        DECLARE @idcurso INT, @idnivel INT;
        DECLARE @ci_mejor VARCHAR(10);
        
        DECLARE cursor_cursos CURSOR FOR
            SELECT DISTINCT i.idcurso, i.idnivel
            FROM inscripcion i
            WHERE i.idgestion = @gestion_anterior;
        
        OPEN cursor_cursos;
        FETCH NEXT FROM cursor_cursos INTO @idcurso, @idnivel;
        
        WHILE @@FETCH_STATUS = 0
        BEGIN
            -- Encontrar al mejor estudiante del curso
            -- (Aquí asumimos que existe una tabla de notas o calificaciones)
            -- Por ahora, seleccionamos el primer estudiante como ejemplo
            -- En producción, esto debería basarse en promedios reales
            
            SELECT TOP 1 @ci_mejor = i.ci
            FROM inscripcion i
            WHERE i.idcurso = @idcurso 
              AND i.idnivel = @idnivel 
              AND i.idgestion = @gestion_anterior
            ORDER BY i.fecharegis; -- Cambiar por promedio de notas cuando esté disponible
            
            -- Verificar si el estudiante tiene inscripción en la gestión actual
            IF EXISTS (
                SELECT 1 FROM inscripcion 
                WHERE ci = @ci_mejor 
                  AND idgestion = @idgestion_actual
            )
            BEGIN
                -- Asignar beca a la inscripción actual
                UPDATE inscripcion 
                SET codbeca = @codbeca_mejor,
                    observaciones = 'Beca automática: Mejor estudiante del curso anterior'
                WHERE ci = @ci_mejor 
                  AND idgestion = @idgestion_actual;
                
                SET @becas_asignadas = @becas_asignadas + 1;
            END
            
            FETCH NEXT FROM cursor_cursos INTO @idcurso, @idnivel;
        END
        
        CLOSE cursor_cursos;
        DEALLOCATE cursor_cursos;
        
        COMMIT TRANSACTION;
        
        SET @mensaje = 'Becas asignadas exitosamente a los mejores estudiantes';
        SELECT @mensaje as Mensaje, @becas_asignadas as BecasAsignadas;
        
    END TRY
    BEGIN CATCH
        IF CURSOR_STATUS('global', 'cursor_cursos') >= 0
        BEGIN
            CLOSE cursor_cursos;
            DEALLOCATE cursor_cursos;
        END
        
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        
        DECLARE @error VARCHAR(MAX) = ERROR_MESSAGE();
        SELECT 'Error: ' + @error as Mensaje, 0 as BecasAsignadas;
    END CATCH
END
GO


CREATE OR ALTER PROCEDURE sp_AsignarBecaTercerHijo
    @idgestion_actual INT
AS
BEGIN
    SET NOCOUNT ON;
    
    DECLARE @mensaje VARCHAR(MAX) = '';
    DECLARE @becas_asignadas INT = 0;
    
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Crear beca si no existe
        DECLARE @codbeca_tercer INT;
        
        IF NOT EXISTS (SELECT 1 FROM beca WHERE nombrebeca = 'Beca Tercer Hijo' AND tipobeca = '2')
        BEGIN
            INSERT INTO beca (nombrebeca, tipobeca, porcentaje)
            VALUES ('Beca Tercer Hijo', '2', 100);
            
            SET @codbeca_tercer = SCOPE_IDENTITY();
        END
        ELSE
        BEGIN
            SELECT @codbeca_tercer = codbeca 
            FROM beca 
            WHERE nombrebeca = 'Beca Tercer Hijo' AND tipobeca = '2';
        END
        
        -- Cursor para recorrer tutores con 3 o más hijos
        DECLARE @citutor VARCHAR(10);
        DECLARE @ci_tercer_hijo VARCHAR(10);
        DECLARE @nivel_minimo INT;
        
        DECLARE cursor_tutores CURSOR FOR
            SELECT i.citutor, COUNT(*) as num_hijos
            FROM inscripcion i
            WHERE i.idgestion = @idgestion_actual
            GROUP BY i.citutor
            HAVING COUNT(*) >= 3;
        
        OPEN cursor_tutores;
        FETCH NEXT FROM cursor_tutores INTO @citutor;
        
        WHILE @@FETCH_STATUS = 0
        BEGIN
            -- Encontrar el nivel más bajo
            SELECT @nivel_minimo = MIN(i.idnivel)
            FROM inscripcion i
            WHERE i.citutor = @citutor 
              AND i.idgestion = @idgestion_actual;
            
            -- Obtener el tercer hijo (ordenado por fecha de registro)
            -- que esté en el nivel más bajo
            SELECT TOP 1 @ci_tercer_hijo = i.ci
            FROM (
                SELECT i.ci, i.idnivel, i.fecharegis,
                       ROW_NUMBER() OVER (ORDER BY i.fecharegis) as hijo_numero
                FROM inscripcion i
                WHERE i.citutor = @citutor 
                  AND i.idgestion = @idgestion_actual
            ) AS hijos
            WHERE hijo_numero >= 3 
              AND idnivel = @nivel_minimo
            ORDER BY hijo_numero;
            
            -- Asignar beca al tercer hijo en nivel más bajo
            IF @ci_tercer_hijo IS NOT NULL
            BEGIN
                UPDATE inscripcion 
                SET codbeca = @codbeca_tercer,
                    observaciones = 'Beca automática: Tercer hijo en nivel más bajo'
                WHERE ci = @ci_tercer_hijo 
                  AND idgestion = @idgestion_actual
                  AND idnivel = @nivel_minimo;
                
                SET @becas_asignadas = @becas_asignadas + 1;
                SET @ci_tercer_hijo = NULL; -- Reset para siguiente iteración
            END
            
            FETCH NEXT FROM cursor_tutores INTO @citutor;
        END
        
        CLOSE cursor_tutores;
        DEALLOCATE cursor_tutores;
        
        COMMIT TRANSACTION;
        
        SET @mensaje = 'Becas asignadas exitosamente a terceros hijos';
        SELECT @mensaje as Mensaje, @becas_asignadas as BecasAsignadas;
        
    END TRY
    BEGIN CATCH
        IF CURSOR_STATUS('global', 'cursor_tutores') >= 0
        BEGIN
            CLOSE cursor_tutores;
            DEALLOCATE cursor_tutores;
        END
        
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        
        DECLARE @error VARCHAR(MAX) = ERROR_MESSAGE();
        SELECT 'Error: ' + @error as Mensaje, 0 as BecasAsignadas;
    END CATCH
END
GO



CREATE OR ALTER PROCEDURE sp_EjecutarBecasAutomaticas
    @idgestion INT
AS
BEGIN
    SET NOCOUNT ON;
    
    DECLARE @total_becas INT = 0;
    DECLARE @becas_mejor INT = 0;
    DECLARE @becas_tercer INT = 0;
    
    -- Ejecutar beca mejor estudiante
    DECLARE @resultado_mejor TABLE (Mensaje VARCHAR(MAX), BecasAsignadas INT);
    INSERT INTO @resultado_mejor
    EXEC sp_AsignarBecaMejorEstudiante @idgestion;
    
    SELECT @becas_mejor = BecasAsignadas FROM @resultado_mejor;
    
    -- Ejecutar beca tercer hijo
    DECLARE @resultado_tercer TABLE (Mensaje VARCHAR(MAX), BecasAsignadas INT);
    INSERT INTO @resultado_tercer
    EXEC sp_AsignarBecaTercerHijo @idgestion;
    
    SELECT @becas_tercer = BecasAsignadas FROM @resultado_tercer;
    
    SET @total_becas = @becas_mejor + @becas_tercer;
    

    SELECT 
        'Becas automáticas ejecutadas exitosamente' as Mensaje,
        @total_becas as TotalBecas,
        @becas_mejor as BecasMejorEstudiante,
        @becas_tercer as BecasTercerHijo;
END
GO




