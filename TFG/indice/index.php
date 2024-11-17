<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KICK IT WITH JJ</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        body {
           
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0ece6;
        }

        .carousel-container {
            margin-top: 10vh;
            margin-bottom: 10vh;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .carousel {
            position: relative;
            width: 90%;
            max-width: 800px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .carousel-inner {
            display: flex;
            transition: transform 0.8s ease-in-out;
        }

        .carousel-item {
            min-width: 100%;
            transition: transform 0.5s ease;
        }

        .carousel-item img {
            width: 100%;
            border-radius: 15px;
        }

        .carousel-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .carousel-button {
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            color: #fff;
            font-size: 2em;
            cursor: pointer;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .carousel-button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        @media (max-width: 600px) {
            .carousel-button {
                font-size: 1.5em;
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <?php include "header.php" ?>
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <a href="../paginas/productos.php"><img src="../imagenes/comprar.webp" alt="Imagen 1"></a>
                </div>
                <div class="carousel-item">
                    <a href="../paginas/vender.php"><img src="../imagenes/vender.webp" alt="Imagen 2"></a>
                </div>
                <div class="carousel-item">
                    <a href="../paginas/pujar.php"><img src="../imagenes/BID.png" alt="Imagen 3"></a>
                </div>
            </div>
            <div class="carousel-controls">
                <button class="carousel-button" id="prev">&#8249;</button>
                <button class="carousel-button" id="next">&#8250;</button>
            </div>
        </div>
    </div>

    <script>
        const carouselInner = document.querySelector('.carousel-inner');
        const carouselItems = document.querySelectorAll('.carousel-item');
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        let currentIndex = 0;

        function updateCarousel() {
            const offset = -currentIndex * 100;
            carouselInner.style.transform = `translateX(${offset}%)`;
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : carouselItems.length - 1;
            updateCarousel();
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex < carouselItems.length - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        });

        // Auto-slide functionality
        setInterval(() => {
            nextButton.click();
        }, 5000); // Change image every 5 seconds
    </script>
    <?php include "footer.php" ?>
</body>

</html>