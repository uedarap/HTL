<template>
  <div>
    <div class="container">
      <div class="banner" :class="{ 'banner-clicked': isBannerClicked }">
        <a :href="videoSrc" class="side one" @click.prevent="playVideo">
          <img class="img" :src="imgSrc" />
        </a>
        <div class="side two">
          <iframe
            v-if="videoUrl"
            class="video"
            width="700"
            height="400"
            :src="videoUrl"
            frameborder="0"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
    <div v-show="overlayVisible" class="overlay" @click="closeVideo"></div>
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
  width: 210px;
  height: 300px;
  position: relative;
//   top: 50%;
//   left: 50%;
//   margin: -150px 0 0 -105px;
//   -webkit-perspective: 1000px;
//   -moz-perspective: 1000px;
//   -ms-perspective: 1000px;
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
  border: 1px solid #dcdcdc27;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.09);
//   background: white;
  border-radius: 2px;
}

.one {
  display: block;
  width: 210px;
  height: 300px;
  -webkit-transform: rotateY(0deg);
  -moz-transform: rotateY(0deg);
  -ms-transform: rotateY(0deg);
  cursor: pointer;
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

.one:after {
  content: '';
  display: block;
  width: 210px;
  height: 80px;
  position: absolute;
  bottom: 0;
  background: url(http://cdn2-b.examiner.com/sites/default/files/styles/large_lightbox/hash/b4/82/b482d3c3cafcdcf8cb1279ec2349ba08.jpg?itok=B2_nUvk5) center center;
  background-size: cover;
}

.two {
  width: 700px;
  height: 400px;
  -webkit-transform: rotateY(180deg);
  -moz-transform: rotateY(180deg);
  -ms-transform: rotateY(180deg);
  margin-left: -250px;
  margin-top: -55px;
}

.overlay {
  position: fixed; /* Fixa o overlay cobrindo a tela inteira */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8); /* Fundo escuro com opacidade */
  z-index: 10; 
  cursor: pointer;
}

img.img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
