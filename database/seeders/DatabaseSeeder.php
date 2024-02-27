<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\Note;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create User
        $user = User::create([
            'name' => 'Sunny Roy',
            'email' => 'sunnyroy@yopmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Create Tasks with Notes and Attachments
        $this->createTaskWithNotes($user, 'Task with Notes and Attachments', 'Description for Task 1', 'New', 'Low', now(), now()->addDays(7));
        $this->createTaskWithNotes($user, 'Another Task with attachment', 'Description for Task 2', 'Incomplete', 'Medium', now(), now()->addDays(10));
        $this->createTaskWithNotes($user, 'Third Complete Status task ', 'Completed Task Description', 'Complete', 'High', now(), now()->addDays(3));
        $this->createTaskWithNotes($user, '4th Task Medium Priorty ', 'Description of Task 4', 'New', 'Medium', now(), now()->addDays(3));

        // Create Tasks without Notes and Attachments
        $this->createTaskWithoutNotes($user, 'Task without Notes 1', 'Description for Task 1', 'Complete', 'Low', now(), now()->addDays(5));
        $this->createTaskWithoutNotes($user, 'Task without Notes 2', 'Description for Task 2', 'Incomplete', 'High', now(), now()->addDays(14));
        $this->createTaskWithoutNotes($user, 'Task without Notes 3', 'Description for Task 3', 'New', 'Medium', now(), now()->addDays(10));
        $this->createTaskWithoutNotes($user, 'Task without Notes 4', 'Description for Task 4', 'Incomplete', 'Low', now(), now()->addDays(2));

        $this->command->info('User, tasks, notes, and attachments seeded successfully.');
    }

    // Helper method to create a task with notes
    private function createTaskWithNotes($user, $subject, $description, $status, $priority, $startDate, $dueDate)
    {
        $task = Task::create([
            'subject' => $subject,
            'description' => $description,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'due_date' => $dueDate,
            'user_id' => $user->id,
        ]);

        // Create notes for the task
        $note1 = Note::create([
            'subject' => 'Note 1 for ' . $subject,
            'attachment' => $attachment, // Replace with actual path or content
            'note' => 'Content of Note 1 for ' . $subject,
            'task_id' => $task->id,
        ]);

        $note2 = Note::create([
            'subject' => 'Note 2 for ' . $subject,
            'attachment' => null, // No attachment for this note
            'note' => 'Content of Note 2 for ' . $subject,
            'task_id' => $task->id,
        ]);
    }

    // Helper method to create a task without notes
    private function createTaskWithoutNotes($user, $subject, $description, $status, $priority, $startDate, $dueDate)
    {
        Task::create([
            'subject' => $subject,
            'description' => $description,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'due_date' => $dueDate,
            'user_id' => $user->id,
        ]);
    }
}

