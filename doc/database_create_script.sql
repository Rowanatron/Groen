CREATE SCHEMA `server_monitor`;


CREATE TABLE `server_monitor`.`user`
(
  `user_id`     INT          NOT NULL AUTO_INCREMENT,
  `username`    VARCHAR(45)  NOT NULL,
  `password`    VARCHAR(225) NOT NULL,
  `given_name`  VARCHAR(45)  NOT NULL,
  `family_name` VARCHAR(45)  NOT NULL,
  `email`       VARCHAR(45)  NOT NULL,
  `role`        VARCHAR(10)  NOT NULL,
  PRIMARY KEY (`user_id`)
);


CREATE TABLE `server_monitor`.`customer`
(
  `customer_id`   INT         NOT NULL AUTO_INCREMENT,
  `customer_name` VARCHAR(45) NOT NULL,
  `user_id`       INT         NULL,
  PRIMARY KEY (`customer_id`),
  INDEX `user_id_idx` (`user_id` ASC),
  CONSTRAINT `user_id`
    FOREIGN KEY (`user_id`)
      REFERENCES `server_monitor`.`user` (`user_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


CREATE TABLE `server_monitor`.`environment`
(
  `environment_id`   INT         NOT NULL AUTO_INCREMENT,
  `environment_name` VARCHAR(45) NOT NULL,
  `customer_id`      INT         NOT NULL,
  PRIMARY KEY (`environment_id`),
  INDEX `customer_id_idx` (`customer_id` ASC),
  CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
      REFERENCES `server_monitor`.`customer` (`customer_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


CREATE TABLE `server_monitor`.`vm`
(
  `vm_id`   INT         NOT NULL AUTO_INCREMENT,
  `vm_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`vm_id`)
);


CREATE TABLE `server_monitor`.`env_vm_relation`
(
  `relation_id`    INT          NOT NULL AUTO_INCREMENT,
  `environment_id` INT          NOT NULL,
  `vm_name_from`   VARCHAR(45)  NOT NULL,
  `vm_name_to`     VARCHAR(45)  NOT NULL,
  `description`    VARCHAR(225) NULL,
  PRIMARY KEY (`relation_id`),
  INDEX `environment_id_idx` (`environment_id` ASC),
  CONSTRAINT `environment_id`
    FOREIGN KEY (`environment_id`)
      REFERENCES `server_monitor`.`environment` (`environment_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

ALTER TABLE `server_monitor`.`user`
  ADD COLUMN `img` VARCHAR(45) NULL AFTER `role`;


ALTER TABLE `server_monitor`.`env_vm_relation`
  DROP FOREIGN KEY `environment_id`;
ALTER TABLE `server_monitor`.`env_vm_relation`
  ADD CONSTRAINT `environment_id`
    FOREIGN KEY (`environment_id`)
      REFERENCES `server_monitor`.`environment` (`environment_id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE;

ALTER TABLE `server_monitor`.`environment`
  DROP FOREIGN KEY `customer_id`;
ALTER TABLE `server_monitor`.`environment`
  ADD CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
      REFERENCES `server_monitor`.`customer` (`customer_id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE;