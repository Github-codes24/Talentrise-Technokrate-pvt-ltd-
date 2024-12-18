function Slider(){
    return`
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<style>
:root {
    --white-100: hsl(206, 5%, 100%);
    --white-200: hsl(206, 5%, 90%);
    --white-300: hsl(206, 5%, 80%);
    --white-400: hsl(206, 5%, 65%);
    --white-500: hsl(206, 5%, 45%);
  
    --black-100: hsl(210, 20%, 10%);
    --black-200: hsl(210, 20%, 8%);
    --black-300: hsl(210, 20%, 6%);
    --black-400: hsl(210, 20%, 4%);
    --black-500: hsl(210, 20%, 1%);
  }
  
  *,
  *::before,
  *::after {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style: none;
    list-style-type: none;
    text-decoration: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;
  }
  

  main {
    overflow: hidden;
  }
  
  a,
  button {
    cursor: pointer;
    user-select: none;
    border: none;
    outline: none;
    background: none;
  }
  
  img {
    display: block;
    max-width: 100%;
    height: auto;
    object-fit: cover;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
  }
  
  
  .section {
    margin: 0 auto;
    padding-block: 5rem;
  }
  
  .container {
    max-width: 75rem;
    height: auto;
    margin-inline: auto;
    padding-inline: 1.25rem;
  }
  
  .swiper {
    &-button-next::after,
    &-button-prev::after {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 800;
      padding: 1rem;
      width: 2rem;
      height: 2rem;
      opacity: 0.75;
      border-radius: 50%;
      color: var(--white-100);
      background: var(--black-300);
    }
  }
  


</style>
        <section class="section slider-section">
            <div class="container slider-column">
            <div class="swiper swiper-slider">
            <div class="swiper-wrapper">
                <img class="swiper-slide" src="https://source.unsplash.com/1920x1280/?animal" alt="Swiper">
                <img class="swiper-slide" src="https://source.unsplash.com/1920x1280/?nature" alt="Swiper">
                <img class="swiper-slide" src="https://source.unsplash.com/1920x1280/?people" alt="Swiper">
                <img class="swiper-slide" src="https://source.unsplash.com/1920x1280/?flower" alt="Swiper">
                <img class="swiper-slide" src="https://source.unsplash.com/1920x1280/?travel" alt="Swiper">
                <img class="swiper-slide" src="https://source.unsplash.com/1920x1280/?fruits" alt="Swiper">
            </div>
            <span class="swiper-pagination"></span>
            <span class="swiper-button-prev"></span>
            <span class="swiper-button-next"></span>
            </div>
        </div>
        </section>
      <script>
      
   
      const swiper = new Swiper(".swiper-slider", {
          // Optional parameters
          centeredSlides: true,
          slidesPerView: 1,
          grabCursor: true,
          freeMode: false,
          loop: true,
          mousewheel: false,
          keyboard: {
            enabled: true
          },
        
          // Enabled autoplay mode
          autoplay: {
            delay: 3000,
            disableOnInteraction: false
          },
        
          // If we need pagination
          pagination: {
            el: ".swiper-pagination",
            dynamicBullets: false,
            clickable: true
          },
        
          // If we need navigation
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
          },
        
          // Responsive breakpoints
          breakpoints: {
            640: {
              slidesPerView: 1.25,
              spaceBetween: 20
            },
            1024: {
              slidesPerView: 2,
              spaceBetween: 20
            }
          }
        });
        
      </script>
    
      

    `
}
export default Slider