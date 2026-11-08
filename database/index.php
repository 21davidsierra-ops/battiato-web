<?php
/*==========================================================
    index.php
    Restaurante Bar Battiato
    Ahora trae los precios desde MySQL (ver includes/menu-data.php
    y el panel de administración en /admin).
==========================================================*/

require_once __DIR__ . '/includes/menu-data.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <!-- ==========================================================
        METADATOS
    =========================================================== -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Restaurante Bar Battiato | Restaurante, Bar y Pizza Plazza
    </title>

    <meta
        name="description"
        content="Restaurante Bar Battiato. Vive una experiencia gastronómica única con parrilla, comida internacional, fast food, Pizza Plazza, bebidas y un ambiente ideal para compartir.">

    <meta
        name="keywords"
        content="Restaurante, Bar, Pizza, Parrilla, Hamburguesas, Comida Mexicana, Restaurante Battiato, Pizza Plazza">

    <meta
        name="author"
        content="Restaurante Bar Battiato">

    <meta
        name="robots"
        content="index, follow">

    <!-- ==========================================================
        OPEN GRAPH
    =========================================================== -->

    <meta property="og:type" content="website">

    <meta
        property="og:title"
        content="Restaurante Bar Battiato">

    <meta
        property="og:description"
        content="Disfruta una experiencia gastronómica única.">

    <meta
        property="og:image"
        content="assets/img/hero/hero.webp">

    <meta
        property="og:url"
        content="https://www.battiato.com">

    <!-- ==========================================================
        FAVICON
    =========================================================== -->

    <link
        rel="icon"
        href="assets/img/logos/favicon.png">

    <!-- ==========================================================
        GOOGLE FONTS
    =========================================================== -->

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- ==========================================================
        FONT AWESOME
    =========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- ==========================================================
        CSS
    =========================================================== -->

    <link
        rel="stylesheet"
        href="assets/css/variables.css">

    <link
        rel="stylesheet"
        href="assets/css/reset.css">

    <link
        rel="stylesheet"
        href="assets/css/layout.css">

    <link
        rel="stylesheet"
        href="assets/css/components.css">

    <link
        rel="stylesheet"
        href="assets/css/sections.css">

    <link
        rel="stylesheet"
        href="assets/css/responsive.css">

</head>

<body>

<!--=========================================================
HEADER
==========================================================-->

<header class="header">

    <div class="container">

        <nav class="nav">

            <!-- Logo -->

            <a
                href="#inicio"
                class="nav__logo">

                <img
                    src="assets/img/logos/logo-battiato.png"
                    alt="Logo Restaurante Bar Battiato">

            </a>

            <!-- Menú -->

            <ul class="nav__menu" id="navMenu">

                <li>

                    <a href="#inicio">

                        Inicio

                    </a>

                </li>

                <li>

                    <a href="#nosotros">

                        Nosotros

                    </a>

                </li>

                <li>

                    <a href="#gastronomia">

                        Gastronomía

                    </a>

                </li>

                <li>

                    <a href="#pizza">

                        Pizza Plazza

                    </a>

                </li>

                <li>

                    <a href="#galeria">

                        Galería

                    </a>

                </li>

                <li>

                    <a href="#contacto">

                        Contacto

                    </a>

                </li>

                <li class="nav__menu-cta">

                    <a
                        href="#contacto"
                        class="button button--primary">

                        Reservar

                    </a>

                </li>

            </ul>

            <!-- Botón (visible en escritorio) -->

            <a
                href="#contacto"
                class="button button--primary nav__cta">

                Reservar

            </a>

            <!-- Botón hamburguesa (visible en móvil/tablet) -->

            <button
                class="nav__toggle"
                id="navToggle"
                type="button"
                aria-label="Abrir menú de navegación"
                aria-expanded="false"
                aria-controls="navMenu">

                <i class="fa-solid fa-bars"></i>

            </button>

        </nav>

    </div>

</header>

<!--=========================================================
MAIN
==========================================================-->

<main>

<!--=========================================================
HERO
==========================================================-->

