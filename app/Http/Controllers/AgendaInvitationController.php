<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Models\Agenda;
use App\Models\AgendaInvitation;
use Illuminate\Support\Facades\Auth;

class AgendaInvitationController extends Controller
{
    // show friends to invite
    public function showInvite(Agenda $agenda)
    {
        $friends = Friend::where('user_id', Auth::id())
            ->with('friend')
            ->get()
            ->pluck('friend');

        $invitedIds = AgendaInvitation::where('agenda_id', $agenda->id)
            ->pluck('receiver_id');

        return view('agendas.invite', compact('agenda', 'friends', 'invitedIds'));
    }

    // show received invitations
    public function showInvitations()
    {
        $incoming = AgendaInvitation::where('receiver_id', Auth::id())
            ->where('invitation_status', 'pending')
            ->with(['sender', 'agenda'])
            ->get();

        $outgoing = AgendaInvitation::where('sender_id', Auth::id())
            ->with(['receiver', 'agenda'])
            ->get();

        return view('agendas.invitations', compact('incoming', 'outgoing'));
    }

    // send invitations
    public function sendInvitation(Request $request, $agendaId)
    {
        $receiverId = $request->input('receiver_id');

        if ($receiverId === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot invite yourself.'
            ], 403);
        }

        $isFriend = Friend::where('user_id', Auth::id())
            ->where('friend_id', $receiverId)
            ->exists();

        if (!$isFriend) {
            return response()->json([
                'success' => false,
                'message' => 'You can only send invitations to your friends.'
            ], 403);
        }

        $exists = AgendaInvitation::where('agenda_id', $agendaId)
            ->where('receiver_id', $receiverId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'An invitation has already been sent to this user.'
            ]);
        }

        AgendaInvitation::create([
            'agenda_id' => $agendaId,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'invitation_status' => 'pending',
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    // accept agenda invitations
    public function accept(AgendaInvitation $invitation)
    {
        if ($invitation->receiver_id !== \Auth::id()) {
            abort(403);
        }

        // prevent duplicates
        \App\Models\AgendaMember::firstOrCreate([
            'agenda_id' => $invitation->agenda_id,
            'user_id'   => $invitation->receiver_id,
        ], [
            'joined_at' => now()
        ]);

        $invitation->update([
            'invitation_status' => 'accepted',
            'responded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    // decline agenda invitations
    public function decline(AgendaInvitation $invitation)
    {
        if ($invitation->receiver_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update([
            'invitation_status' => 'declined',
            'responded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
