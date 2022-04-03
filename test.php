<?php
include "src/classes/Task.php";

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_CALLBACK, "assert_failed");
assert_options(ASSERT_EXCEPTION, false);
assert_options(ASSERT_WARNING, false);

function assert_failed(string $file, int $line, string|null $assertion, string $description) :void {
    echo "Line: $line: Failed: $description\n";
}

function test() :void {
    $task = new Task(1, 1, Task::STATUS_NEW);

    assert($task->getAllActions() == [
        $task::ACTION_ADD,
        $task::ACTION_CANCEL,
        $task::ACTION_START,
        $task::ACTION_COMPLETE,
        $task::ACTION_REFUSE,
    ]);

    assert($task->getAllStatuses() == [
        $task::STATUS_NEW,
        $task::STATUS_CANCELED,
        $task::STATUS_IN_PROGRESS,
        $task::STATUS_COMPLETED,
        $task::STATUS_FAILED,
    ]);

    assert((new Task(1, 1, Task::STATUS_NEW))->getAvailableActions() == [
        Task::ACTION_START,
        Task::ACTION_CANCEL,
    ]);
    assert((new Task(1, 1, Task::STATUS_IN_PROGRESS))->getAvailableActions() == [
        Task::ACTION_COMPLETE,
        Task::ACTION_REFUSE,
    ]);
    assert(empty((new Task(1, 1, Task::STATUS_CANCELED))->getAvailableActions()));
    assert(empty((new Task(1, 1, Task::STATUS_COMPLETED))->getAvailableActions()));
    assert(empty((new Task(1, 1, Task::STATUS_FAILED))->getAvailableActions()));

    assert($task->getActionResultingStatus(Task::ACTION_ADD) === Task::STATUS_NEW);
    assert($task->getActionResultingStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELED);
    assert($task->getActionResultingStatus(Task::ACTION_START) === Task::STATUS_IN_PROGRESS);
    assert($task->getActionResultingStatus(Task::ACTION_COMPLETE) === Task::STATUS_COMPLETED);
    assert($task->getActionResultingStatus(Task::ACTION_REFUSE) === Task::STATUS_FAILED);
}

test();
