<template>
   <div>
      <div class="container">
         <div class="banner" :class="{ 'banner-clicked': isBannerClicked }">
            <a :href="videoSrc" class="side one" @click.prevent="playVideo">
               <img class="img" :src="imgSrc" />
            </a>
         </div>
      </div>
      <!-- Usamos teleport para adicionar o overlay e o iframe no body -->
      <teleport to="body">
         <div v-if="overlayVisible" class="overlay" @click="closeVideo"></div>
         <iframe
            v-if="videoUrl"
            class="video"
            :src="videoUrl"
            width="700"
            height="400"
            frameborder="0"
            allowfullscreen
         ></iframe>
      </teleport>
   </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
   videoSrc: {
      type: String,
      default: 'https://www.youtube.com/watch?v=0VfSMvg5wEg',
   },
   imgSrc: {
      type: String,
      default: 'https://dl.dropboxusercontent.com/u/10873105/dead-1.jpg',
   },
});

const isBannerClicked = ref(false); // Controla o estado do banner
const overlayVisible = ref(false); // Controla a visibilidade do overlay
const videoUrl = ref(''); // URL do vídeo que será carregado

// Função para reproduzir o vídeo
function playVideo(event) {
   isBannerClicked.value = true;
   overlayVisible.value = true;

   // Transformar a URL do YouTube no formato embed
   const href = event.target.closest('a').getAttribute('href'); // Captura o atributo href do link clicado
   videoUrl.value = href.replace('watch?v=', 'embed/') + '?rel=0&autoplay=1';
}

// Função para fechar o vídeo e limpar o estado
function closeVideo() {
   isBannerClicked.value = false;
   overlayVisible.value = false;
   videoUrl.value = ''; // Remove o iframe para garantir que o vídeo pare de tocar
}
</script>

<style lang="scss" scoped>
.container {
   width: 230px;
   aspect-ratio: 2/3;
   position: relative;
   z-index: 2000;
}

.banner {
   width: 100%;
   height: 100%;
   -webkit-transform-style: preserve-3d;
   -webkit-transition: all 0.3s ease-in-out;
   -moz-transform-style: preserve-3d;
   -moz-transition: all 0.3s ease-in-out;
   -ms-transform-style: preserve-3d;
   -ms-transition: all 0.3s ease-in-out;
}

.container:hover .banner {
   -webkit-transform: rotateY(-15deg);
   -moz-transform: rotateY(-15deg);
   -ms-transform: rotateY(-15deg);
}

.banner-clicked {
   -webkit-transform: rotateY(-180deg) !important;
   -webkit-transition: all 0.7s cubic-bezier(0.67, 0.19, 0.31, 1.25) !important;
   -moz-transform: rotateY(-180deg) !important;
   -moz-transition: all 0.7s cubic-bezier(0.67, 0.19, 0.31, 1.25) !important;
   -ms-transform: rotateY(-180deg) !important;
   -ms-transition: all 0.7s cubic-bezier(0.67, 0.19, 0.31, 1.25) !important;
}

.side {
   position: absolute;
   -webkit-backface-visibility: hidden;
   -moz-backface-visibility: hidden;
   -ms-backface-visibility: hidden;
   padding: 4px;
   background: rgba(255, 255, 255, 0.2);
   border-radius: 16px;
   box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
   backdrop-filter: blur(5px);
   -webkit-backdrop-filter: blur(5px);
   border: 1px solid rgba(255, 255, 255, 0.3);
   z-index: 1000;
}

.one {
   display: block;
   width: 100%;
   height: 100%;
   -webkit-transform: rotateY(0deg);
   -moz-transform: rotateY(0deg);
   -ms-transform: rotateY(0deg);
   cursor: pointer;
   text-decoration: none;
   border: none;
}

.one:before {
   content: '';
   display: block;
   width: 48px;
   height: 48px;
   background: url(https://dl.dropbox.com/u/10873105/youtubePlay.png) 0 0 no-repeat;
   position: absolute;
   top: 50%;
   margin-top: -24px;
   left: 50%;
   margin-left: -24px;
   opacity: 0.8;
   zoom: 0.9;
   -webkit-transition: opacity 0.2s ease-in-out;
   -moz-transition: opacity 0.2s ease-in-out;
   -ms-transition: opacity 0.2s ease-in-out;
}

.one:hover:before {
   opacity: 0.9;
}

.overlay {
   position: fixed;
   /* Fixa o overlay cobrindo a tela inteira */
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: rgba(0, 0, 0, 0.8);
   /* Fundo escuro com opacidade */
   z-index: 10000;
   cursor: pointer;
}

iframe.video {
   position: fixed;
   top: 50%;
   left: 50%;
   transform: translate(-50%, -50%);
   z-index: 10001;
   border-radius: 10px;
   box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
}

img.img {
   width: 100%;
   height: 100%;
   object-fit: contain;
   //   padding: 20px;
}
</style>
