CREATE TABLE profesores (
    cod_profesor VARCHAR(5) NOT NULL, 
    contraseña VARCHAR(5) NOT NULL, 
    nombre VARCHAR(20) NOT NULL, 
    apellido VARCHAR(20) NOT NULL, 
    PRIMARY KEY (cod_profesor)
);

CREATE TABLE estudiantes (
    cod_estudiante VARCHAR(5) NOT NULL, 
    nombre VARCHAR(20) NOT NULL, 
    apellido VARCHAR(20) NOT NULL, 
    PRIMARY KEY (cod_estudiante)
);

CREATE TABLE cursos (
    cod_curso VARCHAR(3) NOT NULL, 
    nombre VARCHAR(20) NOT NULL, 
    cod_profesor VARCHAR(5) NOT NULL, 
    PRIMARY KEY (cod_curso),
    CONSTRAINT fk_cod_profesor FOREIGN KEY (cod_profesor) REFERENCES profesores(cod_profesor)
);

CREATE TABLE inscripciones (
    cod_curso VARCHAR(3) NOT NULL,
    cod_estudiante VARCHAR(5) NOT NULL,
    año VARCHAR(4) NOT NULL,
    periodo VARCHAR(2) NOT NULL,
    PRIMARY KEY (cod_curso, cod_estudiante, año, periodo),
    CONSTRAINT fk_cod_curso FOREIGN KEY (cod_curso) REFERENCES cursos(cod_curso),
    CONSTRAINT fk_cod_estudiante FOREIGN KEY (cod_estudiante) REFERENCES estudiantes(cod_estudiante)
);

CREATE TABLE notas (
    cod_nota SERIAL NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    porcentaje INTEGER NOT NULL,
    cod_curso VARCHAR(3) NOT NULL,
    año VARCHAR(4) NOT NULL,
    periodo VARCHAR(2) NOT NULL,
    PRIMARY KEY (cod_nota),
    CONSTRAINT fk_cod_curso FOREIGN KEY (cod_curso) REFERENCES cursos(cod_curso)
);

CREATE TABLE calificaciones (
    cod_calificacion SERIAL NOT NULL,
    cod_nota INTEGER NOT NULL,
    valor DOUBLE PRECISION NOT NULL,
    fecha DATE NOT NULL,
    cod_curso VARCHAR(3) NOT NULL,
    cod_estudiante VARCHAR(5) NOT NULL,
    año VARCHAR(4) NOT NULL,
    periodo VARCHAR(2) NOT NULL,
    PRIMARY KEY (cod_calificacion),
    CONSTRAINT fk_cod_nota FOREIGN KEY (cod_nota) REFERENCES notas(cod_nota) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_inscripcion FOREIGN KEY (cod_curso, cod_estudiante, año, periodo) REFERENCES inscripciones(cod_curso, cod_estudiante, año, periodo) ON DELETE CASCADE ON UPDATE CASCADE
);

/*

CREATE OR REPLACE FUNCTION crear_calificaciones() RETURNS TRIGGER AS $$ 
DECLARE
BEGIN
    INSERT INTO calificaciones (cod_nota, valor, fecha, cod_curso, cod_estudiante, año, periodo)
    SELECT new.cod_nota, 0, CURRENT_DATE, new.cod_curso, c.cod_estudiante, new.año, new.periodo FROM inscripciones c WHERE new.año=c.año AND c.cod_curso=new.cod_curso AND c.periodo=new.periodo;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER crear_calificaciones AFTER INSERT OR UPDATE OR DELETE ON notas FOR EACH ROW EXECUTE PROCEDURE crear_calificaciones();

*/