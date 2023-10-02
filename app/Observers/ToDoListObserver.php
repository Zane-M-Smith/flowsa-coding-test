<?php

namespace App\Observers;

use App\Models\TodoList;
use App\Enum\Status;

class ToDoListObserver
{
    /**
     * Handle the TodoList "created" event.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return void
     */
    public function created(TodoList $todoList)
    {
        //
    }

    /**
     * Handle the TodoList "updated" event.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return void
     */
    public function updating(TodoList $todoList)
    {
      $status = Status::COMPLETE;
      if(!$todoList->todos->isEmpty()){
        foreach($todoList->todos as $todo){
          if($todo->status == Status::INCOMPLETE){
            $status = Status::INCOMPLETE;
          }
        }
          $todoList->status = $status;
      }
        //
    }

    /**
     * Handle the TodoList "updated" event.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return void
     */
    public function updated(TodoList $todoList)
    {
        //
    }

    /**
     * Handle the TodoList "deleted" event.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return void
     */
    public function deleted(TodoList $todoList)
    {
        //
    }

    /**
     * Handle the TodoList "restored" event.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return void
     */
    public function restored(TodoList $todoList)
    {
        //
    }

    /**
     * Handle the TodoList "force deleted" event.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return void
     */
    public function forceDeleted(TodoList $todoList)
    {
        //
    }
}
