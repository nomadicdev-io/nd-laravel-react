<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{config('app.name')}}
</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="PGS" />
	<link rel="shortcut icon" href="{{ asset('assets/frontend/dist/images/favicon.ico') }}">

	<script>
	(function () {
		window.onpageshow = function(event) {
			document.querySelector('body').classList.remove('render');

			if (event.persisted) {
				window.location.reload();
			}
		};
	})();
	</script>

	<style>


main {
	background-color: #ebebeb;
	padding: 5vh;
	min-height: 90vh;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
}


/* main:after {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: #68f14b;
      background: -o-linear-gradient(left, #68f14b 0%, #03c06b 100%);
      background: -webkit-gradient(linear, left top, right top, from(#68f14b), to(#03c06b));
      background: linear-gradient(90deg, #68f14b 0%, #03c06b 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="$b_g_color", endColorstr="$b_g_color_2", GradientType=1);
  } */

.coming_soon_wrap {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	width: 100%;
	background-color: #FFF;
	z-index: 100;

}

.coming_soon_wrap .logo_box {
	width: 15vw;
	margin-bottom: 3vh;
    margin-top: 6vh;
}

.coming_soon_wrap .logo_box img {
	width: 100%;
	height: auto;
}

.coming_soon_wrap .text_ {
	color: #47433f;
	text-align: center;
}

.coming_soon_wrap .text_ h1 strong {
	color: #11f276;
	font-weight: 800;
}

.coming_soon_wrap .text_ h1 {
	font-weight: 400;
	font-size: 2.1vw;
	line-height: 1.1;
  margin: 0;
  margin-bottom: 15px;
}

.coming_soon_wrap .text_ p {
	font-size: 1.3vw;
	letter-spacing: 2px;
	line-height: 1.5;
	max-width: 60vw;
	margin-top: 0;
	margin-bottom: 0;
	margin-left: auto;
	margin-right: auto;
}
.clock_wrapper {
	-webkit-box-flex: 1;
	    -ms-flex: 1;
	        flex: 1;
    padding-top: 16vh;
}
.clock_wrapper .text_{
    margin-top: 5vh;
}

.flip-clock-container {
  direction: ltr;
  font-family: Arial;
  padding: 0;
  margin: 0;
  list-style: none;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  --flip-bg-color: #20b054;
  --flip-text-color: #fff;
  --flip-dots-color: #20b054;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: reverse;
      -ms-flex-direction: row-reverse;
          flex-direction: row-reverse;
}

