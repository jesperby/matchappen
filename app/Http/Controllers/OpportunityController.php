<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreOpportunityRequest;
use Matchappen\Opportunity;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::published()->get();

        return view('opportunity.index')->with(compact('opportunities'));
    }

    public function show(Opportunity $opportunity)
    {
        return view('opportunity.show')->with(compact('opportunity'));
    }

    public function create(Request $request)
    {
        $workplace = $request->user()->workplace;

        $opportunity = new Opportunity();

        return view('opportunity.create')->with(compact('opportunity', 'workplace'));
    }

    public function store(StoreOpportunityRequest $request)
    {
        $opportunity = new Opportunity($request->input());
        $opportunity->workplace()->associate($request->user()->workplace);
        $opportunity->save();

        //TODO: trigger emails on opportunity created

        return redirect()->action('OpportunityController@edit', $opportunity->getKey());
    }

    public function edit(Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        return view('opportunity.edit')->with(compact('opportunity'));
    }

    public function update(Opportunity $opportunity, StoreOpportunityRequest $request)
    {
        $opportunity->update($request->input());

        //TODO: trigger emails on opportunity update

        return redirect()->action('OpportunityController@edit', $opportunity->getKey());
    }
}