<section
    class="hero"
    id="inicio">

    <div class="hero__overlay"></div>

    <div class="container hero__container">

        <div class="hero__content">

            <!-- Logo -->

            <img

                class="hero__logo"

                src="assets/img/logos/logo-battiato.png"

                alt="Restaurante Bar Battiato">

            <!-- Subtítulo -->

            <span class="hero__subtitle">

                Restaurante • Bar • Pizza Plazza

            </span>

            <!-- Título -->

            <h1 class="hero__title">

                Donde la gastronomía,

                el buen ambiente

                y los mejores momentos

                se encuentran.

            </h1>

            <!-- Texto -->

            <p class="hero__text">

                Vive una experiencia gastronómica diferente.

                Disfruta nuestra parrilla,

                pizzas artesanales,

                comida internacional,

                bebidas,

                cócteles

                y un ambiente diseñado para compartir.

            </p>

            <!-- Botones -->

            <div class="hero__buttons">

                <a

                    href="#gastronomia"

                    class="button button--primary">

                    Ver Menú

                </a>

                <a

                    href="#nosotros"

                    class="button button--secondary">

                    Conócenos

                </a>

            </div>

            <!-- Scroll -->

            <a

                href="#nosotros"

                class="hero__scroll"

                aria-label="Desplazarse hacia abajo">

                <i class="fa-solid fa-angles-down"></i>

            </a>

        </div>

    </div>

</section>

<!--=========================================================
NOSOTROS
==========================================================-->

<section

    class="about section"

    id="nosotros">

    <div class="container">

        <header class="section-header">

            <span class="section-header__subtitle">

                Nuestra Historia

            </span>

            <h2 class="section-header__title">

                Mucho más que un restaurante

            </h2>

        </header>

        <div class="about__grid">

            <figure class="about__image">

                <img

                    src="assets/img/restaurant/ambiente.webp"

                    alt="Interior Restaurante Bar Battiato">

            </figure>

            <article class="about__content">

                <h3>

                    Un espacio creado para compartir.

                </h3>

                <p>

                    Restaurante Bar Battiato nace con el propósito de ofrecer una experiencia gastronómica donde cada visita se convierta en un momento especial.

                </p>

                <p>

                    Nuestro ambiente combina gastronomía, buena música, bebidas y atención personalizada para que cada cliente disfrute de un lugar acogedor, moderno y familiar.

                </p>

                <p>

                    Además de nuestra propuesta gastronómica, contamos con Pizza Plazza, un espacio dedicado a las pizzas artesanales elaboradas con ingredientes cuidadosamente seleccionados.

                </p>

                <a

                    href="#gastronomia"

                    class="button button--secondary">

                    Descubrir Nuestra Cocina

                </a>

            </article>

        </div>

    </div>

</section>

<!--=========================================================
GASTRONOMÍA
==========================================================-->

