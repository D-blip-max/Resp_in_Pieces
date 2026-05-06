<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar contraseña</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f7fa; color: #333; }
        .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .button-container { text-align: center; margin: 30px 0; }
        .button { display: inline-block; padding: 12px 30px; background-color: #667eea; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .button:hover { background-color: #764ba2; }
        .footer { background-color: #f5f7fa; padding: 20px; text-align: center; border-top: 1px solid #e0e0e0; font-size: 12px; color: #999; }
        a { color: #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmar Contraseña</h1>
        </div>
        <div class="content">
            <p>¡Hola {{ $user->name }}!</p>
            <p>Solicitaste acceder a una sección protegida. Por favor, confirma tu contraseña para continuar.</p>

            <div class="button-container">
                <a href="{{ $actionUrl }}" class="button">Confirmar Contraseña</a>
            </div>

            <p>Si no realizaste esta solicitud, puedes ignorar este correo.</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>

