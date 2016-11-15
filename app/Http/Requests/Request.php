<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Get the URL to redirect to on a validation error. Override the Laravel
     * base Request method so that we can redirect to a url with a hash.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();

        if ($this->redirect) {
            return $url->to($this->redirect);
        } elseif ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        } elseif ($this->redirectAction) {
            return $url->action($this->redirectAction);
        } elseif ($this->redirectHash) {
            return $url->previous() . $this->redirectHash;
        }

        return $url->previous();
    }
}
