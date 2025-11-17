-- INDICES PARA MEJORAR PERFORMANCE
USE COLEGIO;
GO

-- Índices para tabla inscripcion
CREATE INDEX idx_inscripcion_ci ON inscripcion(ci);
CREATE INDEX idx_inscripcion_citutor ON inscripcion(citutor);
CREATE INDEX idx_inscripcion_idgestion ON inscripcion(idgestion);
CREATE INDEX idx_inscripcion_codbeca ON inscripcion(codbeca);

-- Índices para tabla mensualidad
CREATE INDEX idx_mensualidad_ci ON mensualidad(ci);
CREATE INDEX idx_mensualidad_iddetallemensualidad ON mensualidad(iddetallemensualidad);

-- Índices para tabla maestromater
CREATE INDEX idx_maestromater_ci ON maestromater(ci);
CREATE INDEX idx_maestromater_idmateria ON maestromater(idmateria);
CREATE INDEX idx_maestromater_idgestion ON maestromater(idgestion);

-- Índices para tabla materia
CREATE INDEX idx_materia_idcurso_idnivel ON materia(idcurso, idnivel);

-- Índices para tabla detallemensualidad
CREATE INDEX idx_detallemensualidad_idgestion ON detallemensualidad(idgestion);