/*==========================================================
    APP.JS
    Restaurante Bar Battiato
==========================================================*/

document.addEventListener("DOMContentLoaded", () => {

    /*==========================
        MENÚ HAMBURGUESA (móvil/tablet)
    ==========================*/

    const navToggle = document.getElementById("navToggle");
    const navMenu = document.getElementById("navMenu");

    if (navToggle && navMenu) {

        const closeMenu = () => {
            navMenu.classList.remove("is-open");
            navToggle.setAttribute("aria-expanded", "false");
            navToggle.querySelector("i").className = "fa-solid fa-bars";
        };

        const openMenu = () => {
            navMenu.classList.add("is-open");
            navToggle.setAttribute("aria-expanded", "true");
            navToggle.querySelector("i").className = "fa-solid fa-xmark";
        };

        navToggle.addEventListener("click", () => {
            const isOpen = navMenu.classList.contains("is-open");
            isOpen ? closeMenu() : openMenu();
        });

        // Cerrar al hacer click en cualquier enlace del menú
        navMenu.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", closeMenu);
        });

        // Cerrar al hacer click fuera del menú
        document.addEventListener("click", (event) => {
            const clickedInsideNav = event.target.closest(".nav");
            if (!clickedInsideNav && navMenu.classList.contains("is-open")) {
                closeMenu();
            }
        });

        // Cerrar con la tecla Escape
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                closeMenu();
            }
        });

        // Si la ventana se agranda a escritorio, asegurar que quede cerrado
        // (debe coincidir con el breakpoint de navegación de responsive.css: 1240px)
        window.addEventListener("resize", () => {
            if (window.innerWidth > 1240) {
                closeMenu();
            }
        });

    }

    /*==========================
        PESTAÑAS DE MENÚ
    ==========================*/

    const tabGroups = document.querySelectorAll("[data-tabs]");

    tabGroups.forEach((group) => {

        const buttons = group.querySelectorAll("[data-tab-target]");
        const panels = group.querySelectorAll("[data-tab-panel]");

        buttons.forEach((button) => {

            button.addEventListener("click", () => {

                const target = button.getAttribute("data-tab-target");

                buttons.forEach((btn) => {
                    btn.classList.remove("is-active");
                    btn.setAttribute("aria-selected", "false");
                });

                panels.forEach((panel) => {
                    panel.classList.remove("is-active");
                    panel.hidden = true;
                });

                button.classList.add("is-active");
                button.setAttribute("aria-selected", "true");

                const activePanel = group.querySelector(
                    `[data-tab-panel="${target}"]`
                );

                if (activePanel) {
                    activePanel.hidden = false;
                    activePanel.classList.add("is-active");
                }

            });

        });

    });

    /*==========================
        LIGHTBOX (ampliar imágenes)
    ==========================*/

    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightboxImg");
    const lightboxClose = document.getElementById("lightboxClose");
    const zoomableImages = document.querySelectorAll("[data-zoomable]");

    const openLightbox = (src, alt) => {
        lightboxImg.src = src;
        lightboxImg.alt = alt || "";
        lightbox.classList.add("is-open");
        lightbox.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    };

    const closeLightbox = () => {
        lightbox.classList.remove("is-open");
        lightbox.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    };

    zoomableImages.forEach((img) => {
        img.addEventListener("click", () => {
            openLightbox(img.src, img.alt);
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener("click", closeLightbox);
    }

    if (lightbox) {

        lightbox.addEventListener("click", (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

    }

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeLightbox();
        }
    });

    /*==========================
        GALERÍA — LIGHTBOX PASARELA
    ==========================*/

    const galleryItems = Array.from(document.querySelectorAll("[data-gallery-index]"));
    const galleryLightbox = document.getElementById("galleryLightbox");

    /*==========================
        GALERÍA — BOTONES DEL CARRUSEL
    ==========================*/

    const galleryCarousel = document.getElementById("galleryCarousel");
    const carouselPrevBtn = document.getElementById("galleryCarouselPrev");
    const carouselNextBtn = document.getElementById("galleryCarouselNext");

    if (galleryCarousel && carouselPrevBtn && carouselNextBtn) {

        const scrollByOneSlide = (direction) => {
            const slide = galleryCarousel.querySelector(".gallery__slide");
            const step = slide
                ? slide.getBoundingClientRect().width + 20 // ancho de la tarjeta + gap
                : galleryCarousel.clientWidth * 0.8;

            galleryCarousel.scrollBy({ left: step * direction, behavior: "smooth" });
        };

        carouselPrevBtn.addEventListener("click", () => scrollByOneSlide(-1));
        carouselNextBtn.addEventListener("click", () => scrollByOneSlide(1));

    }

    if (galleryItems.length && galleryLightbox) {

        const galleryImg = document.getElementById("galleryLightboxImg");
        const galleryCounter = document.getElementById("galleryCounter");
        const galleryClose = document.getElementById("galleryLightboxClose");
        const galleryPrevBtn = document.getElementById("galleryPrev");
        const galleryNextBtn = document.getElementById("galleryNext");
        const galleryThumbs = Array.from(document.querySelectorAll("[data-thumb-index]"));

        // Construye la lista de fotos a partir de las miniaturas del DOM
        // (mismo origen de datos que el HTML, sin duplicar rutas en JS).
        const slides = galleryThumbs.map((thumb) => {
            const img = thumb.querySelector("img");
            return { src: img.src, alt: img.alt || "Foto de Restaurante Bar Battiato" };
        });

        let currentIndex = 0;

        const renderSlide = (index) => {
            currentIndex = (index + slides.length) % slides.length;
            const slide = slides[currentIndex];

            galleryImg.src = slide.src;
            galleryImg.alt = slide.alt;
            galleryCounter.textContent = `${currentIndex + 1} / ${slides.length}`;

            galleryThumbs.forEach((thumb, i) => {
                thumb.classList.toggle("is-active", i === currentIndex);
            });
        };

        const openGallery = (index) => {
            renderSlide(index);
            galleryLightbox.classList.add("is-open");
            galleryLightbox.setAttribute("aria-hidden", "false");
            document.body.style.overflow = "hidden";
        };

        const closeGallery = () => {
            galleryLightbox.classList.remove("is-open");
            galleryLightbox.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "";
        };

        galleryItems.forEach((item) => {

            const index = parseInt(item.getAttribute("data-gallery-index"), 10);

            item.addEventListener("click", () => openGallery(index));

            // Accesibilidad: abrir también con Enter/Espacio (los items son focuseables)
            item.addEventListener("keydown", (event) => {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    openGallery(index);
                }
            });

        });

        galleryThumbs.forEach((thumb) => {
            thumb.addEventListener("click", () => {
                renderSlide(parseInt(thumb.getAttribute("data-thumb-index"), 10));
            });
        });

        if (galleryPrevBtn) galleryPrevBtn.addEventListener("click", () => renderSlide(currentIndex - 1));
        if (galleryNextBtn) galleryNextBtn.addEventListener("click", () => renderSlide(currentIndex + 1));
        if (galleryClose) galleryClose.addEventListener("click", closeGallery);

        // Cerrar al hacer click en el fondo oscuro (fuera de la imagen/miniaturas)
        galleryLightbox.addEventListener("click", (event) => {
            if (event.target === galleryLightbox) {
                closeGallery();
            }
        });

        // Navegación y cierre por teclado, solo cuando la pasarela está abierta
        document.addEventListener("keydown", (event) => {

            if (!galleryLightbox.classList.contains("is-open")) return;

            if (event.key === "Escape") closeGallery();
            if (event.key === "ArrowLeft") renderSlide(currentIndex - 1);
            if (event.key === "ArrowRight") renderSlide(currentIndex + 1);

        });

        // Deslizar con el dedo en móvil (swipe izquierda/derecha)
        let touchStartX = null;

        galleryLightbox.addEventListener("touchstart", (event) => {
            touchStartX = event.changedTouches[0].clientX;
        }, { passive: true });

        galleryLightbox.addEventListener("touchend", (event) => {
            if (touchStartX === null) return;
            const delta = event.changedTouches[0].clientX - touchStartX;
            if (Math.abs(delta) > 40) {
                delta > 0 ? renderSlide(currentIndex - 1) : renderSlide(currentIndex + 1);
            }
            touchStartX = null;
        }, { passive: true });

    }

});
