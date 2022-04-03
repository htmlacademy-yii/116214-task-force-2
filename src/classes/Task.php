<?php
class Task
{
    public CONST STATUS_NEW = 'new';
    public CONST STATUS_CANCELED = 'canceled';
    public CONST STATUS_IN_PROGRESS = 'inProgress';
    public CONST STATUS_COMPLETED = 'completed';
    public CONST STATUS_FAILED = 'failed';

    public CONST ACTION_ADD = 'add';
    public CONST ACTION_CANCEL = 'cancel';
    public CONST ACTION_START = 'start';
    public CONST ACTION_COMPLETE = 'complete';
    public CONST ACTION_REFUSE = 'refuse';

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
    public function getAllStatuses() :array
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
    public function getAllActions() :array
    {
        return [
            Task::ACTION_ADD,
            Task::ACTION_CANCEL,
            Task::ACTION_START,
            Task::ACTION_COMPLETE,
            Task::ACTION_REFUSE,
        ];
    }

    /**
     * @return string[]
     */
    public function getAvailableActions() :array
    {
        return match ($this->status) {
            Task::STATUS_NEW => [Task::ACTION_START, Task::ACTION_CANCEL],
            Task::STATUS_IN_PROGRESS => [Task::ACTION_COMPLETE, Task::ACTION_REFUSE],
            Task::STATUS_CANCELED, Task::STATUS_COMPLETED, Task::STATUS_FAILED => [],
        };
    }

    /**
     * @param string $action
     * @return string
     */
    public function getActionResultingStatus(string $action) :string
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
    public function getStatusesMap() :array
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
    public function getActionsMap() :array
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
