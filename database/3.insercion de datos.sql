USE BecasBD
GO

-- Insertar datos en 'PERSONA'
INSERT INTO PERSONA (ci, nombre, apellido, telefono, sexo, correo, tipou, tipoa, tipoe, contrasena, codigo, nroregistro) 
VALUES 
('1234567', 'María', 'Gonzales', '7771234', 'F', 'maria@universidad.edu', '1', '0', '1', 'pass123', NULL, '222103302'),
('7654321', 'Carlos', 'López', '7775678', 'M', 'carlos@universidad.edu', '1', '0', '1', 'pass456', NULL, '223113174'),
('1122334', 'Ana', 'Martínez', '7779012', 'F', 'ana@universidad.edu', '1', '0', '1', 'pass789', NULL, '223113200'),
('4455667', 'Juan', 'Pérez', '7773456', 'M', 'juan@universidad.edu', '1', '1', '0', 'pass101', '4444', NULL),
('8899001', 'Laura', 'Rodríguez', '7777890', 'F', 'laura@universidad.edu', '1', '0', '1', 'pass202', NULL, '223113700')

-- Insertar datos en 'CARRERA'
INSERT INTO CARRERA (idcarrera, plancarrera, codigo, nombre) 
VALUES 
(1, '187', '4', 'Ingeniería de Sistemas'),
(2, '183', '3', 'Ingeniería Civil'),
(3, '019', '5', 'Administración de Empresas'),
(4, '021', '7', 'Medicina General'),
(5, '020', '8', 'Derecho')

-- Insertar datos en 'SEMESTRE'
INSERT INTO SEMESTRE (idsemestre, año, periodo, descripcion) 
VALUES 
(1, 2024, '1', 'Semestre Enero-Junio 2024'),
(2, 2024, '2', 'Semestre Agosto-Diciembre 2024'),
(3, 2023, '1', 'Semestre Enero-Junio 2023'),
(4, 2023, '2', 'Semestre Agosto-Diciembre 2023'),
(5, 2025, '1', 'Semestre Enero-Junio 2025')

-- Insertar datos en 'TIPOBECA'
INSERT INTO TIPOBECA (idtipobeca, nombre, descripcion) 
VALUES 
(1, 'Beca Excelencia', 'Beca para estudiantes con alto rendimiento académico'),
(2, 'Beca Socioeconómica', 'Beca para estudiantes con dificultades económicas'),
(3, 'Beca Deportiva', 'Beca para estudiantes destacados en deportes'),
(4, 'Beca Cultural', 'Beca para estudiantes destacados en actividades culturales'),
(5, 'Beca Investigación', 'Beca para estudiantes involucrados en proyectos de investigación')

-- Insertar datos en 'CONVOCATORIA'
INSERT INTO CONVOCATORIA (idconvocatoria, titulo, descripcion, fechainicio, fechafin, estado, idtipobeca) 
VALUES 
(1, 'Convocatoria Beca Excelencia 2024', 'Convocatoria para becas de excelencia académica', '2024-01-15', '2024-02-28', '1', 1),
(2, 'Convocatoria Beca Socioeconómica 2024', 'Convocatoria para becas socioeconómicas', '2024-03-01', '2024-04-15', '1', 2),
(3, 'Convocatoria Beca Deportiva 2024', 'Convocatoria para becas deportivas', '2024-02-01', '2024-03-31', '0', 3),
(4, 'Convocatoria Beca Cultural 2024', 'Convocatoria para becas culturales', '2024-04-01', '2024-05-31', '1', 4)

-- Insertar datos en 'REQUISITO'
INSERT INTO REQUISITO (idrequisito, descripcion, obligatorio, idtipobeca) 
VALUES 
(1, 'Certificado de notas del último semestre', 1, 1),
(2, 'Carta de recomendación del director de carrera', 1, 1),
(3, 'Formulario de solicitud de beca', 1, 1),
(4, 'Certificado de situación económica', 1, 2),
(5, 'Certificado de participación deportiva', 1, 3),
(6, 'Certificado de participación cultural', 1, 4),
(7, 'Carta de motivación', 0, 1),
(8, 'Certificado de nacimiento', 1, 2)

-- Insertar datos en 'POSTULACION'
INSERT INTO POSTULACION (idpostulacion, fechapostulacion, estado, idconvocatoria, idcarrrera, ci, idsemestre) 
VALUES 
(1, '2024-02-10', '1', 1, 1, '1234567', 1),
(2, '2024-02-12', '2', 1, 2, '7654321', 1),
(3, '2024-03-05', '3', 2, 3, '1122334', 1),
(4, '2024-02-20', '4', 1, 1, '8899001', 1),
(5, '2024-03-10', '1', 2, 4, '7654321', 1)

-- Insertar datos en 'HISTORIALESTADO'
INSERT INTO HISTORIALESTADO (idhistorialestado, estadoanterior, estadonuevo, fechacambio, idpostulacion) 
VALUES 
(1, '2', '1', '2024-02-11', 1),
(2, '1', '3', '2024-03-06', 3),
(3, '2', '4', '2024-02-25', 4),
(4, '2', '1', '2024-03-11', 5),
(5, '1', '3', '2024-03-12', 5)

-- Insertar datos en 'DOCUMENTO'
INSERT INTO DOCUMENTO (iddocumento, tipodocumento, nombrearchivo, rutaarchivo, validado, idpostulacion, idrequisito) 
VALUES 
(1, 'PDF', 'certificado_notas_1234567.pdf', '/documentos/certificados/1234567.pdf', 1, 1, 1),
(2, 'PDF', 'carta_recomendacion_1234567.pdf', '/documentos/cartas/1234567.pdf', 1, 1, 2),
(3, 'PDF', 'formulario_solicitud_1234567.pdf', '/documentos/formularios/1234567.pdf', 1, 1, 3),
(4, 'PDF', 'certificado_economico_1122334.pdf', '/documentos/certificados/1122334.pdf', 1, 3, 4),
(5, 'PDF', 'carta_motivacion_1122334.pdf', '/documentos/cartas/1122334.pdf', 0, 3, 7),
(6, 'PDF', 'certificado_notas_7654321.pdf', '/documentos/certificados/7654321.pdf', 1, 2, 1),
(7, 'PDF', 'certificado_notas_8899001.pdf', '/documentos/certificados/8899001.pdf', 1, 4, 1)