.flip-clock-container * {
  padding: 0;
  margin: 0;
  list-style: none;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

.flip-clock-container *::before, .flip-clock-container *::after {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

.flip-clock-container [class|="flip-item"] {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: reverse;
      -ms-flex-direction: row-reverse;
          flex-direction: row-reverse;
}

.flip-clock-container [class|="flip-item"]::before {
  content: ":";
  font-family: 'Cera Pro';
  font-size: 70px;
  color: var(--flip-dots-color);
  line-height: 75px;
  margin: 0;
}

.flip-clock-container [class|="flip-item"]:first-child::before {
  content: none;
}

.flip-clock-container [class|="flip-item"] .flip-digit {
	width: 50px;
	height: 85px;
  position: relative;
  margin: 0 2px;
}

.flip-clock-container [class|="flip-item"] .flip-digit > span {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: block;
  -webkit-perspective: 300px;
          perspective: 300px;
}

.flip-clock-container [class|="flip-item"] .flip-digit > span::after, .flip-clock-container [class|="flip-item"] .flip-digit > span::before {
  content: attr(data-digit);
  position: absolute;
  left: 0;
  width: 100%;
  height: 50%;
  font-size: 60px;
  font-weight: 100;
  text-align: center;
  color: var(--flip-text-color);
  background-color: var(--flip-bg-color);
  overflow: hidden;
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
}

.flip-clock-container [class|="flip-item"] .flip-digit > span::before {
  top: 0;
  line-height: 90px;
  border-radius: 10px 10px 0 0;
  /*border-bottom: 1px solid #000;*/
  -webkit-transform-origin: bottom;
  -ms-transform-origin: bottom;
      transform-origin: bottom;
}

.flip-clock-container [class|="flip-item"] .flip-digit > span::after {
  bottom: 0;
  line-height: 3px;
  border-radius: 0 0 10px 10px;
  /*border-top: 1px solid #000;*/
  -webkit-transform-origin: top;
  -ms-transform-origin: top;
      transform-origin: top;
}

.flip-clock-container [class|="flip-item"] .flip-digit.flipping .flip-digit-next {
  z-index: 0;
  -webkit-animation: afterZIndexAnim 0.9s linear forwards;
          animation: afterZIndexAnim 0.9s linear forwards;
}

.flip-clock-container [class|="flip-item"] .flip-digit.flipping .flip-digit-next::before {
  -webkit-animation: afterUpShadowAnim 0.9s linear forwards;
          animation: afterUpShadowAnim 0.9s linear forwards;
}

.flip-clock-container [class|="flip-item"] .flip-digit.flipping .flip-digit-next::after {
  -webkit-animation: afterFlipAnim 0.9s linear forwards, afterDownShadowAnim 0.9s linear forwards;
          animation: afterFlipAnim 0.9s linear forwards, afterDownShadowAnim 0.9s linear forwards;
}

.flip-clock-container [class|="flip-item"] .flip-digit.flipping .flip-digit-current {
  z-index: 1;
  -webkit-animation: currentZIndexAnim 0.9s linear forwards;
          animation: currentZIndexAnim 0.9s linear forwards;
}

.flip-clock-container [class|="flip-item"] .flip-digit.flipping .flip-digit-current::before {
  -webkit-animation: currentFlipAnim 0.9s linear forwards, currentUpShadowAnim 0.9s linear forwards;
          animation: currentFlipAnim 0.9s linear forwards, currentUpShadowAnim 0.9s linear forwards;
}

.flip-clock-container [class|="flip-item"] .flip-digit.flipping .flip-digit-current::after {
  -webkit-animation: currentDownShadowAnim 0.9s linear forwards;
          animation: currentDownShadowAnim 0.9s linear forwards;
}

@-webkit-keyframes afterZIndexAnim {
  0% {
    z-index: 0;
  }
  100% {
    z-index: 1;
  }
}

@keyframes afterZIndexAnim {
  0% {
    z-index: 0;
  }
  100% {
    z-index: 1;
  }
}

@-webkit-keyframes currentZIndexAnim {
  0% {
    z-index: 1;
  }
  100% {
    z-index: 0;
  }
}

@keyframes currentZIndexAnim {
  0% {
    z-index: 1;
  }
  100% {
    z-index: 0;
  }
}

@-webkit-keyframes afterFlipAnim {
  0% {
    -webkit-transform: rotateX(180deg);
            transform: rotateX(180deg);
  }
  100% {
    -webkit-transform: rotateX(0);
            transform: rotateX(0);
  }
}

@keyframes afterFlipAnim {
  0% {
    -webkit-transform: rotateX(180deg);
            transform: rotateX(180deg);
  }
  100% {
    -webkit-transform: rotateX(0);
            transform: rotateX(0);
  }
}

@-webkit-keyframes afterUpShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 -100px 20px -10px #179846;
            box-shadow: inset 0 -100px 20px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
  }
}

@keyframes afterUpShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 -100px 20px -10px #179846;
            box-shadow: inset 0 -100px 20px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
  }
}

@-webkit-keyframes afterDownShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 100px 20px -10px #179846;
            box-shadow: inset 0 100px 20px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
  }
}

@keyframes afterDownShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 100px 20px -10px #179846;
            box-shadow: inset 0 100px 20px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 20px -10px rgba(0, 0, 0, 0);
  }
}

@-webkit-keyframes currentFlipAnim {
  0% {
    -webkit-transform: rotateX(0deg);
            transform: rotateX(0deg);
  }
  100% {
    -webkit-transform: rotateX(-180deg);
            transform: rotateX(-180deg);
  }
}

