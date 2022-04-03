<?php

use JetBrains\PhpStorm\Pure;

include "../classes/Task.php";

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_CALLBACK, "assert_failed");
assert_options(ASSERT_EXCEPTION, false);
assert_options(ASSERT_WARNING, false);

function assert_failed(string $file, int $line, string|null $assertion, string $description) :void {
    echo "Line: $line: Failed: $description\n";
}

#[Pure]
function getAllStatuses(\Task $task) :bool {
    $waiting = [
        'new',
        'canceled',
        'inProgress',
        'completed',
        'failed',
    ];
    $result = $task->getAllStatuses();
    return empty(array_diff($waiting, $result));
}

#[Pure]
function getAllActions(\Task $task) :bool {
    $waiting = [
        'add',
        'cancel',
        'start',
        'complete',
        'refuse',
        'respond',
    ];
    $result = $task->getAllActions();
    return empty(array_diff($waiting, $result));
}

#[Pure]
function getAvailableActionsForNew(\Task $task, string $action) :bool {
    $waiting = [
        'start',
        'cancel',
    ];
    $result = $task->getAvailableActions($action);
    return empty(array_diff($waiting, $result));
}

#[Pure]
function getAvailableActionsForInProgress(\Task $task, string $action) :bool {
    $waiting = [
        'complete',
        'refuse',
    ];
    $result = $task->getAvailableActions($action);
    return empty(array_diff($waiting, $result));
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

    assert(getAllActions($task));
    assert(getAllStatuses($task));
    assert(getAvailableActionsForNew(new Task(1, 1, 'new'), 'new'));
    assert(getAvailableActionsForInProgress(new Task(1, 1, 'inProgress'), 'inProgress'));
    assert(getAvailableActionsForCanceled(new Task(1, 1, 'canceled'), 'canceled'));
    assert(getAvailableActionsForCompleted(new Task(1, 1, 'completed'), 'completed'));
    assert(getAvailableActionsForFailed(new Task(1, 1, 'failed'), 'failed'));
}

test();
