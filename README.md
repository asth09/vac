<p align="center">
  <img src="https://frankmorenoalburqueque.com/images/ico490x458.png" height="320px" title="Icono">
</p>

[![Canal de GitHub](https://img.shields.io/badge/Canal-GitHub-black)](https://github.com/fmorenoadmin)
[![Sígueme en Twitter](https://img.shields.io/twitter/follow/sendgrid.svg?style=social&label=Sígueme)](https://twitter.com/FrankMartinMor1)
[![Sígueme en Facebook](https://img.shields.io/badge/Sígueme-@FrankMartinMA-blue)](https://facebook.com/FrankMartinMA)
[![Sígueme en Facebook](https://img.shields.io/badge/Sígueme-@frankmartinmoreno-ff69b4)](https://instagram.com/frankmartinmoreno)
[![Escríbeme en Facebook](https://img.shields.io/badge/Escríbeme-@FrankMartinMA-blue)](https://m.me/FrankMartinMA)
[![Escríbeme en WhatsApp](https://img.shields.io/badge/Escríbeme-WhathApp-green)](https://wa.me/51924741703)
[![Mi Web](https://img.shields.io/badge/Mi_Página-Web-blueviolet)](https://frankmorenoalburqueque.com)

## Metodología de Programación VAC-PHP:

### Mejoras

<p>
	Se acaban de Agregar cambios significativos al código fuente.<br>
	Puede que encuentren el código distinto a los videos ya que los videos<br>
	está basados en la primera Versión de esta metodología.<br>
	<br>
	Pero en este caso se a pasado a la última versión.
	<br>
	Mejorando asi las fallas en CURL al insertar información a la Base de Datos.
</p>
<p>
	Estos son los cambios que se han colocado: en la Acción
<code>
	if (isset($_POST['guardar'])) {//se valida si extiste el nombre del botón dentro del Array $_POST<br>
		if(isset($_SESSION)){}else{ session_start(); }//si existe el Array $_SESSION no hace nada. Si no existe se inician las SESSIONES<br>
		require_once($ru0.'constant.php');//requerimos las Constantes<br>
		//----------------------------------------<br>
		if (isset($_SESSION['sid'])) {//(Validación) Si existe la Session sel usuario [sid] capturamos la información y la pasamos a la clase<br>
			require_once($ru0.DIRMOR.$db.'.php');<br>
			require_once($ru0.DIRMOR.$cl1.'.php');<br>
			$_db = new $db();<br>
			$_cl1 = new $cl1();<br>
			$dt = new stdClass();<br>
			//----------------------------------------<br>
			$dt->nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);<br>
			$dt->correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);<br>
			$dt->telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);<br>
			$dt->mensaje = str_replace("'", '´', $_POST['mensaje']);<br>
			$dt->fecha = date('Y-m-d H:i:s');<br>
			//----------------------------------------<br>
			$url = base64_decode($_POST['url']);<br>
			//----------------------------------------<br>
			$_SESSION['stat'] = $_cl1->add($_db->conect01(),$dt);<br>
			//----------------------------------------<br>
			$_POST = null;<br>
			//----------------------------------------<br>
			header("Location: ".$url);<br>
			exit();<br>
		}else{//Si no existe la session del usuario<br>
			include_once($ru0.'403.shtml');//incluimos el archivo de Error 403.shtml - Prohibido<br>
		}<br>
	}<br>
</code>
</p>

### ¿Por qué VAC?

<ul>
	<li>
		VAC solo es una abreviatura de:
		<ul>
			<li>V => Vistas</li>
			<li>A => Acciones</li>
			<li>C => Clases</li>
		</ul>
	</li>
</ul>

### ¿Por qué usarla?

<ul>
	<li>Por que es muy fácil de entender, desarrollar e implementar.</li>
	<li>Por que se puede reutilizar el código.</li>
	<li>Por que no demora mucho tiempo en cargar.</li>
	<li>Por que no haces trabajos en la vista. Solo muestras la información.</li>
	<li>Por que es práctica.</li>
	<li>Por que aún puede mejorar muchísimo más.</li>
</ul>

### VAC utiliza:

<ul>
	<li>Objetos.</li>
	<li>Constantes.</li>
	<li>Sessiones.</li>
	<li>Variables.</li>
	<li>Funciones.</li>
	<li>Clases.</li>
	<li>Instanciamientos de Clases.</li>
</ul>

### Estructura:

<ul>
	<li>
		dominio.ejm/ (Carpeta donde de alojará todo el proyecto)
		<ul>
			<li>
				ACTIONJF/ (Nombre de Carpeta de Acciones)
				<ul>
					<li>contacto.php (Acción: De la Vista contacto de la web)</li>
					<li>cursos.php (Acción: De la Vista Cursos del sistema)</li>
					<li>index.php (Acción: De la Vista Principal de la web)</li>
				</ul>
			</li>
			<li>
				contacto/ (Nombre de Carpeta del formulario d eocntacto de la web)
				<ul>
					<li>index.php (vista del formulario de contato)</li>
				</ul>
			</li>
			<li>css/* (Nombre de carpeta que contiene los archivos CSS del Tema de la Web)</li>
			<li>
				excel/ (Nombre de carpeta que contiene los archivos de exportación a EXCEL)
				<ul>
					<li>contacto.php (Exportar: De la Vista contacto)</li>
					<li>cursos.php (Exportar: De la Vista Cursos)</li>
				</ul>
			</li>
			<li>fonts/* (Nombre de carpeta que contiene los archivos de fuentes del Tema de la Web)</li>
			<li>img/* (Nombre de carpeta que contiene las imágenes del proyecto)</li>
			<li>js/* (Nombre de carpeta que contiene los archivos JS del Tema de la Web)</li>
			<li>
				MORENOCL/ (Nombre de Carpeta de Clases)
				<ul>
					<li>db.php (Clase: DataBase para la cadena de conexión)</li>
					<li>contacto.php (Clase: Cursos Para nuestro ejemplo Contacto)</li>
					<li>cursos.php (Clase: Cursos Para nuestro ejemplo Cursos)</li>
					<li>function.php (Funciones para llamar en Clases que ejecutan sentencias dentro de un FOR o WHILE)</li>
				</ul>
			</li>
			<li>
				pdf/ (Nombre de carpeta que contiene los archivos de exportación a PDF)
				<ul>
					<li>contacto.php (Exportar: De la Vista contacto)</li>
					<li>cursos.php (Exportar: De la Vista Cursos)</li>
				</ul>
			</li>
			<li>
				plugins/ (Nombre de carpeta que contiene las librerias adicionales que se estan ocupando)
				<ul>
					<li>ckeditor/* (Convierte textarea en mini-word)</li>
					<li>dompdf/* (Exportar documentos PDF)</li>
					<li>toastr/* (Mensaje flotantes)</li>
				</ul>
			</li>
			<li>sass/* (Nombre de carpeta que contiene los archivos SCSS del Tema de la Web)</li>
			<li>
				sistem/ Carpeta del sistema administrativo
				<ul>
					<li>
						contacto/ (Carpeta de nuestra Vista: Contacto)
						<ul>
							<li>index.php (Vista: Contacto)</li>
							<li>detalle.php (vista: Contacto Detalle)</li>
						</ul>
					</li>
					<li>
						cursos/ (Carpeta de nuestra Vista: Curso)
						<ul>
							<li>index.php (Vista: Curso)</li>
							<li>detalle.php (vista: Curso Detalle)</li>
						</ul>
					</li>
					<li>0code.php (Archivo de configuración. Requerido en todas las vistas)</li>
					<li>0mens.php (Archivo de Mensajes. Este archivo se configurarán los mensajes que se mostrarán cuando se complete un CRUD)</li>
					<li>0error.php (Archivo donde se muestra los mensajes de alerts en las vistas. Requerido en todas las vistas)</li>
					<li>1styles.php (Archivo que contendrá los <link /> a estilos CSS . Requerido en todas las vistas)</li>
					<li>2java.php (Archivo que contendrá los <scritp></scritp> a los JavaScript . Requerido en todas las vistas)</li>
					<li>3toastr.php (Archivo que contendrá el muestreo de mesajes . Requerido en todas las vistas)</li>
				</ul>
			</li>
			<li>0code.php (Archivo de configuración. Requerido en todas las vistas)</li>
			<li>1styles.php (Archivo que contendrá los <link /> a estilos CSS . Requerido en todas las vistas)</li>
			<li>2nav.php (Archivo que contendrá la cabecera de la web. Requerido en todas las vistas)</li>
			<li>3footer.php (Archivo que contendrá el pie de página de la web. Requerido en todas las vistas)</li>
			<li>4java.php (Archivo que contendrá los <scritp></scritp> a los JavaScript . Requerido en todas las vistas)</li>
			<li>constant.php (Archivo donde definiremos nuestras constantes . Requerido en todas las vistas)</li>
			<li>script.sql (Archivo que contendrá las estructuras de nuestras tablas de la base de datos)</li>
		</ul>
	</li>
</ul>

### Pasos de Configuración a XAMPP en el PUERTO 81:

<ol>
	<li>Ingresa a tu Panel de control: C:\xampp\xampp-control.exe.</li>
	<li>Inicia Apache y Mysql (Star).</li>
	<li>Importa el archivo (script.sql) a <a href="http://localhost/phpmyadmin/" target="_blank">Puerto 80 clic aqui</a> ó <a href="http://localhost:81/phpmyadmin/" target="_blank">Puerto 81 clic aqui</a></li>
	<li>Ingresa a tu Panel de control.</li>
	<li>Detener Apache y Mysql (Stop).</li>
	<li>Clic en el botón Config.</li>
	<li>Clic en la Primera Opción: Apache (httpd.conf).</li>
	<li>Abre la Herramienta Buscar: Presiona Ctrl + B (Blog de Notas) ó Ctrl + F (Sublime Text).</li>
	<li>Ingresa en el Buscador: 80 y clic en buscar.</li>
	<li>
		Resultados:
		<ol>
			<li>#Listen 12.34.56.78:81Listen 80</li>
			<li>Listen 80</li>
			<li>ServerName localhost:80</li>
		</ol>
	</li>
	<li>
		Reemplazar por:
		<ol>
			<li>#Listen 12.34.56.78:81Listen 81</li>
			<li>Listen 81</li>
			<li>ServerName localhost:81</li>
		</ol>
	</li>
	<li>Guarda los Cambios.</li>
	<li>Regresa a tu Panel de control e Inicia Apache y Mysql (Star).</li>
	<li>Accede a: <a href="http://localhost:81/vac/" target="_blank">http://localhost:81/vac/</a>.</li>
</ol>

### Pasos de Configuración a XAMPP para SSL (https):

<ol>
	<li>Ingresa a tu Panel de control: C:\xampp\xampp-control.exe.</li>
	<li>Detener Apache y Mysql (Stop).</li>
	<li>Clic en el botón Config.</li>
	<li>Clic en la 4 Opción: PHP (php.ini).</li>
	<li>Abre la Herramienta Buscar: Presiona Ctrl + B (Blog de Notas) ó Ctrl + F (Sublime Text).</li>
	<li>Ingresa en el Buscador: [ Dynamic Extensions ] ó [ Many DLL files are located in the extensions/ ] y clic en buscar.</li>
	<li>
		Resultados:
		<ol>
			<li>;extension=openssl</li>
		</ol>
	</li>
	<li>
		Reemplazar por:
		<ol>
			<li>extension=openssl</li>
		</ol>
	</li>
	<li>Guarda los Cambios.</li>
	<li>Regresa a tu Panel de control e Inicia Apache y Mysql (Star).</li>
	<li>Ingresa al Archivo: constant.php</li>
	<li>
		En las Lineas:
		<ul>
			<li>2	define('HTTP', 'http://');</li>
			<li>3	//define('HTTP', 'https://');</li>
			<li>8	define('URL', HTTP.'localhost:81/vac/');</li>
			<li>9	//define('URL', HTTP.'localhost/vac/');</li>
		</ul>
	</li>
	<li>
		Reemplazar por:
		<ul>
			<li>2	//define('HTTP', 'http://');</li>
			<li>3	define('HTTP', 'https://');</li>
			<li>8	//define('URL', HTTP.'localhost:81/vac/');</li>
			<li>9	define('URL', HTTP.'localhost/vac/');</li>
		</ul>
	</li>
	<li>Accede a: <a href="https://localhost/vac/" target="_blank">SSL https://localhost/vac/</a>.</li>
</ol>

### Primera Parte del Vídeo Tutorial:

<p>
	🌐 https://www.facebook.com/FrankMartinMA/videos/913114612508005/
	
	✔️ Metodología de Programación VAC-PHP
	✔️ Listar Registros (Cursos)
	✔️ Agregar Registro (Cursos)
	✔️ Editar Registro (Cursos)
	✔️ Activar Registro (Cursos)
	✔️ Desactivar Registro (Cursos)
	✔️ Eliminar Registro (Cursos)
	✔️ Uso de Ckeditor
</p>

### Segunda Parte del video Tutorial:

<p>
	🌐 https://www.facebook.com/FrankMartinMA/videos/282640326425314/

	✔️ Usar Template HTML
	✔️ Convertir Template HTML a PHP
	✔️ Reutilizar el código
	✔️ Subir imagen al servidor
	✔️ Crear vista para Página web Mostrando la información del ejemplo
	✔️ Uso de Toastr
	✔️ Exportar PDF
	✔️ Exportar Excel
	✔️ Uso de DataTable
	✔️ Agregar Formulario de contacto
	✔️ Listar Registros (Cursos)
	✔️ Agregar seguimiento al formulario de contacto
	✔️ Activar Registro (Contacto)
	✔️ Desactivar Registro (Contacto)
	✔️ Eliminar Registro (Contacto)
</p>
	

<p align="center">
	<label>Moreno Alburqueque Frank Martin</label><br>
	<label>WebMaster - Programador Web PHP</label><br>
	<label><a href="mailto:admin@frankmorenoalburqueque.com">admin@frankmorenoalburqueque.com</a></label><br>
	<label><a href="https://frankmorenoalburqueque.com" target="_blank">https://frankmorenoalburqueque.com</a></label><br>
	<label><a href="tel:924741703">+51 924 741 703</a></label><br>
  <img src="https://frankmorenoalburqueque.com/images/logo480x240.png" width="auto" title="Logo">
</p>
