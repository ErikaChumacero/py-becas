USE BecasBD;
GO

-- RESTRICCIONES FOREIGN KEYS 
-- Relación POSTULACION -> PERSONA
ALTER TABLE POSTULACION
ADD CONSTRAINT fk_postulacion_persona
FOREIGN KEY (ci) REFERENCES PERSONA(ci)
ON UPDATE CASCADE;

-- Relación POSTULACION -> CARRERA
ALTER TABLE POSTULACION
ADD CONSTRAINT fk_postulacion_carrera
FOREIGN KEY (idcarrera) REFERENCES CARRERA(idcarrera)
ON UPDATE CASCADE;

-- Relación POSTULACION -> SEMESTRE
ALTER TABLE POSTULACION
ADD CONSTRAINT fk_postulacion_semestre
FOREIGN KEY (idsemestre) REFERENCES SEMESTRE(idsemestre)
ON UPDATE CASCADE;

-- Relación POSTULACION -> CONVOCATORIA
ALTER TABLE POSTULACION
ADD CONSTRAINT fk_postulacion_convocatoria
FOREIGN KEY (idconvocatoria) REFERENCES CONVOCATORIA(idconvocatoria)
ON UPDATE CASCADE;

-- Relación HISTORIALESTADO -> POSTULACION
ALTER TABLE HISTORIALESTADO
ADD CONSTRAINT fk_historialestado_postulacion
FOREIGN KEY (idpostulacion) REFERENCES POSTULACION(idpostulacion)
ON UPDATE CASCADE;

-- Relación DOCUMENTO -> POSTULACION
ALTER TABLE DOCUMENTO
ADD CONSTRAINT fk_documento_postulacion
FOREIGN KEY (idpostulacion) REFERENCES POSTULACION(idpostulacion)
ON UPDATE CASCADE;

-- Relación DOCUMENTO -> REQUISITO
ALTER TABLE DOCUMENTO
ADD CONSTRAINT fk_documento_requisito
FOREIGN KEY (idrequisito) REFERENCES REQUISITO(idrequisito)
ON UPDATE CASCADE;

-- Relación CONVOCATORIA -> TIPOBECA
ALTER TABLE CONVOCATORIA
ADD CONSTRAINT fk_convocatoria_tipobeca
FOREIGN KEY (idtipobeca) REFERENCES TIPOBECA(idtipobeca)
ON UPDATE CASCADE;

-- Relación REQUISITO -> TIPOBECA
ALTER TABLE REQUISITO
ADD CONSTRAINT fk_requisito_tipobeca
FOREIGN KEY (idtipobeca) REFERENCES TIPOBECA(idtipobeca)
ON UPDATE CASCADE;

--RESTRICCIONES CHECK 
-- PERSONA: tipos válidos (solo 1=Activo, 0=Inactivo en cada caso)
ALTER TABLE PERSONA
ADD CONSTRAINT ch_persona_tipou
CHECK (tipou IN ('0','1'));

ALTER TABLE PERSONA
ADD CONSTRAINT ch_persona_tipoa
CHECK (tipoa IN ('0','1'));

ALTER TABLE PERSONA
ADD CONSTRAINT ch_persona_tipoe
CHECK (tipoe IN ('0','1'));

-- PERSONA: sexo válido
ALTER TABLE PERSONA
ADD CONSTRAINT ch_persona_sexo
CHECK (sexo IN ('M','F'));

-- CONVOCATORIA: fechas válidas (fechafin mayor que fechainicio)
ALTER TABLE CONVOCATORIA
ADD CONSTRAINT ch_convocatoria_fechas
CHECK (fechafin > fechainicio);

-- CONVOCATORIA: estado válido
ALTER TABLE CONVOCATORIA
ADD CONSTRAINT ch_convocatoria_estado
CHECK (estado IN ('1','0'));

-- POSTULACION: estado válido
ALTER TABLE POSTULACION
ADD CONSTRAINT ch_postulacion_estado
CHECK (estado IN ('1','2','3','4'));

-- HISTORIALESTADO: estados válidos
ALTER TABLE HISTORIALESTADO
ADD CONSTRAINT ch_historialestado_estados
CHECK (estadoanterior IN ('1','2','3','4') AND estadonuevo IN ('1','2','3','4'));


--RESTRICCIONES DEFAULT CONSTRAINT
-- PERSONA: valores por defecto para tipos
ALTER TABLE PERSONA
ADD CONSTRAINT df_persona_tipou 
DEFAULT '1' FOR tipou;

ALTER TABLE PERSONA
ADD CONSTRAINT df_persona_tipoa 
DEFAULT '0' FOR tipoa;

ALTER TABLE PERSONA
ADD CONSTRAINT df_persona_tipoe 
DEFAULT '0' FOR tipoe;

-- DOCUMENTO: validado por defecto false
ALTER TABLE DOCUMENTO
ADD CONSTRAINT df_documento_validado 
DEFAULT '0' FOR validado;

-- REQUISITO: obligatorio por defecto true
ALTER TABLE REQUISITO
ADD CONSTRAINT df_requisito_obligatorio 
DEFAULT '1' FOR obligatorio;

-- HISTORIALESTADO: fecha actual por defecto
ALTER TABLE HISTORIALESTADO
ADD CONSTRAINT df_historialestado_fechacambio 
DEFAULT GETDATE() FOR fechacambio;