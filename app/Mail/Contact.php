<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje; // objeto que contendrá toda la info

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asunto = $this->mensaje->asunto ?? 'Contacto';
        $nombre = $this->mensaje->nombre ?? null; // si lo tienes en el form
        $emailUsuario = $this->mensaje->email ?? null;

        $email = $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject("Mensaje recibido: {$asunto}")
            ->when($emailUsuario, fn($m) => $m->replyTo($emailUsuario, $nombre))
            ->view('emails.contact', [
                'mensaje' => $this->mensaje,
                'centro'  => 'CIFO Sabadell',
            ]);

        // Adjuntar si hay fichero (acepta path o UploadedFile)
        if (!empty($this->mensaje->fichero)) {
            $f = $this->mensaje->fichero;

            // Si es instancia de UploadedFile
            if ($f instanceof \Illuminate\Http\UploadedFile) {
                $email->attach($f->getRealPath(), [
                    'as'   => 'adjunto_' . uniqid() . '.' . $f->getClientOriginalExtension(),
                    'mime' => $f->getMimeType(),
                ]);
            } else {
                // Si es ruta en disco
                $email->attach($f, [
                    'as'   => 'adjunto_' . uniqid() . '.pdf',
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $email;
    }
}