@keyframes currentFlipAnim {
  0% {
    -webkit-transform: rotateX(0deg);
            transform: rotateX(0deg);
  }
  100% {
    -webkit-transform: rotateX(-180deg);
            transform: rotateX(-180deg);
  }
}

@-webkit-keyframes currentUpShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
  }
  50% {
    -webkit-box-shadow: inset 0 -50px 25px -10px #179846;
            box-shadow: inset 0 -50px 25px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 -100px 25px -10px #179846;
            box-shadow: inset 0 -100px 25px -10px #179846;
  }
}

@keyframes currentUpShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
  }
  50% {
    -webkit-box-shadow: inset 0 -50px 25px -10px #179846;
            box-shadow: inset 0 -50px 25px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 -100px 25px -10px #179846;
            box-shadow: inset 0 -100px 25px -10px #179846;
  }
}

@-webkit-keyframes currentDownShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
  }
  50% {
    -webkit-box-shadow: inset 0 50px 25px -10px #179846;
            box-shadow: inset 0 50px 25px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 100px 25px -10px #179846;
            box-shadow: inset 0 100px 25px -10px #179846;
  }
}

@keyframes currentDownShadowAnim {
  0% {
    -webkit-box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 15px -10px rgba(0, 0, 0, 0);
  }
  50% {
    -webkit-box-shadow: inset 0 50px 25px -10px #179846;
            box-shadow: inset 0 50px 25px -10px #179846;
  }
  100% {
    -webkit-box-shadow: inset 0 100px 25px -10px #179846;
            box-shadow: inset 0 100px 25px -10px #179846;
  }
}

.flip-clock-container [class|="flip-item"] {
	position: relative;
	padding-bottom: 30px;
}
.flip-item-days:after {
	content: 'Days';
}
.flip-item-hours:after {
	content: 'Hours';
}
.flip-item-minutes:after {
	content: 'Minutes';
}
.flip-item-seconds:after {
	content: 'Seconds';
}
.flip-item-seconds:after ,
.flip-item-minutes:after ,
.flip-item-hours:after ,
.flip-item-days:after {
    position: absolute;
    display: block;
    font-size: 13px;
    left: 0;
    bottom: 0;
    text-align: center;
    letter-spacing: 1px;
    color: #b3b3b3;
}
.flip-item-minutes:after ,
.flip-item-hours:after ,
.flip-item-days:after {
	width: calc(100% - 38.5px);
}
.flip-item-seconds:after  {
	width: 100%;
}

