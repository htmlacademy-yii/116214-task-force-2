<?php
class Task {
    private int $clientId;
    private int $executorId;
    private string $status;

    private CONST STATUS_NEW = 'new';
    private CONST STATUS_CANCELED = 'canceled';
    private CONST STATUS_IN_PROGRESS = 'inProgress';
    private CONST STATUS_COMPLETED = 'completed';
    private CONST STATUS_FAILED = 'failed';

    private CONST ACTION_ADD = 'add';
    private CONST ACTION_CANCEL = 'cancel';
    private CONST ACTION_START = 'start';
    private CONST ACTION_COMPLETE = 'complete';
    private CONST ACTION_REFUSE = 'refuse';
    private CONST ACTION_RESPOND = 'respond';

    public function __construct(int $clientId, int $executorId, string $status) {
        $this->clientId = $clientId;
        $this->executorId = $executorId;
        $this->status = $status;
    }
    private function getAllStatuses() :array {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $constants = $reflectionClass->getConstants();
        return array_filter($constants, function($value, $name) {
            return str_starts_with($name, 'STATUS_');
        }, ARRAY_FILTER_USE_BOTH );
    }

    private function getAllActions() :array {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $constants = $reflectionClass->getConstants();
        return array_filter($constants, function($value, $name) {
            return str_starts_with($name, 'ACTION_');
        }, ARRAY_FILTER_USE_BOTH );
    }

    private function getAvailableActions(string $status) :array {
        return match ($status) {
            'new' => ['respond', 'cancel', 'start'],
            'inProgress' => ['complete', 'refuse'],
            'canceled', 'completed', 'failed' => [],
        };
    }

    private function getActionResultingStatus(string $action) :string {
        return match ($action) {
          'add' => 'new',
          'respond' => '',
          'cancel' => 'canceled',
          'start' => 'inProgress',
          'complete' => 'completed',
          'refuse' => 'failed',
        };
    }

    private function getStatusesMap() :array {
        return [
            'new' => 'Новое',
            'canceled' => 'Отменено',
            'inProgress' => 'В работе',
            'completed' => 'Выполнено',
            'failed' => 'Провалено',
        ];
    }

    private function getActionsMap() :array {
        return [
            'add' => 'добавить',
            'cancel' => 'отменить',
            'start' => 'начинать',
            'complete' => 'завершить',
            'refuse' => 'отказываться',
        ];
    }
}
