-- Script para actualizar todos los correos a @escuelacristiana.edu.bo
-- Ejecutar en SQL Server Management Studio

USE COLEGIO;
GO

-- Actualizar correos de todas las personas
-- Genera correo basado en nombre.apellido@escuelacristiana.edu.bo

UPDATE persona
SET correo = LOWER(
    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
        REPLACE(nombre, ' ', '') + '.' + REPLACE(apellido, ' ', '')
    , 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')
    + '@escuelacristiana.edu.bo'
)
WHERE correo NOT LIKE '%@escuelacristiana.edu.bo';

-- Verificar los cambios
SELECT ci, nombre, apellido, correo 
FROM persona 
ORDER BY nombre;

GO

-- Si hay duplicados, agregar números
-- Este script maneja duplicados agregando un número al final

DECLARE @ci VARCHAR(10);
DECLARE @nombre VARCHAR(100);
DECLARE @apellido VARCHAR(100);
DECLARE @correoBase VARCHAR(200);
DECLARE @correoFinal VARCHAR(200);
DECLARE @contador INT;

DECLARE cursor_personas CURSOR FOR
SELECT ci, nombre, apellido FROM persona;

OPEN cursor_personas;

FETCH NEXT FROM cursor_personas INTO @ci, @nombre, @apellido;

WHILE @@FETCH_STATUS = 0
BEGIN
    -- Generar correo base
    SET @correoBase = LOWER(
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            REPLACE(@nombre, ' ', '') + '.' + REPLACE(@apellido, ' ', '')
        , 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')
    );
    
    SET @correoFinal = @correoBase + '@escuelacristiana.edu.bo';
    SET @contador = 2;
    
    -- Verificar si ya existe (excluyendo el registro actual)
    WHILE EXISTS (SELECT 1 FROM persona WHERE correo = @correoFinal AND ci != @ci)
    BEGIN
        SET @correoFinal = @correoBase + CAST(@contador AS VARCHAR) + '@escuelacristiana.edu.bo';
        SET @contador = @contador + 1;
    END
    
    -- Actualizar el correo
    UPDATE persona SET correo = @correoFinal WHERE ci = @ci;
    
    FETCH NEXT FROM cursor_personas INTO @ci, @nombre, @apellido;
END

CLOSE cursor_personas;
DEALLOCATE cursor_personas;

-- Verificar resultado final
SELECT ci, nombre, apellido, correo 
FROM persona 
ORDER BY correo;

PRINT 'Correos actualizados exitosamente';
GO