<section
    class="menu section"
    id="gastronomia">

    <div class="container">

        <header class="section-header">

            <span class="section-header__subtitle">

                Nuestra Gastronomía

            </span>

            <h2 class="section-header__title">

                Sabores para cada ocasión

            </h2>

            <p class="section-header__description">

                Explora nuestro menú completo por categorías: burgers,
                parrilla, comida mexicana, papas, bebidas, bar y cafés.

            </p>

        </header>

        <div class="menu-tabs" data-tabs>

            <div class="menu-tabs__nav" role="tablist" aria-label="Categorías del menú">

                <button
                    class="menu-tabs__btn is-active"
                    type="button"
                    role="tab"
                    aria-selected="true"
                    data-tab-target="burgers">

                    <i class="fa-solid fa-burger"></i>
                    Burgers

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="parrilla">

                    <i class="fa-solid fa-fire-burner"></i>
                    Parrilla

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="mexicana">

                    <i class="fa-solid fa-pepper-hot"></i>
                    Comida Mexicana

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="papas">

                    <i class="fa-solid fa-utensils"></i>
                    Papas Battiato

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="otros">

                    <i class="fa-solid fa-bowl-food"></i>
                    Pastas y Calzone

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="bebidas">

                    <i class="fa-solid fa-martini-glass-citrus"></i>
                    Bebidas

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="bar">

                    <i class="fa-solid fa-beer-mug-empty"></i>
                    Bar

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="cafe">

                    <i class="fa-solid fa-mug-saucer"></i>
                    Cafés

                </button>

            </div>

            <div class="menu-tabs__panels">

                <figure
                    class="menu-tabs__panel is-active"
                    role="tabpanel"
                    data-tab-panel="burgers">

                    <img
                        src="assets/img/menu/burgers-01.webp"
                        alt="Menú de Burgers: Especial Res, Especial Pollo, Puerquita, Mexicana y La Bistec. Todas $18.900, con papas $24.900."
                        loading="lazy"
                        data-zoomable>

                    <img
                        src="assets/img/menu/burgers-02-smash.webp"
                        alt="Hamburguesa Smash: pan artesanal de papa, carne de res, tocineta y doble queso mozzarella. Sin papas $17.900, con papas $23.900."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('burgers'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="parrilla"
                    hidden>

                    <img
                        src="assets/img/menu/parrilla.webp"
                        alt="Menú de Parrilla: Costichi BBQ, Costichi Mexicano y Costichi Revuelto, cortes de 300gm a la plancha, desde $30.900."
                        loading="lazy"
                        data-zoomable>

                    <img
                        src="assets/img/menu/parrilla-especiales.webp"
                        alt="Especiales de Pollo o Cerdo: BBQ o Champiñones, Revuelto, Mexicano, Chuzo de Pollo y Punta de Anca de Cerdo, desde $25.900."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('parrilla'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="mexicana"
                    hidden>

                    <img
                        src="assets/img/menu/mexicana.webp"
                        alt="Menú Comida Mexicana: Picada Personal $35.900, Quesadillas y Burritos desde $26.900, opcional jalapeños."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('mexicana'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="papas"
                    hidden>

                    <img
                        src="assets/img/papas/papas-battiato.webp"
                        alt="Papas Battiato #1, #2 y #3: papas a la francesa acompañadas de tocineta, queso mozzarella y salsa de la casa, desde $23.900."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('papas'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="otros"
                    hidden>

                    <img
                        src="assets/img/pizza/pizza-02.webp"
                        alt="Menú de Pastas, Lasañas, Calzone y Maicitos, con variedades de pollo, tocineta y vegetariana desde $20.500."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('otros'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="bebidas"
                    hidden>

                    <img
                        src="assets/img/menu/bebidas.webp"
                        alt="Menú de Bebidas Frías: limonadas, jugos, sodas saborizadas, el Guanabanon (bebida original de la casa) y gaseosas."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('bebidas'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="bar"
                    hidden>

                    <img
                        src="assets/img/bar/bar-cocteles.webp"
                        alt="Cócteles todos a $16.000, cervezas nacionales e importadas, y sangría en jarra o copa."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('bar'); ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="cafe"
                    hidden>

                    <img
                        src="assets/img/cafe/cafes.webp"
                        alt="Cafés calientes y fríos: cappuccino, expreso, americano, Coffee Battiato, Amaretto Frappe y Café Mocca."
                        loading="lazy"
                        data-zoomable>

                    <?php renderPriceList('cafe'); ?>

                </figure>

            </div>

        </div>

    </div>

</section>


<!--=========================================================
PIZZA PLAZZA
==========================================================-->

<section
    class="pizza section"
    id="pizza">

    <div class="container">

        <div class="pizza__content">

            <img
                src="assets/img/logos/logo-pizza-plazza.png"
                alt="Pizza Plazza"
                class="pizza__logo">

            <h2>

                El sabor artesanal de nuestras pizzas

            </h2>

            <p>

                Pizza Plazza es el espacio dedicado a los amantes de la pizza.
                Preparaciones artesanales, ingredientes frescos y recetas
                elaboradas para disfrutar en familia o con amigos.

            </p>

        </div>

        <!-- Tamaños y precios -->

        <div class="price-grid">

            <?php foreach (getPizzaSizes() as $size): ?>

                <div class="price-card">

                    <span class="price-card__size">
                        <?= htmlspecialchars($size['name']) ?>
                        <?php if ($size['slices']): ?>
                            <em>x<?= (int) $size['slices'] ?></em>
                        <?php endif; ?>
                    </span>

                    <span class="price-card__price"><?= formatPrice((float) $size['price']) ?></span>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- Menú de pizzas -->

        <div class="menu-tabs menu-tabs--light" data-tabs>

            <div class="menu-tabs__nav" role="tablist" aria-label="Categorías de pizza">

                <button
                    class="menu-tabs__btn is-active"
                    type="button"
                    role="tab"
                    aria-selected="true"
                    data-tab-target="clasicas">

                    <i class="fa-solid fa-pizza-slice"></i>
                    Clásicas y Especiales

                </button>

                <button
                    class="menu-tabs__btn"
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="nuevas">

                    <i class="fa-solid fa-star"></i>
                    Pizzas Nuevas

                </button>

            </div>

            <div class="menu-tabs__panels">

                <figure
                    class="menu-tabs__panel is-active"
                    role="tabpanel"
                    data-tab-panel="clasicas">

                    <img
                        src="assets/img/pizza/pizza-bg.webp"
                        alt="Pizzas Clásicas: Hawaiana, Piña Tocineta, Ranchera, Todas las Carnes, Maíz Tocineta, Pollo Jamón, Vegetariana y Paisa. Pizzas Especiales: Napolitana, Mixta 1, Pollo Champiñones, Florentina, Mixta 2 y Tropical."
                        loading="lazy"
                        data-zoomable>

                    <?php
                        renderFlavorList('pizza-clasicas');
                        renderFlavorList('pizza-especiales');
                    ?>

                </figure>

                <figure
                    class="menu-tabs__panel"
                    role="tabpanel"
                    data-tab-panel="nuevas"
                    hidden>

                    <img
                        src="assets/img/pizza/pizza-01.webp"
                        alt="Pizzas Nuevas: Portofino, Mexicana con Carne, Cuatro Estaciones, Salvatore, Bruno, Pollo BBQ e Isabella."
                        loading="lazy"
                        data-zoomable>

                    <?php renderFlavorList('pizza-nuevas'); ?>

                </figure>

            </div>

        </div>

        <div class="pizza__cta">

            <a
                href="#contacto"
                class="button button--primary">

                Reservar en Pizza Plazza

            </a>

        </div>

    </div>

</section>


<!--=========================================================
GALERÍA
==========================================================-->

<section
    class="gallery section"
    id="galeria">

    <div class="container">

        <header class="section-header">

            <span class="section-header__subtitle">

                Nuestro Ambiente

            </span>

            <h2 class="section-header__title">

                Vive la experiencia Battiato

            </h2>

            <p class="section-header__description">

                Conoce nuestros espacios, platos y el ambiente que hace de
                Restaurante Bar Battiato un lugar especial. Usa las flechas
                para recorrer las fotos, o haz clic en una para verla en
                grande.

            </p>

        </header>

        <div class="gallery__carousel-wrap">

            <button
                class="gallery__carousel-btn gallery__carousel-btn--prev"
                id="galleryCarouselPrev"
                aria-label="Ver fotos anteriores">

                <i class="fa-solid fa-chevron-left"></i>

            </button>

            <div class="gallery__carousel" id="galleryCarousel">

                <figure
                    class="gallery__slide"
                    data-gallery-index="0"
                    tabindex="0"
                    role="button"
                    aria-label="Ampliar foto: fachada del restaurante">

                    <img
                        src="assets/img/gallery/galeria-02.webp"
                        alt="Fachada del Restaurante Bar Battiato en la noche"
                        loading="lazy">

                    <span class="gallery__overlay">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </span>

                </figure>

                <figure
                    class="gallery__slide"
                    data-gallery-index="1"
                    tabindex="0"
                    role="button"
                    aria-label="Ampliar foto: ambientación con velas">

                    <img
                        src="assets/img/gallery/galeria-01.webp"
                        alt="Botellas decorativas con velas, ambiente del restaurante"
                        loading="lazy">

                    <span class="gallery__overlay">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </span>

                </figure>

                <figure
                    class="gallery__slide"
                    data-gallery-index="2"
                    tabindex="0"
                    role="button"
                    aria-label="Ampliar foto: pizza recién servida">

                    <img
                        src="assets/img/gallery/galeria-04.webp"
                        alt="Pizza artesanal recién servida en barra"
                        loading="lazy">

                    <span class="gallery__overlay">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </span>

                </figure>

                <figure
                    class="gallery__slide"
                    data-gallery-index="3"
                    tabindex="0"
                    role="button"
                    aria-label="Ampliar foto: pizza individual">

                    <img
                        src="assets/img/gallery/galeria-05.webp"
                        alt="Pizza individual sobre mesa de madera"
                        loading="lazy">

                    <span class="gallery__overlay">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </span>

                </figure>

                <figure
                    class="gallery__slide"
                    data-gallery-index="4"
                    tabindex="0"
                    role="button"
                    aria-label="Ampliar foto: platos para compartir">

                    <img
                        src="assets/img/gallery/galeria-03.webp"
                        alt="Platos para compartir sobre la barra del restaurante"
                        loading="lazy">

                    <span class="gallery__overlay">
                        <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                    </span>

                </figure>

            </div>

            <button
                class="gallery__carousel-btn gallery__carousel-btn--next"
                id="galleryCarouselNext"
                aria-label="Ver fotos siguientes">

                <i class="fa-solid fa-chevron-right"></i>

            </button>

        </div>

    </div>

</section>

<!--=========================================================
LIGHTBOX DE GALERÍA (pasarela con miniaturas)
==========================================================-->

<div class="gallery-lightbox" id="galleryLightbox" aria-hidden="true">

    <button class="gallery-lightbox__close" id="galleryLightboxClose" aria-label="Cerrar galería">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <button class="gallery-lightbox__arrow gallery-lightbox__arrow--prev" id="galleryPrev" aria-label="Foto anterior">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="gallery-lightbox__stage">

        <img class="gallery-lightbox__img" id="galleryLightboxImg" src="" alt="">

        <span class="gallery-lightbox__counter" id="galleryCounter"></span>

    </div>

    <button class="gallery-lightbox__arrow gallery-lightbox__arrow--next" id="galleryNext" aria-label="Foto siguiente">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <div class="gallery-lightbox__thumbs" id="galleryThumbs">

        <button class="gallery-lightbox__thumb is-active" data-thumb-index="0">
            <img src="assets/img/gallery/galeria-02.webp" alt="">
        </button>

        <button class="gallery-lightbox__thumb" data-thumb-index="1">
            <img src="assets/img/gallery/galeria-01.webp" alt="">
        </button>

        <button class="gallery-lightbox__thumb" data-thumb-index="2">
            <img src="assets/img/gallery/galeria-04.webp" alt="">
        </button>

        <button class="gallery-lightbox__thumb" data-thumb-index="3">
            <img src="assets/img/gallery/galeria-05.webp" alt="">
        </button>

        <button class="gallery-lightbox__thumb" data-thumb-index="4">
            <img src="assets/img/gallery/galeria-03.webp" alt="">
        </button>

    </div>

</div>

<!--=========================================================
UBICACIÓN
==========================================================-->

<section
    class="location section"
    id="ubicacion">

    <div class="container">

        <header class="section-header">

            <span class="section-header__subtitle">

                Visítanos

            </span>

            <h2 class="section-header__title">

                Te esperamos en Restaurante Bar Battiato

            </h2>

            <p class="section-header__description">

                Vive una experiencia gastronómica única en un ambiente cómodo,
                y diseñado para compartir en familia, con amigos o en
                pareja.

            </p>

        </header>

        <div class="location__grid">

            <!-- Información -->

            <article class="location__content">

                <div class="info-card">

                    <i class="fa-solid fa-location-dot"></i>

                    <div>

                        <h3>Dirección</h3>

                        <p>
                            Calle Castrillón, San Cristóbal, Medellín
                        </p>

                    </div>

                </div>

                <div class="info-card">

                    <i class="fa-solid fa-clock"></i>

                    <div>

                        <h3>Horario</h3>

                        <p>

                            Lunes a Domingo

                            <br>

                            12:00 m. – 11:00 p.m.

                        </p>

                    </div>

                </div>

                <div class="info-card">

                    <i class="fa-solid fa-phone"></i>

                    <div>

                        <h3>Reservas</h3>

                        <p>

                           Mediante WhatsApp.

                        </p>

                    </div>

                </div>

                <div class="info-card">

                    <i class="fa-solid fa-car"></i>

                    <div>

                        <h3>Parqueadero</h3>

                        <p>

                            Consulta disponibilidad al momento de realizar tu
                            reserva.

                        </p>

                    </div>

                </div>

            </article>

            <!-- Mapa -->

            <div class="location__map">

                <!-- Sustituir posteriormente por Google Maps -->

                <div class="map-placeholder">

                    <i class="fa-solid fa-map-location-dot"></i>

                    <h3>

                        Ubicación del Restaurante

                    </h3>

                    <p>

                        Aquí se integrará el mapa de Google Maps una vez se
                        confirme la dirección definitiva.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!--=========================================================
CONTACTO
==========================================================-->

<section
    class="contact section"
    id="contacto">

    <div class="container">

        <div class="contact__box">

            <span class="section-header__subtitle">

                Reserva tu mesa

            </span>

            <h2>

                ¿Listo para vivir la experiencia Battiato?

            </h2>

            <p>

                Realiza tu reserva de forma rápida y sencilla a través de
                nuestro canal oficial de WhatsApp.

            </p>

            <a

                href="https://wa.me/573242926618"

                target="_blank"

                rel="noopener"

                class="button button--primary">

                <i class="fa-brands fa-whatsapp"></i>

                Reservar por WhatsApp

            </a>

        </div>

    </div>

</section>

</main>

<!--=========================================================
FOOTER
==========================================================-->

<footer class="footer">

    <div class="container">

        <div class="footer__grid">

            <!-- Marca -->

            <div class="footer__brand">

                <img

                    src="assets/img/logos/logo-battiato.png"

                    alt="Restaurante Bar Battiato">

                <p>

                    Restaurante Bar Battiato es un espacio donde la gastronomía,
                    la buena atención y el mejor ambiente se unen para crear
                    experiencias memorables.

                </p>

            </div>

            <!-- Navegación -->

            <div class="footer__column">

                <h3>

                    Navegación

                </h3>

                <ul>

                    <li><a href="#inicio">Inicio</a></li>

                    <li><a href="#nosotros">Nosotros</a></li>

                    <li><a href="#gastronomia">Gastronomía</a></li>

                    <li><a href="#pizza">Pizza Plazza</a></li>

                    <li><a href="#galeria">Galería</a></li>

                </ul>

            </div>

            <!-- Contacto -->

            <div class="footer__column">

                <h3>

                    Contacto

                </h3>

                <ul>

                    <li>

                        <i class="fa-solid fa-phone"></i>

                        WhatsApp

                    </li>

                    <li>

                        <i class="fa-solid fa-location-dot"></i>

                        Calle Castrillón, San Cristóbal, Medellín

                    </li>

                    <li>

                        <i class="fa-solid fa-clock"></i>

                        Todos los días

                    </li>

                </ul>

            </div>

            <!-- Redes -->

            <div class="footer__column">

                <h3>

                    Síguenos

                </h3>

                <div class="footer__social">

                    <a href="#" aria-label="Facebook">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <a href="#" aria-label="Instagram">

                        <i class="fab fa-instagram"></i>

                    </a>

                    <a href="#" aria-label="TikTok">

                        <i class="fab fa-tiktok"></i>

                    </a>

                    <a href="#" aria-label="WhatsApp">

                        <i class="fab fa-whatsapp"></i>

                    </a>

                </div>

            </div>

        </div>

        <hr class="footer__divider">

        <div class="footer__bottom">

            <p>

                © 2026 Restaurante Bar Battiato.

                Todos los derechos reservados.

            </p>

            <p>

                proyecto de desarrollo web HTML5 y CSS3 SENA

            </p>

        </div>

    </div>

</footer>

<!--=========================================================
LIGHTBOX (para ampliar las imágenes del menú)
==========================================================-->

<div class="lightbox" id="lightbox" aria-hidden="true">

    <button class="lightbox__close" id="lightboxClose" aria-label="Cerrar imagen">

        <i class="fa-solid fa-xmark"></i>

    </button>

    <img class="lightbox__img" id="lightboxImg" src="" alt="">

</div>

<!--=========================================================
SCRIPT
==========================================================-->

<script src="assets/js/app.js" defer></script>

</body>

</html>
