/*----------------------------VAC---------------------------*/
	CREATE DATABASE vac;
	USE vac;
/*----------------------------VAC---------------------------*/
/*-----------------------tabla-cursos-----------------------*/
	CREATE TABLE cursos(
		id INT PRIMARY KEY AUTO_INCREMENT,
		nombre VARCHAR(250) NULL DEFAULT NULL,
		descrip TEXT NULL DEFAULT NULL,
		imagen VARCHAR(950) NULL DEFAULT NULL,
		created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
		id_created INT NULL DEFAULT '1',
		updated_at DATETIME NULL DEFAULT NULL,
		id_updated INT NULL DEFAULT '0',
		drop_at DATETIME NULL DEFAULT NULL,
		id_drop INT NULL DEFAULT '0',
		status INT NULL DEFAULT '1'
	);
	INSERT INTO cursos (nombre,imagen) VALUES 
		('Comuncaion','20200628182542Comunicació-estratègica5.jpg'),
		('Ingles','20200628182500estudiar-ingles-pais-habla-inglesa-mejor-manera-aprender-idioma.jpg'),
		('Religion','202006281809395.jpg'),
		('Arte','202006281804041.jpg'),
		('Ciencia y Ambiente','20200628182759maxresdefault.jpg')
	;
	SELECT * FROM cursos WHERE status=1;
/*-----------------------tabla-contacto---------------------*/
	CREATE TABLE contacto(
		id INT PRIMARY KEY AUTO_INCREMENT,
		nombre VARCHAR(250) NULL DEFAULT NULL,
		correo VARCHAR(350) NULL DEFAULT NULL,
		telefono VARCHAR(15) NULL DEFAULT NULL,
		mensaje TEXT NULL DEFAULT NULL,
		ip_cli VARCHAR(20) NULL DEFAULT NULL,
		nav_cli TEXT NULL DEFAULT NULL,
		sist_cli TEXT NULL DEFAULT NULL,
		utm_id TEXT NULL DEFAULT NULL,
		utm_campaign TEXT NULL DEFAULT NULL,
		utm_source TEXT NULL DEFAULT NULL,
		utm_medium TEXT NULL DEFAULT NULL,
		utm_content TEXT NULL DEFAULT NULL,
		utm_term TEXT NULL DEFAULT NULL,
		fbclid TEXT NULL DEFAULT NULL,
		gclid TEXT NULL DEFAULT NULL,
		created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
		id_created INT NULL DEFAULT '1',
		updated_at DATETIME NULL DEFAULT NULL,
		id_updated INT NULL DEFAULT '0',
		drop_at DATETIME NULL DEFAULT NULL,
		id_drop INT NULL DEFAULT '0',
		status INT NULL DEFAULT '1'
	);
	SELECT * FROM contacto WHERE status=1;
/*-----------------------tabla-cursos-----------------------*/
	CREATE TABLE seg_contacto(
		id_seg INT PRIMARY KEY AUTO_INCREMENT,
		id INT NULL DEFAULT 1,
		id_usuario INT NULL DEFAULT 1,
		respuesta TEXT NULL DEFAULT NULL,
		created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
		id_created INT NULL DEFAULT '1',
		updated_at DATETIME NULL DEFAULT NULL,
		id_updated INT NULL DEFAULT '0',
		drop_at DATETIME NULL DEFAULT NULL,
		id_drop INT NULL DEFAULT '0',
		status INT NULL DEFAULT '1'
	);
/*-----------------------tabla-cursos-----------------------*/