body.render .coming_soon_wrap > * {
  opacity: 0;

}
body .coming_soon_wrap > * {
  opacity: 1;
  -webkit-transition: all .3s ease-in-out;
  -o-transition: all .3s ease-in-out;
  transition: all .3s ease-in-out;
}
.head_ {
    font-size: 2vw;
    margin-bottom: 1em;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: center;
    color: #9a9a9a;
}
@media only screen and (max-width: 1024px) {
	.coming_soon_wrap .logo_box {
		width: 25vw;
	}
	.coming_soon_wrap .text_ h1 {
		font-size: 3.5vw;
	}
	.coming_soon_wrap .text_ p {
		font-size: 2.3vw;
		max-width: 70vw;
	}
}
@media only screen
  and (min-device-width: 768px)
  and (max-device-width: 1024px)
  and (orientation: landscape) {
    .coming_soon_wrap .logo_box {
    width: 19vw;
}
.clock_wrapper {
  padding-top: 12vh;
}.coming_soon_wrap .text_ h1 {
    font-size: 2.8vw;
}
.coming_soon_wrap .text_ p {
    font-size: 18px;
}
}
@media only screen and (max-width: 767px) {
	main {
		padding: 3vh;
		min-height: 94vh;
	}
	.coming_soon_wrap {
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		    -ms-flex-direction: column;
		        flex-direction: column;
		-webkit-box-pack: justify;
		    -ms-flex-pack: justify;
		        justify-content: space-between;
	}
	.coming_soon_wrap .logo_box {
		width: 40vw;
		margin-top: 3vh;
		margin-bottom: 3vh;
	}
	.coming_soon_wrap .text_ h1 {
		font-size: 6vw;
    line-height: 1;
    margin-bottom: 10px;
	}
	.coming_soon_wrap .text_ p {
		font-size: 3.9vw;
		max-width: 100%;
		letter-spacing: 1px;
	}
	.coming_soon_wrap .text_ {
		padding: 0 5vw;
		-webkit-box-flex: 1;
		    -ms-flex: 1;
		        flex: 1;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		    -ms-flex-direction: column;
		        flex-direction: column;
		-webkit-box-align: center;
		    -ms-flex-align: center;
		        align-items: center;
		-webkit-box-pack: center;
		    -ms-flex-pack: center;
		        justify-content: center;
	}
	.flip-clock-container [class|="flip-item"]::before {
		font-size: 38px;
		line-height: 55px;
		margin: 0 2px;
	}
	.flip-clock-container [class|="flip-item"] .flip-digit {
		width: 30px;
		height: 55px;
		margin: 0 1px;
	}
	.flip-clock-container [class|="flip-item"] .flip-digit > span::after,
	.flip-clock-container [class|="flip-item"] .flip-digit > span::before {
		font-size: 35px;
	}
	.flip-clock-container [class|="flip-item"] .flip-digit > span::before {
		line-height: 55px;
    	border-radius: 7px 7px 0 0;
	}
	.flip-clock-container [class|="flip-item"] .flip-digit > span::after {
    	border-radius: 0 0 7px 7px;
	}
	.flip-clock-container [class|="flip-item"] {
		padding-bottom: 20px;
	}
	.flip-item-seconds:after, .flip-item-minutes:after, .flip-item-hours:after, .flip-item-days:after {
		font-size: 11px;
	}
	.flip-item-minutes:after,
	.flip-item-hours:after,
	.flip-item-days:after {
		width: calc(100% - 20.91px);
	}
	.clock_wrapper {
		padding-top: 20vh;
	}
	.clock_wrapper .text_ {
    margin-top: 5vh;
}
}
@media only screen
  and (min-device-width: 320px)
  and (max-device-width: 767px)
  and (orientation: landscape) {
    .coming_soon_wrap .logo_box {
    width: 25vw;
    }
    .coming_soon_wrap .text_ h1 {
    font-size: 4vw;
    }
    .clock_wrapper {
    padding-top: 10vh;
}
.coming_soon_wrap .text_ p {
    font-size: 14px;
}
.flip-clock-container [class|="flip-item"] .flip-digit > span::before {
    line-height: 60px;
}
}
@media only screen and (max-width: 330px) {
  .flip-clock-container [class|="flip-item"] .flip-digit {
    width: 25px;
    height: 40px;
  }
  .flip-clock-container [class|="flip-item"] .flip-digit > span::before {
    line-height: 40px;
  }
  .flip-clock-container [class|="flip-item"] .flip-digit > span::after, .flip-clock-container [class|="flip-item"] .flip-digit > span::before {
    font-size: 25px;
  }
  .flip-clock-container [class|="flip-item"]::before {
    font-size: 30px;
    line-height: 34px;
  }
  .flip-item-seconds:after, .flip-item-minutes:after, .flip-item-hours:after, .flip-item-days:after {
    font-size: 10px;
    letter-spacing: 0;
  }
  .flip-clock-container [class|="flip-item"] {
    padding-bottom: 17px;
  }
}
	</style>
</head>

<body class="render" >
	<main>
		<div class="coming_soon_wrap">
			<div class="logo_box">
				<img src="{{ asset('assets/frontend/dist/images/logo.svg') }}" />
			</div>
            <div class="text_">
					<p>Our website is currently undergoing scheduled maintenance. We will be back shortly. Thank you for your patience.</p>
				</div>

		</div>
	</main>
</body>

</html>
