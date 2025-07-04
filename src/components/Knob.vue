<template>
    <div id="knob" class="knob">
        <input class="knob" type="range" step="10" min="10" max="100" :value="value" @input="handleInput" />
    </div>
</template>


<script setup lang="ts">
    import { ref, onMounted, watch, defineEmits } from 'vue';

	const value = ref(90);
	const emit = defineEmits(['value']);

    onMounted(() => {
        const input = document.querySelector("input[type='range']");
        for (const event of ["input", "change"])
            input.addEventListener(event, (e) => update(e.target));
        update(input);
    });
    
    function update(input) {
        for (const data of ["min", "max", "value"])
            if (input[data]) input.style.setProperty(`--${data}`, input[data]);
    };

	function handleInput(event) {
		const inputValue = event.target.value;
		value.value = inputValue; // Atualiza o valor interno
		emit('value', inputValue); // Emite o evento com o novo valor
		console.log("Input value:", inputValue);
	}


</script>v


<style lang="scss" scoped>
@use 'sass:math';
@use 'sass:color';

// ========================== Custom ==========================\

#knob {
    position: absolute;
    top: 20px;
    right: 20px;
    opacity: .7;
}

// ========================== /Custom =========================

/*
 * 4 March 2022
 * CSS Knob widget with Range Slider
 * Inspired by Ana Tudor's 1 element range slider collection
 *
 * ✔ responsive
 * ✔ only 1 line of HTML
 * ✔ drag + keyboard accessible
 * ✔ UI created with CSS gradients & SASS generators
 * ✔ highly customizable with CSS & SASS variables
 * ✔ powered by 9* lines of JavaScript
 *
 * Tested on the latest versions of Chrome & Firefox
 * Open it in the details view for more information
 *
 */

// ==================
// === logic.scss ===
// ==================

@function devide($n, $dn) {
	// @return math.div($n, $dn);
	@return $n / $dn;
}

@function rgb-color($color) {
	$r: color.red($color);
	$g: color.green($color);
	$b: color.blue($color);
	$a: color.alpha($color);

	@return "rgba(#{$r},#{$g},#{$b},#{$a})";
}

@function split($number) {
	$string: inspect($number);
	$limit: str-length($string);
	$list: ();

	@for $i from 1 through $limit {
		$val: str-slice($string, $i, $i);
		$list: append($list, $val, "comma");
	}

	@return $list;
}

// ======================
// === svg-utils.scss ===
// ======================
@function svg-container($size: 100, $content: null, $inline-styles: null) {
	@return url("data:image/svg+xml,\
%3Csvg viewBox='0 0 #{$size} #{$size}' width='#{$size}px' height='#{$size}px' xmlns='http://www.w3.org/2000/svg'%3E\
%3CforeignObject width='100%25' height='100%25'%3E\
%3Cdiv class='c-o' xmlns='http://www.w3.org/1999/xhtml'%3E\
#{$content}%3C/div%3E%3Cstyle%3E\
.c-o,.c-i{position:absolute;left:0;top:0;right:0;bottom:0}\
#{$inline-styles}%3C/style%3E%3C/foreignObject%3E%3C/svg%3E");
}

@function digit($n) {
	@return "<div class='d d#{$n}'>\
<div class='a'></div>\
<div class='b e'></div>\
<div class='b c'></div>\
</div>";
}

@function create-digits($n) {
	$arr: split($n);
	$html: null;
	@each $num in $arr {
		$html: $html + digit($num);
	}
	@return $html;
}

@function create-series($n, $class, $contain-digits: false) {
	$series: null;
	$content: null;
	@for $i from 0 through $n {
		@if $contain-digits == true {
			$content: create-digits($i);
		}
		$series: $series +
			"<div class='#{$class}' style='--i:#{$i}'>#{$content}</div>";
	}
	@return '<div class="c-i" style="--n:#{$n}">#{$series}</div>';
}

// ===================
// === layers.scss ===
// ===================
@function create-ticks($size, $ticks, $steps, $angles, $colors, $geometry) {
	$nstep: devide($ticks, $steps);
	$calc-radius: calc(
		#{$size} * (#{map-get($geometry, "ticks-radius")} / 100) * 1px
	);
	$style: '\
.tick{--angle:calc((#{map-get($angles, "full")} / var(--n)) * var(--i) * 1deg);\
position:absolute;\
left:50%25;top:50%25;\
width:#{map-get($geometry, "ticks-height")}0px;\
height:#{map-get($geometry, "ticks-width")}0px;\
background:#{rgb-color(map-get($colors, "tick"))};\
border-radius:#{map-get($geometry, "ticks-step-height")}0px;\
transform:translate(-50%25,-50%25) rotate(90deg) rotate(#{map-get($angles, "start")}deg) rotate(var(--angle)) translateX(#{$calc-radius}) translate(50%25);\
opacity:0.73\
}\
.tick:nth-child(#{$nstep}n + 1){\
background:#{rgb-color(map-get($colors, "step"))};\
width:#{map-get($geometry, "ticks-step-height")}0px;\
opacity:0.83\
}';

	@return svg-container($size, create-series($ticks, "tick"), $style);
}

