<?php 



namespace App\Http\Controllers;

use App\Models\OperationalState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class OperationalStateController extends Controller
{
    public function index()
    {
        $states = OperationalState::orderBy('state_name')->get();
        $allStates = $this->getStates();

        return view('admin.operational_state', [
            'states'    => $states,
            'allStates' => $allStates,
        ]);  
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|unique:operational_states,state_id',
            'state_name' => 'required',
        ]);

        OperationalState::create([
            'state_id' => $request->state_id,
            'state_name' => $request->state_name,
        ]);
        return GeneralController::sendNotification('', 'success', '', 'State added successfully.');
    }

    public function update(Request $request, $id)
    {
        $state = OperationalState::findOrFail($id);

        $request->validate([
            'state_id'   => 'required|unique:operational_states,state_id,' . $state->id,
            'state_name' => 'required',
        ]);

        $state->update([
            'state_id' => $request->state_id,
            'state_name' => $request->state_name,
        ]);
        return GeneralController::sendNotification('', 'success', '', 'State updated successfully.');

    }

    public function destroy($id)
    {
        OperationalState::findOrFail($id)->delete();
        return GeneralController::sendNotification('', 'success', '', 'State deleted successfully.');

    }

    protected function getStates()
    {
        // Cache key
        $cacheKey = 'external_states_list_v1';

        return Cache::remember($cacheKey, now()->addHours(12), function () {
            try {
                $response = Http::get('https://api.facts.ng/v1/states');

                if ($response->ok()) {
                    $states = $response->json();

                    // Ensure array structure, and append FCT
                    if (!is_array($states)) {
                        $states = [];
                    }

                    // Append FCT entry
                    $states[] = [
                        'id' => 'fct',
                        'name' => 'Federal Capital Territory (Abuja)',
                    ];

                    return $states;
                }
            } catch (\Throwable $e) {
                // Log the error and fallback to at least FCT
            }

            // Minimal fallback: only FCT
            return [
                ['id' => 'fct', 'name' => 'Federal Capital Territory (Abuja)']
            ];
        });
    }

    /**
     * (Optional) Get LGAs for a given state (not used by the Blade above).
     * Keep here if you want to fetch LGAs later.
     */
    protected function getLgas($state)
    {
        $state = strtolower(trim($state));

        if ($state === 'fct') {
            return [
                'lgas' => [
                    'Abaji',
                    'Abuja Municipal Area Council',
                    'Bwari',
                    'Gwagwalada',
                    'Kuje',
                    'Kwali'
                ]
            ];
        }

        $state = urlencode($state);

        try {
            $response = Http::get("https://api.facts.ng/v1/states/{$state}");
            if ($response->ok()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
        }

        return ['lgas' => []];
    }
}

?>