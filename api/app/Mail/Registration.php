<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $obj;
    private $choosedPlain;
    private $choosedView;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj, $array)
    {
        $this->obj = $obj;
        if((empty($array['html']))OR(empty($array['plain']))OR(empty($array['subject']))){
            \Log::error('missing argument Mailing Registration');
            abort(403, lang::get('auth.missingArgument'));
        }
        $this->choosedView=$array['html'];
        $this->choosedPlain=$array['plain'];
        $this->subject=$array['subject'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('no-reply@coatandclothes.shop')
            ->subject($this->subject)
            ->view($this->choosedView)
            ->text($this->choosedPlain)
            ->with(
                [
                    'testVarOne' => '1',
                    'testVarTwo' => '2',
                ]);
    }
}