@function create-digits-layer($size, $steps, $angles, $colors, $geometry) {
	$calc-radius: calc(
		#{$size} * (#{map-get($geometry, "digits-radius")} / 100) * 1px
	);
	$style: '\
.s{\
--as:#{map-get($angles, "start")};\
--ae:#{map-get($angles, "negative-step")};\
--angle:calc(((#{map-get($angles, "full")} - (var(--ae) * 2)) / var(--n)) * var(--i) * 1deg);\
position:absolute;\
left:50%25;\
top:50%25;\
transform:translate(-50%25, -50%25) rotate(90deg)\
rotate(calc((var(--as) + var(--ae)) * 1deg)) rotate(var(--angle))\
translateX(#{$calc-radius}) rotate(-90deg)\
rotate(calc((var(--as) + var(--ae)) * -1deg))\
rotate(calc(var(--angle) * -1));\
}\
.d{\
--s:130px;\
--pt:polygon(9.2%25 0, 89.8%25 0, 68.2%25 13%25, 31.8%25 13%25);\
--ps:polygon(26%25 33%25, 26%25 76%25, -0.4%25 98.4%25, 0 94%25, 0 1.6%25);\
--pc:polygon(26.6%25 0, 73.4%25 0, 92%25 50%25, 73.4%25 100%25, 26.6%25 100%25, 8%25 50%25);\
--m:0;\
\
color:#{rgb-color(map-get($colors, "digits"))};position:relative;width:var(--s);height:calc(var(--s) * 1.5831818182);display:inline-block}\
.d,.d div{border-radius:calc(var(--s) * 0.1066);overflow:hidden}\
\
.d::before,.d::after{content:"";clip-path:var(--pt)}\
.d::before,.d::after,.d div,.d div::before,.d div::after{position:absolute;left:0;top:0;width:100%25;height:100%25;display:block}\
.d::before,.d::after,.d .a,.d div::before,.d div::after{background:currentColor}\
\
.d .a{top:50%25;height:13%25;transform:translateY(-50%25);clip-path:var(--pc)}\
.d .b {height:50%25}\
.d .b::before,.d .b::after{content: "";clip-path: var(--ps)}\
.d .b::after{transform:rotateY(180deg)}\
.d .c,.d::after{transform:rotateX(180deg)}\
.d .c{transform-origin:0 100%25}\
\
.d::before{opacity:var(--A,1)}\
.e::after{opacity:var(--B,1)}\
.c::after{opacity:var(--C,1)}\
.d::after{opacity:var(--D,1)}\
.c::before{opacity:var(--E,1)}\
.e::before{opacity:var(--F,1)}\
.a{opacity:var(--G, 1)}\
\
.d0{--G:var(--m)}\
.d1{--m:0;--A:var(--m);--D:var(--m);--E:var(--m);--F:var(--m);--G:var(--m);margin-left:calc(var(--s) * -0.742)}\
.d2,.d3,.d7{--F:var(--m)}\
.d3,.d4,.d5,.d7,.d9{--E:var(--m)}\
.d2{--C:var(--m)}\
.d4{--A:var(--m);--D:var(--m)}\
.d5,.d6{--B: var(--m)}\
.d7{--D:var(--m);--G:var(--m)}\
.s > .d:not(:last-of-type){margin-right:calc(var(--s) * 0.16)}';

	@return svg-container($size, create-series($steps, "s", true), $style);
}

