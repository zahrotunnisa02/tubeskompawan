<?php session_start();

if (!isset($_SESSION['role'])) {
	header('Location: login.php');
}

include_once("connection.php");
include_once("header.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Website Caffe's</title>
</head>

<body>
	<div class="slider-container">
		<div class="slides">
			<!-- Gambar akan dimasukkan melalui JavaScript -->
		</div>
	</div>



</body>
<style>
	/* Styling untuk slider */
	.slider-container {
		width: 100%;
		overflow: hidden;
	}

	.slides {
		display: flex;
		transition: transform 0.5s ease-in-out;
	}

	.slide {
		min-width: 100%;
		height: 500px;
		object-fit: cover;
		object-position: center;
	}
</style>
<script>
	const images = ['../images/foto1.jpg', '../images/urban.jpeg', '../images/foto3.jpeg']; // Array sumber gambar
	const slideContainer = document.querySelector('.slides');

	// Mendapatkan sumber gambar dari array dan membuat elemen img untuk setiap gambar
	images.forEach(image => {
		const img = document.createElement('img');
		img.src = image;
		img.alt = 'Slide';
		img.classList.add('slide');
		slideContainer.appendChild(img);
	});

	const slides = document.querySelectorAll('.slide');
	let currentSlide = 0;
	const slideWidth = slides[0].clientWidth;

	function nextSlide() {
		currentSlide = (currentSlide + 1) % slides.length;
		slideContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
	}

	setInterval(nextSlide, 3000);

</script>

</html>