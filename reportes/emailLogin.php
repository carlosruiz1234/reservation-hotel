<?php
// reportes/emailLogin.php
// Variables disponibles: $nombre

$fecha = date('d/m/Y H:i');
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                       style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#190047; padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:26px;">🏨 Hotel Blox</h1>
                            <p style="color:#c9b8ff; margin:8px 0 0;">Tu experiencia de lujo nos espera</p>
                        </td>
                    </tr>

                    <!-- Cuerpo -->
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="color:#190047; margin-top:0;">¡Hola, <?= $nombre ?>! 👋</h2>
                            <p style="color:#555; font-size:16px; line-height:1.6;">
                                Se ha iniciado sesión exitosamente en tu cuenta de <strong>Hotel Blox</strong>.
                            </p>

                            <table width="100%" style="margin:24px 0; background:#f0ebff; border-radius:8px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <p style="margin:0; color:#555; font-size:14px;">
                                            🕐 <strong>Fecha y hora:</strong> <?= $fecha ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#555; font-size:15px; line-height:1.6;">
                                Si no fuiste tú, te recomendamos cambiar tu contraseña de inmediato.
                            </p>

                            <table width="100%" style="margin:30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="http://localhost/MVC/index.php?action=dashboard"
                                           style="background:#6f42c1; color:#ffffff; text-decoration:none;
                                                  padding:14px 32px; border-radius:6px; font-size:16px;
                                                  font-weight:bold; display:inline-block;">
                                            Ir a mi dashboard →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f0ebff; padding:20px 30px; text-align:center;">
                            <p style="color:#888; font-size:13px; margin:0;">
                                © 2024 Hotel Blox · Todos los derechos reservados
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>