@function create-alt($size, $colors, $geometry, $hints) {
	$style: ".c-i{color: #{rgb-color(map-get($colors, 'alt'))};\
--diameter:#{map-get($geometry, 'alt-dots')}px;\
--offset-bottom:#{map-get($geometry, 'alt-offset-bottom')}%25;\
--offset-bottom-text:#{map-get($geometry, 'alt-offset-bottom-text')}%25;\
--offset-center:#{map-get($geometry, 'alt-offset-center')}%25;\
--offset-center-text:#{map-get($geometry, 'alt-offset-center-text')}%25;\
\
background-image:radial-gradient(\
circle at center,\
currentColor calc((var(--diameter) * 0.5) - 1px),\
transparent calc(var(--diameter) * 0.5)\
),\
radial-gradient(\
circle at center,\
currentColor calc((var(--diameter) * 0.5) - 1px),\
transparent calc(var(--diameter) * 0.5)\
);\
background-position:left calc(50%25 + var(--offset-center)) bottom var(--offset-bottom),\
left calc(50%25 - var(--offset-center)) bottom var(--offset-bottom);\
background-size:var(--diameter) var(--diameter);\
background-repeat:no-repeat;\
opacity:0.9;\
}\
\
.c-i::before,.c-i::after{\
position:absolute;\
left:calc(50%25 + (var(--sgn, 1) * var(--offset-center-text)));\
bottom:var(--offset-bottom-text);\
transform:translate(-50%25,100%25);\
font-size:18.2px;\
font-family:Arial, Helvetica, sans-serif;\
font-weight:bold;\
text-transform:uppercase;\
}\
\
.c-i::before{--sgn:-1;content:'#{nth($hints, 1)}'}\
.c-i::after {content:'#{nth($hints, 2)}'}";

	@return svg-container($size, "%3Cdiv class='c-i'%3E%3C/div%3E", $style);
}

@function create-shadows($size, $knob-size, $colors) {
	$style: '.c-i::before{\
--s:#{$knob-size}px;\
content:"";\
position:absolute;\
left:50%25;top:50%25;\
transform:translate(-50%25,-50%25);\
width:calc(var(--s) - 2px);\
height:calc(var(--s) - 2px);\
border-radius:50%25;\
box-shadow:0 56px 70px 8px #{rgb-color(map-get($colors, "shadow-dark"))},\
0 -50px 45px 26px #{rgb-color(map-get($colors, "shadow-light"))}}';

	@return svg-container($size, "%3Cdiv class='c-i'%3E%3C/div%3E", $style);
}

// ========================
// === range-reset.scss ===
// ========================
@mixin range-reset {
	&,
	&::-webkit-slider-runnable-track,
	&::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		position: relative;
		background-color: #0000;
	}

	&::-webkit-slider-runnable-track {
		width: 100%;
		height: 100%;
	}

	&,
	&::-webkit-slider-runnable-track {
		pointer-events: none;
	}

	&,
	&::-moz-range-track,
	&::-moz-range-thumb {
		-webkit-appearance: none;
		appearance: none;
		position: relative;
		border: 0;
		background-color: #0000;
	}

	&::-moz-range-progress {
		appearance: none;
		display: none;
	}

	&::-moz-range-track {
		width: 100%;
		height: 100%;
		pointer-events: none;
	}
}

// ====================
// === knob-ui.scss ===
// ====================
@mixin knob-thumb($colors) {
	width: calc(var(--knob-pseudo-size) * 1em);
	height: calc(var(--knob-pseudo-size) * 1em);
	box-sizing: border-box;
	padding: calc(var(--knob-border-width) / var(--knob-scale));
	border-radius: 50%;

	box-shadow: 0 0 0 0 var(--knob-shadow);
	outline: solid var(--outline-color);
	outline-width: 0;

	background-image: svg-container(
			20,
			'%3Cdiv class="c-i"%3E%3C/div%3E',
			'.c-i{border-radius:50px;background:#{rgb-color(map-get($colors, "knob-pointer"))}}'
		),
		var(--knob-face-gradient), var(--knob-border-gradient);
	background-size: var(--knob-tip-size) var(--knob-tip-size), 100% 100%,
		100% 100%;
	background-position: left 50% bottom 10%, 0 0, 0 0;
	background-repeat: no-repeat;
	background-clip: border-box, content-box, border-box;
	background-origin: content-box, border-box, border-box;

	transition-duration: 100ms, 50ms, var(--drag-duration);
	transition-timing-function: ease-out, ease-out, var(--drag-timing-func);
	pointer-events: auto;
	cursor: var(--cur-drag);
}

@mixin kbon-thumb-hover {
	box-shadow: 0 0 7em 0 var(--knob-shadow);
}

@mixin knob-ui($colors) {
	&::-webkit-slider-thumb {
		@include knob-thumb($colors);

		left: var(--translate, 0);
		top: var(--center, 0);
		transform: rotate(calc(var(--start-angle, 0) * 1deg))
			rotate(var(--current-angle, 0)) scale(var(--knob-scale));
		transition-property: box-shadow, outline, transform;
	}

	&::-moz-range-thumb {
		@include knob-thumb($colors);

		translate: var(--translate, 0) 0;
		scale: var(--knob-scale);
		rotate: calc((var(--start-angle, 0) * 1deg) + var(--current-angle, 0));
		transition-property: box-shadow, outline, rotate;
	}

	&:hover {
		&::-moz-range-thumb {
			@include kbon-thumb-hover;
		}

		&::-webkit-slider-thumb {
			@include kbon-thumb-hover;
		}
	}

	&:active {
		cursor: var(--cur-dragging);
	}

	&::-moz-range-thumb:active {
		cursor: var(--cur-dragging);
	}

	&::-webkit-slider-thumb:active {
		cursor: var(--cur-dragging);
	}

	&:focus-visible {
		outline: none;

		&::-moz-range-thumb {
			outline-width: var(--outline-width);
		}

		&::-webkit-slider-thumb {
			outline-width: var(--outline-width);
		}
	}
}

