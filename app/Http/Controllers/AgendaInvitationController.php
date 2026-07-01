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
    /**
     * Send an agenda invitation to a friend
     */

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

    public function sendInvitation(Request $request, $agendaId)
    {
        $receiverId = $request->input('receiver_id');

        // 1. Prevent inviting yourself
        if ($receiverId === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot invite yourself.'
            ], 403);
        }

        // 2. Enforce logic: Check if the user is actually a friend
        $isFriend = Friend::where('user_id', Auth::id())
            ->where('friend_id', $receiverId)
            ->exists();

        if (!$isFriend) {
            return response()->json([
                'success' => false,
                'message' => 'You can only send invitations to your friends.'
            ], 403);
        }

        // 3. Prevent duplicate requests (handles 'pending', 'accepted', 'declined' values)
        $exists = AgendaInvitation::where('agenda_id', $agendaId)
            ->where('receiver_id', $receiverId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'An invitation has already been sent to this user.'
            ]);
        }

        // 4. Create the invitation using your schema fields
        AgendaInvitation::create([
            'agenda_id' => $agendaId,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'invitation_status' => 'pending',
            'created_at' => now(), // Explicitly set since timestamps are customized
        ]);

        return response()->json([
            'success' => true
        ]);
    }

        /**
     * Accept an agenda invitation
     */
    public function accept(AgendaInvitation $invitation)
    {
        // Only the receiver may accept
        if ($invitation->receiver_id !== \Auth::id()) {
            abort(403);
        }

        // Prevent duplicates in members table if they double-click
        \App\Models\AgendaMember::firstOrCreate([
            'agenda_id' => $invitation->agenda_id,
            'user_id'   => $invitation->receiver_id,
        ], [
            'joined_at' => now()
        ]);

        // Update the invitation status to match your layout style
        $invitation->update([
            'invitation_status' => 'accepted',
            'responded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Decline an agenda invitation
     */
    public function decline(AgendaInvitation $invitation)
    {
        // Only the receiver may decline
        if ($invitation->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Match your friend request styling for updating status
        $invitation->update([
            'invitation_status' => 'declined',
            'responded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
