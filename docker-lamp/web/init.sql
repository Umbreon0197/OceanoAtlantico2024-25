CREATE TABLE IF NOT EXISTS mensajes (
  id INT NOT NULL AUTO_INCREMENT,
  texto VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar un registro de prueba
INSERT INTO mensajes (texto)
VALUES ('Hola desde MySQL + Docker!');