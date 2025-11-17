-- VERIFICAR INDICES CREADOS
USE COLEGIO;
GO

-- Ver todos los índices creados en las tablas
SELECT 
    t.name AS Tabla,
    i.name AS Indice,
    i.type_desc AS Tipo,
    COL_NAME(ic.object_id, ic.column_id) AS Columna
FROM sys.indexes i
INNER JOIN sys.tables t ON i.object_id = t.object_id
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
WHERE t.name IN ('inscripcion', 'mensualidad', 'maestromater', 'materia', 'detallemensualidad')
  AND i.name IS NOT NULL
ORDER BY t.name, i.name, ic.key_ordinal;

-- Contar índices por tabla
SELECT 
    t.name AS Tabla,
    COUNT(DISTINCT i.name) AS TotalIndices
FROM sys.indexes i
INNER JOIN sys.tables t ON i.object_id = t.object_id
WHERE t.name IN ('inscripcion', 'mensualidad', 'maestromater', 'materia', 'detallemensualidad')
  AND i.name IS NOT NULL
  AND i.name LIKE 'idx_%'
GROUP BY t.name
ORDER BY t.name;
