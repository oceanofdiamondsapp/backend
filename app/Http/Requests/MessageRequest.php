<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use OOD\Jobs\Job;

class MessageRequest extends Request
{
    /**
     * Hash to append to the redirect url.
     *
     * @var string
     */
    protected $redirectHash = '#messages';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job = Job::findOrFail($this->route('id'));

        return Auth::user()->id === $job->account_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required'
        ];
    }
}
