<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class controllerEmail {

    // ── CONFIGURACIÓN SMTP (reutilizable) ─────────────────────────────
    private function configurarMail($destinatario, $nombre) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'carlosruiza16@gmail.com';
        $mail->Password   = 'xywt uzqv fsvu khza';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('carlosruiza16@gmail.com', 'Hotel Blox');
        $mail->addAddress($destinatario, $nombre);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        return $mail;
    }

    // ── CARGAR PLANTILLA ──────────────────────────────────────────────
    private function cargarPlantilla($archivo, $variables = []) {
        extract($variables); // convierte el array en variables locales
        ob_start();
        include $archivo;
        return ob_get_clean();
    }

    // ── CORREO DE BIENVENIDA (al registrarse) ─────────────────────────
    public function enviarBienvenida($destinatario, $nombre) {
        try {
            $mail          = $this->configurarMail($destinatario, $nombre);
            $mail->Subject = '¡Bienvenido a Hotel Blox!';
            $mail->Body    = $this->cargarPlantilla('reportes/emailLogin.php', ['nombre' => $nombre]);
            $mail->send();
        } catch (Exception $e) {
            error_log('Error correo bienvenida: ' . $mail->ErrorInfo);
        }
    }

    // ── CORREO DE LOGIN EXITOSO (al iniciar sesión) ───────────────────
    public function enviarLoginExitoso($destinatario, $nombre) {
        try {
            $mail          = $this->configurarMail($destinatario, $nombre);
            $mail->Subject = 'Inicio de sesión exitoso - Hotel Blox';
            $mail->Body    = $this->cargarPlantilla('reportes/emailLogin.php', ['nombre' => $nombre]);
            $mail->send();
        } catch (Exception $e) {
            error_log('Error correo login: ' . $mail->ErrorInfo);
        }
    }

    // ── CORREO DE RESERVA (al crear una reserva) ──────────────────────
    public function enviarReserva($destinatario, $nombre, $datos) {
        try {
            $mail          = $this->configurarMail($destinatario, $nombre);
            $mail->Subject = 'Confirmación de Reserva - Hotel Blox';
            $mail->Body    = $this->cargarPlantilla('reportes/emailReserva.php', ['nombre' => $nombre, 'datos' => $datos]);
            $mail->send();
        } catch (Exception $e) {
            error_log('Error correo reserva: ' . $mail->ErrorInfo);
        }
    }
}