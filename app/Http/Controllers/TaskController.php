<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;


class TaskController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        $tasks = Task::withCount('notes')
            ->with('notes')
            ->where('user_id', $user->id)
            ->orderBy('priority', 'asc')
            ->orderBy('notes_count', 'desc');
        
        // Filter by status
        if (!empty($request->status)) {
            $tasks->where('status', $request->status);
        }

        // Filter by due_date
        if (!empty($request->due_date)) {
            $tasks->where('due_date', $request->due_date);
        }

        // Filter by priority
        if (!empty($request->priority)) {
            $tasks->where('priority', $request->priority);
        }

        // Filter by notes (retrieve tasks with minimum one note attached)
        if (!empty($request->notes)) {
            $tasks->has('notes');
        }

        $tasks = $tasks->get();

        return response()->json(['tasks' => $tasks], 200);
    }

    public function store(TaskRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user(); 

            $task = Task::create([
                'subject' => $request->subject,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'priority' => $request->priority,
                'user_id' => $user->id,
            ]);

            $notesData = $request->notes ?? [];
            foreach ($notesData as $noteData) {
                
                $attachmentPath = NULL;
                if(!empty($noteData['attachment']))
                {
                    // Save attachment and get the file path
                    $attachmentPath = $this->saveAttachment($noteData['attachment']);
                }

                // Create note with attachment path
                $task->notes()->create([
                    'subject' => $noteData['subject'],
                    'attachment' => $attachmentPath,
                    'note' => $noteData['note'],
                ]);
            }
            
            DB::commit();

            return response()->json(['task' => $task], 201);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error creating task', 'error' => $e->getMessage()], 500);
        }
    }

    private function saveAttachment($attachment)
    {
        // Generate a unique filename
        $filename = uniqid() . '_' . time() . '.' . $attachment->extension();
        $path = 'attachments/' . $filename;
        // Save the file to the storage path
        $attachment->storeAs('public', $path);

        // Return the stored file path
        return $path;
    }
}