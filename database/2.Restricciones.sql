-- restricciones
USE COLEGIO;
GO

-- RESTRICCIONES FOREIGNN KEYS 
-- Relación curso ? nivel
ALTER TABLE curso
ADD CONSTRAINT fk_curso_nivel
FOREIGN KEY (idnivel) REFERENCES nivel(idnivel)
ON UPDATE CASCADE;
GO
-- Relación materia ? curso
ALTER TABLE materia
ADD CONSTRAINT fk_materia_curso
FOREIGN KEY (idcurso, idnivel) REFERENCES curso(idcurso,idnivel)
ON UPDATE CASCADE;

-- Relación inscripcion ? persona (estudiante)
ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_estudiante
FOREIGN KEY (ci) REFERENCES persona(ci);

-- Relación inscripcion ? persona (tutor)
ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_tutor
FOREIGN KEY (citutor) REFERENCES persona(ci);

-- Relación inscripcion ? curso
ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_curso
FOREIGN KEY (idcurso, idnivel) REFERENCES curso(idcurso, idnivel)
ON UPDATE CASCADE;

-- Relación inscripcion ? gestion
ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_gestion
FOREIGN KEY (idgestion) REFERENCES gestion(idgestion)
ON UPDATE CASCADE;

-- Relación inscripcion ? beca
ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_beca
FOREIGN KEY (codbeca) REFERENCES beca(codbeca)
ON UPDATE CASCADE;

-- Relación mensualidad ? detallemensualidad
ALTER TABLE mensualidad
ADD CONSTRAINT fk_mensualidad_detalle
FOREIGN KEY (iddetallemensualidad) REFERENCES detallemensualidad(iddetallemensualidad)
ON UPDATE CASCADE;

-- Relación mensualidad ? persona (estudiante)
ALTER TABLE mensualidad
ADD CONSTRAINT fk_mensualidad_estudiante
FOREIGN KEY (ci) REFERENCES persona(ci)
ON UPDATE CASCADE;

-- Relación mensualidad ? curso
ALTER TABLE mensualidad
ADD CONSTRAINT fk_mensualidad_curso
FOREIGN KEY (idcurso,idnivel) REFERENCES curso(idcurso,idnivel)
ON UPDATE CASCADE;

ALTER TABLE detallemensualidad
ADD CONSTRAINT fk_detallemensualidad_gestion
FOREIGN KEY (idgestion) REFERENCES gestion(idgestion)  
ON UPDATE CASCADE;

ALTER TABLE detallemensualidad
ADD CONSTRAINT fk_detallemensualidad_nivel
FOREIGN KEY (idnivel) REFERENCES nivel(idnivel)  
ON UPDATE CASCADE;

-- Relación maestromater ? materia
ALTER TABLE maestromater
ADD CONSTRAINT fk_maestromater_materia
FOREIGN KEY (idmateria) REFERENCES materia(idmateria)
ON UPDATE CASCADE;

-- Relación maestromater ? curso
ALTER TABLE maestromater
ADD CONSTRAINT fk_maestromater_curso
FOREIGN KEY (idcurso,idnivel) REFERENCES curso(idcurso,idnivel)
ON UPDATE NO ACTION;

-- Relación maestromater ? gestion
ALTER TABLE maestromater
ADD CONSTRAINT fk_maestromater_gestion
FOREIGN KEY (idgestion) REFERENCES gestion(idgestion)
ON UPDATE CASCADE;

-- Relación maestromater ? persona (maestro)
ALTER TABLE maestromater
ADD CONSTRAINT fk_maestromater_maestro
FOREIGN KEY (ci) REFERENCES persona(ci)
ON UPDATE CASCADE;

--RESTRICCIONES CHECK 
-- Persona: tipos válidos (solo 1=Activo, 0=Inactivo en cada caso por ejemplo)
ALTER TABLE persona
ADD CONSTRAINT ch_persona_sexo
CHECK (sexo IN ('M', 'F'));

ALTER TABLE persona
ADD CONSTRAINT ch_persona_tipou
CHECK (tipou IN (1,0));

ALTER TABLE personas
ADD CONSTRAINT ch_persona_tipoe
CHECK (tipoe IN (1,0));

