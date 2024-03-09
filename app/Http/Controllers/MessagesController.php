<?php
class MessageController extends Controller
{
    public function index($groupId)
    {
        return Message::where('group_chat_id', $groupId)->get();
    }

    public function store(Request $request, $groupId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $message = new Message();
        $message->group_chat_id = $groupId;
        $message->content = $request->input('content');
        $message->save();

        return response()->json($message, 201);
    }

    // Implement other CRUD methods
}