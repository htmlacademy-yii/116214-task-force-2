<?php
class Task
{
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

    /**
     * @var int
     */
    private int $clientId;
    /**
     * @var int
     */
    private int $executorId;
    /**
     * @var string
     */
    private string $status;

    /**
     * @param int $clientId
     * @param int $executorId
     * @param string $status
     */
    public function __construct(int $clientId, int $executorId, string $status)
    {
        $this->clientId = $clientId;
        $this->executorId = $executorId;
        $this->status = $status;
    }

    /**
     * @return string[]
     */
    private function getAllStatuses() :array
    {
        return [
            Task::STATUS_NEW,
            Task::STATUS_CANCELED,
            Task::STATUS_IN_PROGRESS,
            Task::STATUS_COMPLETED,
            Task::STATUS_FAILED,
        ];
    }

    /**
     * @return string[]
     */
    private function getAllActions() :array
    {
        return [
            Task::ACTION_ADD,
            Task::ACTION_CANCEL,
            Task::ACTION_START,
            Task::ACTION_COMPLETE,
            Task::ACTION_REFUSE,
            Task::ACTION_RESPOND,
        ];
    }

    /**
     * @param string $status
     * @return string[]
     */
    private function getAvailableActions(string $status) :array
    {
        return match ($status) {
            Task::STATUS_NEW => [Task::ACTION_START, Task::ACTION_CANCEL],
            Task::STATUS_IN_PROGRESS => [Task::ACTION_COMPLETE, Task::ACTION_REFUSE],
            Task::STATUS_CANCELED, Task::STATUS_COMPLETED, Task::STATUS_FAILED => [],
        };
    }

    /**
     * @param string $action
     * @return string
     */
    private function getActionResultingStatus(string $action) :string
    {
        return match ($action) {
          Task::ACTION_ADD => Task::STATUS_NEW,
          Task::ACTION_CANCEL => Task::STATUS_CANCELED,
          Task::ACTION_START => Task::STATUS_IN_PROGRESS,
          Task::ACTION_COMPLETE => Task::STATUS_COMPLETED,
          Task::ACTION_REFUSE => Task::STATUS_FAILED,
        };
    }

    /**
     * @return string[]
     */
    private function getStatusesMap() :array
    {
        return [
            Task::STATUS_NEW => 'Новое',
            Task::STATUS_CANCELED => 'Отменено',
            Task::STATUS_IN_PROGRESS => 'В работе',
            Task::STATUS_COMPLETED => 'Выполнено',
            Task::STATUS_FAILED => 'Провалено',
        ];
    }

    /**
     * @return string[]
     */
    private function getActionsMap() :array
    {
        return [
            Task::ACTION_ADD => 'добавить',
            Task::ACTION_CANCEL => 'отменить',
            Task::ACTION_START => 'начинать',
            Task::ACTION_COMPLETE => 'завершить',
            Task::ACTION_REFUSE => 'отказываться',
        ];
    }
}
