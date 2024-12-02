<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos - KICK IT WITH JJ</title>
    <link rel="stylesheet" href="contacto_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <?php include '../indice/header.php'; ?>
    <style>
        body {
           
            background: linear-gradient(120deg, #f0ece6, #d8c3a5);
            margin: 0;
            padding: 0;
        }
*{
    font-family: Georgia, 'Times New Roman', Times, serif;
}
        .contact-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            color: #3e3e3e;
        }

        .contact-header {
            font-size: 3em;
            font-weight: bold;
            color: #3e3e3e;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .contact-content {
            font-size: 1.2em;
            line-height: 1.8;
            color: #5e5345;
            margin-bottom: 50px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .contact-form {
            max-width: 700px;
            margin: 0 auto;
            text-align: left;
            background-color: #f5f5f0;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            animation: slideIn 1.5s ease-in-out;
            position: relative;
        }

        .contact-form label {
            font-weight: bold;
            color: #3e3e3e;
            display: block;
            margin-bottom: 10px;
            animation: fadeInLabel 1s ease-in-out;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            margin: 10px 0 20px;
            border-radius: 15px;
            border: 2px solid #ccc;
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            animation: slideInInput 1.2s ease-in-out;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border: 2px solid #7a6e5d;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #f9f9f9;
            transform: scale(1.02);
        }

        .contact-form textarea {
            resize: vertical;
        }

        .contact-form button {
            display: inline-block;
            padding: 15px 50px;
            background-color: #7a6e5d;
            color: #f5f5f0;
            text-decoration: none;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            animation: pulse 2s infinite;
        }

        .contact-form button:hover {
            background-color: #f0ece6;
            color: #3e3e3e;
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }

        .contact-info {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            animation: fadeIn 2s ease-in-out;
            flex-wrap: wrap;
            gap: 20px;
        }

        .contact-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 280px;
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .contact-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .contact-card h3 {
            color: #3e3e3e;
            margin-bottom: 10px;
        }

        .contact-card p {
            color: #5e5345;
            line-height: 1.6;
        }

        .contact-card .faaa {
            font-size: 3em;
            margin-bottom: 15px;
            animation: popIn 1.5s ease-in-out;
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

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-50%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInInput {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLabel {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes popIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .contact-header {
                font-size: 2.5em;
            }

            .contact-content {
                font-size: 1.1em;
            }

            .contact-form button {
                padding: 12px 25px;
                font-size: 1em;
            }

            .contact-info {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .contact-header {
                font-size: 2em;
            }

            .contact-content {
                font-size: 1em;
            }

            .contact-form {
                padding: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="contact-container">
        <h1 class="contact-header">Contáctanos</h1>
        <p class="contact-content">¿Tienes alguna duda, sugerencia o simplemente quieres saludarnos? ¡Estamos aquí para
            ayudarte! Ponte en contacto con nosotros a través del formulario o la información de contacto que aparece a
            continuación.</p>

        <div class="contact-form">
            <form action="" method="POST" onsubmit="return showAlert()">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Mensaje:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Enviar Mensaje</button>
            </form>
        </div>

        <script>
            function showAlert() {
                alert("El mensaje ha sido enviado de manera correcta.");
                return true;
            }
        </script>


        <div class="contact-info">
            <div class="contact-card">
                <div class="faaa"><i class="fa-solid fa-envelope"></i></div>
                <h3>Email</h3>
                <p>info@kickitwithjj.com</p>
            </div>

            <div class="contact-card">
                <div class="faaa"><i class="fa-solid fa-phone"></i></div>
                <h3>Teléfono</h3>
                <p>+34 600 123 456</p>
            </div>

            <div class="contact-card">
                <div class="faaa"><i class="fa-solid fa-location-dot"></i></div>
                <h3>Dirección</h3>
                <p>Calle Sneakers, 45, Madrid, España</p>
            </div>
        </div>
    </div>

    <?php include '../indice/footer.php'; ?>
</body>

</html>