ALTER TABLE persona
ADD CONSTRAINT ch_persona_tipot
CHECK (tipot IN (1,0));

ALTER TABLE persona
ADD CONSTRAINT ch_persona_tipom
CHECK (tipom IN (1,0));

ALTER TABLE persona
ADD CONSTRAINT ch_persona_tipoa
CHECK (tipoa IN (1,0));

-- Gestion: estado 1=Abierto, 0=Cerrado
ALTER TABLE gestion
ADD CONSTRAINT ch_gestion_estado
CHECK (estado IN (1,0));

-- Detallemensualidad: no puede haber descuento negativo
ALTER TABLE detallemensualidad
ADD CONSTRAINT ch_detallemensualidad_descuento
CHECK (descuento >= 0 AND monto >= 0 AND montototal >= 0);
--Check faltante detallemensualidad prueba--
ALTER TABLE detallemensualidad
ADD CONSTRAINT ch_detallemensualidad_estado
CHECK (estado IN ('0','1'));
--Check faltante detallemensualidad prueba--
ALTER TABLE detallemensualidad
ADD CONSTRAINT ch_detallemensualidad_nodescuento
CHECK (nodescuento IN ('0','1'));

-- Mensualidad: tipo de pago válido (E=Efectivo, Q=QR)
ALTER TABLE mensualidad
ADD CONSTRAINT ch_mensualidad_tipopago
CHECK (tipopago IN ('E','Q'));
--Check faltante maestromater prueba--
ALTER TABLE maestromater
ADD CONSTRAINT ch_maestromater_asesor
CHECK (asesor IN ('0','1'));
--Check faltante validar tutor es diferente que estudiante prueba--
ALTER TABLE inscripcion
ADD CONSTRAINT ch_inscripcion_tutor_diferente
CHECK (ci <> citutor);
-- Beca: porcentaje válido
ALTER TABLE beca
ADD CONSTRAINT ch_beca_porcentaje
CHECK (porcentaje >= 0 AND porcentaje <= 100);
--Check faltante beca prueba--
ALTER TABLE beca
ADD CONSTRAINT ch_beca_tipobeca
CHECK (tipobeca IN ('1','2','A','B','C','D'));

--RESTRICCIONES DEFAULT CONSTRAINT
-- Persona: contraseñas nunca vacías, correos obligatorios (ya están not null)
-- podríamos poner estado activo por defecto en los flags
ALTER TABLE persona
ADD CONSTRAINT df_persona_tipou 
DEFAULT 1 FOR tipou;

ALTER TABLE persona
ADD CONSTRAINT df_persona_tipoe 
DEFAULT 0 FOR tipoe;

ALTER TABLE persona
ADD CONSTRAINT df_persona_tipot 
DEFAULT 0 FOR tipot;

ALTER TABLE persona
ADD CONSTRAINT df_persona_tipom 
DEFAULT 0 FOR tipom;

ALTER TABLE persona
ADD CONSTRAINT df_persona_tipoa 
DEFAULT 0 FOR tipoa;

-- Gestion: estado abierto por defecto
ALTER TABLE gestion
ADD CONSTRAINT df_gestion_estado 
DEFAULT 1 FOR estado;

-- Detallemensualidad: sin descuento por defecto
ALTER TABLE detallemensualidad
ADD CONSTRAINT df_detallemensualidad_descuento 
DEFAULT 0 FOR descuento;
--default faltante detallemensualidad prueba--
ALTER TABLE detallemensualidad
ADD CONSTRAINT df_detallemensualidad_estado 
DEFAULT '1' FOR estado;
--default faltante detallemensualidad prueba--
ALTER TABLE detallemensualidad
ADD CONSTRAINT df_detallemensualidad_nodescuento 
DEFAULT '0' FOR nodescuento;
-- Beca: porcentaje inicial 0
ALTER TABLE beca
ADD CONSTRAINT df_beca_porcentaje 
DEFAULT 0 FOR porcentaje;
--default faltante maestromater prueba--
ALTER TABLE maestromater
ADD CONSTRAINT df_maestromater_asesor
DEFAULT 0 FOR asesor;