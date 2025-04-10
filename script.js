document.addEventListener("DOMContentLoaded", () => {
    // Theme Toggle Functionality
    const themeToggleBtn = document.getElementById("theme-toggle-btn")
    const sunIcon = document.getElementById("sun-icon")
    const moonIcon = document.getElementById("moon-icon")
  
    // Check for saved theme preference or use default
    const savedTheme = localStorage.getItem("theme")
    if (savedTheme === "dark") {
      document.body.classList.add("dark-theme")
    }
  
    // Update icons based on current theme
    updateThemeIcons()
  
    // Toggle theme when button is clicked
    if (themeToggleBtn) {
      themeToggleBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-theme")
        updateThemeIcons()
  
        // Save theme preference
        const currentTheme = document.body.classList.contains("dark-theme") ? "dark" : "light"
        localStorage.setItem("theme", currentTheme)
      })
    }
  
    function updateThemeIcons() {
      if (document.body.classList.contains("dark-theme")) {
        if (sunIcon) sunIcon.style.display = "none"
        if (moonIcon) moonIcon.style.display = "block"
      } else {
        if (sunIcon) sunIcon.style.display = "block"
        if (moonIcon) moonIcon.style.display = "none"
      }
    }
  
    // Floating Navigation Functionality
    const sections = document.querySelectorAll("section[id]")
    const navDots = document.querySelectorAll(".nav-dot")
  
    if (navDots.length > 0) {
      // Add click event to each nav dot
      navDots.forEach((dot) => {
        dot.addEventListener("click", function (e) {
          e.preventDefault()
          const targetId = this.getAttribute("data-target")
          const targetSection = document.getElementById(targetId)
  
          if (targetSection) {
            window.scrollTo({
              top: targetSection.offsetTop,
              behavior: "smooth",
            })
          }
        })
      })
  
      // Highlight active section on scroll
      window.addEventListener("scroll", () => {
        let current = ""
  
        sections.forEach((section) => {
          const sectionTop = section.offsetTop
          const sectionHeight = section.clientHeight
  
          if (pageYOffset >= sectionTop - sectionHeight / 3) {
            current = section.getAttribute("id")
          }
        })
  
        navDots.forEach((dot) => {
          dot.classList.remove("active")
          if (dot.getAttribute("data-target") === current) {
            dot.classList.add("active")
          }
        })
      })
    }
  
    // Blog Modal Functionality
    const readMoreButtons = document.querySelectorAll(".read-more")
    const modal = document.querySelector(".modal")
    const closeModal = document.querySelector(".close-modal")
    const modalTitle = document.querySelector(".modal-blog-title")
    const modalDate = document.querySelector(".modal-blog-meta .date span")
    const modalContent = document.querySelector(".modal-blog-content")
  
    if (readMoreButtons.length > 0 && modal) {
      readMoreButtons.forEach((button) => {
        button.addEventListener("click", function () {
          const postId = this.getAttribute("data-id")
  
          // Fetch post content
          fetch(`get_post.php?id=${postId}`)
            .then((response) => response.json())
            .then((data) => {
              if (data.error) {
                console.error(data.error)
                return
              }
  
              // Update modal content
              modalTitle.textContent = data.title
              modalDate.textContent = data.date
              modalContent.innerHTML = data.content
  
              // Show modal
              modal.classList.add("active")
              document.body.style.overflow = "hidden"
            })
            .catch((error) => console.error("Error fetching post:", error))
        })
      })
  
      // Close modal
      if (closeModal) {
        closeModal.addEventListener("click", () => {
          modal.classList.remove("active")
          document.body.style.overflow = ""
        })
      }
  
      // Close modal when clicking outside
      window.addEventListener("click", (event) => {
        if (event.target === modal) {
          modal.classList.remove("active")
          document.body.style.overflow = ""
        }
      })
    }
  })
  
  