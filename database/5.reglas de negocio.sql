/* ========== REGLAS DE NEGOCIO - SISTEMA DE BECAS ========== */

/* ----- CAMBIAR CONTRASEÑA USUARIO -----------------*/
CREATE PROCEDURE sp_cambiarclaveusuario 
    @ci VARCHAR(10),
    @claveant VARCHAR(100),
    @clavenue VARCHAR(100) 
AS
BEGIN
    IF EXISTS (SELECT 1 FROM PERSONA WHERE ci = @ci AND contrasena = @claveant)
    BEGIN
        UPDATE PERSONA 
        SET contrasena = @clavenue 
        WHERE ci = @ci AND contrasena = @claveant
        
        IF @@ROWCOUNT > 0
            PRINT 'Contraseña actualizada exitosamente'
        ELSE
            PRINT 'Error: No se pudo actualizar la contraseña'
    END
    ELSE
        PRINT 'Error: Contraseña anterior incorrecta o usuario no existe'
END
GO

/* ----- VALIDAR POSTULACIÓN A CONVOCATORIA ---------------*/
CREATE PROCEDURE sp_ValidarPostulacion 
    @ci VARCHAR(10),
    @idconvocatoria INT
AS
BEGIN
    DECLARE @estado_convocatoria CHAR(1)
    DECLARE @fecha_actual DATE = GETDATE()
    DECLARE @fechafin DATE
    
    -- Verificar si la convocatoria está activa
    SELECT @estado_convocatoria = estado, @fechafin = fechafin 
    FROM CONVOCATORIA 
    WHERE idconvocatoria = @idconvocatoria
    
    IF @estado_convocatoria = '0'
        RAISERROR('La convocatoria no está activa', 16, 1)
    ELSE IF @fecha_actual > @fechafin
        RAISERROR('La convocatoria ha finalizado', 16, 1)
    ELSE
        PRINT 'Postulación válida'
END
GO

/* ----- ACTUALIZAR ESTADO POSTULACIÓN ---------------*/
CREATE PROCEDURE sp_ActualizarEstadoPostulacion 
    @idpostulacion INT,
    @nuevo_estado CHAR(1)
AS
BEGIN
    BEGIN TRY
        BEGIN TRANSACTION
        
        DECLARE @estado_actual CHAR(1)
        
        -- Obtener estado actual
        SELECT @estado_actual = estado 
        FROM POSTULACION 
        WHERE idpostulacion = @idpostulacion
        
        -- Validar cambio de estado
        IF @estado_actual = '4' AND @nuevo_estado != '4'
            RAISERROR('No se puede modificar una postulación finalizada', 16, 1)
        
        -- Actualizar estado
        UPDATE POSTULACION 
        SET estado = @nuevo_estado 
        WHERE idpostulacion = @idpostulacion
        
        -- Registrar en historial
        INSERT INTO HISTORIALESTADO (idhistorialestado, estadoanterior, estadonuevo, fechacambio, idpostulacion)
        SELECT ISNULL(MAX(idhistorialestado), 0) + 1, @estado_actual, @nuevo_estado, GETDATE(), @idpostulacion
        FROM HISTORIALESTADO
        
        COMMIT TRANSACTION
        PRINT 'Estado actualizado exitosamente'
    END TRY
    BEGIN CATCH
        ROLLBACK TRANSACTION
        RAISERROR('Error al actualizar el estado de la postulación', 16, 1)
    END CATCH
END
GO


/* ----- ASIGNAR BECA AUTOMÁTICA ---------------*/
CREATE PROCEDURE sp_AsignarBecaAutomatica 
    @idpostulacion INT
AS
BEGIN
    BEGIN TRY
        BEGIN TRANSACTION
        
        DECLARE @ci_estudiante VARCHAR(10)
        DECLARE @idtipobeca INT
        DECLARE @codbeca INT
        
        -- Obtener datos del estudiante y tipo de beca
        SELECT @ci_estudiante = p.ci, @idtipobeca = c.idtipobeca
        FROM POSTULACION p
        INNER JOIN CONVOCATORIA c ON p.idconvocatoria = c.idconvocatoria
        WHERE p.idpostulacion = @idpostulacion
        
        -- Verificar si cumple requisitos
        EXEC sp_VerificarRequisitosObligatorios @idpostulacion
        
        -- Asignar código de beca (simulado)
        SET @codbeca = @idtipobeca * 1000 + @idpostulacion
        
        -- Actualizar estado a "Beca Asignada"
        EXEC sp_ActualizarEstadoPostulacion @idpostulacion, '3'
        
        PRINT 'Beca asignada automáticamente al estudiante: ' + @ci_estudiante
        PRINT 'Código de beca: ' + CAST(@codbeca AS VARCHAR)
        
        COMMIT TRANSACTION
    END TRY
    BEGIN CATCH
        ROLLBACK TRANSACTION
        RAISERROR('Error al asignar beca automática', 16, 1)
    END CATCH
END
GO

/* ----- GENERAR REPORTE POSTULACIONES ---------------*/
CREATE PROCEDURE sp_GenerarReportePostulaciones 
    @idconvocatoria INT
AS
BEGIN
    SELECT 
        p.idpostulacion,
        per.ci,
        per.nombre + ' ' + per.apellido AS estudiante,
        c.nombre AS carrera,
        p.estado,
        p.fechapostulacion,
        COUNT(d.iddocumento) AS documentos_subidos,
        SUM(CASE WHEN d.validado = '1' THEN 1 ELSE 0 END) AS documentos_validados
    FROM POSTULACION p
    INNER JOIN PERSONA per ON p.ci = per.ci
    INNER JOIN CARRERA c ON p.idcarrera = c.idcarrera
    LEFT JOIN DOCUMENTO d ON p.idpostulacion = d.idpostulacion
    WHERE p.idconvocatoria = @idconvocatoria
    GROUP BY p.idpostulacion, per.ci, per.nombre, per.apellido, c.nombre, p.estado, p.fechapostulacion
    ORDER BY p.fechapostulacion DESC
END
GO

/* ----- CERRAR CONVOCATORIA AUTOMÁTICA ---------------*/
CREATE PROCEDURE sp_CerrarConvocatoriasVencidas 
AS
BEGIN
    UPDATE CONVOCATORIA 
    SET estado = '0' 
    WHERE fechafin < GETDATE() 
    AND estado = '1'
    
    PRINT 'Convocatorias vencidas cerradas: ' + CAST(@@ROWCOUNT AS VARCHAR)
END
GO

/* ----- VALIDAR UNICIDAD POSTULACIÓN ---------------*/
CREATE PROCEDURE sp_ValidarUnicidadPostulacion 
    @ci VARCHAR(10),
    @idconvocatoria INT
AS
BEGIN
    IF EXISTS (
        SELECT 1 FROM POSTULACION 
        WHERE ci = @ci AND idconvocatoria = @idconvocatoria
    )
        RAISERROR('El estudiante ya tiene una postulación para esta convocatoria', 16, 1)
    ELSE
        PRINT 'Postulación única válida'
END
GO