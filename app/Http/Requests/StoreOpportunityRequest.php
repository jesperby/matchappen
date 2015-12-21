<?php

namespace Matchappen\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Matchappen\Http\Requests\Request;
use Matchappen\Opportunity;

class StoreOpportunityRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $opportunity = $this->route('opportunity');

        if (!$opportunity) {
            return (bool) $this->user()->workplace_id;
        }

        return Gate::allows('update', $opportunity);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'max_visitors' => 'integer|min:1|max:' . Opportunity::MAX_VISITORS,
            'description' => 'string|max:1000',
        ];
    }
}
