document.addEventListener("DOMContentLoaded", () => {
  /* =========================================================
     NAVBAR SCROLL
  ========================================================== */

  const navbar = document.getElementById("mainNavbar");

  function handleNavbar() {
    if (!navbar) return;

    if (window.scrollY > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  }

  window.addEventListener("scroll", handleNavbar);

  handleNavbar();

  /* =========================================================
     ACTIVE NAVBAR
  ========================================================== */

  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-link");

  function updateActiveNav() {
    let currentSection = "";

    sections.forEach((section) => {
      const sectionTop = section.offsetTop - 180;
      const sectionHeight = section.offsetHeight;

      if (
        window.scrollY >= sectionTop &&
        window.scrollY < sectionTop + sectionHeight
      ) {
        currentSection = section.getAttribute("id");
      }
    });

    navLinks.forEach((link) => {
      link.classList.remove("active");

      const href = link.getAttribute("href");

      if (href === `#${currentSection}`) {
        link.classList.add("active");
      }
    });
  }

  window.addEventListener("scroll", updateActiveNav);

  updateActiveNav();

  /* =========================================================
     SMOOTH SCROLL
  ========================================================== */

  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener("click", function (event) {
      const targetId = this.getAttribute("href");

      if (!targetId || targetId === "#" || targetId.length < 2) {
        return;
      }

      const target = document.querySelector(targetId);

      if (!target) {
        return;
      }

      event.preventDefault();

      const navbarHeight = navbar ? navbar.offsetHeight : 0;

      const targetPosition =
        target.getBoundingClientRect().top + window.scrollY - navbarHeight;

      window.scrollTo({
        top: targetPosition,
        behavior: "smooth",
      });

      /* Close mobile navbar */

      const navbarCollapse = document.getElementById("navbarContent");

      if (navbarCollapse && navbarCollapse.classList.contains("show")) {
        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);

        if (bsCollapse) {
          bsCollapse.hide();
        }
      }
    });
  });

  /* =========================================================
     BACK TO TOP
  ========================================================== */

  const backToTop = document.getElementById("backToTop");

  function handleBackToTop() {
    if (!backToTop) return;

    if (window.scrollY > 500) {
      backToTop.classList.add("show");
    } else {
      backToTop.classList.remove("show");
    }
  }

  window.addEventListener("scroll", handleBackToTop);

  handleBackToTop();

  if (backToTop) {
    backToTop.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  /* =========================================================
     GALLERY LIGHTBOX
  ========================================================== */

  const galleryItems = document.querySelectorAll(".gallery-item");

  const lightbox = document.getElementById("lightbox");

  const lightboxImage = document.getElementById("lightboxImage");

  const lightboxClose = document.getElementById("lightboxClose");

  galleryItems.forEach((item) => {
    item.addEventListener("click", () => {
      const image = item.querySelector("img");

      if (!image) return;

      lightboxImage.src = image.src;

      lightboxImage.alt = image.alt || "Gallery preview";

      lightbox.classList.add("active");

      document.body.style.overflow = "hidden";
    });
  });

  function closeLightbox() {
    if (!lightbox) return;

    lightbox.classList.remove("active");

    document.body.style.overflow = "";
  }

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

  /* =========================================================
     IMAGE FALLBACK
  ========================================================== */

  document.querySelectorAll("img").forEach((image) => {
    image.addEventListener("error", function () {
      this.style.background = "linear-gradient(135deg, #172b46, #0f1b2d)";

      this.style.objectFit = "cover";

      this.removeAttribute("src");
    });
  });

  /* =========================================================
     HERO PARALLAX
  ========================================================== */

  const hero = document.querySelector(".hero-section");

  if (hero) {
    window.addEventListener("scroll", () => {
      const scrollY = window.scrollY;

      if (scrollY < window.innerHeight) {
        hero.style.backgroundPosition = `center ${scrollY * 0.25}px`;
      }
    });
  }

  /* =========================================================
     SCROLL REVEAL
  ========================================================== */

  const revealElements = document.querySelectorAll(
    `
      .experience-card,
      .destination-card,
      .gallery-item,
      .feature-item,
      .profile-card,
      .location-card,
      .night-card,
      .timeline-item,
      .budget-card,
      .culinary-card,
      .tip-card
      `,
  );

  const revealObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("reveal");

          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.12,
    },
  );

  revealElements.forEach((element) => {
    revealObserver.observe(element);
  });

  /* =========================================================
     BUDGET CALCULATOR
  ========================================================== */

  const budgetType = document.getElementById("budgetType");

  const peopleCount = document.getElementById("peopleCount");

  const totalBudget = document.getElementById("totalBudget");

  function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(number);
  }

  function calculateBudget() {
    if (!budgetType || !peopleCount || !totalBudget) {
      return;
    }

    const pricePerPerson = Number(budgetType.value);

    let people = Number(peopleCount.value);

    if (people < 1 || isNaN(people)) {
      people = 1;
      peopleCount.value = 1;
    }

    if (people > 20) {
      people = 20;
      peopleCount.value = 20;
    }

    const total = pricePerPerson * people;

    totalBudget.textContent = formatRupiah(total);
  }

  if (budgetType) {
    budgetType.addEventListener("change", calculateBudget);
  }

  if (peopleCount) {
    peopleCount.addEventListener("input", calculateBudget);
  }

  calculateBudget();

  /* =========================================================
     CONSOLE
  ========================================================== */

  console.log(
    "%c MALIOBORO NIGHT 🌙 ",
    "background:#f6c85f;color:#172033;font-size:16px;font-weight:bold;padding:8px;",
  );

  console.log("Website promosi Malioboro siap menjelajah Jogja!");
});
