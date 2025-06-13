<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';
import Knob from '../../components/Knob.vue';
import AutoCarousel from '../../components/AutoCarousel.vue';

const name = ref();
const email = ref();
const message = ref();
const knobValue = ref(90);

onMounted(() => {
  // Configuração inicial do background
  if(window.innerWidth < 969) {
    document.getElementById('background').style.filter = `brightness(30%)`;
  }
});

async function enviarFormulario() {
  try {
    const formData = new FormData();
    formData.append('name', this.name);
    formData.append('email', this.email);
    formData.append('message', this.message);

    const response = await axios.post('/email.php', formData);

    if (response.data.success) {
      alert(response.data.message);  // Alerta de sucesso
    } else {
      alert(response.data.message);  // Alerta de erro
    }
  } catch (error) {
    alert("Erro ao enviar o email."); // Alerta de erro se algo der errado
  }
}

const knobValueChange = (value: number) => {
  knobValue.value = value; // Atualiza o valor do knob
  document.getElementById('background').style.filter = `brightness(${value}%)`;
  console.log('Knob value changed:', knobValue.value);
};

</script>

<template>

  <div id="background"></div>

  <!-- Page Wrapper -->
  <div id="page-wrapper">

    <!-- Header -->
    <header id="header" class="alt">
      <!-- <h1 class="q-pt-lg" style="font-size: 25pt; font-weight: 400; scroll-behavior: smooth;"><a href="#banner">HTL</a>
      </h1> -->
      <img src="../../assets/images/logo_less.png" style="width: 70px; scroll-behavior: smooth; padding-top: 20px;" alt="">
      <nav>
        <!-- <a href="#menu">Menu</a> -->
      </nav>
      <a id="wpp" href="http://wa.me/+5513988504774" target="_blank">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
      </a>
    </header>

    <!-- Menu -->
    <nav id="menu">
      <div class="inner">
        <h2>Menu</h2>
        <ul class="links">
          <li><a href="index.html">Home</a></li>
          <li><a href="generic.html">Generic</a></li>
          <li><a href="elements.html">Elements</a></li>
          <li><a href="#">Log In</a></li>
          <li><a href="#">Sign Up</a></li>
        </ul>
        <a href="#" class="close">Close</a>
      </div>
    </nav>

    <!-- Banner -->
    <section id="banner">
      <div class="inner">
        <div class="logo">
          <!-- <span class="icon fa-gem"></span> -->
          <img src="../../assets/images/logo_d9.png" alt="">
        </div>
        <!-- <h2 style="font-weight: 100; font-size: 25pt; text-transform: uppercase;">Engenharia e Serviços</h2> -->
        <!-- <p>Another free + fully responsive site template by <a href="http://html5up.net">HTML5 UP</a></p> -->
      </div>
      <Knob @value="knobValueChange"></Knob>
    </section>

    <!-- Wrapper -->
    <section id="wrapper">

      <!-- One -->
      <section id="one" class="wrapper spotlight style1 opacity">
        <div class="inner">
          <a href="#" class="image"><img src="../../assets/images/brain.png" alt="" style="mix-blend-mode: color-dodge; opacity: .8;"/></a>
          <div class="content">
            <h2 class="major">Iluminação inteligente</h2>
            <p>A iluminação das cidades mudou muito nos últimos anos, saindo de lâmpadas simples e gastonas para LEDs modernos e, agora, sistemas inteligentes. A ideia é usar sensores e redes sem fio para ajustar a luz automaticamente, de acordo com a necessidade do momento, como trânsito ou clima ruim. Isso não só economiza até 70% de energia, mas também deixa as ruas mais seguras e os espaços urbanos mais eficientes e sustentáveis. É uma forma prática de combinar tecnologia e sustentabilidade no dia a dia das cidades.</p>
            <!-- <a href="#" class="special">Learn more</a> -->
          </div>
        </div>
      </section>

      <!-- Two -->
      <section id="two" class="wrapper alt spotlight style2 opacity">
        <div class="inner">
          <h2 class="major">Nossas soluções</h2>
        </div>
        <div class="inner">
          <a href="#" class="image"><img src="../../assets/images/eagle.png" alt="" /></a>
          <div class="content">
            <h2 class="major">Eagle Eye 3.0</h2>
            <p>O Eagle Eye é um sistema de iluminação pública inteligente com detecção por radar, que aciona luzes automaticamente ao detectar movimento e reduz a intensidade quando não há atividade, economizando energia. Ele usa comunicação por rádio para conectar controladores e garantir iluminação eficiente e segura para pedestres, ciclistas e veículos, contribuindo para a preservação ambiental.</p>
            <!-- <a href="#" class="special">Saiba mais sobre esse produto</a> -->
          </div>
        </div>
      </section>

      <!-- Three -->
      <section id="three" class="wrapper spotlight style3 opacity">
        <div class="inner">
          <a href="#" class="image"><img src="../../assets/images/zhaga.png" alt="" /></a>
          <div class="content">
            <h2 class="major">Eagle Eye Zhaga</h2>
            <p>O Eagle Eye Zhaga é um controlador de luz compatível com os padrões <b>Zhaga Book 18 e Dali-2</b>, capaz de detectar pedestres, ciclistas e veículos por meio de um sensor de movimento com radar Doppler. Ele ilumina o caminho à frente e pode atuar como controlador principal ou auxiliar em redes integradas. Seu compartimento ajustável permite adaptar a área de detecção para diferentes necessidades.</p>
            <a href="#" class="special">Saiba mais sobre esses produtos</a>
          </div>
        </div>
      </section>

      <!-- Four -->
      <section id="four" class="wrapper alt style1 opacity">
        <div class="inner">
          <h2 class="major">Quem somos</h2>
          <p>Desde 2011, a <b>HTL</b> atua em indústrias, rodovias e terminais portuários, oferecendo serviços de instalação, manutenção e adequação de sistemas elétricos, além de projetos e laudos técnicos. Também somos especialistas em soluções de iluminação inteligente, trazendo inovação e eficiência para nossos clientes. Nosso foco é combinar tecnologia de ponta com um atendimento próximo e confiável, garantindo excelência, transparência e resultados que atendem às reais necessidades de cada projeto.</p>
          <section class="features">
            <article>
              <a href="#" class="image"><img src="../../assets/images/ilumincacao.png" alt="" style="pointer-events: none;"/></a>
              <h3 class="major">Iluminação</h3>
              <p>Soluções inteligentes e econômicas que garantem segurança e eficiência em diversos ambientes.</p>
              <!-- <a href="#" class="special">Learn more</a> -->
            </article>
            <article>
              <a href="#" class="image" style="pointer-events: none;"><img src="../../assets/images/laudos.png" alt="" /></a>
              <h3 class="major">Laudos e Projetos</h3>
              <p>Laudos e projetos elétricos precisos, alinhados às normas e necessidades dos clientes.</p>
              <!-- <a href="#" class="special">Learn more</a> -->
            </article>
            <article>
              <a href="#" class="image" style="pointer-events: none;"><img src="../../assets/images/montagem.png" alt="" /></a>
              <h3 class="major">Montagem e Instalação</h3>
              <p>Montagem e instalação de sistemas elétricos com qualidade, agilidade e segurança.</p>
              <!-- <a href="#" class="special">Learn more</a> -->
            </article>
            <!-- <article>
              <a href="#" class="image"><img src="../../assets/images/pic07.jpg" alt="" /></a>
              <h3 class="major">Fusce consequat</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing vehicula id nulla dignissim dapibus ultrices.</p>
              <a href="#" class="special">Learn more</a>
            </article> -->
          </section>
          <!-- <ul class="actions">
            <li><a href="#" class="button">Browse All</a></li>
          </ul> -->
        </div>
        <AutoCarousel></AutoCarousel>
        <div style="height: 40px;"></div>
      </section>

    </section>

    <!-- Footer -->
    <section id="footer">
      <div class="inner">
        <div style="flex: 1; z-index: 10;">
          <div id="simple_logo">
            <img src="../../assets/images/logo_less.png" alt="">
          </div>
          <div id="social">
            <a href="https://www.instagram.com/htl_empresa" target="_blank">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            <a href="http://wa.me/+5513988504774" target="_blank">
              <i class="fa fa-whatsapp" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <ul class="contact" style="flex: 1; padding-left: 25px;">
          <li class="fa fa-home" aria-hidden="true">
            <a target="_blank" href="https://maps.app.goo.gl/mwWzykkUpXKk9LZ58">
              <b>Rua Alexandre Gusmão 11</b><br />
              Cj 917 e Sala 09<br />
              Valongo, Santos SP - Brasil
            </a>
          </li>
          <li class="fa fa-phone" style="line-height: 1.2;">
            <a href="" target="_blank" style="pointer-events: none;"><b>Thiago:</b> (13) 98815-8703</a><br/>
            <a href="" target="_blank" style="pointer-events: none;"><b>Ivan:</b> (13) 99133-9014</a>
          </li>
          <li class="fa fa-envelope"><a href="mailto:comercial@htlbrasil.com">comercial@htlbrasil.com</a></li>
          <!-- <li class="icon brands fa-twitter"><a href="#">twitter.com/untitled-tld</a></li> -->
          <!-- <li class="icon brands fa-facebook-f"><a href="#">facebook.com/untitled-tld</a></li> -->
          <!-- <li class="icon brands fa-instagram"><a href="#">instagram.com/untitled-tld</a></li> -->
        </ul>
        <!-- <ul class="copyright">
          <li>&copy; Untitled Inc. All rights reserved.</li>
          <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul> -->
      </div>
    </section>

  </div>

</template>

<style lang="scss">
  @use '../../style.scss';
</style>
