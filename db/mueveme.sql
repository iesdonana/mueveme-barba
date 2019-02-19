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
  , titulo          VARCHAR(255)   NOT NULL
  , noticia         VARCHAR(255)   UNIQUE NOT NULL
  , cuerpo          TEXT
  , created_at      TIMESTAMP      NOT NULL
                                   DEFAULT CURRENT_TIMESTAMP
  , movimiento      INT            DEFAULT 0
  , categoria_id    BIGINT         NOT NULL
                                   REFERENCES categorias (id)
                                   ON DELETE NO ACTION
                                   ON UPDATE CASCADE
  , usuario_id      BIGINT         NOT NULL
                                   REFERENCES usuarios (id)
                                   ON DELETE NO ACTION
                                   ON UPDATE CASCADE
  /* Falta crear created_at */
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
                                REFERENCES usuarios (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
);

DROP TABLE IF EXISTS votos CASCADE;

CREATE TABLE votos
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT    NOT NULL
                              REFERENCES usuarios(id)
                              ON DELETE CASCADE
                              ON UPDATE CASCADE
    , comentario_id BIGINT    NOT NULL
                              REFERENCES comentarios(id)
                              ON DELETE CASCADE
                              ON UPDATE CASCADE
    , votacion      INT
    , UNIQUE(usuario_id, comentario_id)
);


ALTER TABLE comentarios ADD CONSTRAINT fk1 FOREIGN KEY (padre_id) REFERENCES comentarios (id);

DROP TABLE IF EXISTS movimientos CASCADE;

CREATE TABLE movimientos
(
      usuario_id BIGINT REFERENCES usuarios(id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , noticia_id BIGINT REFERENCES noticias(id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , PRIMARY KEY(usuario_id, noticia_id)
);

INSERT INTO usuarios (nombre, password)
VALUES ('admin', crypt('admin', gen_salt('bf', 10)))
     , ('demo', crypt('demo', gen_salt('bf', 10)))
     , ('pepe', crypt('pepe', gen_salt('bf', 10)));

INSERT INTO categorias (categoria)
VALUES ('Actualidad')
     , ('Deportes')
     , ('Ciencia')
     , ('Memes')
     , ('Politica');

INSERT INTO noticias (titulo, cuerpo, noticia, categoria_id, usuario_id, movimiento)
VALUES ('Las rutas de la cocaína en el mundo'
      , 'La cocaína es una de las drogas más consumidas actualmente en el mundo, y por ello su tráfico se ha convertido en una variable clave para numerosas dinámicas geopolíticas y económicas tanto en países concretos como a nivel mundial. Su producción está concentrada en Sudamérica, especialmente en zonas de Colombia, Perú y Bolivia, y desde ahí se distribuye hacia mercados de elevado poder adquisitivo como Estados Unidos, Europa, el golfo Pérsico o Asia-Pacífico.'
      , 'https://elordenmundial.com/mapas/las-rutas-de-la-cocaina-en-el-mundo/'
      , 1
      , 1
      , 2)
     , ('Enseñar programación a un niño con Scratch desde cero: consejos, tutoriales y vídeos'
      , 'Scratch es un lenguaje visual de programación centrado en fomentar la creatividad y el pensamiento lógico. Aunque cualquier edad es buena para aprenderlo, los niños/as son destinatarios ideales para Scratch. Enseñándoles a usar Scratch estamos ayudándoles a afrontar y resolver situaciones y problemas de todo tipo de una manera lógica y estructurada.'
      , 'https://www.xataka.com/especiales/ensenar-programacion-a-nino-scratch-cero-consejos-tutoriales-videos'
      , 2
      , 3
      , 2);

INSERT INTO comentarios (cuerpo, noticia_id, padre_id, usuario_id)
VALUES ('Muy buen articulo Paco!!', 1, null, 1)
     , ('A Enrique le vendria bien.', 2, null, 2)
     , ('Y a garci tambien!', 2, 2, 1);
