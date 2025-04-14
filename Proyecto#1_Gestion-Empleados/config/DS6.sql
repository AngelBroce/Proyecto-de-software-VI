
-- Tablas principales
CREATE TABLE DEPARTAMENTO (
    cod_dep VARCHAR(2) PRIMARY KEY,
    nombre VARCHAR(40)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE CARGO (
    cod_carg VARCHAR(2) PRIMARY KEY,
    nombre VARCHAR(40)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE DEP_CARGO (
    cod_dep VARCHAR(2),
    cod_carg VARCHAR(2),
    PRIMARY KEY (cod_dep, cod_carg),
    FOREIGN KEY (cod_dep) REFERENCES DEPARTAMENTO(cod_dep),
    FOREIGN KEY (cod_carg) REFERENCES CARGO(cod_carg)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE USUARIOS (
    id_us INT PRIMARY KEY,
    administrador INT NOT NULL DEFAULT 0,
    estado INT NOT NULL, 
    correo_instit VARCHAR(40) NOT NULL UNIQUE,
    contraseña VARCHAR(18) NOT NULL UNIQUE, 
    f_contra DATE NOT NULL DEFAULT CURRENT_DATE,  
    f_alta DATE NULL,
    cod_carg VARCHAR(2) NOT NULL,
    cod_dep VARCHAR(2) NOT NULL,
    CONSTRAINT CHK_estado CHECK (estado IN (0,1)),
    CONSTRAINT CHK_correo CHECK (correo_instit LIKE '%@%'),
    CONSTRAINT CHK_administrador CHECK (administrador IN (0,1)),
    FOREIGN KEY (cod_dep) REFERENCES DEPARTAMENTO(cod_dep),
    FOREIGN KEY (cod_carg) REFERENCES CARGO(cod_carg)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE EMPLEADOS (
    cedula VARCHAR(13) NOT NULL PRIMARY KEY, 
    prefijo VARCHAR(6) NOT NULL,
    tomo VARCHAR(6) NOT NULL,
    asiento VARCHAR(6) NOT NULL,
    nombre1 VARCHAR(25) NOT NULL,
    nombre2 VARCHAR(25),
    apellido1 VARCHAR(25) NOT NULL,
    apellido2 VARCHAR(25),
    genero INT NOT NULL, 
    cod_nacion INT NOT NULL, 
    estado_civil INT,
    tipo_sangre VARCHAR(3),
    usa_ac INT NOT NULL, 
    f_nacimiento DATE NOT NULL,
    celular INT NOT NULL, 
    telefono INT,
    correo VARCHAR(40) NOT NULL,
    id_us INT NOT NULL, 
    codigo_provincia VARCHAR(2) NOT NULL, 
    codigo_distrito VARCHAR(4) NOT NULL,
    codigo_corregimiento VARCHAR(6) NOT NULL, 
    comunidad VARCHAR(25),
    calle VARCHAR(30),
    casa VARCHAR(10),
    CONSTRAINT CHK_genero CHECK (genero IN (0,1)),
    CONSTRAINT CHK_usa_ac CHECK (usa_ac IN (0,1)),
    CONSTRAINT CHK_correo CHECK (correo LIKE '%@%'),
    CONSTRAINT fk_empleados_nacionalidad FOREIGN KEY (cod_nacion) REFERENCES PAISES(id),
    FOREIGN KEY (codigo_provincia) REFERENCES PROVINCIA(codigo_provincia),
    FOREIGN KEY (codigo_distrito) REFERENCES DISTRITO(codigo_distrito),
    FOREIGN KEY (codigo_corregimiento) REFERENCES CORREGIMIENTO(codigo_corregimiento),
    FOREIGN KEY (id_us) REFERENCES USUARIOS(id_us)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE U_ELIMINADOS (
    e_id_us INT NOT NULL PRIMARY KEY,
    id_us INT,
    administrador INT NOT NULL,
    estado INT NOT NULL, 
    correo_instit VARCHAR(40) NOT NULL UNIQUE,
    contraseña VARCHAR(18) NOT NULL UNIQUE, 
    f_contra DATE NOT NULL DEFAULT CURRENT_DATE,  
    f_alta DATE,
    cod_carg VARCHAR(2) NOT NULL,
    cod_dep VARCHAR(2) NOT NULL,
    CONSTRAINT CHK_estado_elim CHECK (estado IN (0,1)),
    CONSTRAINT CHK_administrador_elim CHECK (administrador IN (0,1)),
    CONSTRAINT CHK_correo_elim CHECK (correo_instit LIKE '%@%'),
    FOREIGN KEY (id_us) REFERENCES USUARIOS(id_us),
    FOREIGN KEY (cod_dep) REFERENCES DEPARTAMENTO(cod_dep),
    FOREIGN KEY (cod_carg) REFERENCES CARGO(cod_carg)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE E_ELIMINADOS (
    e_cedula VARCHAR(13) NOT NULL PRIMARY KEY,
    cedula VARCHAR(13) NOT NULL,
    prefijo VARCHAR(6) NOT NULL,
    tomo VARCHAR(6) NOT NULL,
    asiento VARCHAR(6) NOT NULL,
    nombre1 VARCHAR(25) NOT NULL,
    nombre2 VARCHAR(25),
    apellido1 VARCHAR(25) NOT NULL,
    apellido2 VARCHAR(25),
    genero INT NOT NULL,
    cod_nacion INT NOT NULL,
    estado_civil INT,
    tipo_sangre VARCHAR(3),
    usa_ac INT NOT NULL,
    f_nacimiento DATE NOT NULL,
    celular INT NOT NULL,
    telefono INT,
    correo VARCHAR(40) NOT NULL,
    id_us INT NOT NULL,
    codigo_provincia VARCHAR(2) NOT NULL,
    codigo_distrito VARCHAR(4) NOT NULL,
    codigo_corregimiento VARCHAR(6) NOT NULL,
    comunidad VARCHAR(25),
    calle VARCHAR(30),
    casa VARCHAR(10),
    CONSTRAINT CHK_genero_elim CHECK (genero IN (0,1)),
    CONSTRAINT CHK_usa_ac_elim CHECK (usa_ac IN (0,1)),
    CONSTRAINT CHK_correo_elim CHECK (correo LIKE '%@%'),
    CONSTRAINT fk_eliminados_nacionalidad FOREIGN KEY (cod_nacion) REFERENCES PAISES(id),
    FOREIGN KEY (codigo_provincia) REFERENCES PROVINCIA(codigo_provincia),
    FOREIGN KEY (codigo_distrito) REFERENCES DISTRITO(codigo_distrito),
    FOREIGN KEY (codigo_corregimiento) REFERENCES CORREGIMIENTO(codigo_corregimiento),
    FOREIGN KEY (id_us) REFERENCES U_ELIMINADOS(id_us),
    FOREIGN KEY (cedula) REFERENCES EMPLEADOS(cedula)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
