<noscript>
    <style>
      /**
      * Reinstate scrolling for non-JS clients
      */
      .simplebar-content-wrapper {
        overflow: auto;
      }
    </style>
</noscript>
<style type="text/css">
	*{padding: 0; margin:0; font-family: 'Open Sans', sans-serif}
	body{background-color: #f9f9f9;}
	:root{
		--principal : #006634;
		--nav-item : #76838f;
		--ancho-menu : 60px;
		--ancho_full : 250px;
		--ancho-menu-user: 250px;
		--btn-success :#2ecc71;
		--btn-danger:#fa2a00;
		--btn-primary:#22a7f0;
        --btn-view:#FFDC00;

	}
	.nav{transition: width .5s,-webkit-transform .5s;transition: width .5s,transform .5s;transition: width .5s,transform .5s,-webkit-transform .5s;   transition-timing-function: ease, ease, ease;}
	.nav{width: var(--ancho-menu); height: 100vh; position: fixed; z-index: 9999; top: 0; left: 0;background: #353d47;background: linear-gradient(45deg,#353d47,#21292e);}
	.nav.extended{width: var(--ancho_full)}
	.nav .app_name{width: calc(100% - 1em); padding:1.2em  0.5em; color: #FFF; letter-spacing: 2px; background: var(--principal);}
	.nav.extended .app_name{width: calc(100% - 2em); padding:1.2em  1em;}
	.nav .app_name span:nth-of-type(1){display: none}
	.nav.extended span:nth-of-type(1){display: initial;}
	.nav.extended span:nth-of-type(2){display: none;}
	.nav .user{color: #FFF; display: flex;background: url({{ asset('storage/settings/bg-login.jpg') }});background: url({{ asset('storage/settings/bg-login.webp') }}); background-repeat: no-repeat; background-size: cover;}
	.nav .user .sombra{width: calc(100% - 1em); padding:1.2em  0.5em; height: 100%;background: rgba(45,53,61,.5);background: linear-gradient(275deg,#242c32,rgba(36,44,50,.95) 34%,rgba(36,44,50,.7)); display: flex; justify-content: flex-start; align-items: center; }
	.nav.extended .user .sombra{width: calc(100% - 2em); padding:1.2em  1em;}
	.nav .user .sombra .avatar{margin-right: 0px;overflow: hidden; border-radius: 50%; height: 40px;}
	.nav.extended .user .sombra .avatar{ margin-right: 1em;}
	.nav .user .sombra .avatar picture{ height: 40px; width: 40px; }
	.nav .user .sombra .avatar picture img{width: 100%; height: 100%; max-width: 40px; max-height: 40px;}
	.nav .user .sombra .username{display: none;}
	.nav.extended .user .sombra .username{ width: calc(100% - 40px - 1em); display: initial;}
	.nav.extended .user .sombra .username h4{letter-spacing: 2px; font-size: 1.1em; white-space: pre; overflow: hidden; text-overflow: ellipsis;}
	.nav ul{width: 100%; height: calc(100vh - 1.5em); overflow-y: auto; padding-bottom: 1.5em; overflow:visible}
	.nav ul li{width: calc(100% - 1em); padding:  0.3em 0.5em; list-style: none;}
	.nav.extended ul li{width: calc(100% - 2em); padding:  0.3em 1em;}
	.nav ul li:hover{background: #2a363b;}
	.nav ul li:hover a{color: #FFF;}
	.nav ul li a{text-decoration: none; color: var(--nav-item); width: 100%; cursor: pointer; display: flex; position: relative; justify-content: center; font-size: 0.9em;}
	.nav.extended ul li a{justify-content: flex-start;}
	.nav ul li a .nav-titulo{display: none; margin-left: 0px;}
	.nav.extended ul li a .nav-titulo{margin-left: 1em; display: initial;}
	.nav ul li a .right{position: absolute; right: 0em; top: 0;}
	.nav.extended ul li a .right{right: 1em;}
	.nav ul li.active a{color: #FFF;}
	.nav ul li ol{height: 0;overflow: hidden;}
	.nav ul li ol li{list-style: none; padding: 0.5em 0.5em;}
	.nav.extended ul li ol li{padding: 0.5em 1em}
	.nav ul li ol li a{ position: relative;}
	.nav ul li:hover ol li a{color: var(--nav-item);}
	.nav ul li ol li:hover a{color: #FFF;}
	.nav ul li ol li:last-child{padding-bottom: 0;}

	.nav ul li:hover a .nav-titulo{display: initial;position: absolute;top: -0.1em;left: calc(100% + 0.5em);background: var(--nav-item);padding: 0.2em 1em; white-space: pre;}

	.nav ul li ol li:hover a .nav-titulo{display: initial !important;position: absolute !important;top: -0.1em;left: calc(100% + 1em);background: var(--nav-item) !important;padding: 0.2em 1em !important; white-space: pre;}
	.nav.extended ul li:hover a .nav-titulo{position: initial; background: transparent; padding: 0;}
	.nav ul li:hover ol li a .nav-titulo{position: initial; background: transparent; padding: 0;display: none;}
	.nav.extended ul li:hover ol li a .nav-titulo{display: initial;}
	.nav.extended ul li:hover ol li a .nav-titulo{position: initial !important; background: transparent !important; padding: 0 !important;}

	header{position: fixed; width: calc(100% - 2em - var(--ancho-menu)); top: 0 ; left: 0;background: hsla(0,0%,98%,.9); padding: 1.2em 1em; padding-left: calc(var(--ancho-menu) + 1em); display: flex; justify-content: space-between; align-items:center;height: calc(56.4px - 2.4em);box-shadow: 0 0 0 rgba(0,0,0,.08);}
	header.extended{ width: calc(100% - 2em - var(--ancho_full));padding-left: calc(var(--ancho_full) + 1em);}
	header:after{content: ""; width: calc(100% - 2em - var(--ancho-menu)); bottom: 0px;right: 1em; height: 1px; background: #cfcfcf; position: absolute;}
	header.extended:after{content: ""; width: calc(100% - 2em - var(--ancho_full)); bottom: 0px;right: 1em; height: 1px; background: #cfcfcf; position: absolute;}
	header .tabs{background: #FFF; border-radius: 6px; padding: 0.6em 1em; display: flex;align-items: center;}
	header .tabs.active{display: none;}
	header .tabs a{margin: 0 1em; position: relative; text-decoration: none; font-size: 0.9em;}
	header .tabs a:nth-of-type(n+2):before{content: "\f101"; font-family: "Font Awesome 5 Free"; position: absolute; height: 100%;  top: 0; left: -1.6em; color: #ccc;}
	header .tabs a.active{color: var(--principal); font-weight: bold;}
	header .menu-user-container{position: relative;}
	header .menu-user-container .avatar{overflow: hidden;height: 40px; margin-right: 1em; display: flex; justify-content: flex-end; align-items: center;}
	header .menu-user-container .avatar picture{ height: 30px; width: 30px; border-radius: 50%;}
	header .menu-user-container .avatar picture img{border-radius:50%; width: 100%; height: 100%; max-width: 30px; max-height: 30px;}
	header .menu-user-container .menu-user{position: absolute; top: calc(100% + 1em); right: 0; height: auto; width: calc(var(--ancho-menu-user) - 2em); padding:  1em; border-radius: 6px; background: #FFF; box-shadow: 0 0 4px 0 rgba(0,0,0,.25); opacity: 0;transition: opacity .5s,-webkit-transform .5s;transition: opacity .5s,transform .5s;transition: opacity .5s,transform .5s,-webkit-transform .5s;    transition-timing-function: ease, ease, ease;}
	header.extended .menu-user-container .menu-user{width: calc(var(--ancho_full) - 2em); }
	header .menu-user-container .menu-user.extended{opacity: 1;}
	header .menu-user-container .menu-user .menu-option{ margin-bottom: 1em; width: 100%;}
	header .menu-user-container .menu-user .menu-option:last-child{margin-bottom: 0px;}
	header .menu-user-container .menu-user .menu-option a{display: flex; text-decoration: none; width: 100%; color: #777; transition: color .3s ease;}
	header .menu-user-container .menu-user .menu-option a:hover{color: #333;}
	header .menu-user-container .menu-user .menu-option a.btn-logout:hover{color: #cfc;}
	header .menu-user-container .menu-user .menu-option a .title-option{margin-left: 1em;}
	header .menu-user-container .menu-user .menu-option .btn-logout{background: var(--principal); color: #FFF; text-align: center; padding:  0.5em 1em; border-radius: 6px; width: calc(100% - 2em);}
	.contenedor{padding-top: 54.6px; padding-left: calc(var(--ancho-menu) + 1em); padding-right: 1em; width: calc(100% - 2em - var(--ancho-menu)); min-height: calc(100vh - 112px);}
	.contenedor.extended{padding-left: calc(var(--ancho_full) + 1em);width: calc(100% - 2em - var(--ancho_full));}
	.contenedor .contenido{width: 100%; min-height: calc(100vh - 112px);}
	.contenedor footer{width: calc(100% - 2em);padding: 0 1em;  height: 45px; display: flex; justify-content: flex-end; align-items: center;}
    img{background: gray;}
    .icono-menu{width: 20px;height: 20px;text-align: center;cursor: pointer;}
	/* critico para celular*/
	@media (max-width: 767px){
		.contenedor.extended{padding-top: 54.6px; padding-left: calc(var(--ancho-menu) + 1em); padding-right: 1em; width: calc(100% - 2em - var(--ancho-menu)); min-height: calc(100vh - 112px);}

	}
	</style>
	<link href="{{ asset('/plugins/fontawesome-free-5.11.2-web/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/fontawesome-free-5.11.2-web/css/brands.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/fontawesome-free-5.11.2-web/css/solid.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/simplebar/simplebar.css') }} "
/>
<style>
    .simplebar-scrollbar{
        background: white;
    }
</style>
@yield('styles')
