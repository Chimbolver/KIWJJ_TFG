<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KICK IT WITH JJ</title>
    <link rel="stylesheet" href="aboutus_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <?php include "../indice/header.php" ?>
    <style>
        *{
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        body {   
            font-family: Georgia, 'Times New Roman', Times, serif;
            background: linear-gradient(120deg, #f0ece6, #c8b59b);
            margin: 0;
            padding: 0;
        }

        .about-us-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 20px;
            text-align: center;
            color: #3e3e3e;
        }

        .about-us-header {
            font-size: 3em;
            font-weight: bold;
            color: #3e3e3e;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .about-us-content {
            font-size: 1.2em;
            line-height: 1.8;
            color: #5e5345;
            margin-bottom: 50px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .highlight {
            color: #7a6e5d;
            font-weight: bold;
        }

        .nosotros {
            display: block;
            width: 90%;
            max-width: 300px;
            margin: 30px auto;
            animation: zoomIn 1.5s ease, spin 10s linear infinite;
        }

        @media (max-width: 768px) {
            .nosotros {
                width: 80%;
                max-width: 250px;
                margin: 20px auto;
            }
        }

        @media (max-width: 480px) {
            .nosotros {
                width: 70%;
                max-width: 200px;
                margin: 15px auto;
            }
        }

        @media (min-width: 1440px) {
            .nosotros {
                max-width: 400px;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .about-us-button {
            display: inline-block;
            padding: 15px 30px;
            margin-top: 30px;
            background-color: #7a6e5d;
            color: #f5f5f0;
            text-decoration: none;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.4s ease;
            animation: bounceIn 1.5s ease-in-out;
        }

        .about-us-button:hover {
            background-color: #f0ece6;
            color: #3e3e3e;
            transform: scale(1.05);
        }


        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }

        .card {
            background-color: #f5f5f0;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 300px;
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card-content {
            padding: 20px;
            text-align: left;
        }

        .card-content h3 {
            color: #3e3e3e;
            margin-bottom: 10px;
        }

        .card-content p {
            color: #5e5345;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .faaa {
            margin-top: 30px;
            text-align: center;
            font-size: 48px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.8);
            }

            60% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .about-us-header {
                font-size: 2.5em;
            }

            .about-us-content {
                font-size: 1.1em;
            }

            .about-us-button {
                padding: 12px 25px;
                font-size: 1em;
            }

            .about-us-image {
                height: 45vh;
                width: 20vw;
            }
        }

        @media (max-width: 480px) {
            .about-us-header {
                font-size: 2em;
            }

            .about-us-content {
                font-size: 1em;
            }

            .about-us-image {
                padding: 12px 25px;
                font-size: 1em;
            }
        }
    </style>
    </head>

    <body>
        <div class="about-us-container">
            <h1 class="about-us-header">Sobre Nosotros</h1>
            <p class="about-us-content">
                Soy Juan José y desde pequeño he sentido una <span class="highlight">pasión inmensa por las zapatillas,
                    la moda y el arte</span>. Así nació KICK IT WITH JJ, un espacio donde podemos conectar a través de
                algo que todos amamos: las zapatillas. No somos solo una tienda, somos una comunidad donde cada uno de
                ustedes tiene un lugar.
            </p>
            <img src="../imagenes/logoredondo.png" alt="About Us Image" class="nosotros">
            <p class="about-us-content">
                Aquí puedes <span class="highlight">comprar, vender o pujar por sneakers exclusivas</span>, y lo más
                importante, ser parte de una familia que comparte la misma pasión. No importa si eres un experto
                coleccionista o si recién empiezas; queremos que te sientas bienvenido y seguro en cada transacción, y
                que juntos creemos recuerdos inolvidables.
            </p>
            <a href="../login/registro.php" class="about-us-button">Únete a Nosotros</a>
        </div>
        <div class="card-container">
            <div class="card">
                <div class="faaa"><i class="fa-solid fa-cart-shopping"></i></div>
                <div class="card-content">
                    <h3>Compra Sneakers Exclusivas</h3>
                    <p>Encuentra las zapatillas que siempre has deseado. Nuestra colección está llena de modelos únicos
                        y exclusivos para ti.</p>
                </div>
            </div>
            <div class="card">
                <div class="faaa"><i class="fa-solid fa-money-bill"></i></div>
                <div class="card-content">
                    <h3>Vende tus Sneakers</h3>
                    <p>¿Tienes zapatillas que ya no usas? Véndelas en nuestra plataforma y encuentra un nuevo hogar para
                        ellas con la mejor comunidad de amantes de sneakers.</p>
                </div>
            </div>
            <div class="card">
                <div class="faaa"><i class="fa-solid fa-check"></i></div>
                <div class="card-content">
                    <h3>Puja y Gana</h3>
                    <p>Participa en nuestras subastas y consigue zapatillas únicas a un precio increíble. ¡La emoción de
                        ganar está a solo un paso!</p>
                </div>
            </div>
        </div>
        </div><br><br>
    </body>

</html>

<?php include "../indice/footer.php" ?>

</body>