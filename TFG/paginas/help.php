<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - KICK IT WITH JJ</title>
    <link rel="stylesheet" href="help_styles.css">
    <style>
        *{
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        body {
            background: linear-gradient(120deg, #f0ece6, #c8b59b);
            margin: 0;
            padding: 0;
        }

        .help-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            color: #3e3e3e;
        }

        .help-header {
            font-size: 3em;
            font-weight: bold;
            color: #3e3e3e;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .help-content {
            font-size: 1.2em;
            line-height: 1.8;
            color: #5e5345;
            margin-bottom: 50px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .help-faq {
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }

        .faq-item {
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .faq-question {
            background-color: #7a6e5d;
            color: #f5f5f0;
            padding: 15px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.4s;
        }

        .faq-question:hover {
            background-color: #5e5345;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background-color: #f5f5f0;
            color: #3e3e3e;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .help-contact {
            margin-top: 50px;
            text-align: center;
        }

        .contact-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #7a6e5d;
            color: #f5f5f0;
            text-decoration: none;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.4s ease;
            animation: bounceIn 1.5s ease-in-out;
        }

        .contact-button:hover {
            background-color: #f0ece6;
            color: #3e3e3e;
            transform: scale(1.05);
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
            .help-header {
                font-size: 2.5em;
            }

            .help-content {
                font-size: 1.1em;
            }

            .contact-button {
                padding: 12px 25px;
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {
            .help-header {
                font-size: 2em;
            }

            .help-content {
                font-size: 1em;
            }
        }
    </style>
</head>

<body>
    <?php include '../indice/header.php'; ?>

    <div class="help-container">
        <h1 class="help-header">Centro de Ayuda</h1>
        <p class="help-content">Estamos aquí para ayudarte. Encuentra las respuestas a tus preguntas más comunes y conoce cómo puedes disfrutar al máximo de nuestra plataforma.</p>

        <div class="help-faq">
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Cómo comprar zapatillas en KICK IT WITH JJ?</div>
                <div class="faq-answer">Para comprar tus zapatillas favoritas, simplemente navega por nuestro catálogo, selecciona el producto que deseas y sigue los pasos de pago seguros.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Cómo puedo vender mis zapatillas?</div>
                <div class="faq-answer">Subir tus zapatillas a nuestra plataforma es fácil. Haz clic en 'Vender', proporciona las fotos y detalles, y estaremos listos para conectarte con compradores.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Qué es la opción de pujas?</div>
                <div class="faq-answer">La opción de pujas te permite ofertar por zapatillas exclusivas y conseguir el mejor precio. Participa y siente la emoción de ganar la subasta.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Cómo sé que mis zapatillas son auténticas?</div>
                <div class="faq-answer">En KICK IT WITH JJ, nos aseguramos de que cada par de zapatillas pase por un riguroso proceso de autenticación para garantizar que recibas productos 100% originales.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Cuánto tiempo tarda el envío?</div>
                <div class="faq-answer">El tiempo de envío varía dependiendo de tu ubicación. Generalmente, los pedidos se entregan entre 5 a 10 días hábiles.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Puedo devolver un artículo si no estoy satisfecho?</div>
                <div class="faq-answer">Sí, aceptamos devoluciones bajo ciertas condiciones. Consulta nuestra política de devoluciones para más detalles.</div>
            </div>
            <div class="faq-item">
                <div class="faq-question">&#9656; ¿Cuáles son las formas de pago aceptadas?</div>
                <div class="faq-answer">Aceptamos varias formas de pago, incluyendo tarjetas de crédito, débito y PayPal. Nuestro sistema de pago es seguro y confiable.</div>
            </div>
        </div>

        <div class="help-contact">
            <a href="contacto.php" class="contact-button">Contáctanos</a>
        </div>
    </div>

    <?php include '../indice/footer.php'; ?>

    <script>
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            question.addEventListener('click', () => {
                const isVisible = answer.style.display === 'block';
                faqItems.forEach(i => i.querySelector('.faq-answer').style.display = 'none');
                answer.style.display = isVisible ? 'none' : 'block';
            });
        });
    </script>
</body>

</html>
