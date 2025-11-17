
USE COLEGIO
GO

-- Insertar datos en 'nivel'
INSERT INTO nivel (descripcion) VALUES ('Inicial')
INSERT INTO nivel (descripcion) VALUES ('Primaria')
INSERT INTO nivel (descripcion) VALUES ('Secundaria')

-- Insertar datos en 'curso'
INSERT INTO curso (idnivel, descripcion) VALUES (1, 'Kinder')
INSERT INTO curso (idnivel, descripcion) VALUES (2, '1ro A')
INSERT INTO curso (idnivel, descripcion) VALUES (2, '2do A')
INSERT INTO curso (idnivel, descripcion) VALUES (2, '3ro A')
INSERT INTO curso (idnivel, descripcion) VALUES (2, '4to A')
INSERT INTO curso (idnivel, descripcion) VALUES (2, '5to A')
INSERT INTO curso (idnivel, descripcion) VALUES (2, '6to A')
INSERT INTO curso (idnivel, descripcion) VALUES (3, '1ro A')
INSERT INTO curso (idnivel, descripcion) VALUES (3, '2do A')  
INSERT INTO curso (idnivel, descripcion) VALUES (3, '3ro A')
INSERT INTO curso (idnivel, descripcion) VALUES (3, '4to A')
INSERT INTO curso (idnivel, descripcion) VALUES (3, '5to A')

-- Insertar datos en 'gestion'
INSERT INTO gestion (detalleges, observacion, fechaapertura, fechacierre, estado) 
VALUES ('Gestión 2024', 'Inicio de año académico', '2024-02-01', '2024-11-30', '1')

-- Insertar datos en 'beca'
INSERT INTO beca (nombrebeca, tipobeca, porcentaje) VALUES ('Beca Excelencia', 'A', '100')
INSERT INTO beca (nombrebeca, tipobeca, porcentaje) VALUES ('Beca Tercer Hermano', 'B', '100')

-- Insertar datos en 'persona' (Estudiantes y Maestros)
INSERT INTO persona (ci, nombre, apellido, telefono, fecharegistro, correo, tipou, tipoe, tipot, tipom, tipoa, contrasena, codestudiante, codmaestro) 
VALUES 
('1234567', 'sofia', 'Pérez', '7771234', '2024-01-10', 'sofia@colegio.edu', '1', '1', '0', '0', '0', 'pass123', 'EST001', NULL),
('7654321', 'lucas', 'López', '7775678', '2024-01-10', 'lucas@colegio.edu', '1', '0', '1', '0', '0', 'pass456', NULL, 'PROF001'),
('1122334', 'Carlos', 'García', '7779012', '2024-01-10', 'carlos@colegio.edu', '1', '0', '0', '1', '0', 'pass789', 'EST002', NULL)

-- Insertar datos en 'materia'
INSERT INTO materia (sigla, descripcion, idcurso, idnivel) 
VALUES 
('GEN101', 'GENERAL', 1, 1),
('LEN202', 'Lenguaje y Comunicación', 2, 2),
('MAT303', 'Matemáticas', 2, 2),
('CIE202', 'Ciencias Naturales', 2, 2),
('HIS202', 'Ciencias Sociales', 2, 2),
('GEO202', 'Educación Musical', 2, 2),
('EDU202', 'Educación Física', 2, 2),
('LEN303', 'Lenguaje y Comunicación', 8, 3),
('MAT303', 'Matemáticas', 8, 3),
('CIE303', 'Ciencias Naturales', 8, 3),
('HIS303', 'Ciencias Sociales', 8, 3),
('GEO303', 'Educación Musical', 8, 3),
('EDU303', 'Educación Física', 8, 3),
('ART404', 'Artes Plásticas', 8, 3)

-- Insertar datos en 'inscripcion'
INSERT INTO inscripcion (ci, idcurso, idnivel, observaciones, fecharegis, citutor, idgestion, codbeca) 
VALUES 
('1234567', 1, 1, 'Inscripción regular', '2024-01-15', '7654321', 1, NULL),
('1122334', 2, 2, 'Inscripción con beca', '2024-01-16', '7654321', 1, 1)

-- Insertar datos en 'detallemensualidad'
INSERT INTO detallemensualidad (descripcion, estado, monto, montototal, nodescuento, descuento) 
VALUES 
('Mensualidad Febrero', '1', 480.00, 480.00, '0', 0),
('Mensualidad Marzo', '1', 480.00, 480.00, '1', 10)

-- Insertar datos en 'mensualidad'
INSERT INTO mensualidad (fechamen, observacion, tipopago, iddetallemensualidad, ci, idcurso, idnivel) 
VALUES 
('2024-01-05', 'Pago completo', 'E', 1, '1234567', 1, 1),
('2024-02-05', 'Pago con descuento', 'Q', 2, '1122334', 2, 2)

-- Insertar datos en 'maestromater'
INSERT INTO maestromater (ci, idmateria, fecharegis, observacion, idgestion, idcurso, idnivel, asesor) 
VALUES 
('7654321', 17, '2024-01-10', 'Asignación regular', 1, 1, 1, '0'),
('7654321', 20, '2024-01-10', 'Asignación adicional', 1, 2, 2, '1')


