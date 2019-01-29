------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       BIGSERIAL   PRIMARY KEY
  , nombre   VARCHAR(32) NOT NULL UNIQUE
  , password VARCHAR(60) NOT NULL
);

DROP TABLE IF EXISTS categorias CASCADE;

CREATE TABLE categorias
(
    id          BIGSERIAL    PRIMARY KEY
  , categoria   VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS noticias CASCADE;

CREATE TABLE noticias
(
    id              BIGSERIAL      PRIMARY KEY
  , titulo          VARCHAR(255)   UNIQUE NOT NULL
  , cuerpo          TEXT
  , categoria_id    BIGINT         NOT NULL
                                   REFERENCES categorias (id)
                                   ON DELETE NO ACTION
                                   ON UPDATE CASCADE
  , usuario_id      BIGINT         NOT NULL
                                   REFERENCES categorias (id)
                                   ON DELETE NO ACTION
                                   ON UPDATE CASCADE
);

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
    id              BIGSERIAL   PRIMARY KEY
  , cuerpo          TEXT
  , created_at      TIMESTAMP   NOT NULL
                                DEFAULT CURRENT_TIMESTAMP
  , noticia_id      BIGINT      NOT NULL
                                REFERENCES noticias (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , padre_id        BIGINT
  , usuario_id      BIGINT      NOT NULL
                                REFERENCES categorias (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
);

ALTER TABLE comentarios ADD CONSTRAINT fk1 FOREIGN KEY (padre_id) REFERENCES comentarios (id);
