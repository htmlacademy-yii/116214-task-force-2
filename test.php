<?php

use JetBrains\PhpStorm\Pure;

include "src/classes/Task.php";

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_CALLBACK, "assert_failed");
assert_options(ASSERT_EXCEPTION, false);
assert_options(ASSERT_WARNING, false);

function assert_failed(string $file, int $line, string|null $assertion, string $description) :void {
    echo "Line: $line: Failed: $description\n";
}

#[Pure]
function getAvailableActionsForCanceled(\Task $task, string $action) :bool {
    $waiting = [];
    $result = $task->getAvailableActions($action);
    return empty(array_diff($waiting, $result));
}

#[Pure]
function getAvailableActionsForCompleted(\Task $task, string $action) :bool {
    $waiting = [];
    $result = $task->getAvailableActions($action);
    return empty(array_diff($waiting, $result));
}

#[Pure]
function getAvailableActionsForFailed(\Task $task, string $action) :bool {
    $waiting = [];
    $result = $task->getAvailableActions($action);
    return empty(array_diff($waiting, $result));
}

function test() :void {
    $task = new Task(1, 1, 'new');

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

    assert((new Task(1, 1, 'new'))->getAvailableActions() == [
        Task::ACTION_START,
        Task::ACTION_CANCEL,
    ]);

    assert((new Task(1, 1, 'inProgress'))->getAvailableActions() == [
        Task::ACTION_COMPLETE,
        Task::ACTION_REFUSE,
    ]);

    assert(empty((new Task(1, 1, 'canceled'))->getAvailableActions()));

    assert(empty((new Task(1, 1, 'completed'))->getAvailableActions()));

    assert(empty((new Task(1, 1, 'failed'))->getAvailableActions()));
}

test();
