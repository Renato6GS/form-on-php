CREATE DATABASE IF NOT EXISTS `bdCuestionario` /*!40100 DEFAULT CHARACTER SET latin1 */;

use bdCuestionario;

CREATE TABLE tbl_respuestas (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  carnet VARCHAR(30) NOT NULL,
  nivel_felicidad int(3) NOT NULL,
  nivel_estres int(3) NOT NULL,
  nivel_satisfaccion int(3) NOT NULL,
  clase_virtual int(3) NOT NULL,
  inicio_presencial int(3) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);