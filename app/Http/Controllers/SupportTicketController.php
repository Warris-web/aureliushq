<?php
namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class SupportTicketController extends Controller
{
    // List all tickets (admin)
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::user()->id)->with('user')->latest()->get();
        return view('user_new.support', compact('tickets'));
    }
    public function admin_support()
    {
        $tickets = SupportTicket::with('user')->latest()->get();
        return view('admin.support', compact('tickets'));
    }

    // Store new ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'pending',
        ]);
        return GeneralController::sendNotification('', 'success', '', 'Support ticket created successfully.');
    }

    // Update (only if status is pending)
    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->status !== 'pending') {
            return GeneralController::sendNotification('', 'error', '', 'Only pending tickets can be updated.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket->update([
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return GeneralController::sendNotification('', 'success', '', 'Ticket updated successfully.');
    }

    // Delete (only if status is pending)
    public function destroy($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->status !== 'pending') {
            return GeneralController::sendNotification('', 'error', '', 'Only pending tickets can be deleted.');
        }

        $ticket->delete();
        return GeneralController::sendNotification('', 'success', '', 'Ticket deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status'   => 'required|in:pending,resolved,closed',
        'response' => 'nullable|string|max:2000',
    ]);

    $ticket = SupportTicket::findOrFail($id);
    $ticket->status = $request->status;

    // If you have a response column in DB
    if ($request->filled('response')) {
        $ticket->response = $request->response;
    }

    $ticket->save();

    // Send email to the user
    try{
        $user = $ticket->user; // assuming relationship exists
        if ($user && $user->email) {
            $messageBody = "Hello {$user->name},\n\n"
                . "Your support ticket #{$ticket->id} has been updated.\n\n"
                . "Status: " . ucfirst($ticket->status) . "\n";
        
            if ($request->filled('response')) {
                $messageBody .= "Response: {$request->response}\n\n";
            }
        
            $messageBody .= "Thank you,\nSupport Team";
        
            Mail::raw($messageBody, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your Support Ticket Status Has Been Updated');
            });
        }
        

    }catch(\Exception $e){

    }
    return GeneralController::sendNotification('', 'success', '', 'Ticket status updated successfully!');
}




}

?>