// ======================
// === knob-main.scss ===
// ======================
@mixin knob(
	$size: 533,
	$unit: 0.152vmin,
	$ticks: 100,
	$steps: 10,
	$angles: (
		full: 250,
		start: 55,
		negative-step: -0.6
	),
	$geometry: (
		knob-size: 300,
		knob-pseudo-size: 100,
		knob-tip-size: 9%,
		knob-border-width: 1.6%,
		ticks-radius: 38.5931,
		digits-radius: 45.03726,
		ticks-width: 3,
		ticks-height: 8,
		ticks-step-height: 10,
		alt-dots: 10,
		alt-offset-bottom: 13,
		alt-offset-bottom-text: 12.5,
		alt-offset-center: 18.78,
		alt-offset-center-text: 18.28
	),
	$colors: (
		knob-pointer: #282828,
		tick: #a1a1a1,
		step: #585656,
		digits: rgba(40, 40, 40, 0.859),
		alt: #282828,
		shadow-dark: rgba(0, 0, 0, 0.45),
		shadow-light: rgba(255, 255, 255, 0.6)
	),
	$hints: (
		"min",
		"max"
	),
	$cursors: (
		drag: grab,
		dragging: grabbing
	)
) {
	@include range-reset;

	font-size: .2px;
	--full-angle: #{map-get($angles, "full")};
	--start-angle: #{map-get($angles, "start")};

	--size: #{$size};
	--knob-size: #{map-get($geometry, "knob-size")};
	--knob-tip-size: #{map-get($geometry, "knob-tip-size")};
	--knob-pseudo-size: #{map-get($geometry, "knob-pseudo-size")};
	--knob-border-width: #{map-get($geometry, "knob-border-width")};
	--knob-scale: calc(var(--knob-size) / var(--knob-pseudo-size));

	--calc-size: calc(var(--size) * 1em);
	--calc-knob-size: calc(var(--size) * (var(--knob-size) / 100) * 1em);

	--mapped: calc(
		(var(--value) - var(--min, 0)) / (var(--max, 100) - var(--min, 0))
	);
	--current-angle: calc(var(--full-angle, 360) * var(--mapped, 0) * 1deg);

	--calc-size-diff: calc(var(--size) - var(--knob-pseudo-size));
	--center: calc(var(--calc-size-diff) * 0.5em);
	--translate: calc(
		(var(--calc-size-diff) * var(--mapped, 0) * -1em) + var(--center)
	);

	--cur-drag: #{map-get($cursors, "drag")};
	--cur-dragging: #{map-get($cursors, "dragging")};

	width: var(--calc-size);
	height: var(--calc-size);
	overflow: hidden;

	background-image: 
        // create-shadows($size, map-get($geometry, "knob-size"), $colors),
		create-digits-layer(5260, $steps, $angles, $colors, $geometry),
		create-alt(520, $colors, $geometry, $hints),
		create-ticks(5260, $ticks, $steps, $angles, $colors, $geometry);
	background-position: 0 0;
	background-size: 100% 100%;
	background-repeat: no-repeat;
	border-radius: 50%;

	visibility: hidden;
	animation: appear steps(2) 20ms calc(var(--drag-duration) * 2) forwards;

	@include knob-ui($colors);
}

@keyframes appear {
	to {
		visibility: visible;
	}
}

// ==================
// === index.scss ===
// ==================
.knob {
	@include knob();

	--outline-color: rgba(0, 100, 200, 0.5);
	--outline-width: 3em;
	--drag-duration: 500ms;
	--drag-timing-func: cubic-bezier(0.18, 0.89, 0.32, 1.28);
	--knob-shadow: rgba(0, 0, 0, 0.6);
	--knob-face-gradient: linear-gradient(#f1f1f1, #fff);
	--knob-border-gradient: linear-gradient(#fff 34%, #d1d1d1);
}

// =================
// === reset.css ===
// =================
html,
body {
	height: 100%;
}

html {
	background: #e8e8e8;
}

body {
	display: grid;
	place-items: center;
	overscroll-behavior-y: contain;
}

* {
	padding: 0;
	margin: 0;
}

</style>