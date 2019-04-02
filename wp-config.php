<?php
/**
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define( 'DB_NAME', 'wordpress' );

/** Tu nombre de usuario de MySQL */
define( 'DB_USER', 'root' );

/** Tu contraseña de MySQL */
define( 'DB_PASSWORD', '' );

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define( 'DB_HOST', 'localhost' );

/** Codificación de caracteres para la base de datos. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', '+I JJ7x,HAz<raR7cl3_Q=8mY&/|4:Y}D5MVv_kgM6Rb[;]3mwzqZLbT*+dM[k,)' );
define( 'SECURE_AUTH_KEY', '$c #qaqK.Mptho8YZ<h#t-m$mYV9$qpq=|t3Rk)JE^85O4(:XXtsR(xq:1$`_+IL' );
define( 'LOGGED_IN_KEY', 'ivJd<zR|[.c*T0c>Cg6;^V?O~S}lPN -OsT=otZw7A3-T-$7w>9S+8F-- L8%J:3' );
define( 'NONCE_KEY', ' =Y$]As_MnRDqIMP;5Xv(Dw)s0OPw_[_?d=Bsug.}[x3dOruB0~06Qb><fzN6 *?' );
define( 'AUTH_SALT', 'z;[WTed2<lVNSiEZ3,*z8 YP}kE?2!AzUlL-kN?~QHi%q17[;>?Oh-<QURp01[OP' );
define( 'SECURE_AUTH_SALT', '-l_+4%Y(gN.JX:1yaoLa@_YmYd*N[g&F]CL@r!jB>=2?EfKwu.f_m)<CSfW$3.kF' );
define( 'LOGGED_IN_SALT', 'bB[lw/NKo1kkZ;8fV]QNtnG`]%CQXN5V6-i-%n*IU,u][?5ZLY`J(&i8/#iB|/>C' );
define( 'NONCE_SALT', '=+<b/nApi=HKsfXg@#92fBIqHrLpkf!AQ/-8D<Sd%9|0dG Mdjn]2#f3(RIZb!/b' );

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

